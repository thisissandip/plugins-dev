<?php

/* @package SandipPlugin */

namespace Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController{
    function register(){
        /* ENQUEUE THE SCRIPTS */
        add_action('admin_enqueue_scripts', array($this, "EnqueueScript"));
    }

    function EnqueueScript(){
        wp_enqueue_style( "sandip_plugin_adminstyle", $this->pluginURL."src/adminstyles.css" );
        wp_enqueue_script( "sandip_plugin_adminscript", $this->pluginURL."src/adminscripts.js", $deps = array(), $ver="1.0", $in_footer=true );
    }
}