<?php
/**
 * Author : Mateusz Grzybowski
 * contact@wp-linker.com
 */


/**
 * Adds scripts and styles in admin section
 */
function wp_linker_admin_enqueue_styles( $hook )
{
     // wp_die(sh_debug($hook) );
    /**
     * Enqueue scripts only for placec where it would be used
     */
    if(
        $hook === 'wp-linker_page_wp_linker_settings' ||
        $hook === 'toplevel_page_wp_linker' ||
        $hook === 'wp_linker_admin_enqueue_styles'
    )
    {
        wp_enqueue_script( 'wp-linker_admin_repeater', SH_IL_URL.'assets/js/repeater-dist.js', [], SH_IL_VERSION, TRUE );
        wp_enqueue_script( 'wp-linker_select2', SH_IL_URL.'assets/js/select2.min.js', [], SH_IL_VERSION, TRUE );
        wp_enqueue_script( 'wp-linker_admin_scripts', SH_IL_URL.'assets/js/admin_scripts-dist.js', [], SH_IL_VERSION, TRUE );
        /**
         * Admin styles
         */
        wp_enqueue_style( 'wp-linker_admin_styles', SH_IL_URL.'assets/css/admin_styles.css', [], SH_IL_VERSION );
    }
    
    
}

add_action( 'admin_enqueue_scripts', 'wp_linker_admin_enqueue_styles', 20 );


/**
 * Adds scripts and styles in front-end section
 */
function wp_linker_enqueue_styles()
{
    /**
     * TODO: Check if is select tooltip option
     */

    wp_enqueue_script( 'wp-linker_tooltip', SH_IL_URL.'assets/js/tooltip-dist.js', [], SH_IL_VERSION, TRUE );
    wp_enqueue_script( 'wp-linker_scripts', SH_IL_URL.'assets/js/scripts-dist.js', [], SH_IL_VERSION, TRUE );
    /**
     * Admin styles
     */
    wp_enqueue_style( 'wp-linker_styles', SH_IL_URL.'assets/css/styles.css', [], SH_IL_VERSION );
    
    wp_localize_script( 'wp-linker_scripts', 'wp_linker_ajax', [
        'url' => admin_url( 'admin-ajax.php' ),
        'gif' => SH_IL_URL.'assets/images/loader.gif',
    ] );
}

// add_action( 'wp_enqueue_scripts', 'wp_linker_enqueue_styles', 20 ); // TEMPORARY disable due to problem with tooltip for taxonomies

if( !function_exists( 'sh_debug' ) )
{
    function sh_debug( $item )
    {
        /**
         * If debug is on in wp-config.php
         */
        echo '<pre>';
        print_r( debug_backtrace()[ 1 ][ 'function' ].':<br/>' );
        print_r( $item );

        echo '</pre>';
    }
    
}
