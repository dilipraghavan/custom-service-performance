<?php

if (!defined('ABSPATH'))
    exit;

/**
 * Plugin Name: Custom Service Performance
 * Description: A plugin that lets users creates Services post type and display it to clients in the front-end using shortcode.
 * Version: 1.0.0
 * Plugin URI: https://github.com/dilipraghavan
 * Author: Dilip Raghavan 
 * Author URI: https://wpshiftstudio.com
 * Text Domain: custom-service-performance
 */


require_once(plugin_dir_path(__FILE__).'includes/class-custom-service-performance.php');


function classInstantiater(){
    global $customServicePerformance;
    $customServicePerformance = new CustomServicePerformance(); 
}


add_action('plugins_loaded', 'classInstantiater');