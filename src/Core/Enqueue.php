<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance\Core;

class Enqueue {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
    }
    
    public function enqueue_frontend_scripts() {
        $css_file_url = CSP_PLUGIN_URL . 'assets/css/csp-styles.css';
        $css_file_path = CSP_PLUGIN_DIR . 'assets/css/csp-styles.css';
        $css_file_version = filemtime($css_file_path);

        wp_enqueue_style( 'csp-styles', $css_file_url, [], $css_file_version );
    }

    public function enqueue_admin_scripts() {
        $screen = get_current_screen();
        if ($screen->id === 'csp_service') {
            $script_url = CSP_PLUGIN_URL . 'assets/js/csp-script.js';
            $script_path = CSP_PLUGIN_DIR . 'assets/js/csp-script.js';
            $script_version = filemtime($script_path);

            wp_enqueue_script( 'csp-scripts', $script_url, ['jquery', 'wp-mediaelement'], $script_version, true );
            
            $style_url = CSP_PLUGIN_URL . 'assets/css/csp-admin-styles.css';
            $style_version = filemtime(CSP_PLUGIN_DIR . 'assets/css/csp-admin-styles.css');
            wp_enqueue_style('csp-admin-styles', $style_url, [], $style_version);
        }
    }
    
}