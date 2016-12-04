<?php
class Admin extends MY_Controller{
  
  public function __construct()
  {
    parent::__construct();
    $this->assign('root', 'http://'.$_SERVER ['HTTP_HOST'].'/shop/');
    session_start();
  }
  
  public function index()
  {
   $this->display('adminLogin.html');
  }
  
  public function showLogin()
  {
    $this->display('adminLogin.html');
  }
  
  public function admin()
  {
    $this->display('admin.html');
  }
  
  public function login()
  {
    $adminname = $_POST['adminname'];
    $password = $_POST['adminPwd'];
    $this->load->model('admin_model');
    $result = $this->admin_model->authenticate($adminname, $password);
    if($result) {
      global $admin;
      $admin = $result;
      $_SESSION['admin'] = $admin;
      $this->load->helper('url');
      redirect(base_url('admin/admin'));
    } else {
      echo false;
    }
  }
  
  public function userManage()
  {
    if(isset($_SESSION['admin'])) {
    if(!isset($_GET['offset'])) {
      $offset = 0;
    } else {
      $offset = $_GET['offset'];
      if($offset == '-1')$offset = 0;
    }  
    $this->load->model('admin_model');
    $user = $this->admin_model->getUser('10',$offset);
    $quantity = $this->admin_model->getUserQuantity();
    $this->assign('userTotal', $quantity);
    $this->assign('pageTotal', ceil($quantity/10));
    $this->assign('offset', $offset);
    $this->assign('users', $user);
    $this->display('userManage.html');
    } else {
      $this->load->helper('url');
      redirect(base_url('admin/index'));
    }
  }
  
  public function itemManage()
  {
    if(isset($_SESSION['admin'])) {
    $this->display('itemManage.html');
    } else {
      $this->load->helper('url');
      redirect(base_url('admin/index'));
    }
  }
  
  public function itemAdmin()
  {
    if(isset($_SESSION['admin'])) {
    if(!isset($_GET['offset'])) {
      $offset = 0;
    } else {
      $offset = $_GET['offset'];
      if($offset == '-1')$offset = 0;
    }
    $this->load->model('admin_model');
    $itemTotal = $this->admin_model->getItemQuantity();
    $classTotal = $this->admin_model->getClass();
    $items = $this->admin_model->getItem('10', $offset);
    $this->assign('pageTotal', ceil($itemTotal/10));
    $this->assign('offset', $offset);
    $this->assign('items', $items);
    $this->assign('classTotal', $classTotal);
    $this->assign('itemTotal', $itemTotal);
    $this->display('itemAdmin.html');
    } else {
      $this->load->helper('url');
      redirect(base_url('admin/index'));
    }
  }
  
  public function addItem()
  {
    $data = array(
        'itemname' => $_POST['itemname'],
        'itemclass' => $_POST['itemclass'],
        'itemimg' => $_POST['itemimg'],
        'information' => $_POST['information'],
        'brand' => $_POST['brand'],
        'inventory' => $_POST['inventory'],
        'itemprice' => $_POST['itemprice']
    );
    $this->load->model('admin_model');
    $this->admin_model->addItem($data);
  }
  
  public function updateItem()
  {
    $itemid = $_POST['itemid'];
    $data = array(
        'itemname' => $_POST['itemname'],
        'itemclass' => $_POST['itemclass'],
        'itemimg' => $_POST['itemimg'],
        'information' => $_POST['information'],
        'brand' => $_POST['brand'],
        'inventory' => $_POST['inventory'],
        'itemprice' => $_POST['itemprice']
    );
    $this->load->model('admin_model');
    $this->admin_model->updateItem($itemid, $data);
  }
  
  public function showHomeManage()
  {
    if(isset($_SESSION['admin'])) {
    $this->load->model('home_model');
    $bargains = $this->home_model->getItemsByFlag('bargains');
    $recommend = $this->home_model->getItemsByFlag('recommend');
    $hots = $this->home_model->getItemsByFlag('hot');
    $this->assign('hots', $hots);
    $this->assign('recommends', $recommend);
    $this->assign('bargains',$bargains );
    $this->display('homeManage.html');
    } else {
      $this->load->helper('url');
      redirect(base_url('admin/index'));
    }
  }
  
  public function deleteFromHome()
  {
    $itemid = $_GET['itemid'];
    $this->load->model('admin_model');
    $this->admin_model->deleteItem($itemid);
    $this->load->helper('url');
    redirect(base_url('admin/showHomeManage'));
  }
  
  public function addItemToHome()
  {
    $itemid = $_POST['itemid'];
    $flag = $_POST['flag'];   
    $this->load->model('home_model');
    $result = $this->home_model->getItemById($itemid);
    if($result){
      $this->load->model('admin_model');
      $this->admin_model->addItemToHome($itemid, $flag);
      echo true;
    } else {
      echo false;
    }   
  }
  
  public function orderManage()
  {
    if(isset($_SESSION['admin'])) {
      if(!isset($_GET['offset'])) {
        $offset = 0;
      } else {
        $offset = $_GET['offset'];
        if($offset == '-1')$offset = 0;
      }
      $limit = 10;
      $this->load->model('admin_model');  
      $orders = $this->admin_model->getOrder($limit, $offset);
      $this->assign('orders', $orders);
      $this->assign('offset', $offset);
      $quantity = $this->admin_model->getOrderQuantity();
      $this->assign('orderTotal', $quantity);
      $this->assign('pageTotal', ceil($quantity/10));
      $this->display('orderManage.html');  
    } else {
        $this->load->helper('url');
        redirect(base_url('admin/index'));
      }
   }
   
   public function getOrderDetail()
   {
     $orderid = $_POST['orderid'];
     $this->load->model('admin_model');
     $result = $this->admin_model->getOrderDetail($orderid);
     echo json_encode($result);
   }

}