<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class FrontLoginController extends BaseController{

    public $isActivated;

    public function register(){
        $this->isActivated = get_option( "front_login" );

        if($this->isActivated == 1){
      
        }
    }
}