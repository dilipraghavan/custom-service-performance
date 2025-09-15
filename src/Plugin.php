<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance;

use WPSHIFTSTUDIO\CustomServicePerformance\Admin\Admin;
use WPSHIFTSTUDIO\CustomServicePerformance\Frontend\Shortcode;
use WPSHIFTSTUDIO\CustomServicePerformance\Core\PostType;
use WPSHIFTSTUDIO\CustomServicePerformance\Core\Enqueue;

class Plugin {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Enqueue scripts and styles
        new Enqueue();
        
        // Register core components
        new PostType();
        new Admin();
        new Shortcode();

        // Add settings link to plugin page
        add_filter( 'plugin_action_links_' . plugin_basename( CSP_PLUGIN_FILE ), [ $this, 'add_settings_link' ] );
    }

    public function add_settings_link( $links ) {
        $settings_link = '<a href="options-general.php?page=csp_settings_page">' . __( 'Settings', 'custom-service-performance' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
}