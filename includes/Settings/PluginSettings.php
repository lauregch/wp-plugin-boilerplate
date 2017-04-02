<?php

namespace PluginBoilerplate\Settings;


class PluginSettings extends SettingsPage {


    static $options_key = 'plblp';


    protected $labels = array(
        'page_title' => 'Plugin Boilerplate Options',
        'menu_title' => 'Plugin',
        'menu_slug' => 'plugin-boilerplate',
        'parent_slug' => 'options-general.php'
    );


    public function register_hooks() {

        add_filter( 'acf/load_field/key=' . self::$options_key.'_field_xxx', array( $this, 'do_sth' ) );
        // etc

    }


    protected function options() {

        // Insert here ACF custom fields
        $options = array();

        return $options;

    }


}


