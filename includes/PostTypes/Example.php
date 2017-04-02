<?php

namespace PluginBoilerplate\PostTypes;


class Example extends PostType {


    public static $slug = 'post_type_slug';


    public function field_groups() {

        // Post type ACF Fields
        return array();

    } 


    public function register_post_type() {

        $args = array(
            'labels' => array(
                'name'          => __( 'Example' ),
                'singular_name' => __( 'Example' ),
                'add_new_item'  => __( 'Add an Example' ),
                'edit_item'     => __( 'Edit Example' ),
            ),
            'public'        => true,
            'exclude_from_search' => true,
            'has_archive'   => false,
            'menu_icon'     => 'dashicons-xx', //https://developer.wordpress.org/resource/dashicons/
            'supports'      => array('title', 'editor', 'thumbnail', 'revisions'),
        );

        register_post_type( self::$slug, $args );

    }



}