<?php

namespace Inc\Api;

use \Inc\Base\BaseController;
use \Inc\Api\ManageSubPlugins;

class SettingsAPI extends BaseController {

    public $allpluginsmanager;

    public function RegisterPluginsSetting(){
        /* Register Settings and Fields For Manage Tab */
        foreach($this->pluginsmanager as $key=>$value){
            register_setting( "sandip_plugins_manager", $key, array($this,"checkboxSanitize" ) );
        }
        $this->AddSettingSection()->AddSettingFields();
        return $this;
    }

    public function AddSettingSection(){
        add_settings_section( "pluginsmanager_sections", "",  
        array($this, "pluginsmanager_sections_display"), "sandip-plugin" );
        return $this;
    }

    public function AddSettingFields(){
        foreach($this->pluginsmanager as $key=>$value)
        {
            add_settings_field( $id = $key, $title = $value, 
            $callback = array($this, "pluginsmanager_checkboxfield"), $page = "sandip-plugin", 
            $section = "pluginsmanager_sections", $args = array(
                "label_for" => $key,
                "class" => "plugin-row",
                "option_name" => $key
            ) );
        }
        return $this;
    }

    public function checkboxSanitize($input){
        return $input;
    }


    public function pluginsmanager_sections_display(){
        echo "<div>Manage Your Plugins</div>";
    }

    public function pluginsmanager_checkboxfield($args){

        $option_name = $args["option_name"];
        $labelfor = $args["label_for"];
        $checked = get_option( $args["option_name"]);


       // var_dump($checked);
        echo '

            <label for="'. $labelfor .'">
            <input id="'. $option_name .'"  type="checkbox" value="1"
            class="regular-text" name="'. $option_name .'" '. ($checked ? "checked" : "") . ' /> 
            <span class="slider-bg">
            <span class="slider-circle"></span> 
            </span> 
           
            </label>
       ';
    }


}