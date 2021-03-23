<?php

namespace Inc\Base;

use \Inc\API\EmbedWidgetAPI; 

class EmbedController {

    public $isActivated;
    public $API;

    public function register(){
        $this->isActivated = get_option( "embed_widget" );

        if($this->isActivated == 1){
            $this->API = new EmbedWidgetAPI();
            $this->API->register();
        }
    }
}