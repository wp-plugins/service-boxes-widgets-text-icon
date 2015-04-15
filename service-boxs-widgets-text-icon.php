<?php
/** 
    * Plugin Name: Service Boxes Widgets Text Icon
    * Plugin URI: http://plugin.bdwebteam.com/service-boxes-widgets-text-icon/
    * Description: Basically it just a WordPress "Service Boxes Text Widget" but with additional icon font selector based on <a href="http://fortawesome.github.io/Font-Awesome/">FontAwesome</a>. The Icon will display Top, bottom, Left, Right to widget title.
    * Author:Md. Mahabub Hasan Manik
    * Author URI: http://bdwebteam.com/
    * Version: 1.0.1
    * Text Domain: service-Boxes-widgets-text-icon
    * Domain Path: /languages
    * License: MIT License
    * License URI: http://opensource.org/licenses/MIT
*/

/**
   *
   * @package   Service_Boxes_Widget_Text_Icon
   * @author    Md. Mahabub Masan Manik <bdwebteam@gmail.com>
   * @license   MIT License
   * @link      http://plugin.bdwebteam.com/service-boxes-widgets-text-icon/
   * @copyright 2015 Mahabub Hasan
   * 
 */



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Service_Boxes_Widget_Text_Icon extends WP_Widget {

	/**
	 * Default service Boxes Widgets Text Icon widget values.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Default service Boxes Widgets Text Icon widget values.
	 *
	 * @var array
	 */
	protected $sizes;
    
    	/**
	 * Default service Boxes Widgets Text Icon  widget values.
	 *
	 * @var array
	 */
	protected $positions;

	/**
	 * Constructor method.
	 *
	 * Set some global values and create widget.
	 */
	function __construct() {

		/**
		 * Default service Boxes Widgets Text Icon widget option values.
		 */
		$this->defaults = array(
			'title'		=> '',
			'icon'		=> '',
            'position'	=> 'left',
			'size'		=> '16',
			'text'		=> '',
			'filter'	=> 0
		);

		/**
		 * Icon sizes.
		 */
		$this->sizes = array( '14', '16', '24', '32', '48', '78', '100' );
        
        /**
		 * service Boxes Widgets Text Icon position.
		 */         
		$this->positions = array( 'top', 'right', 'bottom', 'left');
        
		$widget_bdops = array(
			'classname'	  => 'service-boxes-widget-text-icon',
			'description' => __( 'Displays icon from FontAwesome before widget title.', 'bdweb' ),
		);

		$control_bdops = array(
			'id_base' => 'service-boxes-widget-text-icon',
			'width'   => 400,
			#'height'  => 200,
		);

		$this->WP_Widget( 'service-boxes-widget-text-icon', __( 'Service Boxes Widget Text Icon', 'bdweb' ), $widget_bdops, $control_bdops );

		/** Load font-awesome.css  */
		add_action( 'wp_enqueue_scripts', array( $this, 'awesome_css' ), 8 );

	}

	/**
	 * Widget Form.
	 *
	 * Outputs the widget form that allows users to control the output of the widget.
	 *
	 */
	function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'bdweb' ); ?>:</label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e( 'Choose Icon', 'bdweb' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>">
				<?php
				foreach ( bdweb_fontawesome() as $icons => $icon ) {
					printf( '<option value="%s" %s>%s</option>', $icon, selected( $icon, $instance['icon'], 0 ), $icon );
				}
				?>
			</select>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size', 'bdweb' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
				<?php
				foreach ( (array) $this->sizes as $size ) {
					printf( '<option value="%d" %s>%dpx</option>', (int) $size, selected( $size, $instance['size'], 0 ), (int) $size );
				}
				?>
			</select>
		</p>
        
        <p>
        <label for="<?php echo $this->get_field_id( 'position' ); ?>"><?php _e( 'Icon Position', 'bdweb' ); ?>:</label>
        			<select id="<?php echo $this->get_field_id( 'position' ); ?>" name="<?php echo $this->get_field_name( 'position' ); ?>">
        				<?php
        				foreach ( (array) $this->positions as $position ) {
        					printf( '<option value="%s" %s>%s</option>', $position, selected( $position, $instance['position'], 0 ), $position );
        				}
        				?>
        			</select>
        </p>
        
		<textarea class="widefat" rows="14" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea($instance['text']); ?></textarea>

		<p>
            <input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'read-more-btn-txt' ); ?>"><?php _e( 'Read More Botton Text', 'bdweb' ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'read-more-btn-txt' ); ?>" name="<?php echo $this->get_field_name( 'read-more-btn-txt' ); ?>" type="text" value="<?php echo esc_attr( $instance['read-more-btn-txt'] ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'read-more-btn-link' ); ?>"><?php _e( 'Read More link', 'bdweb' ); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'read-more-btn-link' ); ?>" name="<?php echo $this->get_field_name( 'read-more-btn-link' ); ?>" type="text" value="<?php echo esc_attr( $instance['read-more-btn-link'] ); ?>" />
        </p>

		<?php

	}

	/**
	 * Form validation.
	 *
	 * Runs when you save the widget form. Allows you to validate widget options before they are saved.
	 *
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['icon'] = $new_instance['icon'];
        $instance['position'] = $new_instance['position'];
		$instance['size'] = $new_instance['size'];
        $instance['read-more-btn-txt'] = $new_instance['read-more-btn-txt'];
        $instance['read-more-btn-link'] = $new_instance['read-more-btn-link'];
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
		$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	/**
	 * Widget Output.
	 *
	 * Outputs the actual widget on the front-end based on the widget options the user selected.
	 *
	 */
	function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        $size = ( ! empty( $instance['size'] ) ) ? 'font-size: '. $instance['size'] .'px;' : '' ;
        
       
        if ($instance['position']=='left'){ 
            
        $icon = ( ! empty( $instance['icon'] ) ) ? '<i class="fa fa-'. $instance['icon'] .'" style="line-height:1em;margin-right:10px;'. $size .'" ></i>' : '';
        }
        elseif($instance['position']=='top'){
         
         $icon = ( ! empty( $instance['icon'] ) ) ? '<i class="fa fa-'. $instance['icon'] .'" style="display: block;text-align: center;line-height:1em;margin-right:10px;'. $size .'" ></i>' : '';
        }
        elseif($instance['position']=='right'){
         
         $icon = ( ! empty( $instance['icon'] ) ) ? '<i class="fa fa-'. $instance['icon'] .'" style="line-height:1em;margin-right:10px;'. $size .'" ></i>' : '';
        }
        elseif($instance['position']=='bottom'){
         
         $icon = ( ! empty( $instance['icon'] ) ) ? '<i class="fa fa-'. $instance['icon'] .'" style="display: block;text-align: center;line-height:1em;margin-right:10px;'. $size .'" ></i>' : '';
        }

		echo $before_widget;

		if ( !empty( $title ) ):  
        
            if ($instance['position']=='left'){ 
            
                echo $before_title . $icon . $title . $after_title;
                }
            elseif($instance['position']=='top'){
            
                echo $before_title . $icon . $title . $after_title;
                }
            elseif($instance['position']=='right'){
            
                echo $before_title . $title .  $icon .  $after_title;
                }
            elseif($instance['position']=='bottom'){
            
                echo $before_title . $title . $icon . $after_title;
                }
        endif;
            
		?>

		<div class="textwidget-icon"><?php echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
        
        <?php if( ! empty( $instance['read-more-btn-txt'] )){ ?>
            <div class="read-more-page-link"><a class="btn btn-primary" href="<?php echo $instance['read-more-btn-link']; ?>"><?php echo $instance['read-more-btn-txt']; ?></a></div>   
        <?php } ?>
    	
        <?php  echo $after_widget;

	}

	/** Load font-awesome.css if widget active */
	function awesome_css() {
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$browser = substr( "$browser", 25, 8);

	    /** Register Fontawesome v.3.0.2 */
		if ( ! wp_style_is( "fontawesome", "registered" ) )
	    	wp_register_style( "fontawesome", "//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css", array(), "4.3.0", "all" );
		if ( ! wp_style_is( "fontawesome-ie7", "registered" ) )
			wp_register_style( "fontawesome-ie7", "//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome-ie7.css", array(), "3.0.2", "all" );
		
		if ( ! is_admin() && is_active_widget( false, false, $this->id_base, true ) ) {
			wp_enqueue_style( 'fontawesome' );
		} elseif ( ! is_admin() && is_active_widget( false, false, $this->id_base, true ) && $browser == "MSIE 7.0" ) {
			wp_enqueue_style( 'fontawesome-ie7' );
		}

	}

}

add_action( 'widgets_init', 'bdweb_load_widget' );
/**
 * Widget Registration.
 *
 * Register Service Boxes Widgets Text Icon.
 *
 */
function bdweb_load_widget() {

	register_widget( 'Service_Boxes_Widget_Text_Icon' );

}

if ( ! function_exists( 'bdweb_fontawesome' ) ) :

/**
 * This function is an array for listing fontawesome classes
 *
 * @var 		array
 * @link 		http://fortawesome.github.com/Font-Awesome/
 * @license  	https://github.com/FortAwesome/Font-Awesome#license
 * @version 	4.1.0
 */
function bdweb_fontawesome(){

	$bdweb_fontawesome = array(
		""						=> __( '- Select Icon -', 'bdweb' ),
        'none' => 'No Icon',
        'fa-adjust' => 'adjust',
        'fa-anchor' => 'anchor',
        'fa-archive' => 'archive',
        'fa-arrows' => 'arrows',
        'fa-arrows-h' => 'arrows-h',
        'fa-arrows-v' => 'arrows-v',
        'fa-asterisk' => 'asterisk',
        'fa-automobile' => 'automobile',
        'fa-ban' => 'ban',
        'fa-bank' => 'bank',
        'fa-bar-chart-o' => 'bar-chart-o',
        'fa-barcode' => 'barcode',
        'fa-bars' => 'bars',
        'fa-beer' => 'beer',
        'fa-bell' => 'bell',
        'fa-bell-o' => 'bell-o',
        'fa-bolt' => 'bolt',
        'fa-bomb' => 'bomb',
        'fa-book' => 'book',
        'fa-bookmark' => 'bookmark',
        'fa-bookmark-o' => 'bookmark-o',
        'fa-briefcase' => 'briefcase',
        'fa-bug' => 'bug',
        'fa-building' => 'building',
        'fa-building-o' => 'building-o',
        'fa-bullhorn' => 'bullhorn',
        'fa-bullseye' => 'bullseye',
        'fa-cab' => 'cab',
        'fa-calendar' => 'calendar',
        'fa-calendar-o' => 'calendar-o',
        'fa-camera' => 'camera',
        'fa-camera-retro' => 'camera-retro',
        'fa-car' => 'car',
        'fa-caret-square-o-down' => 'caret-square-o-down',
        'fa-caret-square-o-left' => 'caret-square-o-left',
        'fa-caret-square-o-right' => 'caret-square-o-right',
        'fa-caret-square-o-up' => 'caret-square-o-up',
        'fa-certificate' => 'certificate',
        'fa-check' => 'check',
        'fa-check-circle' => 'check-circle',
        'fa-check-circle-o' => 'check-circle-o',
        'fa-check-square' => 'check-square',
        'fa-check-square-o' => 'check-square-o',
        'fa-child' => 'child',
        'fa-circle' => 'circle',
        'fa-circle-o' => 'circle-o',
        'fa-circle-o-notch' => 'circle-o-notch',
        'fa-circle-thin' => 'circle-thin',
        'fa-clock-o' => 'clock-o',
        'fa-cloud' => 'cloud',
        'fa-cloud-download' => 'cloud-download',
        'fa-cloud-upload' => 'cloud-upload',
        'fa-code' => 'code',
        'fa-code-fork' => 'code-fork',
        'fa-coffee' => 'coffee',
        'fa-cog' => 'cog',
        'fa-cogs' => 'cogs',
        'fa-comment' => 'comment',
        'fa-comment-o' => 'comment-o',
        'fa-comments' => 'comments',
        'fa-comments-o' => 'comments-o',
        'fa-compass' => 'compass',
        'fa-credit-card' => 'credit-card',
        'fa-crop' => 'crop',
        'fa-crosshairs' => 'crosshairs',
        'fa-cube' => 'cube',
        'fa-cubes' => 'cubes',
        'fa-cutlery' => 'cutlery',
        'fa-dashboard' => 'dashboard',
        'fa-database' => 'database',
        'fa-desktop' => 'desktop',
        'fa-dot-circle-o' => 'dot-circle-o',
        'fa-download' => 'download',
        'fa-edit' => 'edit',
        'fa-ellipsis-h' => 'ellipsis-h',
        'fa-ellipsis-v' => 'ellipsis-v',
        'fa-envelope' => 'envelope',
        'fa-envelope-o' => 'envelope-o',
        'fa-envelope-square' => 'envelope-square',
        'fa-eraser' => 'eraser',
        'fa-exchange' => 'exchange',
        'fa-exclamation' => 'exclamation',
        'fa-exclamation-circle' => 'exclamation-circle',
        'fa-exclamation-triangle' => 'exclamation-triangle',
        'fa-external-link' => 'external-link',
        'fa-external-link-square' => 'external-link-square',
        'fa-eye' => 'eye',
        'fa-eye-slash' => 'eye-slash',
        'fa-fax' => 'fax',
        'fa-female' => 'female',
        'fa-fighter-jet' => 'fighter-jet',
        'fa-file-archive-o' => 'file-archive-o',
        'fa-file-audio-o' => 'file-audio-o',
        'fa-file-code-o' => 'file-code-o',
        'fa-file-excel-o' => 'file-excel-o',
        'fa-file-image-o' => 'file-image-o',
        'fa-file-movie-o' => 'file-movie-o',
        'fa-file-pdf-o' => 'file-pdf-o',
        'fa-file-photo-o' => 'file-photo-o',
        'fa-file-picture-o' => 'file-picture-o',
        'fa-file-powerpoint-o' => 'file-powerpoint-o',
        'fa-file-sound-o' => 'file-sound-o',
        'fa-file-video-o' => 'file-video-o',
        'fa-file-word-o' => 'file-word-o',
        'fa-file-zip-o' => 'file-zip-o',
        'fa-film' => 'film',
        'fa-filter' => 'filter',
        'fa-fire' => 'fire',
        'fa-fire-extinguisher' => 'fire-extinguisher',
        'fa-flag' => 'flag',
        'fa-flag-checkered' => 'flag-checkered',
        'fa-flag-o' => 'flag-o',
        'fa-flash' => 'flash',
        'fa-flask' => 'flask',
        'fa-folder' => 'folder',
        'fa-folder-o' => 'folder-o',
        'fa-folder-open' => 'folder-open',
        'fa-folder-open-o' => 'folder-open-o',
        'fa-frown-o' => 'frown-o',
        'fa-gamepad' => 'gamepad',
        'fa-gavel' => 'gavel',
        'fa-gear' => 'gear',
        'fa-gears' => 'gears',
        'fa-gift' => 'gift',
        'fa-glass' => 'glass',
        'fa-globe' => 'globe',
        'fa-graduation-cap' => 'graduation-cap',
        'fa-group' => 'group',
        'fa-hdd-o' => 'hdd-o',
        'fa-headphones' => 'headphones',
        'fa-heart' => 'heart',
        'fa-heart-o' => 'heart-o',
        'fa-history' => 'history',
        'fa-home' => 'home',
        'fa-image' => 'image',
        'fa-inbox' => 'inbox',
        'fa-info' => 'info',
        'fa-info-circle' => 'info-circle',
        'fa-institution' => 'institution',
        'fa-key' => 'key',
        'fa-keyboard-o' => 'keyboard-o',
        'fa-language' => 'language',
        'fa-laptop' => 'laptop',
        'fa-leaf' => 'leaf',
        'fa-legal' => 'legal',
        'fa-lemon-o' => 'lemon-o',
        'fa-level-down' => 'level-down',
        'fa-level-up' => 'level-up',
        'fa-life-bouy' => 'life-bouy',
        'fa-life-ring' => 'life-ring',
        'fa-life-saver' => 'life-saver',
        'fa-lightbulb-o' => 'lightbulb-o',
        'fa-location-arrow' => 'location-arrow',
        'fa-lock' => 'lock',
        'fa-magic' => 'magic',
        'fa-magnet' => 'magnet',
        'fa-mail-forward' => 'mail-forward',
        'fa-mail-reply' => 'mail-reply',
        'fa-mail-reply-all' => 'mail-reply-all',
        'fa-male' => 'male',
        'fa-map-marker' => 'map-marker',
        'fa-meh-o' => 'meh-o',
        'fa-microphone' => 'microphone',
        'fa-microphone-slash' => 'microphone-slash',
        'fa-minus' => 'minus',
        'fa-minus-circle' => 'minus-circle',
        'fa-minus-square' => 'minus-square',
        'fa-minus-square-o' => 'minus-square-o',
        'fa-mobile' => 'mobile',
        'fa-mobile-phone' => 'mobile-phone',
        'fa-money' => 'money',
        'fa-moon-o' => 'moon-o',
        'fa-mortar-board' => 'mortar-board',
        'fa-music' => 'music',
        'fa-navicon' => 'navicon',
        'fa-paper-plane' => 'paper-plane',
        'fa-paper-plane-o' => 'paper-plane-o',
        'fa-paw' => 'paw',
        'fa-pencil' => 'pencil',
        'fa-pencil-square' => 'pencil-square',
        'fa-pencil-square-o' => 'pencil-square-o',
        'fa-phone' => 'phone',
        'fa-phone-square' => 'phone-square',
        'fa-photo' => 'photo',
        'fa-picture-o' => 'picture-o',
        'fa-plane' => 'plane',
        'fa-plus' => 'plus',
        'fa-plus-circle' => 'plus-circle',
        'fa-plus-square' => 'plus-square',
        'fa-plus-square-o' => 'plus-square-o',
        'fa-power-off' => 'power-off',
        'fa-print' => 'print',
        'fa-puzzle-piece' => 'puzzle-piece',
        'fa-qrcode' => 'qrcode',
        'fa-question' => 'question',
        'fa-question-circle' => 'question-circle',
        'fa-quote-left' => 'quote-left',
        'fa-quote-right' => 'quote-right',
        'fa-random' => 'random',
        'fa-recycle' => 'recycle',
        'fa-refresh' => 'refresh',
        'fa-reorder' => 'reorder',
        'fa-reply' => 'reply',
        'fa-reply-all' => 'reply-all',
        'fa-retweet' => 'retweet',
        'fa-road' => 'road',
        'fa-rocket' => 'rocket',
        'fa-rss' => 'rss',
        'fa-rss-square' => 'rss-square',
        'fa-search' => 'search',
        'fa-search-minus' => 'search-minus',
        'fa-search-plus' => 'search-plus',
        'fa-send' => 'send',
        'fa-send-o' => 'send-o',
        'fa-share' => 'share',
        'fa-share-alt' => 'share-alt',
        'fa-share-alt-square' => 'share-alt-square',
        'fa-share-square' => 'share-square',
        'fa-share-square-o' => 'share-square-o',
        'fa-shield' => 'shield',
        'fa-shopping-cart' => 'shopping-cart',
        'fa-sign-in' => 'sign-in',
        'fa-sign-out' => 'sign-out',
        'fa-signal' => 'signal',
        'fa-sitemap' => 'sitemap',
        'fa-sliders' => 'sliders',
        'fa-smile-o' => 'smile-o',
        'fa-sort' => 'sort',
        'fa-sort-alpha-asc' => 'sort-alpha-asc',
        'fa-sort-alpha-desc' => 'sort-alpha-desc',
        'fa-sort-amount-asc' => 'sort-amount-asc',
        'fa-sort-amount-desc' => 'sort-amount-desc',
        'fa-sort-asc' => 'sort-asc',
        'fa-sort-desc' => 'sort-desc',
        'fa-sort-down' => 'sort-down',
        'fa-sort-numeric-asc' => 'sort-numeric-asc',
        'fa-sort-numeric-desc' => 'sort-numeric-desc',
        'fa-sort-up' => 'sort-up',
        'fa-space-shuttle' => 'space-shuttle',
        'fa-spinner' => 'spinner',
        'fa-spoon' => 'spoon',
        'fa-square' => 'square',
        'fa-square-o' => 'square-o',
        'fa-star' => 'star',
        'fa-star-half' => 'star-half',
        'fa-star-half-empty' => 'star-half-empty',
        'fa-star-half-full' => 'star-half-full',
        'fa-star-half-o' => 'star-half-o',
        'fa-star-o' => 'star-o',
        'fa-suitcase' => 'suitcase',
        'fa-sun-o' => 'sun-o',
        'fa-support' => 'support',
        'fa-tablet' => 'tablet',
        'fa-tachometer' => 'tachometer',
        'fa-tag' => 'tag',
        'fa-tags' => 'tags',
        'fa-tasks' => 'tasks',
        'fa-taxi' => 'taxi',
        'fa-terminal' => 'terminal',
        'fa-thumb-tack' => 'thumb-tack',
        'fa-thumbs-down' => 'thumbs-down',
        'fa-thumbs-o-down' => 'thumbs-o-down',
        'fa-thumbs-o-up' => 'thumbs-o-up',
        'fa-thumbs-up' => 'thumbs-up',
        'fa-ticket' => 'ticket',
        'fa-times' => 'times',
        'fa-times-circle' => 'times-circle',
        'fa-times-circle-o' => 'times-circle-o',
        'fa-tint' => 'tint',
        'fa-toggle-down' => 'toggle-down',
        'fa-toggle-left' => 'toggle-left',
        'fa-toggle-right' => 'toggle-right',
        'fa-toggle-up' => 'toggle-up',
        'fa-trash-o' => 'trash-o',
        'fa-tree' => 'tree',
        'fa-trophy' => 'trophy',
        'fa-truck' => 'truck',
        'fa-umbrella' => 'umbrella',
        'fa-university' => 'university',
        'fa-unlock' => 'unlock',
        'fa-unlock-alt' => 'unlock-alt',
        'fa-unsorted' => 'unsorted',
        'fa-upload' => 'upload',
        'fa-user' => 'user',
        'fa-users' => 'users',
        'fa-video-camera' => 'video-camera',
        'fa-volume-down' => 'volume-down',
        'fa-volume-off' => 'volume-off',
        'fa-volume-up' => 'volume-up',
        'fa-warning' => 'warning',
        'fa-wheelchair' => 'wheelchair',
        'fa-wrench' => 'wrench',
        'fa-file' => 'file',
        'fa-file-archive-o' => 'file-archive-o',
        'fa-file-audio-o' => 'file-audio-o',
        'fa-file-code-o' => 'file-code-o',
        'fa-file-excel-o' => 'file-excel-o',
        'fa-file-image-o' => 'file-image-o',
        'fa-file-movie-o' => 'file-movie-o',
        'fa-file-o' => 'file-o',
        'fa-file-pdf-o' => 'file-pdf-o',
        'fa-file-photo-o' => 'file-photo-o',
        'fa-file-picture-o' => 'file-picture-o',
        'fa-file-powerpoint-o' => 'file-powerpoint-o',
        'fa-file-sound-o' => 'file-sound-o',
        'fa-file-text' => 'file-text',
        'fa-file-text-o' => 'file-text-o',
        'fa-file-video-o' => 'file-video-o',
        'fa-file-word-o' => 'file-word-o',
        'fa-file-zip-o' => 'file-zip-o',
        'fa-circle-o-notch' => 'circle-o-notch',
        'fa-cog' => 'cog',
        'fa-gear' => 'gear',
        'fa-refresh' => 'refresh',
        'fa-spinner' => 'spinner',
        'fa-check-square' => 'check-square',
        'fa-check-square-o' => 'check-square-o',
        'fa-circle' => 'circle',
        'fa-circle-o' => 'circle-o',
        'fa-dot-circle-o' => 'dot-circle-o',
        'fa-minus-square' => 'minus-square',
        'fa-minus-square-o' => 'minus-square-o',
        'fa-plus-square' => 'plus-square',
        'fa-plus-square-o' => 'plus-square-o',
        'fa-square' => 'square',
        'fa-square-o' => 'square-o',
        'fa-bitcoin' => 'bitcoin',
        'fa-btc' => 'btc',
        'fa-cny' => 'cny',
        'fa-dollar' => 'dollar',
        'fa-eur' => 'eur',
        'fa-euro' => 'euro',
        'fa-gbp' => 'gbp',
        'fa-inr' => 'inr',
        'fa-jpy' => 'jpy',
        'fa-krw' => 'krw',
        'fa-money' => 'money',
        'fa-rmb' => 'rmb',
        'fa-rouble' => 'rouble',
        'fa-rub' => 'rub',
        'fa-ruble' => 'ruble',
        'fa-rupee' => 'rupee',
        'fa-try' => 'try',
        'fa-turkish-lira' => 'turkish-lira',
        'fa-usd' => 'usd',
        'fa-won' => 'won',
        'fa-yen' => 'yen',
        'fa-align-center' => 'align-center',
        'fa-align-justify' => 'align-justify',
        'fa-align-left' => 'align-left',
        'fa-align-right' => 'align-right',
        'fa-bold' => 'bold',
        'fa-chain' => 'chain',
        'fa-chain-broken' => 'chain-broken',
        'fa-clipboard' => 'clipboard',
        'fa-columns' => 'columns',
        'fa-copy' => 'copy',
        'fa-cut' => 'cut',
        'fa-dedent' => 'dedent',
        'fa-eraser' => 'eraser',
        'fa-file' => 'file',
        'fa-file-o' => 'file-o',
        'fa-file-text' => 'file-text',
        'fa-file-text-o' => 'file-text-o',
        'fa-files-o' => 'files-o',
        'fa-floppy-o' => 'floppy-o',
        'fa-font' => 'font',
        'fa-header' => 'header',
        'fa-indent' => 'indent',
        'fa-italic' => 'italic',
        'fa-link' => 'link',
        'fa-list' => 'list',
        'fa-list-alt' => 'list-alt',
        'fa-list-ol' => 'list-ol',
        'fa-list-ul' => 'list-ul',
        'fa-outdent' => 'outdent',
        'fa-paperclip' => 'paperclip',
        'fa-paragraph' => 'paragraph',
        'fa-paste' => 'paste',
        'fa-repeat' => 'repeat',
        'fa-rotate-left' => 'rotate-left',
        'fa-rotate-right' => 'rotate-right',
        'fa-save' => 'save',
        'fa-scissors' => 'scissors',
        'fa-strikethrough' => 'strikethrough',
        'fa-subscript' => 'subscript',
        'fa-superscript' => 'superscript',
        'fa-table' => 'table',
        'fa-text-height' => 'text-height',
        'fa-text-width' => 'text-width',
        'fa-th' => 'th',
        'fa-th-large' => 'th-large',
        'fa-th-list' => 'th-list',
        'fa-underline' => 'underline',
        'fa-undo' => 'undo',
        'fa-unlink' => 'unlink',
        'fa-angle-double-down' => 'angle-double-down',
        'fa-angle-double-left' => 'angle-double-left',
        'fa-angle-double-right' => 'angle-double-right',
        'fa-angle-double-up' => 'angle-double-up',
        'fa-angle-down' => 'angle-down',
        'fa-angle-left' => 'angle-left',
        'fa-angle-right' => 'angle-right',
        'fa-angle-up' => 'angle-up',
        'fa-arrow-circle-down' => 'arrow-circle-down',
        'fa-arrow-circle-left' => 'arrow-circle-left',
        'fa-arrow-circle-o-down' => 'arrow-circle-o-down',
        'fa-arrow-circle-o-left' => 'arrow-circle-o-left',
        'fa-arrow-circle-o-right' => 'arrow-circle-o-right',
        'fa-arrow-circle-o-up' => 'arrow-circle-o-up',
        'fa-arrow-circle-right' => 'arrow-circle-right',
        'fa-arrow-circle-up' => 'arrow-circle-up',
        'fa-arrow-down' => 'arrow-down',
        'fa-arrow-left' => 'arrow-left',
        'fa-arrow-right' => 'arrow-right',
        'fa-arrow-up' => 'arrow-up',
        'fa-arrows' => 'arrows',
        'fa-arrows-alt' => 'arrows-alt',
        'fa-arrows-h' => 'arrows-h',
        'fa-arrows-v' => 'arrows-v',
        'fa-caret-down' => 'caret-down',
        'fa-caret-left' => 'caret-left',
        'fa-caret-right' => 'caret-right',
        'fa-caret-square-o-down' => 'caret-square-o-down',
        'fa-caret-square-o-left' => 'caret-square-o-left',
        'fa-caret-square-o-right' => 'caret-square-o-right',
        'fa-caret-square-o-up' => 'caret-square-o-up',
        'fa-caret-up' => 'caret-up',
        'fa-chevron-circle-down' => 'chevron-circle-down',
        'fa-chevron-circle-left' => 'chevron-circle-left',
        'fa-chevron-circle-right' => 'chevron-circle-right',
        'fa-chevron-circle-up' => 'chevron-circle-up',
        'fa-chevron-down' => 'chevron-down',
        'fa-chevron-left' => 'chevron-left',
        'fa-chevron-right' => 'chevron-right',
        'fa-chevron-up' => 'chevron-up',
        'fa-hand-o-down' => 'hand-o-down',
        'fa-hand-o-left' => 'hand-o-left',
        'fa-hand-o-right' => 'hand-o-right',
        'fa-hand-o-up' => 'hand-o-up',
        'fa-long-arrow-down' => 'long-arrow-down',
        'fa-long-arrow-left' => 'long-arrow-left',
        'fa-long-arrow-right' => 'long-arrow-right',
        'fa-long-arrow-up' => 'long-arrow-up',
        'fa-toggle-down' => 'toggle-down',
        'fa-toggle-left' => 'toggle-left',
        'fa-toggle-right' => 'toggle-right',
        'fa-toggle-up' => 'toggle-up',
        'fa-arrows-alt' => 'arrows-alt',
        'fa-backward' => 'backward',
        'fa-compress' => 'compress',
        'fa-eject' => 'eject',
        'fa-expand' => 'expand',
        'fa-fast-backward' => 'fast-backward',
        'fa-fast-forward' => 'fast-forward',
        'fa-forward' => 'forward',
        'fa-pause' => 'pause',
        'fa-play' => 'play',
        'fa-play-circle' => 'play-circle',
        'fa-play-circle-o' => 'play-circle-o',
        'fa-step-backward' => 'step-backward',
        'fa-step-forward' => 'step-forward',
        'fa-stop' => 'stop',
        'fa-youtube-play' => 'youtube-play',
        'fa-adn' => 'adn',
        'fa-android' => 'android',
        'fa-apple' => 'apple',
        'fa-behance' => 'behance',
        'fa-behance-square' => 'behance-square',
        'fa-bitbucket' => 'bitbucket',
        'fa-bitbucket-square' => 'bitbucket-square',
        'fa-bitcoin' => 'bitcoin',
        'fa-btc' => 'btc',
        'fa-codepen' => 'codepen',
        'fa-css3' => 'css3',
        'fa-delicious' => 'delicious',
        'fa-deviantart' => 'deviantart',
        'fa-digg' => 'digg',
        'fa-dribbble' => 'dribbble',
        'fa-dropbox' => 'dropbox',
        'fa-drupal' => 'drupal',
        'fa-empire' => 'empire',
        'fa-facebook' => 'facebook',
        'fa-facebook-square' => 'facebook-square',
        'fa-flickr' => 'flickr',
        'fa-foursquare' => 'foursquare',
        'fa-ge' => 'ge',
        'fa-git' => 'git',
        'fa-git-square' => 'git-square',
        'fa-github' => 'github',
        'fa-github-alt' => 'github-alt',
        'fa-github-square' => 'github-square',
        'fa-gittip' => 'gittip',
        'fa-google' => 'google',
        'fa-google-plus' => 'google-plus',
        'fa-google-plus-square' => 'google-plus-square',
        'fa-hacker-news' => 'hacker-news',
        'fa-html5' => 'html5',
        'fa-instagram' => 'instagram',
        'fa-joomla' => 'joomla',
        'fa-jsfiddle' => 'jsfiddle',
        'fa-linkedin' => 'linkedin',
        'fa-linkedin-square' => 'linkedin-square',
        'fa-linux' => 'linux',
        'fa-maxcdn' => 'maxcdn',
        'fa-openid' => 'openid',
        'fa-pagelines' => 'pagelines',
        'fa-pied-piper' => 'pied-piper',
        'fa-pied-piper-alt' => 'pied-piper-alt',
        'fa-pied-piper-square' => 'pied-piper-square',
        'fa-pinterest' => 'pinterest',
        'fa-pinterest-square' => 'pinterest-square',
        'fa-qq' => 'qq',
        'fa-ra' => 'ra',
        'fa-rebel' => 'rebel',
        'fa-reddit' => 'reddit',
        'fa-reddit-square' => 'reddit-square',
        'fa-renren' => 'renren',
        'fa-share-alt' => 'share-alt',
        'fa-share-alt-square' => 'share-alt-square',
        'fa-skype' => 'skype',
        'fa-slack' => 'slack',
        'fa-soundcloud' => 'soundcloud',
        'fa-spotify' => 'spotify',
        'fa-stack-exchange' => 'stack-exchange',
        'fa-stack-overflow' => 'stack-overflow',
        'fa-steam' => 'steam',
        'fa-steam-square' => 'steam-square',
        'fa-stumbleupon' => 'stumbleupon',
        'fa-stumbleupon-circle' => 'stumbleupon-circle',
        'fa-tencent-weibo' => 'tencent-weibo',
        'fa-trello' => 'trello',
        'fa-tumblr' => 'tumblr',
        'fa-tumblr-square' => 'tumblr-square',
        'fa-twitter' => 'twitter',
        'fa-twitter-square' => 'twitter-square',
        'fa-vimeo-square' => 'vimeo-square',
        'fa-vine' => 'vine',
        'fa-vk' => 'vk',
        'fa-wechat' => 'wechat',
        'fa-weibo' => 'weibo',
        'fa-weixin' => 'weixin',
        'fa-windows' => 'windows',
        'fa-wordpress' => 'wordpress',
        'fa-xing' => 'xing',
        'fa-xing-square' => 'xing-square',
        'fa-yahoo' => 'yahoo',
        'fa-youtube' => 'youtube',
        'fa-youtube-play' => 'youtube-play',
        'fa-youtube-square' => 'youtube-square',
        'fa-ambulance' => 'ambulance',
        'fa-h-square' => 'h-square',
        'fa-hospital-o' => 'hospital-o',
        'fa-medkit' => 'medkit',
        'fa-plus-square' => 'plus-square',
        'fa-stethoscope' => 'stethoscope',
        'fa-user-md' => 'user-md',
        'fa-wheelchair' => 'wheelchair',
	);

	asort( $bdweb_fontawesome );
	return apply_filters( 'bdweb_fontawesome', $bdweb_fontawesome );
	
}
endif; /** bdweb_fontawesome() : end conditional statement */