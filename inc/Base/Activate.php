<?php

/** 
* @package SandipPlugin
 */ 

namespace Inc\Base;

class Activate{
    public static function register(){
        flush_rewrite_rules( );

        $default = array();

        if(!get_option( "all_cpts")){
            update_option( "all_cpts", $default);
        }
    }
}