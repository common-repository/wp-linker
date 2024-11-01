<?php
namespace SoftwareHut\WPLinker;


class ContentFilterer {
    
    
    private $keywords;
    
    public function __construct()
    {
        $this->keywords = get_option('wp_linker');
    }
    
    private function __getReplacements()
    {
    
    }
    
    function str_replace_n( $search, $replace, $subject, $occurrence, $maxMatches = -1 )
    {
        $search = preg_quote( $search );
        
        return preg_replace( "/^((?:(?:.*?$search){".--$occurrence."}.*?))$search/", "$1$replace", $subject, $maxMatches );
    }
    
    public function renderInScope( $content )
    {
        if (empty( $this->getKeywords()) ){
        	return $content;
        }

        // sh_debug( $this->getKeywords() );

        foreach( $this->getKeywords() as $keyword )
        {
            if( array_key_exists( 'scope', $keyword ) )
            {
                foreach( $keyword[ 'scope' ] as $scope )
                {
                    $scopeType = explode( '|', $scope )[ 0 ];
                    $scopeValue = explode( '|', $scope )[ 1 ];
                    
                    if( $scopeType === 'tax' )
                    {
                        $taxID = explode( '|', $scope )[ 2 ];
                        if( has_term( $taxID, $scopeValue ) )
                        {
                            $content = $this->filterContent( $content, [ $keyword ] );
                        }
                    }
                    
                    elseif( $scopeType === 'post' )
                    {
                        if( is_single( $scopeValue ) )
                        {
                            $content = $this->filterContent( $content, [ $keyword ] );
                        }
                        /**
                         * Is single page
                         */
                        elseif( is_page( $scopeValue ) )
                        {
                            $content = $this->filterContent( $content, [ $keyword ] );
                        }
                    }
                    
                    if( $scopeType === 'cpt' )
                    {
                        if( is_singular( $scopeValue ) )
                        {
                            $content = $this->filterContent( $content, [ $keyword ] );
                        }
                    }
                }
            }
        }
        
        return $content;
    }
    
    public function filterContent( $content, $keywords )
    {
        $test = [];
        /**
         * Find matches and add them to array with config
         */
        foreach( $keywords as $key => $value )
        {
            if( array_key_exists( 'wordsToMatch', $value ) && !empty( $value[ 'wordsToMatch' ] ) )
            {
                $words = explode( ',', $value[ 'wordsToMatch' ] );
                foreach( $words as $word )
                {
                    $word = trim($word);
                    preg_match_all( '/'.mb_strtolower( $word ).'/', mb_strtolower($content), $matches );
                    $keywords[ $key ][ '_matches' ][] = $matches[ 0 ];
                }

                $results = call_user_func_array( 'array_merge', $keywords[ $key ][ '_matches' ] );
            }
            else
            {
                /**
                 * Put all records to array
                 */
                preg_match_all( '/'.mb_strtolower( $value[ 'keyword' ] ).'/', mb_strtolower($content), $matches );
                /**
                 * Add to config
                 */
                $keywords[ $key ][ '_matches' ] = $matches[ 0 ];

                $results = $keywords[ $key ][ '_matches' ];
            }

            $keywords[ $key ][ '_matches' ] = $results;
        }
	

        /**
         * Go each keyword set
         */
        foreach( $keywords as $value )
        {
            $isTooltip = isset($value[ 'enableTooltip' ]) && $value[ 'enableTooltip' ] ? 'tooltip-on' : '';
            
            /**
             * Prepare link replacement for text
             */
            
            $firstMatch = ( intval( $value[ 'numberOfFirstMatch' ] ) ) - 1; //Translate human start to array start
            $nthMatch = intval( $value[ 'numberOfSkips' ] ); //
            $maxMatches = intval( $value[ 'numberOfMaxMatches' ] ) + 1;
            $keywordsToSearch = array_values( array_unique( $value[ '_matches' ] ) );
            $originalKeywords = explode( ',', $value[ 'wordsToMatch' ] ?? '' );
            

            // sh_debug($value);
            foreach( $keywordsToSearch as $keyword )
            {
                /**
                 * Prevent errors like empty keyword
                 */
                if( $keyword !== '' )
                {
                    $replacement = '<a class="ks_link '.esc_attr($isTooltip).'" href="'.esc_url( $this->getUrl( $value[ 'pointAddress' ] ) ).'" rel="'.esc_attr( implode(' ',$value[ 'anchorRel' ]) ).'" title="'.esc_attr($value[ 'anchorTitle' ]).'">'. esc_attr( $this->findOriginalKeyword($keyword, $originalKeywords) ) .'</a> ';
                    $parts = preg_split( '/(?![^<]*>)('.$keyword.')\b\s/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );

                    $countOfMatches = 1;
                    $keywordParts = [];


                    /**
                     * sort parts
                     */
                    $counter = [];
                    foreach( $parts as $num => $part )
                    {
                        //Add next matches to counter array
                        $counter[] = ( $num * $nthMatch ) + $firstMatch;

                        /**
                         * Add parts of array only when keyword is in it
                         */
                        if( mb_strtolower($part) === $keyword )
                        {
                            //Number of index where is keyword
                            $keywordParts[] = $num;
                        }
                    }

                    foreach( $keywordParts as $index => $partsNumberWithKeyword )
                    {
                        /**
                         * Render first match
                         */
                        if( $index === $firstMatch )
                        {
                            $parts[ $partsNumberWithKeyword ] = $replacement;
                        }

                        /**
                         * Render nth match according to first and previous match
                         */
                        if( in_array( $index, $counter ) )
                        {
                            $parts[ $partsNumberWithKeyword ] = $replacement;
                            ++$countOfMatches;
                        }

                        if( $countOfMatches === $maxMatches )
                        {
                            break;
                        }
                    }

                    $content = implode( ' ', $parts );
                }
            }
        }
        
        
        return $content;
    }
    
    
    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    /**
     * @param mixed|void $keywords
     */
    public function setKeywords( $keywords )
    {
        $this->keywords = $keywords;
    }

    private function findOriginalKeyword(string $keyword, array $keywords)
    {
        if (!empty($keywords))
        {
            foreach($keywords as $originalKeyword)
            {
                if  ( mb_strtolower(trim($originalKeyword)) === $keyword )
                {
                    return $originalKeyword;
                }
            }
        }
        return $keyword;
    }
	
	private function getUrl( string $pointAddress )
	{
//		$parts = explode('|',$pointAddress);
//		$type = $parts[0]; // Taxonomy(tax) or CustomPostType(cpt)
//		$typeName = $parts[1];
//		$typeId = $parts[2];
//		$url = '#';
//
//
//		if ($type === 'cpt')
//		{
//			$post = get_post($typeId);
//			if ($post)
//			{
//				$url = get_permalink($post->ID);
//			}
//		}
//		else if ($type === 'tax')
//		{
//			$term = get_term($typeId, $typeName);
//			if ($term)
//			{
//				$url = get_term_link($term);
//			}
//		}
		
		return $pointAddress;
	}
	
	
}
