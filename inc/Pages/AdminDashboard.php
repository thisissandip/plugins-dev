<?php

/* @package SandipPlugin */

namespace Inc\Pages;

use \Inc\Api\SettingsAPI;
use \Inc\Api\MediaWidgetAPI;
use \Inc\Api\SubSettings\CPTSettings;
use \Inc\Api\SubSettings\TAXSettings;
use \Inc\Base\BaseController;

class AdminDashboard extends BaseController{

    public $settingsAPI;

    public $activatedPlugin;
    public $checked;

    function register(){
        $this->settingsAPI = new SettingsAPI();
        /* Add the AdminDashboard Page */
        add_action( "admin_menu", array($this, "AdminMenuPages") );
        /* Register Settings For Admin DashBoard */
        add_action("admin_init", array($this->settingsAPI, "RegisterPluginsSetting"));
    }

    function AdminMenuPages(){
        /* Add the Menu Page with Menu Option in Sidebar */
        add_menu_page( "Sandip Plugin", "Sandip Plugin", "manage_options", "sandip-plugin", 
        array($this, "sandip_dash_template"), $icon_url = "", $position = null );


        /* Check all the subplugins, Check If they are activated, If yes then add submenu Page and Intialise the Settings Fields */
            foreach($this->pluginsmanager as $key=>$value){
               $this->checked = get_option( $key );
    
              if($this->checked == 1){
                switch($key){
                    case "cpt_manager":
                        add_submenu_page( $parent_slug = "sandip-plugin", $page_title = $value, 
                        $menu_title = "CPT Manager", $capability= "manage_options",
                        $menu_slug = $key , $function = array($this, "sandip_cpt_template"), 
                        $position = null ); 
                        $this->settingsAPI = new CPTSettings();
                        break;
                        
                    case "taxonomy_manager":
                        add_submenu_page( $parent_slug = "sandip-plugin", $page_title = $value, 
                        $menu_title = "Taxonomy Manager", $capability= "manage_options",
                        $menu_slug = $key , $function = array($this, "sandip_taxonomy_template"), 
                        $position = null ); 
                        new TAXSettings();
                        break;

                    case "media_widget":                       
                    case "embed_widget":
                        break;
                    case "testimonial_manager":
                        add_submenu_page( $parent_slug = "sandip-plugin", $page_title = $value, 
                        $menu_title = "Testimonial Manager", $capability= "manage_options",
                        $menu_slug = $key , $function = array($this, "sandip_testimonial_template"), 
                        $position = null ); 
                    default:
                        break;
                }
              }
            }
       
    }

    function sandip_dash_template(){
        require $this->pluginPATH. "templates/SandipDash.php";
    }

    public function sandip_cpt_template(){
        require $this->pluginPATH. "templates/CPTtemplate.php";
    }

    public function sandip_taxonomy_template(){
        require $this->pluginPATH. "templates/TAXONOMYtemplate.php";
    }

    public function sandip_testimonial_template(){
        require $this->pluginPATH. "templates/TESTIMONIALtemplate.php";
    }
}