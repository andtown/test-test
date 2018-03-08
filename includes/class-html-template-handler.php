<?php

/**
 * The HTML Template Handler class
 *
 */


class HTML_Template_Handler {

    protected static $instance;

    public function text( array $atts = [] ) {
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left;<?=(isset($atts['wrapper_left_width']))?' width: '.$atts['wrapper_left_width'].'; ':' width: 65%; '?>vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left;<?=(isset($atts['wrapper_right_width']))?' width: '.$atts['wrapper_right_width'].'; ':' width: 35%; '?>vertical-align: top">          
        <input name="<?=(isset($atts['id']))?$atts['id']:''?>" id="<?=(isset($atts['id']))?$atts['id']:''?>" placeholder="<?=(isset($atts['placeholder']))?esc_attr($atts['placeholder']):''?>" value="<?=(isset($atts['value']))?esc_attr($atts['value']):''?>" class="regular-text<?=(isset($atts['class']))?' '.$atts['class']:''?>" type="text">
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>            
    <?php    
    }

    public function textarea( array $atts = [] ) {
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left;<?=(isset($atts['wrapper_left_width']))?' width: '.$atts['wrapper_left_width'].'; ':' width: 65%; '?>vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left;<?=(isset($atts['wrapper_right_width']))?' width: '.$atts['wrapper_right_width'].'; ':' width: 35%; '?>vertical-align: top">      
        <textarea class="large-text" name="<?=(isset($atts['id']))?$atts['id']:''?>" id="<?=(isset($atts['id']))?$atts['id']:''?>" rows="<?=(isset($atts['rows']))?$atts['rows']:'10'?>"><?=(isset($atts['value']))?esc_textarea($atts['value']):''?></textarea>
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>           
    <?php        
    }

    public function select( array $atts = [] ) {
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left;<?=(isset($atts['wrapper_left_width']))?' width: '.$atts['wrapper_left_width'].'; ':' width: 65%; '?>vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left;<?=(isset($atts['wrapper_right_width']))?' width: '.$atts['wrapper_right_width'].'; ':' width: 35%; '?>vertical-align: top">    
        <select name="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" id="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>">
            <?php foreach ( (array) $atts['options'] as $key => $val ): ?>
                <option value="<?=(isset($val['value']))?esc_attr($val['value']):''?>" <?=(isset($atts['value']) && $atts['value']==$val['value'])?'selected':''?>><?=(isset($val['label']))?esc_html($val['label']):''?></option>
            <?php endforeach; ?>
        </select>
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>           
    <?php        
    }

    public function heading( array $atts = [] ) {
    ?>
        <div class="heading wrapper">
            <h4 style="font-weight: bold; display: block; font-size: .75rem; line-height: 1.4; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(230,230,230); text-transform: uppercase; padding: .75rem 0 .375rem; margin: 0 0 6px"><?=(isset($atts['label']))?esc_html($atts['label']):''?></h4>
            <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
        </div>
    <?php
    }    

    public function wp_editor( array $atts = [] ) {
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left;<?=(isset($atts['wrapper_left_width']))?' width: '.$atts['wrapper_left_width'].'; ':' width: 65%; '?>vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left;<?=(isset($atts['wrapper_right_width']))?' width: '.$atts['wrapper_right_width'].'; ':' width: 35%; '?>vertical-align: top">
                <?php wp_editor((isset($atts['value']))?$atts['value']:'',$atts['id']); ?>
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>   
    <?php
    }

    public function checkbox( array $atts = [] ) {
        //$bracket = (isset($atts['options']) && is_array($atts['options']) && count($atts['options']) > 1)?'[]':'';
        $bracket = '[]';
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left;<?=(isset($atts['wrapper_left_width']))?' width: '.$atts['wrapper_left_width'].'; ':' width: 65%; '?>vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left;<?=(isset($atts['wrapper_right_width']))?' width: '.$atts['wrapper_right_width'].'; ':' width: 35%; '?>vertical-align: top">
        <?php foreach ( (array) $atts['options'] as $key => $val ): ?>
            <input name="<?=(isset($atts['id']))?esc_attr($atts['id']).$bracket:''?>" size="30" id="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" value="<?=(isset($val['value']))?esc_attr($val['value']):''?>" class="checkbox" type="checkbox" <?=(isset($atts['value']) && in_array($val['value'], $atts['value']))?'checked=""':''?>> <?=(isset($val['label']))?esc_html($val['label']):''?>
        <?php endforeach; ?>  
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>                              
    <?php   
    }

    public function radio( array $atts = [] ) {
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left;<?=(isset($atts['wrapper_left_width']))?' width: '.$atts['wrapper_left_width'].'; ':' width: 65%; '?>vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left;<?=(isset($atts['wrapper_right_width']))?' width: '.$atts['wrapper_right_width'].'; ':' width: 35%; '?>vertical-align: top">
    <?php
        foreach ( (array) $atts['options'] as $key => $val ):
    ?>
        <input name="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" value="<?=(isset($val['value']))?esc_attr($val['value']):''?>" id="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" type="radio" class="radio" <?=(isset($atts['value']) && $val['value']==$atts['value'])?'checked=""':''?>> <?=(isset($val['label']))?esc_html($val['label']):''?>
    <?php
        endforeach;
    ?>
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>
    <?php            
    }

    public function available_tags( array $atts = [] ) {
    ?>
        <div class="heading wrapper">
            <h4 style="font-weight: bold; display: block; font-size: .75rem; line-height: 1.4; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(230,230,230); text-transform: uppercase; padding: .75rem 0 .375rem; margin: 0 0 6px"><?=(isset($atts['label']))?esc_html($atts['label']):''?></h4>
            <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
            <ul role="list">
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_one%</button></li>
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_two%</button></li>
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_three%</button></li>
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_four%</button></li>
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_five%</button></li>
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_six%</button></li>
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_seven%</button></li>               
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_eight%</button></li>  
               <li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_nine%</button></li><li style="margin-right: 5px; margin-bottom: 6px; float: left;"><button type="button" class="button button-secondary" >%tag_ten%</button></li>                                   
            </ul>            
        </div>
        <div class="clear" style="margin-bottom: 12px"></div>
    <?php
    }

    public function begin_field_wrapper( array $atts = [] ) { 
    ?>
        <div class="field wrapper" style="margin-bottom: 12px; overflow: auto;">
            <div class="label" style="float: left; width: 25%; vertical-align: top">
                <label for=""><?=(isset($atts['label']))?esc_html($atts['label']):''?></label>
                <p class="description"><?=(isset($atts['label_desc']))?esc_html($atts['label_desc']):''?></p>
             </div>
            <div class="input" style="float: left; width: 75%; vertical-align: top">
    <?php
    }

    public function end_field_wrapper( array $atts = [] ) {
    ?>
                <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>
            </div>
        </div>
    <?php        
    }   

    public function advanced_form_hidden( array $atts = [] ) {
    ?>
        <div class="widget">    
            <div class="widget-top">
                <div class="widget-title ui-sortable-handle"><h3><?=(isset($atts['label']))?esc_html($atts['label']):''?></h3></div>
            </div>
            <div class="widget-insidex">
                <div class="widget-content">
                    <input class="widefat" id="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" name="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" type="hidden" value="selected_item">
                </div>  
            </div>

        </div>
    <?php                                
    }

    public function advanced_form_text( array $atts = [] ) {
        $bracket = '[]';
    ?>
        <div class="widget">    
            <div class="widget-top">
                <div class="widget-title-action">
                    <button type="button" class="widget-action hide-if-no-js" aria-expanded="false">
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="widget-title ui-sortable-handle"><h3><?=(isset($atts['label']))?esc_html($atts['label']):''?></h3></div>
            </div>
            <div class="widget-inside">
                <div class="widget-content">
                <p>
                <?php foreach ( (array) $atts['options'] as $key => $val ): ?>
                <label>
                    <?=$val['label']?>            
                    <input class="widefat" id="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" name="<?=(isset($atts['id']))?esc_attr($atts['id']).$bracket:''?>" type="text" value="<?=(isset($atts['value'][0]))?esc_attr($atts['value'][0]):''?>">
                </label>                    
                <?php endforeach; ?>
                    <input type="hidden" name="<?=(isset($atts['id']))?esc_attr($atts['id']).$bracket:''?>" value="selected_item">
                </div>  
                </p>
            </div>

        </div>
    <?php                                
    }    

    public function advanced_form_checkbox( array $atts = [] ) {
    ?>        
        <div class="widget">
            <div class="widget-top">
                <div class="widget-title-action">
                    <button type="button" class="widget-action hide-if-no-js" aria-expanded="false">
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="widget-title ui-sortable-handle"><h3><?=(isset($atts['label']))?esc_html($atts['label']):''?><span class="in-widget-title"></span></h3></div>
            </div>

            <div class="widget-inside">
                <div class="widget-content">            
                    <p>
                    <?php $bracket = ''; foreach ( (array) $atts['options'] as $key => $val ): $bracket = '[]'; ?>
                        <input class="checkbox" type="checkbox" id="<?=(isset($atts['id']))?esc_attr($atts['id']):''?>" name="<?=(isset($atts['id']))?esc_attr($atts['id']).$bracket:''?>" value="<?=(isset($val['value']))?esc_attr($val['value']):''?>" <?=(isset($atts['value']) && in_array($val['value'], $atts['value']))?'checked=""':''?>>
                        <label for="<?=isset($atts['id'])?esc_attr($atts['id']):''?>"><?=isset($val['label'])?esc_html($val['label']):''?></label>
                        <br>
                    <?php endforeach; ?>  
                        <input type="hidden" name="<?=(isset($atts['id']))?esc_attr($atts['id']).$bracket:''?>" value="selected_item">                
                    </p>
                </div> 
            </div>
        </div>
    <?php
    }

    public function render( array $element = [], string $id = null ) {    
        foreach ( $element as $k => &$v ) { 
            if ( isset($v['type']) && !empty($v['type']) && method_exists($this, $v['type']) ) {
                //TODO: form handler has default types template (text.php, select.php, textarea.php, wp-editor.php, checkbox.php) which are generic/native html input. Since form handler can be used by any classes for rendering purpose so it should be able to be overided by placing the template files on theme/childtheme directory.                
                //TODO: include_once from files
                // if ( $value['type'] == 'wp_editor' )
                // include_once($value['type'].'.php');  
                $v['id'] = (!isset($id) || empty($id))?$k:$id.'['.$k.']'; 
                $m = $v['type'];                                 
                $this->$m($v);
            }
        }  
    }

    public function shortcodes_list( array $atts = [] ) {
    ?>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Shortcode</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>first-page</td>
                    <td>[test_shortcode att1="val1" att2="val2"]</td>
                </tr>
            </tbody>
        </table>        
    <?php
    }

    public function advanced_form_items( array  $atts = [] ) {
        global $page_hook;
    ?>
        <div class="wrap">
            <h1><?=$atts['page_title']?></h1>        

            <div class="clear"></div>

            <div class="widget-liquid-left">
                <div id="widgets-left" class="wp-clearfix">
                    <div class="sidebars-column-1">
                        <div class="widgets-holder-wrap">

                            <div class="sidebar-name">
                                <h2>Available Items</h2>
                            </div>

                            <div class="sidebar-description">
                                <p class="description">These items are available and can be added to appear on your landing pages.</p>
                            </div>     

                            <div id="sidebar-1" class="widgets-sortables ui-droppable ui-sortable" style="min-height: 175px">                           

                            <?=$atts['available']?>

                            </div>    
                        </div>                        
                    </div>                
                </div>
            </div>


            <div class="widget-liquid-right">
                <div id="widgets-right" class="wp-clearfix">
                    <div class="sidebars-column-1">
                        <form method="POST" action="" enctype="application/x-www-form-urlencoded" id="myform" name="myform">
                        <?php wp_nonce_field( $page_hook, '_wpnonce' ); ?>
                            <div class="widgets-holder-wrap">

                                <div class="sidebar-name">
                                    <h2>Current Display <span class="spinner"></span></h2>
                                </div>

                                <div class="sidebar-description">
                                <p class="description">You are displaying {count_items} items on your landing page. You can "Drag & Drop" items from the left column to this colum, do some sortings and save the changes.</p>
                                </div>
                                
                                <div id="sidebar-2" class="widgets-sortables ui-droppable ui-sortable" style="">
                                   <?=$atts['reserved']?>
                                </div>

                            </div>     
                            <p class="description"><?=(isset($atts['type_desc']))?esc_html($atts['type_desc']):''?></p>                                       
                            <p class="submit"><input id="submit" class="button button-primary" value="Save" type="submit"></p>                                                
                        </form>
                    </div>                                    
                </div>
            </div>

        </div>

    <?php
    }

    public static function get_instance() {
        if ( !static::$instance ) new static;
        return static::$instance;
    }

    public function __construct() {
        static::$instance = $this;
    }

}