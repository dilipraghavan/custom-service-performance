<?php
 
class CustomServicePerformance{
    public function __construct(){
        add_action('init', [$this, 'register_custom_post_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('save_post', [$this, 'save_meta_box']);
        add_shortcode('csp_services', [$this, 'csp_shortcode_callback']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_init', [$this, 'register_plugin_settings']);
        add_action('admin_menu', [$this, 'add_settings_page']);
    }

    public function register_plugin_settings(){
        register_setting('csp_settings_group', 'csp_clear_cache', [$this, 'handle_clear_cache_button']);
        add_settings_section(
                                'csp_settings_main_section',
                                'Cache Settings',
                                null,
                                'csp_settings_page'    
                            );
    }

    public function add_settings_page(){
        add_options_page(
            'Custom Services Settings Page',
            'Custom Services Settings',
            'manage_options',
            'csp_settings_page',
            [$this, 'settings_page_html']
        );
    }

    public function settings_page_html(){

        if(!current_user_can('manage_options')){
            return;
        }
        
        echo "<div class='wrap'>";

        // Title section
        echo "<h1>";
        echo get_admin_page_title();
        echo "</h1>";

        //Display any the messages registered.
        //settings_errors('csp_cache_notice');

        // Form Section
        echo "<form method='post' action='options.php'>";
        
        settings_fields('csp_settings_group');
        do_settings_sections('csp_settings_page');
        submit_button('Clear Cache');
        
        echo "</form>";
        echo "</div>";
    }

    public function handle_clear_cache_button($value){
        delete_transient('csp_transient');
        
        
        add_settings_error(
            'csp_cache_notice', 
            'csp_cache_cleared',
            'Cache has been successfully cleared.',
            'success'
        );

        return "1";
        
    }

    public function enqueue_scripts(){
        
        $plugin_base_url = plugin_dir_url(dirname(__FILE__));
        $css_file_url =   $plugin_base_url.'assets/css/csp-styles.css';
        
        $plugin_base_path = plugin_dir_path(dirname(__FILE__));
        $css_file_path = $plugin_base_path.'assets/css/csp-styles.css';
        $css_file_version = filemtime($css_file_path);

        wp_enqueue_style(
            'csp-styles', 
            $css_file_url,
            [],
            $css_file_version
        );
    }

    public function register_custom_post_type(){

        $labels = [
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add a New Service'
        ];   
        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'services'],
            'supports' => ['title', 'editor', 'thumbnail']
        ];
        register_post_type('csp_service', $args);
    }

    public function add_meta_box(){
        add_meta_box(
            'service_details',
            'Service Details',
            [$this, 'meta_box_html'],
            'csp_service'
        );
    }

    public function meta_box_html($post){

        $service_icon = get_post_meta($post->ID,'service_icon', true) ?? '';
        echo "<label for='service_icon'>Service Icon URL </label>";
        echo "<input 
                id='service_icon' 
                type='text' 
                name='service_icon' 
                value=" . esc_attr($service_icon) . " />";
        echo "<br>";

        $service_name = get_post_meta($post->ID,'service_name', true) ?? '';
        echo "<label for='service_name'>Service Name </label>";
        echo "<input 
                id ='service_name' 
                type ='text' 
                name ='service_name' 
                value = " . esc_attr($service_name) . " />"; 
        echo "<br>";

        $service_description = get_post_meta($post->ID,'service_description', true) ?? '';
        echo "<label for='service_description'>Service Description</label>";
        echo "<textarea
                id='service_description' 
                name='service_description' 
              >"; 
        echo esc_attr($service_description);
        echo "</textarea>";
        echo "<br>";

        wp_nonce_field('service_meta_box_nonce', 'service_meta_box');
    }

    public function save_meta_box($post_id){

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if(!current_user_can('edit_post', $post_id)) return ;
        if(get_post_type($post_id) !== 'csp_service') return;

        if(!isset($_POST['service_meta_box'])) return;
        if(!wp_verify_nonce($_POST['service_meta_box'], 'service_meta_box_nonce')) return;

        $fields = ['service_icon', 'service_name', 'service_description'];
        foreach ($fields as $field){
            if (isset($_POST[$field])){
                if($field === 'service_icon'){
                    update_post_meta(
                        $post_id,
                        $field,
                        sanitize_url($_POST[$field])
                    );
                }else{
                    update_post_meta(
                        $post_id,
                        $field,
                        sanitize_text_field($_POST[$field])
                    );  
                }
            }
        }
        delete_transient('csp_transient');
    }

    public function csp_shortcode_callback(){
        
        $transient_name = 'csp_transient';
        $transient_value = get_transient($transient_name);
        $output = "";

        if($transient_value === false){
            $args = [
                'post_type' => 'csp_service',
                'posts_per_page' => -1,
            ];
            $query = new WP_Query($args);

            if($query -> have_posts()){
                $output .= "<div class='csp-services-container'>";
                while($query -> have_posts()){
                    $query->the_post();
                    $postId = get_the_id();
                    
                    $service_icon = esc_url(get_post_meta($postId, 'service_icon', true));
                    $service_name = sanitize_text_field(get_post_meta($postId, 'service_name', true));
                    $service_description = sanitize_text_field(get_post_meta($postId, 'service_description', true));

                    $output .= "<div class='main-container'>";
                        $output .= "<div class='inner-container'>";
                            $output .= "<div class='front-container'>";
                                $output .= "<img 
                                            src='{$service_icon}'
                                            alt='service icon'
                                        />";
                                $output .= "<h2>{$service_name}</h2>";
                            $output .= "</div>";
                            
                            $output .= "<div class='back-container'>";
                                $output .= "<h2>{$service_description}</h2>";
                            $output .= "</div>";

                        $output .= "</div>";
                    $output .= "</div>";

                }
                $output .= "</div>";
                wp_reset_postdata();
            }

            //Set transient
            set_transient($transient_name, $output, 12 * 3600);

        }else{
            $output = $transient_value;
        }

        return $output;
    }
}