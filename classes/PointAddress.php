<?php
namespace SoftwareHut\WPLinker;


class PointAddress {
    
    
    private $scopes = [];
    private $cpts;
    
    public function __construct()
    {
        $this->Scopes();
    }
    
    /**
     * Gets list of scopes
     *
     */
    private function Scopes()
    {
        
        $this->scopes[ 'taxonomy' ] = $this->getTaxonomies();
        $this->scopes[ 'post_types' ] = $this->getPostTypes();
        $this->scopes[ 'pages' ] = $this->getPages();

    }
    
    /**
     * Gets list of all post types
     */
    private function getPostTypes()
    {
        $postTypes = get_post_types();


        unset( $postTypes[ 'attachment' ] );
        unset( $postTypes[ 'revision' ] );
        unset( $postTypes[ 'nav_menu_item' ] );
        unset( $postTypes[ 'custom_css' ] );
        unset( $postTypes[ 'customize_changeset' ] );
        unset( $postTypes[ 'oembed_cache' ] );
        unset( $postTypes[ 'user_request' ] );
        unset( $postTypes[ 'acf-field-group' ] );
        unset( $postTypes[ 'acf-field' ] );
        unset( $postTypes[ 'wpcf7_contact_form' ] );
        unset( $postTypes[ 'ba_schema_cpt' ] );
        unset( $postTypes[ 'site-review' ] );
        unset( $postTypes[ 'wp_navigation' ] );
        unset( $postTypes[ 'saswp_reviews' ] );
        unset( $postTypes[ 'saswp' ] );
        unset( $postTypes[ 'saswp_rvs_location' ] );
        unset( $postTypes[ 'saswp-collections' ] );
        unset( $postTypes[ 'wp_global_styles' ] );
        unset( $postTypes[ 'wp_template' ] );
        unset( $postTypes[ 'wp_template_part' ] );
        unset( $postTypes[ 'wp_block' ] );

        // wp_die(sh_debug($postTypes));


        $posts = [];
        foreach( $postTypes as $key => $post_type ){
            $posts[ $key ][ 'ID' ] = 'cpt|'.esc_attr($post_type);
            $posts[ $key ][ 'name' ] = esc_attr($post_type);
            $posts[ $key ][ 'label' ] = esc_attr(get_post_type_object( $post_type )->label);
        }
        
        $this->cpts = $postTypes;
        
        //        $this->scopes['post_types'][] = $posts;
        return $posts;
    }
    
    /**
     *
     * Retrives list of taxonomies
     *
     *
     * @return array
     */
    public function getTaxonomies()
    {
        $allTaxonomies = get_taxonomies( '', 'names' );
        
        unset( $allTaxonomies[ 'post_tag' ] );
        unset( $allTaxonomies[ 'link_category' ] );
        unset( $allTaxonomies[ 'nav_menu' ] );
        unset( $allTaxonomies[ 'post_format' ] );
        unset( $allTaxonomies[ 'site-review-category' ] );
        unset( $allTaxonomies[ 'wp_theme' ] );
        unset( $allTaxonomies[ 'wp_template_part_area' ] );
        unset( $allTaxonomies[ 'platform' ] );

//       wp_die(sh_debug($allTaxonomies));
        
        $terms = get_terms( [
            'taxonomy'   => $allTaxonomies,
            'hide_empty' => FALSE,
        ] );
        
        $taxes = [];
        
        foreach( $terms as $key => $term )
        {
            $taxes[ $key ][ 'ID' ] = esc_attr('tax|'.$term->taxonomy.'|'.$term->term_id);
            $taxes[ $key ][ 'name' ] = esc_attr($term->name);
            $taxes[ $key ][ 'label' ] = esc_attr($term->name);
            $taxes[ $key ][ 'taxonomy' ] = esc_attr($term->taxonomy);
            $taxes[ $key ][ 'taxonomy_object' ] = get_taxonomy( $term->taxonomy );
        }
        
        
        return $taxes;
    }
    
    /**
     * Gets lists of posts with IDs
     *
     * @return array
     */
    private function getPages()
    {
        
        $args = [
            'post_type'   => $this->cpts,
            'posts_per_page' => -1,
            'post_status'=>'publish'
        ];
        
        $allPages = get_posts( $args );
        
        
        $pages = [];
        /**
         * Trim values
         */
        foreach( $allPages as $key => $post )
        {
            $pages[ $key ][ 'ID' ] = esc_attr('cpt|'.$post->post_type.'|'.$post->ID);
            $pages[ $key ][ 'name' ] = esc_attr($post->post_title);
            $pages[ $key ][ 'post_type' ] = esc_attr($post->post_type);
            $pages[ $key ][ 'label' ] = esc_attr( $post->post_title );
            $pages[ $key ][ 'post_type_object' ] = get_post_type_object( $post->post_type );
        }
        
        
        //        $this->scopes['pages'][] = $pages;
        
        return $pages;
    }
    
    /**
     *
     * @param $scopes
     */
    function setScopes( $scopes )
    {
        $this->scopes = $scopes;
    }
    
    /**
     *
     * @return array
     */
    function getScopes()
    {
        return $this->scopes;
    }
    
    /**
     * Gets part of scopes
     *
     * @param  $name
     *
     * @return array
     */
    function getScope( $name )
    {
        return $this->scopes[ $name ];
    }
}
