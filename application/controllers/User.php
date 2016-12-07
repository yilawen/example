<?php
class User extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('user_model');
    $this->load->helper('url');
    session_start();
    if(isset($_SESSION['user'])) {
      $this->assign('username', $_SESSION['user']->username);
    } else {
      $this->assign('username', null);
    }
  }

  public function loginDetect()
  {
    if(!isset($_SESSION['user'])) {
      redirect(base_url('user/showLogin'));
    }
  }

  public function showLogin()
  {
    $this->display('login.html');
  }

  public function login()
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $this->user_model->authenticate($username, $password);
    if($result) {
      global $user;
      $user = $result;
      $_SESSION['user'] = $user;
      echo true;
    } else {
      echo false;
    }
  }

  public function showRegister()
  {
    $this->display('register.html');
  }

  public function register()
  {
    $username = isset($_POST['username'])?$_POST['username']:null;
    $password = isset($_POST['password'])?$_POST['password']:null;
    $telephone = $_POST['telephone'] == ''?null:$_POST['telephone'];
    $address = $_POST['address'] == ''?null:$_POST['address'];
    $result = $this->user_model->insertUser($username, $password, $telephone, $address);
    if($result) {
      echo true;
    } else {
      echo false;
    }
  }

  public function userDetail()
  {
    $this->loginDetect();
    $user = $this->user_model->getUserById($_SESSION['user']->userid);
    $this->assign('user', $user);
    $this->display('user_detail.html');
  }

  public function updatePwd()
  {
    $this->loginDetect();
    $username = $_SESSION['user']->username;
    $oldPwd = $_POST['oldPwd'];
    $result = $this->user_model->authenticate($username, $oldPwd);
    if($result) {
      $newPwd = $_POST['newPwd'];
      $this->user_model->updatePwd($_SESSION['user']->userid, $newPwd);
      echo true;
    } else {
      echo false;
    }
  }

  public function updateInf()
  {
    $this->loginDetect();
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $data = array(
      'telephone' => $telephone,
      'address' => $address
      );
    $this->user_model->updateInf($_SESSION['user']->userid, $data);
  }

  public function logout()
  {
    session_destroy();
    $this->showLogin();
  }
}
