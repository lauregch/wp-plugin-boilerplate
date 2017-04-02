<?php 

namespace PluginBoilerplate\Schedules;


abstract class Schedule {


    protected $frequency;

    public static $hook_slug;


    public function __construct( $frequency='hourly' ) {

        $this->frequency = $frequency;
        $this->update_schedule();

    }


    final public function update_schedule() {

        $current_schedule = wp_get_schedule( static::$hook_slug );
        $option_schedule = $this->frequency;

        if ( ! wp_next_scheduled( static::$hook_slug ) || $current_schedule != $option_schedule ) {

            wp_clear_scheduled_hook( static::$hook_slug );
            wp_schedule_event( time(), $option_schedule, static::$hook_slug );

        }

        add_action( static::$hook_slug, array( $this, 'run' ) );

    }


    final public function remove_schedule() {

        remove_action( static::$hook_slug, array( $this, 'run' ) );
        wp_clear_scheduled_hook( static::$hook_slug );

    }


    abstract public function run();


}