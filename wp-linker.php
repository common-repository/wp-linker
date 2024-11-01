<?php
/**
 * Plugin Name: WP Linker / Internal linking creator
 * Author: Mateusz Grzybowski
 * Author URI: https://wp-linker.com
 * Description: Plugins adds dynamically links across your website according to your configured internal linking campaign
 * Plugin URI: https://wp-linker.com
 * Version: 1.2
 * License: GPLv2
 * Text Domain: wp_linker
 * Domain Path: /languages
 */


use SoftwareHut\WPLinker\Controller;
use SoftwareHut\WPLinker\AjaxHandler;

require_once( 'vendor/autoload.php' );


class wp_linker {
    
    public $version;

    public function __construct( $version )
    {
        $this->version = $version;
        $this->define_constants();
        
        new AjaxHandler();
        new Controller();
    }
    
    /**
     * Define constants used in plugin
     */
    public function define_constants()
    {
        define( 'SH_IL_PLUGIN_FILE', __FILE__ );
        define( 'SH_IL_ABSPATH', dirname( __FILE__ ).'/' );
        define( 'SH_IL_VERSION', $this->version );
        define( 'SH_IL_PATH', plugin_dir_path( __FILE__ ) );
        define( 'SH_IL_URL', plugin_dir_url( __FILE__ ) );
        define( 'SH_IL_LOCALIZATION_DOMAIN', 'wp_linker');
    }

    public function load_textdomain()
    {
        load_plugin_textdomain( 'wp_linker', FALSE, dirname( plugin_basename( __FILE__ ) ).'/languages/' );
    }

    public function activatePlugin()
    {
        $isFreeVersionActive = is_plugin_active('wp-linker-pro/wp-linker-pro.php');
        if ($isFreeVersionActive)
        {
            deactivate_plugins(['wp-linker-pro/wp-linker-pro.php'],true);
        }
    }

    public function deactivatePlugin()
    {

    }
}

if( !function_exists( 'get_plugins' ) ){
    require_once ABSPATH.'wp-admin/includes/plugin.php';
}

$pluginData = get_plugin_data( plugin_dir_path( __DIR__ ).'wp-linker/wp-linker.php' );
$internalLinker = new wp_linker( $pluginData[ 'Version' ] );

register_activation_hook( __FILE__, [ $internalLinker, 'activatePlugin' ]);
register_deactivation_hook( __FILE__, [ $internalLinker, 'deactivatePlugin' ] );
