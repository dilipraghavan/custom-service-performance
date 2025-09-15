<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance\Admin;

class Metabox {

    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_action( 'save_post', [ $this, 'save_meta_box' ] );
    }
    
    public function add_meta_box()
    {
        add_meta_box(
            'service_details',
            'Service Details',
            [$this, 'meta_box_html'],
            'csp_service'
        );
    }

    public function meta_box_html($post) {
        $service_icon_id = get_post_meta($post->ID, 'service_icon', true) ?: '';
        $service_icon_url = wp_get_attachment_image_url($service_icon_id) ?: '';
        $service_name = get_post_meta($post->ID, 'service_name', true) ?: '';
        $service_description = get_post_meta($post->ID, 'service_description', true) ?: '';
        
        // Pass variables to the helper method
        $this->render_template('metabox.php', [
            'service_icon_url' => $service_icon_url,
            'service_name' => $service_name,
            'service_description' => $service_description,
        ]);
    }

    public function save_meta_box($post_id){
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        if (get_post_type($post_id) !== 'csp_service') return;

        if (!isset($_POST['service_meta_box']) || !wp_verify_nonce($_POST['service_meta_box'], 'service_meta_box_nonce')) return;

        if (isset($_POST['service_icon'])) {
            $icon_id = intval($_POST['service_icon']);
            update_post_meta($post_id, 'service_icon', $icon_id);
        }

        $text_fields = ['service_name', 'service_description'];
        foreach ($text_fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        delete_transient('csp_transient');
    }

    private function render_template($template_name, $vars = []) {
        // Extract the variables from the array, making them available in the template scope
        extract($vars);

        $file_path = CSP_PLUGIN_DIR . 'templates/' . $template_name;

        if (file_exists($file_path)) {
            include $file_path;
        }
    }
}