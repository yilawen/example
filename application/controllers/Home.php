<?php
class Home extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    session_start();
    $this->load->helper('url');
    $this->load->model('home_model');
  }

  public function index()
  {
    $bargains = $this->home_model->getItemsByFlag('bargains');
    $recommend = $this->home_model->getItemsByFlag('recommend');
    $hots = $this->home_model->getItemsByFlag('hot');
    $data = array(
      'hots' => $hots,
      'recommends' => $recommend,
      'bargains' => $bargains
      );
    $this->assign('data', $data);
    $this->display('homepage.html');
  }

  public function itemDetail()
  {
    $itemId = $_GET['itemid'];
    $item = $this->home_model->getItemById($itemId);
    $this->assign('item', $item);
    $this->display('item_detail.html');
  }

  public function shopCar()
  {
    if(isset($_SESSION['user'])) {
      $items = $this->home_model->getItemFromCarByUserId($_SESSION['user']->userid);
      $this->assign('items', $items);
      $this->display('shop_car.html');
    } else {
      redirect(base_url('user/showLogin'));
    }
  }

  public function addToCar()
  {
    if(isset($_SESSION['user'])) {
      $userid = $_SESSION['user']->userid;
      $itemid = $_POST['itemid'];
      $quantity = $_POST['quantity'];
      $this->home_model->addToCar($userid, $itemid, $quantity);
      echo true;
    } else {
      echo false;
    }
  }

  public function alterShopCar()
  {
      if(isset($_SESSION['user'])) {
      $userid = $_SESSION['user']->userid;
      $itemid = $_POST['itemid'];
      $quantity = $_POST['quantity'];
      $this->home_model->alterShopCar($userid, $itemid, $quantity);
      } else {
        redirect(base_url('user/showLogin'));
      }
  }

  public function deleteItem()
  {
    if(isset($_SESSION['user'])) {
      $userid = $_SESSION['user']->userid;
      $itemid = $_POST['itemid'];
      $this->home_model->deleteItem($userid, $itemid);
    } else {
      redirect(base_url('user/showLogin'));
    }
  }

  public function preItems()
  {
    $itemIds = $_POST['itemIds'];
    $totalPrice = $_POST['totalPrice'];
    $_SESSION['preOrder'] = $itemIds;
    $_SESSION['totalPrice'] = $totalPrice;
  }

  public function preOrder()
  {
    $itemIds = $_SESSION['preOrder'];
    $userid = $_SESSION['user']->userid;
    $totalPrice = $_SESSION['totalPrice'];
    $preAddr = $_SESSION['user']->address;
    $prePhone = $_SESSION['user']->telephone;
    $preName = $_SESSION['user']->username;
    $items = $this->home_model->getItemFromCarByItemIds($userid, $itemIds);
    $this->assign('totalPrice', $totalPrice);
    $this->assign('items', $items);
    $this->assign('preName', $preName);
    $this->assign('preAddr', $preAddr);
    $this->assign('prePhone', $prePhone);
    $this->display('preOrder.html');
  }

  public function showOrder()
  {
    if(isset($_SESSION['user'])) {
      $userid = $_SESSION['user']->userid;
      $orders = $this->home_model->getOrder($userid);
      $this->assign('orders', $orders);
      $this->display('order.html');
    } else {
      redirect(base_url('user/showLogin'));
    }
  }

  public function submitOrder()
  {
    if(isset($_SESSION['user'])) {
      $userid = $_SESSION['user']->userid;
      $totalPrice = $_GET['totalPrice'];
      $itemids = $_SESSION['preOrder'];
      $recipient = $_GET['recipient'];
      $orderPhone = $_GET['orderPhone'];
      $orderAddr = $_GET['orderAddr'];
      $this->home_model->addOrder($userid, $totalPrice, $itemids, $recipient, $orderPhone, $orderAddr);
      $this->home_model->deleteItems($userid, $itemids);
      redirect(base_url('home/showOrder'));
    } else {
      redirect(base_url('user/showLogin'));
    }
  }

  public function search()
  {
    $searchBrand = $_GET['searchBrand'];
    $searchClass = $_GET['searchClass'];
    if($searchBrand == ""){
      $items = $this->home_model->searchByClass($searchClass);
    } else if($searchClass == "") {
      $items = $this->home_model->searchByBrand($searchBrand);
    } else {
      $items = $this->home_model->searchByClassAndBrand($searchClass, $searchBrand);
    }
    $classes = $this->home_model->getAllClass();
    $brands = $this->home_model->getAllBrand();
    $this->assign('searchString', "");
    $this->assign('searchClass', $searchClass);
    $this->assign('searchBrand', $searchBrand);
    $this->assign('classes', $classes);
    $this->assign('brands', $brands);
    $this->assign('items', $items);
    $this->display('search.html');


  }

  public function searchByInput()
  {
    $search = $_POST['search'];
    $items = $this->home_model->searchByString($search);
    $classes = $this->home_model->getAllClass();
    $this->assign('searchString', $search);
    $brands = $this->home_model->getAllBrand();
    $this->assign('searchClass', "");
    $this->assign('searchBrand', "");
    $this->assign('classes', $classes);
    $this->assign('brands', $brands);
    $this->assign('items', $items);
    $this->display('search.html');
  }
}
