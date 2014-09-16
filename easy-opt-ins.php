<?php
/*
    Plugin Name: Easy Opt-ins For Mailchimp
    Plugin URI: http://fatcatapps.com/eoi
    Description: Easy Opt-ins For Mailchimp Helps You Get More Email Subscribers. Create Beautiful & Highly Converting Opt-In Widgets In Less Than 2 Minutes.
    Author: Fatcat Apps
    Version: 1.0
    Author URI: http://http://fatcatapps.com/
*/

// define( 'FCA_EOI_DEBUG', true );
// define( 'FCA_EOI_CACHE_LISTS', true );

if ( ! function_exists( 'is_admin' ) ) {
    exit();
}

if ( ! class_exists ( 'K' ) ) {
    require plugin_dir_path( __FILE__ ) . 'includes/classes/K/K.php';
}
if( ! defined ( 'FCA_EOI_DEBUG' ) ) {
    define( 'FCA_EOI_DEBUG', false );
}
if( ! defined ( 'FCA_EOI_CACHE_LISTS' ) ) {
    define( 'FCA_EOI_CACHE_LISTS', false );
}
if ( FCA_EOI_DEBUG && ! class_exists ( 'Kint' ) ) {
    require plugin_dir_path( __FILE__ ) . 'includes/classes/kint/Kint.class.php';
}
if ( ! class_exists ( 'Mustache_Engine' ) ) {
    require plugin_dir_path( __FILE__ ) . 'includes/classes/Mustache/Autoloader.php';
    Mustache_Autoloader::register();
}

include_once plugin_dir_path( __FILE__ ) . 'includes/eoi-post-types.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/eoi-settings.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/eoi-customize.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/eoi-shortcode.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/eoi-widget.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/eoi-pointer.php';

define('EOI_PLUGIN_PATH_FOR_SUBDIRS', plugin_dir_path(str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__))));

class DhEasyOptIns
{
    var $ver = '1.0.0';
    var $shortcode = 'opt-in';
    var $settings;
    var $providers = array();
    var $provider = 'mailchimp';

    function __construct()
    {
        global $fca_eoi_shortcodes;

        $post_type = $this->get_current_post_type();
        $eoi_settings = get_option('easy_opt_in_settings');

        // Settings
        $this->settings();
        $this->settings[ 'provider' ] = $this->provider;
        $this->settings[ 'eoi_settings' ] = $eoi_settings;

        // Abstract helper class
        include_once $this->settings[ 'plugin_dir' ] . "providers/$this->provider/functions.php";

        // Initialize a provider instance
        // $this->settings[ 'helper' ] = provider_object(
        //     $this->settings[ 'providers' ][ $this->provider ]
        //     , $this->settings
        //     , $eoi_settings
        // );
                
        // Load extensions
        $post_types = new EasyOptInsPostTypes($this->settings);
        // $settings   = new EasyOptInsSettings($this->settings);
        // $customize  = new EasyOptInsCustomize($this->settings);
        $fca_eoi_shortcodes = new EasyOptInsShortcodes($this->settings);
        $widget     = new EasyOptInsWidgetHelper($this->settings);

        // Load subscribing banner
        $pointer = new EasyOptInsPointer($post_type, $this->settings);
        
        // Enqueue CSS styles
        // add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    function get_current_post_type()
    {
        global $post, $typenow, $current_screen;

        if ( $post && $post->post_type ) {
            return $post->post_type;
        } elseif( $typenow ) {
            return $typenow;
        } elseif( $current_screen && $current_screen->post_type ) {
            return $current_screen->post_type;
        } elseif( isset( $_REQUEST['post_type'] ) ) {
            return sanitize_key( $_REQUEST['post_type'] );
        }

        return null;
    }

    function enqueue_assets( $hook )
    {
        // CSS Style
        wp_enqueue_style('dh-easy-opt-in', $this->settings['plugin_url'] . '/assets/ui/style.css' );

        // JS
        wp_enqueue_script('dh-easy-opt-in-colorbox', $this->settings['plugin_url'] . '/assets/ui/colorbox/jquery.colorbox-min.js', array('jquery'));
    }

    function settings()
    {
        $this->settings['plugin_dir'] = plugin_dir_path( __FILE__ );
        $this->settings['plugin_url'] = plugins_url('', __FILE__);
        $this->settings['shortcode']  = $this->shortcode;
        $this->settings['version']    = $this->ver;
        $this->settings['provider']   = $this->provider;
        // Load all providers
        foreach ( glob( $this->settings[ 'plugin_dir' ] . 'providers/*', GLOB_ONLYDIR ) as $provider_path ) {  
            $provider_id = basename( $provider_path );
            require_once "$provider_path/provider.php";
            $this->settings[ 'providers' ][ $provider_id ] = call_user_func( "provider_$provider_id" );
        }
    }
}

$dh_easy_opt_ins_plugin = new DhEasyOptIns();
