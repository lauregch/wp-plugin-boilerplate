<?php

namespace PluginBoilerplate\Taxonomies;

use PluginBoilerplate\PostTypes\Example as ExamplePostType;


class Example extends Taxonomy {


    public static $slug = 'tax_slug';


    public function field_groups() {

        // ACF custom fields
        return array();

    } 


    protected function default_terms() {

        return array(

            'EX_NAME' => array(
                'term' => array(
                    'slug' => 'ex_name',
                    'description' => 'EXAMPLE DESC',
                ),
                'fields' => array(
                    'acf_field_name' => 'acf_field_value'
                )
            )

        );

    } 


    public function register_taxonomy() {

        $args = array(
            
            'labels'   => array(
                'name'          => __('Example Tax'),
                'singular_name' => __('Example Tax')
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'meta_box_cb' => false

        );

        register_taxonomy(
            self::$slug,
            array( ExamplePostType::$slug ),
            $args
        );

    }



}