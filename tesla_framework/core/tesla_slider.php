<?php

class Tesla_slider{

	private static $slider_config;
	private static $load;

	private function __construct(){}

	public static function init(){

		if(!isset(self::$slider_config)){

			self::$slider_config = include get_template_directory() . '/theme_config/slider-options.php';

			self::$load = new TT_Load;

			self::slider_autoload();

		}

	}

	private static function slider_autoload(){

		add_action( 'init', array('Tesla_slider','generate_custom_fields') );

		add_action( 'add_meta_boxes', array('Tesla_slider','generate_meta_boxes') );

		add_action('save_post', array('Tesla_slider','metabox_save') );

		self::generate_shortcodes();

		add_action('wp_enqueue_scripts', array('Tesla_slider','slider_enqueue') );

		add_action('admin_enqueue_scripts', array('Tesla_slider','slider_admin_enqueue') );

		self::register_ajax();

	}

	public static function slider_enqueue(){

		wp_enqueue_script('tesla-image-holder', TT_FW . '/static/js/holder.js',array(),null);

	}

	public static function slider_admin_enqueue(){

    	wp_enqueue_style('tesla-slider-admin', TT_FW . '/static/css//tesla_slider.css',false,null);

		wp_enqueue_media();
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('tesla-image-holder', TT_FW . '/static/js/holder.js',array(),null);
		wp_enqueue_script('tesla-slider-admin', TT_FW . '/static/js/tesla_slider.js',array(),null);

	}

	private static function generate_shortcodes(){

		$slider_options = self::$slider_config;

		foreach($slider_options as $slider_id => $slider){

			foreach($slider['output'] as $output_id => $output){

				if(isset($output['shortcode']))
					add_shortcode( $output['shortcode'], array('Tesla_slider','shortcode_view') );

			}

		}

	}

	public static function register_ajax(){

		add_action('wp_enqueue_scripts', array('Tesla_slider','ajax_scripts_enqueue'), 10000 );

		add_action( "wp_ajax_tesla_slider", array('Tesla_slider','ajax_content') );
		add_action( "wp_ajax_nopriv_tesla_slider", array('Tesla_slider','ajax_content') );

	}

	public static function ajax_scripts_enqueue(){

		$slider_options = self::$slider_config;

		$ajax_string = 'tesla_ajax.actions = {';

		foreach($slider_options as $slider_id => $slider){

			$ajax_string .= $slider_id.':{';

			foreach($slider['output'] as $output_id => $output){

				if(isset($output['ajax_javascript']))
					$ajax_string .= $output['ajax_javascript'].':
						function(offset,nr,callback,category=""){
							jQuery.post(tesla_ajax.url, {action:"tesla_slider",id:"'.$slider_id.'",view:"'.$output_id.'","offset":offset,"nr":nr,"category":category,nonce:tesla_ajax.nonce}, callback);
						},'."\n";

			}

			$ajax_string .= '},'."\n";

		}

		$ajax_string .= '}';

		wp_enqueue_script('jquery');
		wp_localize_script('jquery','tesla_ajax',array('url'=>admin_url( 'admin-ajax.php' ),'nonce'=>wp_create_nonce(),'l10n_print_after'=> $ajax_string));

	}

	public static function ajax_content(){

		if ( wp_verify_nonce( $_POST['nonce'])) {
	      
			$slider_options = self::$slider_config;

			$slider_id = $_POST['id'];
			$output_id = $_POST['view'];
			$category = $_POST['category'];
			$offset = $_POST['offset'];
			$nr = $_POST['nr'];

			if(array_key_exists($slider_id, $slider_options)){
				$data = array();
				$posts_array = get_posts(array(
					'post_type' => $slider_id,
					$slider_id.'_tax' => $category,
					'offset' => $offset,
					'numberposts' => $nr,
					'order' => isset($slider_options[$slider_id]['order'])?$slider_options[$slider_id]['order']:'DESC'
				));
				$values_array = array();
				foreach($posts_array as $post){
					$meta_array = get_post_meta($post->ID, 'slide_options', true);if(!is_array($meta_array))$meta_array=json_decode($meta_array,true);
					foreach($meta_array as $meta_id => $meta_value){
						if(empty($meta_value)&&isset($slider_options[$slider_id]['options'][$meta_id]['default']))
							$meta_array[$meta_id] = $slider_options[$slider_id]['options'][$meta_id]['default'];
					}
					$post_cats = get_the_terms($post->ID, $slider_id.'_tax');
					$post_cats_slugs = array();
					if(is_array($post_cats))
						foreach($post_cats as $cat)
							$post_cats_slugs[] = $cat->slug;
					$values_array[] = array(
						'post' => $post,
						'options' => $meta_array,
						'categories' => $post_cats_slugs //array of slugs
					);
				}
				$data['slides'] = $values_array;
				$data['all_categories'] = Tesla_slider::get_categories($slider_id, true);
				if($output_id===null){
					if(isset($slider_options[$slider_id]['output_default'])&&isset($slider_options[$slider_id]['output'][$slider_options[$slider_id]['output_default']])){
						$view = $slider_options[$slider_id]['output'][$slider_options[$slider_id]['output_default']]['view'];
					}else{
						$view_array = reset($slider_options[$slider_id]['output']);
						$view = $view_array['view'];
					}
				}else{
					$view = $slider_options[$slider_id]['output'][$output_id]['view'];
				}
				echo self::$load->view($view,$data,true,true);
			}

	   }  

		die();

	}

	public static function shortcode_view($atts, $content, $tag){

		extract(shortcode_atts(array(
            'category' => ''
        ), $atts));

        $slider_options = self::$slider_config;

        foreach($slider_options as $slider_id => $slider){

        	foreach($slider['output'] as $output_id => $output){

	        	if(isset($output['shortcode'])&&$output['shortcode']===$tag)
	        		return self::get_slider_html($slider_id,$category,$output_id,null,$atts);

        	}

        }

		return '';
		
	}

	public static function generate_custom_fields(){

		$slider_options = self::$slider_config;
		
		foreach($slider_options as $slider_id => $slider){

			$slider_term = isset($slider['term'])?$slider['term']:'slide';
			$slider_term_plural = isset($slider['term_plural'])?$slider['term_plural']:$slider_term.'s';
			$slider_queryable = isset($slider['has_single'])?$slider['has_single']:false;

			register_post_type($slider_id,array(
				'label' => $slider_id,
				'labels' => array(
					'name' => ucwords($slider_term_plural),
					'singular_name' => ucwords($slider_term),
					'menu_name' => $slider['name'],
					'all_items' => 'All '.ucwords($slider_term_plural),
					'add_new' => 'Add New',
					'add_new_item' => 'Add New '.ucwords($slider_term),
					'edit_item' => 'Edit '.ucwords($slider_term),
					'new_item' => 'New '.ucwords($slider_term),
					'view_item' => 'View '.ucwords($slider_term),
					'search_items' => 'Search '.ucwords($slider_term_plural),
					'not_found' => 'No '.$slider_term_plural.' found.',
					'not_found_in_trash' => 'No '.$slider_term_plural.' found.',
					'parent_item_colon' => 'Parent '.ucwords($slider_term)
				),
				'description' => 'Manage '.ucwords($slider_term_plural),
				'public' => true,
				'exclude_from_search' => true,
				'publicly_queryable' => $slider_queryable,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'show_in_menu' => true,
				'show_in_admin_bar' => true,
				'menu_position' => 100,
				'menu_icon' => isset($slider['icon'])?TT_THEME_URI.'/theme_config/'.$slider['icon']:null,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array(
					'title',
                                        'comments'
				),
			));

			register_taxonomy($slider_id.'_tax',$slider_id,array(
				'label' => 'Categories',
				'labels' => array(
					'name' => 'Categories',
					'singular_name' => 'Category',
					'menu_name' => 'Categories',
					'all_items' => 'All Categories',
					'edit_item' => 'Edt Categories',
					'view_item' => 'View Category',
					'update_item' => 'Update Category',
					'add_new_item' => 'Add New Category',
					'new_item_name' => 'New Category',
					'parent_item' => 'Parent Category',
					'parent_item_colon' => 'Parent Category:',
					'search_items' => 'Search Categories',
					'popular_items' => 'Popular Categories',
					'separate_items_with_commas' => 'Separate categories with commas',
					'add_or_remove_items' => 'Add or remove categories',
					'choose_from_most_used' => 'Choose from the most used categories',
					'not_found' => 'No categories found'
				),
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'show_tagcloud' => false,
				'show_admin_column' => true,
				'hierarchical' => true
			));

		}
	}

	public static function generate_meta_boxes(){

		$slider_options = self::$slider_config;

		foreach($slider_options as $slider_id => $slider){

			add_meta_box('slide_options','Slide Options',array('Tesla_slider','metabox_view'),$slider_id,'normal','default',array(
				'options' => $slider['options']
			));

		}

	}

	public static function metabox_view($post, $params){

		wp_nonce_field(-1, 'slide_options_nonce');

		$values_array = get_post_meta($post->ID, 'slide_options', true);if(!is_array($values_array))$values_array=json_decode($values_array,true);

		foreach($params['args']['options'] as $option_id => $option){

			$option_multiple = isset($option['multiple'])?$option['multiple']:false;
			$option_value = is_array($values_array)&&array_key_exists($option_id,$values_array)?$values_array[$option_id]:($option_multiple?array():'');
			
			$option_value_default = isset($option['default'])?$option['default']:'';
			
			switch($option['type']){
				case 'line':
					echo '<fieldset class="tesla-option">';
					echo '<legend>';
					echo $option['title'];
					echo '</legend>';
					echo '<div class="tesla-option-container">';
					
					echo '<input type="text" name="'.$option_id.'" value="'.$option_value.'" placeholder="'.$option['description'].'" />';
					
					echo '</fieldset>';
					break;
				case 'text':
					echo '<fieldset class="tesla-option">';
					echo '<legend>';
					echo $option['title'];
					echo '</legend>';
					echo '<div class="tesla-option-container">';
					
					echo '<textarea rows="1" cols="40" name="'.$option_id.'" placeholder="'.$option['description'].'">'.$option_value.'</textarea>';
					
					echo '</div>';
					echo '</fieldset>';
					break;
				case 'image':
					if(!$option_multiple){
						echo '<fieldset class="tesla-option">';
						echo '<legend>';
						echo $option['title'];
						echo '</legend>';
						echo '<div class="tesla-option-container">';
						echo '<label>';
						
						echo '<span class="tesla-image-holder" '.(empty($option_value)?'style="display:none;"':'').'>';
						echo '<img src="'.$option_value.'" class="tesla-slide-image" alt="'.$option['description'].'" />';
						echo '<br/>';
						echo '</span>';
						if(!empty($option_value_default)){
							echo '<span class="tesla-image-default" '.(empty($option_value_default)||!empty($option_value)?'style="display:none;"':'').'>';
							echo '<img src="'.$option_value_default.'" class="tesla-slide-image" alt="default image" />';
							echo '<br/>';
							echo '</span>';
						}
						echo '<input type="button" value="Set Image" class="tesla-select-image" />';
						echo '</label>';
						echo '<input type="button" value="Remove Image" class="tesla-remove-image" '.(empty($option_value)?'style="display:none;" ':'').'/>';
						echo '<input type="hidden" name="'.$option_id.'" value="'.$option_value.'" />';
						echo '</div>';
						echo '</fieldset>';
					}else{
						echo '<fieldset class="tesla-option-multiple">';
						echo '<legend>';
						echo $option['title'];
						echo '</legend>';

						if(is_array($option_value))
							foreach($option_value as $option_item){
								echo '
									<div class="tesla-option-container">
										<span class="tesla-image-holder">
											<img src="'.$option_item.'" class="tesla-slide-image" alt="'.$option['description'].'" />
											<br/>
										</span>
										<input type="button" value="Remove Image" class="tesla-delete-image" />
										<input type="hidden" name="'.$option_id.'[]" value="'.$option_item.'" />
									</div>
								';
							}

						echo '
							<div class="tesla-option-template">
								<span class="tesla-image-holder">
									<img src="" class="tesla-slide-image" alt="'.$option['description'].'" />
									<br/>
								</span>
								<input type="button" value="Remove Image" class="tesla-delete-image" />
								<input type="hidden" name="'.$option_id.'[]" value="" disabled="disabled" />
							</div>
						';

						if(!empty($option_value_default)){
							echo '<label>';
							echo '<img src="'.$option_value_default.'" class="tesla-slide-image" alt="default image" />';
							echo '<br/>';
							echo '<input type="button" value="Add Image" class="tesla-add-image" />';
							echo '</label>';
						}else
							echo '<input type="button" value="Add Image" class="tesla-add-image" />';
						echo '</fieldset>';
					}
					break;
				default:
					break;
			}

		}

	}

	public static function metabox_save($post_id){

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	        return;

	    if (!isset($_POST['slide_options_nonce']) || !wp_verify_nonce($_POST['slide_options_nonce']))
	        return;

	    if (!current_user_can('edit_post', $post_id))
	        return;

	    if (wp_is_post_revision($post_id) === false) {

	    	$post_type = get_post_type($post_id);

	    	$slider_options = self::$slider_config;

	    	$fields_array = array_keys($slider_options[$post_type]['options']);

	    	$values_array = array();

	    	foreach($fields_array as $field){
	    		$values_array[$field] = $_POST[$field];
	    	}

	        add_post_meta($post_id, 'slide_options', $values_array, true) or
            	update_post_meta($post_id, 'slide_options', $values_array);

	    }

	}

	public static function get_slider_html($slider_id, $category='', $output_id = null, $post_id = null, $shortcode_parameters = array()){

		$slider_options = self::$slider_config;

		if(!array_key_exists($slider_id, $slider_options))
			return false;
		else{
			if($output_id===null)
				if(isset($slider_options[$slider_id]['output_default'])&&isset($slider_options[$slider_id]['output'][$slider_options[$slider_id]['output_default']]))
					$output_id = $slider_options[$slider_id]['output_default'];
				else
					$output_id = reset(array_keys($slider_options[$slider_id]['output']));
			$data = array();
			$tesla_m = 0;
			if($slider_id === 'teslawp_main') $tesla_m = 4;
			if($slider_id === 'teslawp_portfolio') $tesla_m = 8;
			if($post_id === null)
				$posts_array = get_posts(array(
					'post_type' => $slider_id,
					$slider_id.'_tax' => $category,
					'numberposts' => $tesla_m,
					'order' => isset($slider_options[$slider_id]['order'])?$slider_options[$slider_id]['order']:'DESC',
					'posts_per_page' => -1
				));
			else
				$posts_array = array( get_post($post_id) );
			$values_array = array();
			foreach($posts_array as $post){
				$meta = get_post_meta($post->ID, 'slide_options', true);if(!is_array($meta))$meta=json_decode($meta,true);
				$meta_array = array();
				foreach ($slider_options[$slider_id]['options'] as $meta_id => $meta_value) {
					if(isset($meta[$meta_id]))
						if(empty($meta[$meta_id])&&isset($meta_value['default']))
							$meta_array[$meta_id] = $meta_value['default'];
						else
							$meta_array[$meta_id] = $meta[$meta_id];
					else
						if(isset($meta_value['multiple'])&&$meta_value['multiple']===true)
							$meta_array[$meta_id] = array();
						else
							$meta_array[$meta_id] = '';
				}
				
				$post_cats = get_the_terms($post->ID, $slider_id.'_tax');
				$post_cats_slugs = array();
				if(is_array($post_cats))
					foreach($post_cats as $cat)
						$post_cats_slugs[$cat->slug] = $cat->name;
				$values_array[] = array(
					'post' => $post,
                                        'nikhil' => $meta,
					'options' => $meta_array,
					'categories' => $post_cats_slugs, //array of slugs
					'related' => self::get_related($post->ID)
				);
			}
			$data['slides'] = $values_array;
			$data['all_categories'] = Tesla_slider::get_categories($slider_id, true);
			$shortcode_defaults = isset($slider_options[$slider_id]['output'][$output_id]['shortcode_defaults'])?$slider_options[$slider_id]['output'][$output_id]['shortcode_defaults']:array();
			$data['shortcode'] = shortcode_atts($shortcode_defaults,$shortcode_parameters);
			
			$view = $slider_options[$slider_id]['output'][$output_id]['view'];
			return self::$load->view($view,$data,true,true);
		}

	}

	public static function get_available_sliders_list(){

		$slider_list = array();

		$slider_options = self::$slider_config;
		
		foreach($slider_options as $slider_id => $slider)
			$slider_list[$slider_id] = $slider['name'];

		return $slider_list;

	}

	public static function get_categories($slider_id, $hide_empty = false, $raw = false){

		$tax_array =  get_terms($slider_id.'_tax',array('hide_empty'=>$hide_empty));

		if($raw){
			return $tax_array;
		}

		$tax_categories = array();

		foreach($tax_array as $tax){
			$tax_categories[$tax->slug] = $tax->name;
		}

		return $tax_categories;

	}

	public static function get_related($post_id){

		$slider_options = self::$slider_config;

		$slider_id = get_post_type($post_id);

		$slugs_array = get_the_terms($post_id, $slider_id.'_tax');
		$slugs = array();
		if(is_array($slugs_array))
			foreach($slugs_array as $cat)
				$slugs[] = $cat->slug;

		$related_array = get_posts(array(
			'post_type' => $slider_id,
			$slider_id.'_tax' => implode(', ', $slugs),
			'post__not_in' => array( $post_id ),
			'order' => isset($slider_options[$slider_id]['order'])?$slider_options[$slider_id]['order']:'DESC',
			'posts_per_page' => -1
		));

		$values_array = array();
		foreach($related_array as $post){
			$meta_array = get_post_meta($post->ID, 'slide_options', true);if(!is_array($meta_array))$meta_array=json_decode($meta_array,true);
			foreach($meta_array as $meta_id => $meta_value){
				if(empty($meta_value)&&isset($slider_options[$slider_id]['options'][$meta_id]['default']))
					$meta_array[$meta_id] = $slider_options[$slider_id]['options'][$meta_id]['default'];
			}
			$post_cats = get_the_terms($post->ID, $slider_id.'_tax');
			$post_cats_slugs = array();
			if(is_array($post_cats))
				foreach($post_cats as $cat)
					$post_cats_slugs[] = $cat->slug;
			$values_array[] = array(
				'post' => $post,
				'options' => $meta_array,
				'categories' => $post_cats_slugs //array of slugs
			);
		}

		return $values_array;

	}

}