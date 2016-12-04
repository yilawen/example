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
   * @return object[] 商品对象数组,失败返回false
   */
  public function getItemsByFlag($flag = null)
  {
    if(!isset($flag)) {
      return false;
    }
    $items = $this->db->select('*')->from('item')->where('flag',$flag)->join('iteminhome','item.itemid=iteminhome.itemid')->get()->result_array();
    return$items;
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
    $item = $this->db->select('*')->from('shopcar')->where($data)->join('item','shopcar.itemid=item.itemid')->get()->row();
    return $item;
  }
  
  /**
   * 根据用户id获取购物车所有商品
   * @param int $userid 用户id
   * @return object[] 返回商品对象数组
   */
  public function getItemFromCarByUserId($userid)
  {
    $items = $this->db->select('*')->from('shopcar')->where('userid',$userid)->join('item','shopcar.itemid=item.itemid')->get()->result();
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
   * 通过商品ID数组获取商品对象数组
   * @param int $userId 用户id
   * @param int[] $itemIds 商品id数组
   */
  public function getItemFromCarByItemIds($userid, $itemids)
  {
    for($i=0; $i<count($itemids);$i++)
    {
      $item = $this->getItemFromCar($userid, $itemids[$i]);
      $items[$i] = $item;
    }
    return $items;
  }
  
  /**
   * 生成订单
   * @param int $userid 用户id
   * @param int $totalPrice 总价
   * @param array $itemids 商品id数组
   */
  public function addOrder($userid, $totalPrice, $itemids, $recipient, $orderPhone, $orderAddr)
  {
    $data = array(
        'userid' => $userid,
        'totalPrice' => $totalPrice,
        'orderAddr' => $orderAddr,
        'orderPhone' => $orderPhone,
        'recipient' => $recipient
    );
   $this->db->insert('order', $data);
   $orderid =  $this->db->insert_id();  
   $this->db->query('update `order` set addtime=now() where orderid='.$orderid);
   for($i=0;$i<count($itemids);$i++) {
     $quantity = $this->db->select('quantity')->from('shopcar')->where(array('userid'=>$userid,'itemid'=>$itemids[$i]))->get()->row_array();
     $quantity = $quantity['quantity'];
     $this->db->insert('orderdetail',array('orderid'=>$orderid,'itemid'=>$itemids[$i],'quantity'=>$quantity));
   }
  }
  
  /**
   * 获取用户所有订单
   * @param int $userid 用户id
   */
  public function getOrder($userid)
  {
    $orders = $this->db->select('*')->from('order')->where('userid', $userid)->order_by('orderid','desc')->get()->result();
    for($i=0;$i<count($orders);$i++) {
      $thisItems = null;
      $orderid = $orders[$i]->orderid;
      $items = $this->db->select('*')->from('orderdetail')->where('orderid', $orderid)->get()->result();
      for($j=0;$j<count($items);$j++) {
        $thisItem = $this->db->select('*')->from('orderdetail')->where('orderdetail.itemid',$items[$j]->itemid)->join('item','item.itemid=orderdetail.itemid')->get()->row();
        $thisItems[$j] = $thisItem;
      }
      $orders[$i]->items = $thisItems;
    }
    return $orders;
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
  
  public function test()
  {    
    $this->db->query('insert into `test`(addtime) values(`now()`)');
  }
}