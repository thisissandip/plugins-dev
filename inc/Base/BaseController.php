<?php

/* @package SandipPlugin */

namespace Inc\Base;

class BaseController{

    public $pluginPATH;
    public $pluginURL;
    public $publicBASENAME;

    public function __construct(){

        $this->pluginPATH = plugin_dir_path( dirname(__FILE__, 2) );
        $this->pluginURL = plugin_dir_url( dirname(__FILE__, 2) );
        $this->pluginBASENAME = "sandip-plugin.php";

        $this->pluginsmanager = array(
            "cpt_manager" => "Activate CPT Manager",
            "taxonomy_manager" => "Activate Taxonomy",
            "media_widget" => "Activate Media Widget",
            "embed_widget" => "Activate Embed Widget",
            "testimonial_manager" => "Activate Testimonial Manager",
            "front_login" => "Activate Front Login",
            "custom_template" => "Activate Custom Template"
        );
    }
}