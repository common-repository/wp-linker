<?php
declare(strict_types=1);

namespace SoftwareHut\WPLinker;

class Config
{
    public function getConfig()
    {
        return [
            [
                'type'        => 'text',
                'name'        => 'keyword',
                'label'       => __( 'Search for keyword', 'wp_linker'),
                'placeholder' => __( 'Keyword', 'wp_linker'),
                'scope'       => 'table',
            ],
            [
                'type'        => 'text',
                'name'        => 'pointAddress',
                'label'       => __( 'Page to redirect', 'wp_linker'),
                'placeholder' => __( 'Redirect to', 'wp_linker'),
                'scope'       => 'table',
            ],
            [
                'type'        => 'text',
                'name'        => 'anchorTitle',
                'label'       => __( 'Anchor title attribute', 'wp_linker'),
                'placeholder' => __( 'Enter title attribute', 'wp_linker'),
                'scope'       => 'table',
            ],
            [
                'type'        => 'select',
                'name'        => 'anchorRel',
                'label'       => __( 'Anchor rel attribute', 'wp_linker'),
                'placeholder' => __( 'Choose REL', 'wp_linker'),
                'options'     => [
                    'follow',
                    'nofollow',
                    'sponsored',
                    'ugc',
                    'alternate',
                    'author',
                    'canonical',
                    'external',
                    'help',
                    'noreferrer',
                    'noopener',
                    'search',
                    'help',
                ],
                'multiple'=>true,
                'scope'       => 'table',
            ],
            [
                'type' => 'checkbox',
                'name' => 'scope',
                'labelHint' => __('Select where internal links should be placed. MUST be selected at least 1 field','wp_linker'),
                'label' => __('Scope', 'wp_linker'),
                'placeholder' => __('Scope', 'wp_linker'),
                'options' => $this->__getAvailableScopes(),
                'scope' => 'config',
            ],
            [
                'type'        => 'number',
                'name'        => 'numberOfFirstMatch',
                'hint'        => __( 'How many items skip from the start', 'wp_linker'),
                'label'       => __( 'First match on page', 'wp_linker'),
                'placeholder' => __( 'First match on page', 'wp_linker'),
                'scope'       => 'config',
            ],
            [
                'type'        => 'number',
                'name'        => 'numberOfMaxMatches',
                'hint'        => __( 'How many matches should be linked in particular page', 'wp_linker'),
                'label'       => __( 'Max match on page', 'wp_linker'),
                'placeholder' => __( 'Max match on page', 'wp_linker'),
                'scope'       => 'config',
            ],
            [
                'type'        => 'number',
                'name'        => 'numberOfSkips',
                'hint'        => __( 'Gap between matches', 'wp_linker'),
                'label'       => __( 'Space between match?', 'wp_linker'),
                'placeholder' => __( 'Space between match?', 'wp_linker'),
                'scope'       => 'config',
            ],
//            [
//                'type'        => 'radio',
//                'name'        => 'enableTooltip',
//                'label'       => __( 'Enable tooltip', 'wp_linker'),
//                'placeholder' => __( 'Enable tooltip', 'wp_linker'),
//                'options'     => [
//                    '0' => __( 'No', 'wp_linker' ),
//                    '1' => __( 'Yes', 'wp_linker' ),
//                ],
//                'scope'       => 'config',
//            ],
        ];
    }

    /**
     * Renders available scopes where to display keywords
     *
     * @return array|string
     */
    private function __getAvailableScopes()
    {

        $screen = new PointAddress();
        $Scopes = $screen->getScopes();

        $h = [];

        if( !empty( $Scopes ) ){
            $num = 0;
            foreach( $Scopes as $key => $scopes ){

                $h[ $key ][ 'label' ] = ucfirst( str_replace( '_', ' ', $key ) );

                foreach( $scopes as $scope ){

                    $h[ $key ][ 'posts' ][ $num ][ 'id' ] = esc_attr($scope[ 'ID' ]);
                    $h[ $key ][ 'posts' ][ $num ][ 'name' ] = esc_attr($scope[ 'label' ]);
                    $num++;
                }
            }
        }
        else{
            $h .= __( 'Could not find scope list' );
        }

        return $h;
    }

    /**
     *
     * Renders available point addresses
     *
     * @return array
     */
    private function __getAvailablePointAddresses()
    {
        $addresses = [];

        $scope = new PointAddress();
        $pages = $scope->getScope( 'pages' );
        $taxonomies = $scope->getTaxonomies();

        foreach( $pages as $key => $scope )
        {
            $id = $scope[ 'ID' ];
            $addresses[ $scope[ 'post_type' ] ][ 'cpt' ] = esc_attr($scope[ 'post_type' ]);
            $addresses[ $scope[ 'post_type' ] ][ 'label' ] = esc_attr($scope[ 'post_type_object' ]->label);
            $addresses[ $scope[ 'post_type' ] ][ 'posts' ][ $key ][ 'id' ] = esc_attr($id);
            $addresses[ $scope[ 'post_type' ] ][ 'posts' ][ $key ][ 'name' ] = esc_attr($scope[ 'name' ]);
        }

        foreach($taxonomies as $key => $taxonomy)
        {
            $id = $taxonomy[ 'ID' ];

            $addresses[ $taxonomy['taxonomy'] ][ 'cpt' ] = esc_attr( $taxonomy['taxonomy'] );
            $addresses[ $taxonomy['taxonomy'] ][ 'label' ] = esc_attr( $taxonomy['taxonomy_object']->label );
            $addresses[ $taxonomy['taxonomy'] ][ 'posts' ][ $key ][ 'id' ] = esc_attr( $id );
            $addresses[ $taxonomy['taxonomy'] ][ 'posts' ][ $key ][ 'name' ] = esc_attr($taxonomy[ 'name' ]);
        }

        // wp_die( sh_debug($addresses) );

        return $addresses;
    }
}
