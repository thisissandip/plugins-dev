<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class CustomPageTemplateController extends BaseController{

    public $isActivated;

    /* A variable to store all Custom Page Templates as array */
    public $myCustomTemplates;

    public function register(){
        $this->isActivated = get_option( "custom_template" );

        if($this->isActivated == 1){
            /* Fill the array with key as location of theme file and value as Template Name */
            $this->myCustomTemplates = array(
                "templates/SpecialTemplate.php" => "Special Template",
            );

            // include the custom template
		    add_filter( 'theme_page_templates', array( $this, 'add_custom_template' ) );

            // render the template
		    add_filter( 'template_include', array( $this, 'load_template' ) );
        }
    }

    /* 
    This arguments templates in the below function is an array which has all the 
    templates that are exisiting in the theme so we have to merge our 
    custom templates in this array
    */

    public function add_custom_template($templates){
        $templates = array_merge($templates, $this->myCustomTemplates );
        return $templates;
    }

    /*
    The argument of this function is the template which is to be rendered
    */

    public function load_template( $template ){
    global $post;

    /*
    First Check if the template is being accessed via a Post. 
    If it is not then return the default $template
    */

    if ( ! $post ) {
        return $template;
    }

    /*

    // If it is the front page, load a custom template and return the template file
	
    if ( is_front_page() ) {
		$file = $this->pluginPATH . 'templates/front-page.php';

		if ( file_exists( $file ) ) {
			return $file;
		}
	}

    */

    /*  
        If it is coming from a post, get the meta info
		of the post. Get the meta key _wp_page_template which holds the 
		template name which is being used by the post

		Then check if the template is actually included by us in out custom
		template array. If not then return the default template
		Else get the file and if file exists return the template file
    */

    $template_name = get_post_meta( $post->ID, '_wp_page_template', true );

    if ( ! isset( $this->myCustomTemplates[$template_name] ) ) {
        return $template;
    }

    $file = $this->pluginPATH . $template_name;

    if ( file_exists( $file ) ) {
        return $file;
    }   
    else{
        return $template;
    }

    }

}