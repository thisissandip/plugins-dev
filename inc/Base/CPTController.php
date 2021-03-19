<?php

namespace Inc\Base;

class CPTController {

    public $all_CPT_to_reg = array();

    public function register(){
        $this->storeAllCustomPostType();

        if( !empty($this->all_CPT_to_reg) ){
            add_action( 'init', array( $this, 'registerCustomPostTypes' ));
        }
    }

    /* Get all the Custom Post Type from DB (all_cpts) and store them in an array To register them all
    AND check if has archives and is public is set or not
    */
    
    public function storeAllCustomPostType(){

        $all_cpts = get_option( "all_cpts" ) ? : array();
       

        foreach($all_cpts as $cpt){

            $this->all_CPT_to_reg[] = array(
                'post_type'             => $cpt['post_type'],
				'name'                  => $cpt['plural_name'],
				'singular_name'         => $cpt['singular_name'],
				'menu_name'             => $cpt['plural_name'],
				'name_admin_bar'        => $cpt['singular_name'],
				'archives'              => $cpt['singular_name'] . ' Archives',
				'attributes'            => $cpt['singular_name'] . ' Attributes',
				'parent_item_colon'     => 'Parent ' . $cpt['singular_name'],
				'all_items'             => 'All ' . $cpt['plural_name'],
				'add_new_item'          => 'Add New ' . $cpt['singular_name'],
				'add_new'               => 'Add New',
				'new_item'              => 'New ' . $cpt['singular_name'],
				'edit_item'             => 'Edit ' . $cpt['singular_name'],
				'update_item'           => 'Update ' . $cpt['singular_name'],
				'view_item'             => 'View ' . $cpt['singular_name'],
				'view_items'            => 'View ' . $cpt['plural_name'],
				'search_items'          => 'Search ' . $cpt['plural_name'],
				'not_found'             => 'No ' . $cpt['singular_name'] . ' Found',
				'not_found_in_trash'    => 'No ' . $cpt['singular_name'] . ' Found in Trash',
				'featured_image'        => 'Featured Image',
				'set_featured_image'    => 'Set Featured Image',
				'remove_featured_image' => 'Remove Featured Image',
				'use_featured_image'    => 'Use Featured Image',
				'insert_into_item'      => 'Insert into ' . $cpt['singular_name'],
				'uploaded_to_this_item' => 'Upload to this ' . $cpt['singular_name'],
				'items_list'            => $cpt['plural_name'] . ' List',
				'items_list_navigation' => $cpt['plural_name'] . ' List Navigation',
				'filter_items_list'     => 'Filter' . $cpt['plural_name'] . ' List',
				'label'                 => $cpt['singular_name'],
				'description'           => $cpt['plural_name'] . 'Custom Post Type',
				'supports'              => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'            => array( 'category', 'post_tag' ),
				'hierarchical'          => false,
				'public'                => isset($cpt['is_public']) ?: false,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => isset($option['has_archive']) ?: false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post'
            );
        }  
    }

    /* Register Post Type with all_custom_post_types_to_reg Array */

    public function registerCustomPostTypes(){
        foreach($this->all_CPT_to_reg as $post_type){

            $allargs = array(
                'labels' => array(
                    'name'                  => $post_type['name'],
                    'singular_name'         => $post_type['singular_name'],
                    'menu_name'             => $post_type['menu_name'],
                    'name_admin_bar'        => $post_type['name_admin_bar'],
                    'archives'              => $post_type['archives'],
                    'attributes'            => $post_type['attributes'],
                    'parent_item_colon'     => $post_type['parent_item_colon'],
                    'all_items'             => $post_type['all_items'],
                    'add_new_item'          => $post_type['add_new_item'],
                    'add_new'               => $post_type['add_new'],
                    'new_item'              => $post_type['new_item'],
                    'edit_item'             => $post_type['edit_item'],
                    'update_item'           => $post_type['update_item'],
                    'view_item'             => $post_type['view_item'],
                    'view_items'            => $post_type['view_items'],
                    'search_items'          => $post_type['search_items'],
                    'not_found'             => $post_type['not_found'],
                    'not_found_in_trash'    => $post_type['not_found_in_trash'],
                    'featured_image'        => $post_type['featured_image'],
                    'set_featured_image'    => $post_type['set_featured_image'],
                    'remove_featured_image' => $post_type['remove_featured_image'],
                    'use_featured_image'    => $post_type['use_featured_image'],
                    'insert_into_item'      => $post_type['insert_into_item'],
                    'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
                    'items_list'            => $post_type['items_list'],
                    'items_list_navigation' => $post_type['items_list_navigation'],
                    'filter_items_list'     => $post_type['filter_items_list']
                ),
                'label'                     => $post_type['label'],
                'description'               => $post_type['description'],
                'supports'                  => $post_type['supports'],
                'taxonomies'                => $post_type['taxonomies'],
                'hierarchical'              => $post_type['hierarchical'],
                'public'                    => $post_type['public'],
                'show_ui'                   => $post_type['show_ui'],
                'show_in_menu'              => $post_type['show_in_menu'],
                'menu_position'             => $post_type['menu_position'],
                'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
                'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
                'can_export'                => $post_type['can_export'],
                'has_archive'               => $post_type['has_archive'],
                'exclude_from_search'       => $post_type['exclude_from_search'],
                'publicly_queryable'        => $post_type['publicly_queryable'],
                'capability_type'           => $post_type['capability_type'],
            );

            register_post_type( $post_type["post_type"], $args = $allargs);
        }
    }

   
}