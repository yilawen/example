<?php
 if (!defined('BASEPATH')) exit('No direct access allowed.');
class MY_Controller extends CI_Controller {
    protected $root;

    public function __construct() {
        parent::__construct();
        $this->config->load('config');
        $this->root = $this->config->base_url();
        $this->assign('root', $this->root);
    }

    public function assign($key,$val) {
        $this->cismarty->assign($key,$val);
    }

    public function display($html) {
        $this->cismarty->display($html);
    }
}