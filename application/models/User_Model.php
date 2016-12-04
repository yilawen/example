<?php
class User_Model extends CI_Model{
  
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * 验证用户名和密码
   * @Param string $username 用户名
   * @Param string $userPwd 密码
   * @return object/bool 用户对象，失败返回false
   */
  public function authenticate ($username, $password)
  {
    $result = $this->db->get_where('user',array('username'=>$username,'userPwd'=>$password))->row_array();
    if($result){
       $uid = $result['userid'];
       return  $this->getUserById($uid);
    }    
    else {
      return false;
    }
  }
  
  /**
   * 根据用户id获取用户
   * @param int $uid 用户id
   * @return object/bool 用户对象, 失败返回false
   */
  public function getUserById($uid = null)
  {
    if(!isset($uid)) {
      return false;
    }
    $user = $this->db->get_where('user',array('UserId'=>$uid))->row();
    return $user;
  }
  
  /**
   * 根据用户名获取用户
   * @param strng $username 用户名
   * @return object 用户对象
   */
  public function getUserByUserName($username)
  {
    if(!isset($username)) {
      return false;
    }
    $user = $this->db->get_where('user',array('username'=>$username))->row();
    return $user;
  }
  
  /**
   * 新增一个用户
   * @param array $user 用户数组
   * @return int/bool 新用户ID, 失败返回 false
   */
  public function insertUser($username, $password, $telephone = null, $address = null)
  {
   $data = array('username' => $username,
                        'userpwd' => $password,
                        'telephone' => $telephone,
                        'address' => $address
                        );
   $user = $this->getUserByUserName($username);
   if($user) {
     return false;
   }
   $result = $this->db->insert('user',$data);
    return $result;
  }
  
  /**
   * 修改密码
   */
  public function updatePwd($userid, $newPwd)
  {
    $data = array('userPwd' => $newPwd);
    $this->db->where('userid', $userid)->update('user',$data);
  }
  
  /**
   * 修改基本信息
   */
  public function updateInf($userid, $data)
  {
    $this->db->where('userid', $userid)->update('user', $data);
  }
}