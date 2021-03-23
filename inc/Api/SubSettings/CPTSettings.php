<?php

namespace Inc\Api\SubSettings;

use \Inc\Base\BaseController;
use \Inc\Api\ManageSubPlugins;

class CPTSettings extends BaseController {

    public function __construct(){
        add_action("admin_init", array($this, "register"));
    }

    /* Register CPT and create setting, sections, fields -> Sanitize the inputs  */
    public function register(){
        register_setting( "sandip_cpt_OG", "all_cpts", $args = array($this, "sanitizeInput") );

        add_settings_section( "sandip_cpt_section", "",  
        array($this, "sandip_cpt_section_display"), "cpt_manager" );

        add_settings_field( $id = "post_type", $title = "Custom Post Type ID", 
        $callback = array($this, "textfield"), $page = "cpt_manager", 
        $section = "sandip_cpt_section", $args = array(
            "id" => "post_type",
            "class" => "plugin-row",
            "option_name" => "all_cpts"
        ) );

        add_settings_field( $id = "singular_name", $title = "Singular Name", 
        $callback = array($this, "textfield"), $page = "cpt_manager", 
        $section = "sandip_cpt_section", $args = array(
            "id" => "singular_name",
            "class" => "plugin-row",
            "option_name" => "all_cpts"
        ) );

        add_settings_field( $id = "plural_name", $title = "Plural Name", 
        $callback = array($this, "textfield"), $page = "cpt_manager", 
        $section = "sandip_cpt_section", $args = array(
            "id" => "plural_name",
            "class" => "plugin-row",
            "option_name" => "all_cpts"
        ) );

        add_settings_field( $id = "is_public", $title = "Public", 
        $callback = array($this, "checboxFields"), $page = "cpt_manager", 
        $section = "sandip_cpt_section", $args = array(
            "id" => "is_public",
            "class" => "plugin-row",
            "option_name" => "all_cpts"
        ) );

        add_settings_field( $id = "has_archives", $title = "Archive", 
        $callback = array($this, "checboxFields"), $page = "cpt_manager", 
        $section = "sandip_cpt_section", $args = array(
            "id" => "has_archives",
            "class" => "plugin-row",
            "option_name" => "all_cpts"
        ) );

       

    }

    public function sanitizeInput($input){
        /* Get exisiting data from option name */
        $output = get_option( "all_cpts" );

        /* If remove is set, then delete cpt with the ID attached to It */
        if( isset($_POST["remove"]) ){
            unset($output[$_POST["remove"]]);
            return $output;
        }

        /* If existing data is empty fill output array with entered CPT 
         with CPT id as it's key */
          if( empty($output) ){
            $output = array();
            $output[$input["post_type"]] = $input;
            return $output;
          }
          /* If existing data is not empty, Check existing data pair, If 
          an array with same key(CPT) exists update it. If not, then update the 
          array with same the new CPT with CPT id as it's key
         */
          else
          {
              foreach($output as $key=>$value){
                  if($input["post_type"] == $key){
                      $output[$key] = $input; 
                  }else{
                    $output[$input["post_type"]] = $input;
                  } 
              }
              return $output;
          }
    }

    public function sandip_cpt_section_display(){
        echo "<strong>Add New Custom Post Type</strong>";
    }

    public function textfield($args){

        $value = "";

        $id = $args["id"];
        $option_name = $args["option_name"];
        $name = $option_name. "[". $id ."]";

        if(isset($_POST["edit_post"])){
            /* get all cpts */
            $allcpts = get_option("all_cpts");
            /* get the required cpt array */
            $reqCPT = $allcpts[$_POST["edit_post"]]; 
            /* get the values of all field in that array */
            $value = $reqCPT[$id];
        }

        echo '<input type="text" class="regular-text" id='. $id .' name='. $name.' 
        value = "'. $value .'"
        required />';
    }

    public function checboxFields( $args){
       
        $id = $args["id"];
        $option_name = $args["option_name"];
        $name = $option_name. "[". $id ."]";

        $checked = false;

        if(isset($_POST["edit_post"])){
            /* get all cpts */
            $allcpts = get_option("all_cpts");
            /* get the required cpt array */
            $reqCPT = $allcpts[$_POST["edit_post"]]; 
            /* check if the fields are set if they are then check if it is 1 */
            $checked = isset($reqCPT[$id]) ? ($reqCPT[$id]==1 ? true : false ) : false ;
        }

        echo '
            <label for="'. $id .'">
                <input id="'. $id .'"  type="checkbox" value="1"
                class="regular-text" name="'. $name .'" 
                '.($checked ? "checked" : "").' /> 
                <span class="slider-bg">
                    <span class="slider-circle"></span> 
                </span> 
            </label>
       ';
    }

}