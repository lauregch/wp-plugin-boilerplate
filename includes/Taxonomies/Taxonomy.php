<?php

namespace PluginBoilerplate\Taxonomies;


abstract class Taxonomy {


    public static $slug;

    abstract public function field_groups();

    protected function default_terms() {
        return array();
    }


    public function __construct() {

        // Do register post type
        add_action( 'init', array( $this, 'register_taxonomy' ), 13 );

        // Insert default terms
        add_action( 'init', array( $this, 'insert_default_terms' ), 14 );

        // Add Custom Fields
        $this->register_custom_fields();

    }


    abstract public function register_taxonomy();


    final public function insert_default_terms() {

        foreach ( $this->default_terms() as $name => $data ) {
            
            // Insert term
            $res = wp_insert_term( $name, static::$slug, $data['term'] );

            // Init custom fields
            if ( array_key_exists( 'fields', $data ) ) {

                if ( ! is_wp_error($res) ) {
                    $term_id = $res['term_id'];
                }
                elseif ( is_wp_error($res) && array_key_exists( 'term_exists', $res->errors ) ) {
                    $term_id = $res->error_data[ 'term_exists' ];
                }

                if ( isset( $term_id ) ) {

                    $fields = $data['fields'];
                    
                    foreach ( $fields as $key => $value ) {
                        update_field( $key, $value, static::$slug.'_'.$term_id );
                    }

                }
                
            }
            
        }

    }


    protected function register_custom_fields() {

        foreach ( $this->field_groups() as $field_group ) {

            $field_group['location'] = array( array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => static::$slug
                )
            ));

            acf_add_local_field_group( $field_group );

        }

    }



}