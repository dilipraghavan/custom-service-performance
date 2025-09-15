<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance\Frontend;

use \WP_Query;  

class Shortcode {

    public function __construct() {
        add_shortcode( 'csp_services', [ $this, 'render' ] );
    }

    public function render() {
        $transient_name = 'csp_transient';
        $transient_value = get_transient($transient_name);
        $output = "";

        if ( $transient_value === false ) {
            $args = [
                'post_type'      => 'csp_service',
                'posts_per_page' => -1,
            ];
            $query = new WP_Query( $args );

            ob_start();
            if ( $query->have_posts() ) {
                ?> <div class='csp-services-container'> <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $postId = get_the_id();
                    
                    $service_icon_id = intval(get_post_meta($postId, 'service_icon', true));
                    $service_icon_url = wp_get_attachment_image_url($service_icon_id);
                    $service_name = sanitize_text_field(get_post_meta($postId, 'service_name', true));
                    $service_description = sanitize_text_field(get_post_meta($postId, 'service_description', true));

                    // Create an array of variables to pass to the template
                    $vars = [
                        'service_icon' => $service_icon_url,
                        'service_name' => $service_name,
                        'service_description' => $service_description,
                    ];
                    
                    // Call the new helper method to render the template
                    $this->render_template('shortcode-services-item.php', $vars);
                }
                ?> </div> <?php
            }
            $output = ob_get_clean();

            wp_reset_postdata();
            set_transient( $transient_name, $output, 12 * 3600 );
        } else {
            $output = $transient_value;
        }
        return $output;
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