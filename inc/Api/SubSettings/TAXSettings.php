<?php

namespace Inc\Api\SubSettings;

use \Inc\Base\BaseController;

class TAXSettings extends BaseController {

    public function __construct(){
        add_action("admin_init", array($this, "register"));
    }

    /* Register CPT and create setting, sections, fields -> Sanitize the inputs  */
    public function register(){
        register_setting( "sandip_TAX_OG", "all_taxonomy", $args = array($this, "sanitizeInput") );

        add_settings_section( "sandip_TAX_section", "",  
        array($this, "sandip_TAX_section_display"), "taxonomy_manager" );

        add_settings_field( $id = "tax_id", $title = "Taxonomy ID", 
        $callback = array($this, "textfield"), $page = "taxonomy_manager", 
        $section = "sandip_TAX_section", $args = array(
            "id" => "tax_id",
            "class" => "plugin-row",
            "option_name" => "all_taxonomy"
        ) );

        add_settings_field( $id = "singular_name", $title = "Singular Name", 
        $callback = array($this, "textfield"), $page = "taxonomy_manager", 
        $section = "sandip_TAX_section", $args = array(
            "id" => "singular_name",
            "class" => "plugin-row",
            "option_name" => "all_taxonomy"
        ) );

        add_settings_field( $id = "hierarchical", $title = "Hierarchical", 
        $callback = array($this, "checboxFields"), $page = "taxonomy_manager", 
        $section = "sandip_TAX_section", $args = array(
            "id" => "hierarchical",
            "class" => "plugin-row",
            "option_name" => "all_taxonomy"
        ) );

        add_settings_field( $id = "objects", $title = "Objects", 
        $callback = array($this, "ObjectChecboxFields"), $page = "taxonomy_manager", 
        $section = "sandip_TAX_section", $args = array(
            "id" => "objects",
            "class" => "plugin-row",
            "option_name" => "all_taxonomy"
        ) );

    }

    public function sanitizeInput($input){
        /* Get exisiting data from option name */
        $output = get_option( "all_taxonomy" );

        /* If remove is set, then delete cpt with the ID attached to It */
        if( isset($_POST["remove"]) ){
            unset($output[$_POST["remove"]]);
            return $output;
        }

        /* If existing data is empty fill output array with entered CPT 
         with CPT id as it's key */
          if( empty($output) ){
            $output = array();
            $output[$input["tax_id"]] = $input;

            return $output;
          }
          /* If existing data is not empty, Check existing data pair, If 
          an array with same key(CPT) exists update it. If not, then update the 
          array with same the new CPT with CPT id as it's key
         */
          else
          {
              foreach($output as $key=>$value){
                  if($input["tax_id"] == $key){
                      $output[$key] = $input; 
                  }else{
                    $output[$input["tax_id"]] = $input;
                  } 
              }
              return $output;
          }
    }

    public function sandip_TAX_section_display(){
        echo "<strong>Add New Taxonomy</strong>";
    }

    public function textfield($args){

        $value = "";

        $id = $args["id"];
        $option_name = $args["option_name"];
        $name = $option_name. "[". $id ."]";

        if(isset($_POST["edit_tax"])){
            /* get all tax */
            $allcpts = get_option("all_taxonomy");
            /* get the required tax array */
            $reqTAX = $allcpts[$_POST["edit_tax"]]; 
            /* get the values of all field in that array */
            $value = $reqTAX[$id];
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

        if(isset($_POST["edit_tax"])){
            /* get all tax */
            $allcpts = get_option("all_taxonomy");
            /* get the required tax array */
            $reqTAX = $allcpts[$_POST["edit_tax"]]; 
            /* check if the fields are set if they are then check if it is 1 */
            $checked = isset($reqTAX[$id]) ? ($reqTAX[$id]==1 ? true : false ) : false ;
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

    public function ObjectChecboxFields( $args){

        $id = $args["id"];
        $option_name = $args["option_name"];
        $name = $option_name. "[". $id ."]";

        $allPostTypes = get_post_types(array("show_ui" => true));

        $checked = false;

        foreach($allPostTypes as $posttype){

            if(isset($_POST["edit_tax"])){
                /* get all TAX */
                $allcpts = get_option("all_taxonomy");
                /* get the required tax array */
                $reqTAX = $allcpts[$_POST["edit_tax"]]; 
                /* check if the fields are set if they are then check if it is 1 */
                $checked = isset($reqTAX[$id][$posttype]) ? ($reqTAX[$id][$posttype]==1 ? true : false ) : false ;
            
           /*  var_dump($$reqCPT[$id][$posttype]);
            die(); */
            }

            echo '
            <label for="'.  $posttype .'">
            <input id="'. $posttype .'"  type="checkbox" value="1"
            class="regular-text" name="'. $name.'['. $posttype .']' .'" 
            '.($checked ? "checked" : "").' /> 
            <span class="slider-bg" style="margin-bottom: 5px">
                <span class="slider-circle"></span> 
            </span> 
        </label>
        <div style="display: inline-block; "  >'. strtoupper($posttype) .'</div>
         <br>';
        }
    }

}