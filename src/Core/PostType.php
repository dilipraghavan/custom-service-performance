<?php

namespace WPSHIFTSTUDIO\CustomServicePerformance\Core;

class PostType {

    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register() {
        $labels = [
            'name'          => __( 'Services', 'custom-service-performance' ),
            'singular_name' => __( 'Service', 'custom-service-performance' ),
            'add_new'       => __( 'Add New Service', 'custom-service-performance' ),
            'add_new_item'  => __( 'Add a New Service', 'custom-service-performance' )
        ];
        $args = [
            'labels'        => $labels,
            'public'        => true,
            'has_archive'   => true,
            'rewrite'       => [ 'slug' => 'services' ],
            'supports'      => [ 'title', 'editor', 'thumbnail' ],
        ];
        register_post_type( 'csp_service', $args );
    }
}