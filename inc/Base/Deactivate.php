<?php

/** 
* @package SandipPlugin
 */ 

namespace Inc\Base;

class Deactivate{
    public static function register(){
        flush_rewrite_rules( );
    }
}