<?php 

namespace PluginBoilerplate\Shortcodes;


abstract class Shortcode {


    protected $shortcode;


    public function __construct() {

        // Register shortcode
        add_action( 'init', array( $this, 'register_shortcode' ), 15 );

    }


    public function register_shortcode() {

        add_shortcode( $this->shortcode, array( $this, 'output_shortcode' ) );

    }


    abstract public function output_shortcode( $atts, $content='' );


}