<?php

namespace PluginBoilerplate\PostTypes;


abstract class PostType {


    public static $slug;


    public function field_groups() {
        return array();
    }
    

    public function default_posts() {
        return array();
    }


    public function __construct() {

        // Do register post type
        add_action( 'init', array( $this, 'register_post_type' ), 11 );

        // Insert default terms
        add_action( 'init', array( $this, 'insert_default_content' ), 12 );

        // Add Custom Fields
        $this->register_custom_fields();

    }


    abstract public function register_post_type();


    public function insert_default_content() {
        
        $posts = $this->default_posts();

        foreach ( $posts as $post ) {
            wp_insert_post( $post );
        }

    }
    

    final public function register_custom_fields() {

        $field_groups = $this->field_groups();

        // Force fields to appear when editing current post type
        $rule = array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => static::$slug,
        );

        // Do register field groups
        foreach ( $field_groups as $field_group ) {
            
            if ( array_key_exists( 'location', $field_group ) ) {
                $field_group['location'][] = array( $rule );
            }
            else {
                $field_group['location'] = array( array($rule) );
            }

            acf_add_local_field_group( $field_group );
            
        }

    }


}