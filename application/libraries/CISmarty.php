<?php
if(!defined('BASEPATH')) EXIT('No direct script asscess allowed');
require_once( APPPATH . 'libraries/Smarty/Smarty.class.php' );

class CiSmarty extends Smarty {
  protected $ci;
  public function  __construct(){
    $this->ci = & get_instance();
    $this->ci->load->config('smarty');//加载smarty的配置文件
    //获取相关的配置项
    $this->setTemplateDir($this->ci->config->item('template_dir')) ;
    $this->setCompileDir($this->ci->config->item('compile_dir')) ;
    $this->setCacheDir($this->ci->config->item('cache_dir')) ;
    $this->setConfigDir($this->ci->config->item('config_dir')) ;
    $this->setCaching($this->ci->config->item('caching')) ;
    $this->setCacheLifetime($this->ci->config->item('lefttime')) ;
    $this->setLeftDelimiter($this->ci->config->item('leftdelimiter'));
    $this->setRightDelimiter($this->ci->config->item('rightdelimiter'));
  }
}