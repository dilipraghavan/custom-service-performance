<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance\Admin;

class Settings {

    public function __construct() {
        add_action( 'admin_init', [ $this, 'register_plugin_settings' ] );
        add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
    }

    public function register_plugin_settings() {
        register_setting( 'csp_settings_group', 'csp_clear_cache' );
        add_settings_section( 'csp_settings_main_section', 'Cache Settings', null, 'csp_settings_page' );
        add_action( 'admin_post_csp_clear_cache_action', [ $this, 'handle_clear_cache' ] );
    }

    public function handle_clear_cache() {
        // Verify the nonce to ensure the request is valid
        if (!isset($_POST['csp_clear_cache_nonce']) || !wp_verify_nonce($_POST['csp_clear_cache_nonce'], 'csp_clear_cache_nonce')) {
            wp_die('Security check failed.');
        }
        
        // Check if the current user has the necessary permissions
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have sufficient permissions to access this page.' );
        }

        delete_transient('csp_transient');
        wp_safe_redirect(add_query_arg(['settings-updated' => 'true'], wp_get_referer()));
        exit;
    }

    public function add_settings_page()
    {
        add_options_page(
            'Custom Services Settings Page',
            'Custom Services Settings',
            'manage_options',
            'csp_settings_page',
            [$this, 'settings_page_html']
        );
    }

    public function settings_page_html() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo get_admin_page_title(); ?></h1>
            <?php settings_errors(); ?>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php
                // Security nonce field for the "Clear Cache" action
                wp_nonce_field('csp_clear_cache_nonce', 'csp_clear_cache_nonce');
                ?>
                <input type="hidden" name="action" value="csp_clear_cache_action">
                <?php submit_button('Clear Cache'); ?>
            </form>
        </div>
        <?php
    }
}