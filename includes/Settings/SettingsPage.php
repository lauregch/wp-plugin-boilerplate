<?php

namespace PluginBoilerplate\Settings;


abstract class SettingsPage {


    protected static $options_key;
    protected $labels;



    protected static $instances;

    final public static function instance() {
        
        $class = get_called_class();

        if ( ! isset( static::$instances[$class] ) )
            static::$instances[$class] = new $class();

        return static::$instances[$class];

    }


    protected function __construct() {

        // Add page in Settings menu
        if ( ! array_key_exists( 'parent_slug', $this->labels ) ) {
            acf_add_options_page( $this->labels + array( 'redirect' => false ) );
        }
        else {
            acf_add_options_sub_page( $this->labels );
        }

        // Add fields in option page
        $this->create_fields();

        // Enqueue scripts
        $this->register_scripts();

        // Hooks
        $this->register_hooks();

    }


    abstract protected function options();


    protected function register_scripts() {}

    protected function register_hooks() {}


    private function create_fields() {

        $field_group = array(
            'key' => static::$options_key."_fieldgroup",
            'title' => $this->labels['page_title'],
            'style' => 'seamless',
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => $this->labels['menu_slug'],
                    ),
                ),
            ),
            'fields' => array()
        );


        $options = $this->options();

        foreach ( $options as $group_key => $group ) {
            
            $field_group['fields'][] = array( 
                'key' => static::$options_key."_field_{$group_key}_tab",
                'label' => array_key_exists('name', $group) ? $group['name'] : $group_key,
                'name' => static::$options_key."_{$group_key}_tab",
                'type' => 'tab'
            );

            foreach ( $group['fields'] as $field ) {

                $field_group['fields'][] = wp_parse_args(
                    array(
                        'name' => static::$options_key."_{$field['name']}",
                        'key' => static::$options_key."_field_{$field['name']}"
                    ),
                    $field
                );

            }

        }

        acf_add_local_field_group( $field_group );

    }



    static public function get( $name ) {

        return get_field( static::$options_key."_{$name}", 'option' );

    }


    static public function set( $name, $value ) {

        update_field( "field_".static::$options_key."_{$name}", $value, 'option' );

    }



}