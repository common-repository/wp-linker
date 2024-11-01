<?php
namespace SoftwareHut\WPLinker;

class AjaxHandler {
    
    
    public function __construct()
    {
        add_action( 'wp_ajax_nopriv_wp_linker_ajax_handler', [
            $this,
            'handleRequest',
        ] );
        add_action( 'wp_ajax_wp_linker_ajax_handler', [
            $this,
            'handleRequest',
        ] );
    }


    public function handleRequest()
    {
        $requestType = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING )[ 'requestType' ];
        $requestParams = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING )[ 'requestParams' ];
        
        $dataToSend = [];

        if( $requestType === 'getPost' )
        {
            $post = get_post( $requestParams );
            
            $dataToSend[ 'post' ][ 'post_content' ] = wp_trim_words( $post->post_content, 15, '...' );
            $dataToSend[ 'post' ][ 'post_title' ] = esc_attr($post->post_title);
            $dataToSend[ 'post' ][ 'post_thumbnail' ] = has_post_thumbnail( $post->ID ) ? get_the_post_thumbnail_url( esc_attr($post->ID), 'thumbnail' ) : FALSE;
            $dataToSend[ 'post' ][ 'post_url' ] = esc_url( get_permalink( $post->ID ) );
        }
        //TODO: Handle save in admin area


        $dataToSend[ 'type' ] = $requestType;
        $dataToSend[ 'params' ] = $requestParams;
        
        
        echo json_encode( $dataToSend );
        
        die();
    }
    
    
}
