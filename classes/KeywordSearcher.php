<?php
namespace SoftwareHut\WPLinker;


class KeywordSearcher {
    
    private $primaryConfig = [];
    private $secondaryConfig = [];
    
    public function __construct()
    {
        register_setting( 'wp_linker', 'wp_linker');
        $this->settings = get_option( 'wp_linker_settings' );
        $this->primaryConfig = (new Config())->getConfig();
    }
    
    public function renderPage()
    {
        $keywords = get_option('wp_linker');
        // sh_debug($keywords);
        ?>


		<form class="repeater" method="post" action="options.php">
			<?php settings_fields('wp_linker'); ?>
            <?php do_settings_sections('wp_linker'); ?>

			<div class="modernTable">
			<div class="tableHeader">
            <?php
            foreach( $this->primaryConfig as $column )
            {
                if( $column[ 'scope' ] === 'table' )
                {
                    echo '<p class="'.esc_html($column[ 'type' ]).'">'.esc_html($column[ 'label' ]).'</p>';
                }
            }
            ?>
            </div>
            <div class="tableContent">
            <?php

            echo '<div data-repeater-list="wp_linker" class="v2" >';

            if( !empty( $keywords ) )
            {
                foreach( $keywords as $num => $keyword )
                {
                    echo $this->__renderRepeaterItems( 'wp_linker', $keyword, $this->primaryConfig, $num );
                }
            }
            else
            {
                echo $this->__renderRepeaterItems( 'wp_linker', $keywords, $this->primaryConfig, 0 );
            }

            echo '</div>';
            echo '</div>';//data-repeater-list
            echo '</div>'; //tableContent


            echo '<input class="addRow" data-repeater-create type="button" value="'.__( 'Add new', 'wp_linker').'" />';

            ?>

            <?php submit_button(); ?>
	        
		</form>

        <div class="buy-coffee">
            <a href="https://donate.stripe.com/eVa8zDgP6d52edO144" target="_blank" rel="noreferrer noopener nofollow">
                <img src="<?php echo SH_IL_URL ?>/assets/images/coffee-mug.png" alt="buy me a coffee"/>
                <span>Like this plugin? Buy me a coffee</span>
            </a>
        </div>


		</div>
        <?php
    }

    /**
     * @param $fieldGroup
     * @param $keywords
     * @param $config
     * @param $index
     * @return string
     */
    private function __renderRepeaterItems( $fieldGroup, $keywords, $config, $index )
    {
        $modalContent = '';
        $tableContent = '';
        
        $repeaterItems = '';
        $repeaterItems .= '<div class="repeaterRow" data-repeater-item>';
        
        /**
         * Render predefined fields in config property
         */
        foreach( $config as $key => $item )
        {
            if( $item[ 'type' ] === 'text' )
            {
                $str = '<input type="'.esc_attr($item[ 'type' ]).'" name="'.esc_attr($item[ 'name' ]).'" value="'.( isset( $keywords[ $item[ 'name' ] ] ) ? esc_attr($keywords[ $item[ 'name' ] ]) : '' ).'" placeholder="'.esc_attr($item[ 'placeholder' ]).'" >';
                
                if( $item[ 'scope' ] === 'config' ){
                    $modalContent .= '<div class="inputHolder type-'.esc_attr($item[ 'type' ]).'"><label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>'.esc_attr($str).'</div>';
                }
								elseif( $item[ 'scope' ] === 'table' ){
                    $tableContent .= $str;
                }
            }
            
            if( $item[ 'type' ] === 'textarea' )
            {
                $str = '<textarea placeholder="'.esc_attr($item[ 'placeholder' ]).'" name="'.esc_attr($item[ 'name' ]).'" >'.( isset( $keywords[ $item[ 'name' ] ] ) ? esc_attr($keywords[ $item[ 'name' ] ]) : '' ).'</textarea>';
                
                if( $item[ 'scope' ] === 'config' )
                {
                    $modalContent .= '<div class="inputHolder type-'.esc_attr($item[ 'type' ]).'">';
                    $modalContent .= '<label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>';
                    $modalContent .= $str;
                    $modalContent .= isset($item['hint']) ? '<p class="hint">'.esc_attr($item['hint']).'</p>' : '';
                    $modalContent .= '</div>';
                }
								elseif( $item[ 'scope' ] === 'table' ){
                    $tableContent .= $str;
                }
                
            }
            
            if( $item[ 'type' ] === 'number' )
            {
                $str = '<input min="1" step="1" type="'.esc_attr($item[ 'type' ]).'" name="'.esc_attr($item[ 'name' ]).'" value="'.( isset( $keywords[ $item[ 'name' ] ] ) ? intval( esc_attr( $keywords[ $item[ 'name' ] ]) ) : 2 ).'" placeholder="'.esc_attr($item[ 'placeholder' ]).'" >';
                
                if( $item[ 'scope' ] === 'config' )
                {
                    $modalContent .= '<div class="inputHolder type-'.esc_attr($item[ 'type' ]).'">';
                    $modalContent .= '<label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>';
                    $modalContent .= $str;
                    $modalContent .= isset($item['hint']) ? '<p class="hint">'.esc_attr( $item['hint'] ).'</p>' : '';
                    $modalContent .= '</div>';
                }
								elseif( $item[ 'scope' ] === 'table' ){
                    $tableContent .= $str;
                }
                
            }
            if( $item[ 'type' ] === 'radio' )
            {
                $str = '<div class="pseudoInput">';
                if( !empty( $item[ 'options' ] ) ){
                    foreach( $item[ 'options' ] as $key => $option )
                    {
                        $selected = isset( $keywords[ $item[ 'name' ] ] ) ? checked( $keywords[ $item[ 'name' ] ], $key, FALSE ) : 'checked="checked"';
                        $str .= '<label>'.$option.'<input type="'.esc_attr($item[ 'type' ]).'" name="'.esc_attr($item[ 'name' ]).'" value="'.esc_attr($key).'" '.$selected.'></label>';
                    }
                }
                
                $str .= '</div>';
                
                if( $item[ 'scope' ] === 'config' ){
                    $modalContent .= '<div class="inputHolder type-'.$item[ 'type' ].'"><label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>'.$str.'</div>';
                }
								elseif( $item[ 'scope' ] === 'table' ){
                    $tableContent .= $str;
                }
            }
            /**
             * Selects
             */
            if( $item[ 'type' ] === 'select' )
            {
                $str = '<div class="select--wrapper">';
                $str .= '<select name="'.esc_attr($item[ 'name' ]).'" placeholder="'.esc_attr($item[ 'placeholder' ]).'"'.( isset($item['multiple']) && $item['multiple'] ? 'class="select2_multiple" multiple="multiple"' : 'class="select2"' ).'>';
                $str .= '<option value="0">--</option>';
							
                //sh_debug();
	            
                if( !empty( $item[ 'options' ] ) ){
                    foreach( $item[ 'options' ] as $key => $option )
                    {
                    	if  (isset($item['multiple']) && $item['multiple'])
                    	{
                    	  $selectedOptions = $keywords[$item[ 'name' ]] ?? [];
                    	  $selected = in_array( esc_attr($option), $selectedOptions );
		                    $str .= '<option value="'.esc_attr($option).'" '.($selected ? 'selected="selected"' : '').' >'.esc_attr($option).'</option>';
	                    }
                    	else{
		                    $selected = isset( $keywords[ $item[ 'name' ] ] ) ? selected( $keywords[ $item[ 'name' ] ], $option, FALSE ) : '';
		                    $str .= '<option value="'.esc_attr($option).'" '.$selected.'>'.esc_attr($option).'</option>';
	                    }
                    }
                }
                $str .= '</select>';
                $str .= '</div>';

                if( $item[ 'scope' ] === 'config' )
                {
                    $modalContent .= '<div class="inputHolder type-'.esc_attr($item[ 'type' ]).'"><label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>'.$str.'</div>';
                }
								elseif( $item[ 'scope' ] === 'table' )
								{
                    $tableContent .= $str;
                }
            }
            /**
             * Select2 is with optgroups
             */
            if( $item[ 'type' ] === 'select2' )
            {
                $str = '<div class="select--wrapper">';
                $str .= '<select name="'.esc_attr($item[ 'name' ]).'" placeholder="'.esc_attr($item[ 'placeholder' ]).'" class="select2">';
                $str .= '<option value="0">--</option>';
                
                if( !empty( $item[ 'options' ] ) ){
                    foreach( $item[ 'options' ] as $key => $option )
                    {
                        /**
                         * group post type by optgroup
                         */
                        $str .= '<optgroup label="'.esc_attr($option[ 'label' ]).'">';
                        /**
                         * Insert posts groupsed by post type
                         */
                        foreach( $option[ 'posts' ] as $value )
                        {
                            $selected = isset( $keywords[ $item[ 'name' ] ] ) ? selected( $keywords[ $item[ 'name' ] ], $value[ 'id' ], FALSE ) : '';
                            $str .= '<option value="'.esc_attr($value[ 'id' ]).'" '.$selected.'>'.esc_attr($value[ 'name' ]).'</option>';
                        }
                        
                        $str .= '</optgroup>';
                    }
                }
                
                $str .= '</select>';
                $str .= '</div>';

                if( $item[ 'scope' ] === 'config' ){
                    $modalContent .= '<div class="inputHolder type-'.esc_attr($item[ 'type' ]).'"><label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>'.$str.'</div>';
                }
								elseif( $item[ 'scope' ] === 'table' ){
                    $tableContent .= $str;
                }
            }
            
            
            if( $item[ 'type' ] === 'checkbox' )
            {
                $str = '';
                $str .= '<div class="scopes--wrapper">';
                foreach( $item[ 'options' ] as $key => $option )
                {
                    $str .= '<div class="scope--item">';
                    $str .= '<label class="itemLabel">';
                    $str .= '<span>'.esc_attr($option[ 'label' ]).'</span>';
                    $str .= '<select name="'.esc_attr($item[ 'name' ]).'" class="select2_multiple" multiple="multiple">';
                    foreach( $option[ 'posts' ] as $value )
                    {
                        $selected = '';
                        if( !empty( $keywords['scope'] ) )
                        {
                            foreach($keywords['scope'] as $scope)
                            {
                                if ($scope === $value['id'])
                                {
                                    $selected = 'selected="selected"';
                                }
                            }
                        }
                        $str .= '<option value="'.esc_attr($value[ 'id' ]).'" '. ( $selected ) .'>'.esc_attr($value[ 'name' ]).'</option>';
                    }
                    $str .= '</select>';
                    $str .= '</label>';
                    $str .= '</div>';
                }
                $str .= '</div>';

                if( $item[ 'scope' ] === 'config' )
                {
                    $modalContent .= '<div class="inputHolder type-scope">';
                    $modalContent .= '<label class="groupLabel">'.esc_attr($item[ 'label' ]).'</label>';
                    $modalContent .= isset($item['labelHint']) && !empty($item['labelHint']) ? '<span class="label-hint">'.esc_attr($item['labelHint']).'</span>' : '';
                    $modalContent .= $str;
                    $modalContent .= '</div>';

                }
                elseif( $item[ 'scope' ] === 'table' ){
                    $tableContent .= $str;
                }
            }
        }
        $repeaterItems .= '<div class="rowActions">';
        $repeaterItems .= '<button class="modalTrigger" data-id="'.esc_attr($index).'" >Open</button>';
        $repeaterItems .= '<button class="deleteRow" data-repeater-delete type="button" value="'.__( 'Delete', 'wp_linker').'" />';
        $repeaterItems .= '</div>';
        
        
        $repeaterItems .= '<div class="table">'.$tableContent.'</div>';
        $repeaterItems .= '<div class="config">'.$modalContent.'</div>';
        
        
        $repeaterItems .= '</div>';
        
        return $repeaterItems;
    }
}
