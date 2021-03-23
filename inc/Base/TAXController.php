<?php

namespace Inc\Base;

class TAXController {

    public $taxToreg = array();

    public function register(){
        $this->storeAllTaxnomy();

        if( !empty($this->taxToreg)){
            add_action( 'init', array( $this, 'RegisterAllTaxnomy' ));
        }
    }

    public function storeAllTaxnomy(){
        $alltax = get_option( "all_taxonomy") ?: array();
       
        foreach($alltax as $taxonomy){

            $labels = array(
				'name'              => $taxonomy['singular_name'],
				'singular_name'     => $taxonomy['singular_name'],
				'search_items'      => 'Search ' . $taxonomy['singular_name'],
				'all_items'         => 'All ' . $taxonomy['singular_name'],
				'parent_item'       => 'Parent ' . $taxonomy['singular_name'],
				'parent_item_colon' => 'Parent ' . $taxonomy['singular_name'] . ':',
				'edit_item'         => 'Edit ' . $taxonomy['singular_name'],
				'update_item'       => 'Update ' . $taxonomy['singular_name'],
				'add_new_item'      => 'Add New ' . $taxonomy['singular_name'],
				'new_item_name'     => 'New ' . $taxonomy['singular_name'] . ' Name',
				'menu_name'         => $taxonomy['singular_name'],
			);

			$this->taxToreg[] = array(
				'hierarchical'      => isset($taxonomy['hierarchical']) ? true : false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => $taxonomy['tax_id'] ),
				'objects'           => isset($taxonomy['objects']) ? array_keys($taxonomy['objects'])  : null
			);
        }
    }


    public function RegisterAllTaxnomy(){     

        foreach($this->taxToreg as $mytaxonomy){
            $objects = isset($mytaxonomy["objects"]) ? $mytaxonomy["objects"]  : null;

            register_taxonomy( $taxonomy = $mytaxonomy["rewrite"]["slug"], 
            $object_type = $objects , $args = $mytaxonomy );  
        }

 
     
    }
}