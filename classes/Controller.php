<?php
namespace SoftwareHut\WPLinker;


class Controller {
    
    /**
     *
     *
     * Controller constructor.
     */
    public function __construct()
    {
        add_action( 'admin_menu', [
            $this,
            'createMenu',
        ] );
        
        add_filter( 'the_content', [
            new ContentFilterer(),
            'renderInScope',
        ] );
    }

    public function createMenu()
    {
        add_menu_page( __( 'WP Linker','wp_linker' ), __( 'WP Linker','wp_linker' ), 'manage_options', 'wp_linker', [
            new KeywordSearcher(),
            'renderPage',

        ], 'dashicons-admin-comments', 9999 );
    }
    
}