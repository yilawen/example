<?php
class Home_Model extends CI_Model{

 /**
   * 根据商品id获取商品
   * @param string $gid 商品id
   * @return object/bool 商品对象, 失败返回false
   */
 public function getItemById($gid = null)
 {
  if(!isset($gid)) {
    return false;
  }
  $item = $this->db->get_where('item',array('itemid'=>$gid))->row();
  return $item;
}

  /**
   * 根据标志获取商品组
   * @param string $flag 商品标志
   * @return array 商品数组,失败返回false
   */
  public function getItemsByFlag($flag = null)
  {
    if(!isset($flag)) {
      return false;
    }
    $items = $this->db->select('*')->from('item')->where('flag',$flag)->
      join('iteminhome','item.itemid=iteminhome.itemid')->get()->result_array();
    return $items;
  }

  /**
   * 加入购物车
   * @param int $userid 用户id
   * @param int $itemid 商品id
   * @param int $quantity 商品数量
   * @return boolean 失败返回false
   */
  public function addToCar($userid, $itemid, $quantity)
  {
    $data = array(
      'userid' => $userid,
      'itemid' => $itemid,
      'quantity' => $quantity
      );
    $result = $this->getItemFromCar($userid, $itemid);
    if($result) {
      $result = $this->db->select('quantity')->from('shopcar')->where(array('userid'=>$userid,'itemid'=>$itemid))->get()->row_array();
      $old = $result['quantity'];
      $data = array('quantity'=>$old+$quantity);
      $this->db->where(array('userid'=>$userid,'itemid'=>$itemid))->update('shopcar',$data);
    } else {
      $this->db->insert('shopcar',$data);
    }
  }

  /**
   * 根据用户id和商品id获取购物车商品
   * @param int $userid
   * @param int $itemid
   * @return object 商品对象
   */
  public function getItemFromCar($userid, $itemid)
  {
    $data = array('userid'=>$userid,'item.itemid'=>$itemid);
    $item = $this->db->select('*')->from('shopcar')->
      where($data)->join('item', 'shopcar.itemid=item.itemid')->get()->row();
    return $item;
  }

  /**
   * 根据用户id获取购物车所有商品
   * @param int $userid 用户id
   * @return object[] 返回商品对象数组
   */
  public function getItemFromCarByUserId($userid)
  {
    $items = $this->db->select('*')->from('shopcar')->
      where('userid',$userid)->join('item','shopcar.itemid=item.itemid')->get()->result();
    return $items;
  }

  /**
   * 修改商品数量
   * @param int $itemid 商品id
   * @param int $userid 用户id
   * @param int $quantity 商品数量
   */
  public function alterShopCar($userid, $itemid, $quantity)
  {
    $data = array(
      'userid' => $userid,
      'itemid' => $itemid,
      'quantity' => $quantity
      );
    $this->db->where(array('userid'=>$userid,'itemid'=>$itemid))->update('shopcar',$data);
  }

  /**
   * 删除商品
   * @param int $userid 用户id
   * @param int $itemid 商品id
   */
  public function deleteItem($userid, $itemid)
  {
    $data = array(
      'userid' => $userid,
      'itemid' => $itemid
      );
    $this->db->delete('shopcar',$data);
  }

  /**
   * 删除商品组
   */
  public function deleteItems($userid, $itemids)
  {
    for($i=0; $i<count($itemids); $i++) {
      $this->deleteItem($userid, $itemids[$i]);
    }
  }

  /**
   * 通过商品ID数组获取商品数组
   * @param int $userId 用户id
   * @param int[] $itemIds 商品id数组
   */

  public function getItemsByItemIds($userId, $itemIds)
  {
    $items = $this->db->select('*')->from('shopcar')->join('item', 'shopcar.itemid=item.itemid')->
      where('shopcar.userid', $userId)->where_in('item.itemid', $itemIds)->get()->result_array();
    $totalPrice = 0;
    $unitPrice = 0;
    foreach($items as $item) {
      $unitPrice = $item['quantity'] * $item['itemprice'];
      $totalPrice += $unitPrice;
    }
    return array(
      'items' => $items,
      'totalPrice' => $totalPrice
      );
  }

  /**
   * 生成订单
   * @param int $userId 用户id
   * @param int $totalPrice 总价
   * @param array $itemIds 商品id数组
   */
  public function addOrder($userId, $itemIds, $recipient, $orderPhone, $orderAddr)
  {
    $itemInfos = $this->db->select('quantity, itemprice')->from('shopcar')->join('item', 'shopcar.itemid=item.itemid')->
      where('shopcar.userid', $userId)->where_in('item.itemid', $itemIds)->get()->result_array();
    $totalPrice = 0;
    $unitPrice = 0;
    foreach($itemInfos as $itemInfo) {
      $unitPrice = $itemInfo['quantity'] * $itemInfo['itemprice'];
      $totalPrice += $unitPrice;
    }
    $order = array(
      'userid' => $userId,
      'totalPrice' => $totalPrice,
      'orderAddr' => $orderAddr,
      'orderPhone' => $orderPhone,
      'recipient' => $recipient,
      'addtime' => date('Y-m-d H:i:s')
      );
    $items = $this->db->select('itemid, quantity')->from('shopcar')->
      where('userid', $userId)->where_in('itemid', $itemIds)->get()->result_array();

    $this->db->trans_start();
    $this->db->insert('order', $order);
    $orderId = $this->db->insert_id();
    foreach($items as &$item) {
      $item['orderid'] = $orderId;
    }
    $this->db->insert_batch('orderdetail', $items);
    $this->db->where_in('itemid', $itemIds)->delete('shopcar');
    $this->db->trans_complete();
 }

  /**
   * 获取用户所有订单
   * @param int $userid 用户id
   */
  public function getOrder($userId)
  {
    $orders = $this->db->select('*')->from('order')->join('orderdetail', 'order.orderid=orderdetail.orderid')
      ->join('item', 'item.itemid=orderdetail.itemid')->where('userid', $userId)->get()->result_array();
    $result = array();
    $orderId = null;
    foreach($orders as $order) {
      $orderId = $order['orderid'];
      if(array_key_exists($orderId, $result)) {
        array_push($result[$orderId], $order);
      } else {
        $result[strval($orderId)] = array();
        array_push($result[$orderId], $order);
      }
    }
    return $result;
  }

  /**
   * 通过商品类别搜索
   * @param string $search 搜索字符串
   */
  public function searchByClass($search)
  {
    $items = $this->db->select('*')->from('item')->where('itemclass', $search)->get()->result();
    return $items;
  }

  /**
   * 通过品牌搜索
   * @param string $search
   */
  public function searchByBrand($search)
  {
    $items = $this->db->select('*')->from('item')->where('brand', $search)->get()->result();
    return $items;
  }

  /**
   * 通过类别和品牌搜索
   */
  public function searchByClassAndBrand($class, $brand)
  {
    $data = array(
      'itemclass' => $class,
      'brand' => $brand
      );
    $items = $this->db->select('*')->from('item')->where($data)->get()->result();
    return $items;
  }


  /**
   * 模糊搜索
   */
  public function searchByString($search)
  {
    $items = $this->db->select('*')->from('item')->like('itemclass', $search)->or_like('brand', $search)->get()->result();
    return $items;
  }

  /**
   * 获取所有类别
   */
  public function getAllClass()
  {
    $classes = $this->db->distinct()->select('itemclass')->from('item')->get()->result();
    return $classes;
  }

  /**
   * 获取所有品牌
   */
  public function getAllbrand()
  {
    $brands = $this->db->distinct()->select('brand')->from('item')->get()->result();
    return $brands;
  }
}
