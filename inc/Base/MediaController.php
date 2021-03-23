<?php

namespace Inc\Base;

use \Inc\Api\MediaWidgetAPI;

class MediaController {
 
    public $mediaActivated;

    public $mediawidget;

    public function register(){

        $this->mediaActivated = get_option("media_widget");
   
        if($this->mediaActivated == 1 ){
            $this->mediawidget = new MediaWidgetAPI();
            $this->mediawidget->register(); 
        }
        
    }
}