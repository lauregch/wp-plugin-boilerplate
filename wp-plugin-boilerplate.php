<?php
/*
Plugin Name: Plugin Boilerplate
Version: 1.0
Author: Laure Guicherd
Author Email: laure.guicherd@gmail.com
*/

namespace PluginBoilerplate;

use PluginBoilerplate\Settings\PluginSettings as Settings;


require_once( plugin_dir_path( __FILE__ ) . 'autoload.php' );



class Plugin {


    public function __construct() {

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'init', array( $this, 'init' ) );

    }

    public function init() {

        // Core elements (post types, shortcodes, ...)
        new Core();

        // Initiate plugin settings
        Settings::instance();

        // Public features
        new PublicFeatures\Example();

        // Admin features
        if ( is_admin() ) {
            new Admin\Example();
        }

    }


    public function activate() {
        // Nothing to do here yet.
    }

    public function deactivate() {
        // Nothing to do here yet.
    }

}



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// if ACF is not active, abort.
if ( ! class_exists('acf') ) {
    wp_die( 'The Advanced Custom Fields plugin must be activated to use this plugin.' );
}

new Plugin();
