<?php

namespace PluginBoilerplate;

use PluginBoilerplate\Taxonomies;
use PluginBoilerplate\PostTypes;
use PluginBoilerplate\Shortcodes;
use PluginBoilerplate\Schedules;


class Core {

    protected $post_types = array();
    protected $taxonomies = array();
    protected $shortcodes = array();
    protected $schedules = array();


    public function __construct() {

        // Register Post Types
        $this->register_post_types();

        // Register Taxonomies
        $this->register_taxonomies();

        // Register Shortcodes
        $this->register_shortcodes();

        // Register Cron Schedules
        $this->register_schedules();

    }


    protected function register_post_types() {

        $this->post_types = array(
            new PostTypes\Example()
        );

    }


    protected function register_taxonomies() {

        $this->taxonomies = array(
            new Taxonomies\Example()
        );

    }


    protected function register_shortcodes() {

        $this->shortcodes = array(
            new Shortcodes\Example()
        );

    }


    protected function register_schedules() {

        $this->schedules = array(
            new Schedules\Example()
        );

    }
    

}