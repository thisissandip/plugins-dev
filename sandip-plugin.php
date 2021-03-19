<?php
/**
 * @package  SandipPlugin
 */
/*
Plugin Name: Sandip Plugin
Description: This is my first attempt on writing a custom Plugin.
Version: 1.0.0
Author: Sandip Mondal
License: GPLv2 or later
Text Domain: sandip-plugin
*/

defined('ABSPATH') or die('You Cannot Access this file directly');

use Inc\Init;
use Inc\Base\Activate;
use Inc\Base\Deactivate;

if(file_exists(dirname(__FILE__) . "/vendor/autoload.php")){
    require_once dirname(__FILE__) . "/vendor/autoload.php";
}

function activate_sandip_plugin()
{
    /* Activate Code */
    Activate::register();
}

function deactivate_sandip_plugin()
{
      /* Deactivate Code */
      Deactivate::register();
}

register_activation_hook( __FILE__, "activate_sandip_plugin" );
register_deactivation_hook( __FILE__, "deactivate_sandip_plugin" );

if(class_exists('Inc\Init')){
    Init::regsiter_servicies();
}