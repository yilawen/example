<?php
class Admin_Model extends CI_Model{

 /**
   * 验证管理员
   */
  public function authenticate ($adminname, $password)
  {
    $result = $this->db->get_where('admin',array('adminname'=>$adminname,'adminPwd'=>$password))->row_array();
    if($result){
       $aid = $result['adminid'];
       return  $this->getAdminById($aid);
    }
    else {
      return false;
    }
  }

  /**
   * 根据用户id获取管理员
   */
  public function getAdminById($aid = null)
  {
    if(!isset($aid)) {
      return false;
    }
    $admin = $this->db->get_where('admin',array('adminid'=>$aid))->row();
    return $admin;
  }

  /**
   * 根据用户名获取管理员
   */
  public function getAdminByAdminName($adminname)
  {
    if(!isset($adminname)) {
      return false;
    }
    $admin = $this->db->get_where('admin',array('adminname'=>$adminname))->row();
    return $admin;
  }

  /**
   * 新增一个管理员
   * @param array $user 用户数组
   * @return int/bool 新用户ID, 失败返回 false
   */
  public function insertAdmin($adminname, $password)
  {
   $data = array('adminname' => $adminname,
                        'adminpwd' => $password,
                        );
   $admin = $this->getAdminByAdminName($adminname);
   if($user) {
     return false;
   }
   $result = $this->db->insert('admin',$data);
    return $result;
  }

  /**
   * 获取指定数量用户
   */
  public function getUser($limit, $offset)
  {
    $result = $this->db->select('*')->from('user')->limit($limit, $offset*$limit)->get()->result();
    return $result;
  }

  /**
   * 统计用户总数
   */
  public function getUserQuantity()
  {
    $result = $this->db->count_all('user');
    return $result;
  }

  /**
   * 获取指定数量商品
   */
  public function getItem($limit, $offset)
  {
    $result = $this->db->select('*')->from('item')->limit($limit, $offset*$limit)->get()->result();
    return $result;
  }

  /**
   * 统计商品总数
   */
  public function getItemQuantity()
  {
    $result = $this->db->count_all('item');
    return $result;
  }

  /**
   * 获取类别总数
   *
   */
  public function getClass()
  {
    $result = $this->db->distinct()->select('itemclass')->from('item')->count_all_results();
    return $result;
  }

  /**
   * 更新商品信息,如果id为空，则添加商品
   */
  public function updateItem($itemId, $data)
  {
    if(!$itemId) {
      $this->db->insert('item', $data);
    } else {
      $this->db->where("itemid", $itemId)->update('item', $data);
    }
  }

  /**
   * 获取指定数量订单
   */
  public function getOrder($limit, $offset)
  {
    $result = $this->db->select('*')->from('order')->limit($limit, $offset*$limit)->get()->result();
    return $result;
  }

  /**
   * 统计订单总数
   */
  public function getOrderQuantity()
  {
    $result = $this->db->count_all('order');
    return $result;
  }
  /**
   *根据订单id 获取订单详情
   */
  public function getOrderDetail($orderid)
  {
    $result = $this->db->select('order.orderid, order.userid, orderdetail.itemid, orderdetail.quantity, item.itemname, item.brand, item.itemprice')
    ->from('order')->where('order.orderid', $orderid)->join('orderdetail', 'order.orderid=orderdetail.orderid')
    ->join('item', 'orderdetail.itemid=item.itemid')
    ->get()->result();
    return $result;
  }
}
