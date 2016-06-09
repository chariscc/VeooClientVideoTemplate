<?php

/*
Plugin Name: Huge IT Video Player
Plugin URI: http://huge-it.com/video-player/
Description: Huge-IT Video player is perfect for using for creating various portfolios within various views. 
Version: 1.1.4
Author: Huge-IT
Author: http://huge-it.com/
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/



add_action('media_buttons_context', 'add_video_player_my_custom_button');


add_action('admin_footer', 'add_video_player_inline_popup_content');


function add_video_player_my_custom_button($context) {
  

  $img = plugins_url( '/images/post.button.png' , __FILE__ );
  

  $container_id = 'huge_it_video_player';
  

  $title = 'Select Huge IT Video Album to insert into post';

  $context .= '<a class="button thickbox" title="Select Video Album to insert into post"    href="#TB_inline?width=400&inlineId='.$container_id.'">
		<span class="wp-media-buttons-icon" style="background: url('.$img.'); background-repeat: no-repeat; background-position: left bottom;"></span>
	Add Video Player
	</a>';
  
  return $context;
}

function add_video_player_inline_popup_content() {
?>
<script type="text/javascript">
				jQuery(document).ready(function() {
				  jQuery('#hugeitvideo_playerinsert').on('click', function() {
				  	var id = jQuery('#huge_it_video_player-select option:selected').val();
			
				  	window.send_to_editor('[huge_it_video_player id="' + id + '"]');
					tb_remove();
				  })
				});
</script>

<div id="huge_it_video_player" style="display:none;">
  <h3>Select Huge IT Video Album to insert into post</h3>
  <?php 
  	  global $wpdb;
	  $query="SELECT * FROM ".$wpdb->prefix."huge_it_video_players order by id ASC";
			   $shortcodevideo_players=$wpdb->get_results($query);
			   ?>

 <?php 	if (count($shortcodevideo_players)) {
							echo "<select id='huge_it_video_player-select'>";
							foreach ($shortcodevideo_players as $shortcodevideo_player) {
								echo "<option value='".$shortcodevideo_player->id."'>".$shortcodevideo_player->name."</option>";
							}
							echo "</select>";
							echo "<button class='button primary' id='hugeitvideo_playerinsert'>Insert Video Album</button>";
						} else {
							echo "No slideshows found", "huge_it_video_player";
						}
						?>
	
</div>
<?php
}
///////////////////////////////////shortcode update/////////////////////////////////////////////


add_action('init', 'hugesl_video_player_do_output_buffer');
function hugesl_video_player_do_output_buffer() {
        ob_start();
}
add_action('init', 'video_player_lang_load');

function video_player_lang_load()
{
    load_plugin_textdomain('sp_video_player', false, basename(dirname(__FILE__)) . '/Languages');

}


function huge_it_video_player_images_list_shotrcode($atts)
{
    extract(shortcode_atts(array(
        'id' => 'no huge_it video_player',
    
    ), $atts));




    return huge_it_video_player_images_list($atts['id']);

}

///////////////////// end filter


add_shortcode('huge_it_video_player', 'huge_it_video_player_images_list_shotrcode');




function   huge_it_video_player_images_list($id)
{

    require_once("Front_end/video_player_front_end_view.php");
    require_once("Front_end/video_player_front_end_func.php");
    if (isset($_GET['product_id'])) {
        if (isset($_GET['view'])) {
            if ($_GET['view'] == 'huge_itvideo_player') {
                return showPublishedvideo_player_1($id);
            } else {
                return front_end_single_product($_GET['product_id']);
            }
        } else {
            return front_end_single_product($_GET['product_id']);
        }
    } else {
        return showPublishedvideo_player_1($id);
    }
}




add_filter('admin_head', 'huge_it_video_player_ShowTinyMCE');
function huge_it_video_player_ShowTinyMCE()
{
    // conditions here
    wp_enqueue_script('common');
    wp_enqueue_script('jquery-color');
    wp_print_scripts('editor');
    if (function_exists('add_thickbox')) add_thickbox();
    wp_print_scripts('media-upload');
    if (version_compare(get_bloginfo('version'), 3.3) < 0) {
        if (function_exists('wp_tiny_mce')) wp_tiny_mce();
    }
    wp_admin_css();
    wp_enqueue_script('utils');
    do_action("admin_print_styles-post-php");
    do_action('admin_print_styles');
}

function all_video_frontend_scripts_and_styles() {
	wp_enqueue_media();
	wp_enqueue_style("iconfonts",plugins_url("icon-fonts/css/font-awesome.css", __FILE__), FALSE);
	wp_enqueue_script("froogaloop",plugins_url("froogaloop.min.js", __FILE__), FALSE);
}
add_action('wp_enqueue_scripts', 'all_video_frontend_scripts_and_styles');


add_action('admin_menu', 'huge_it_video_player_options_panel');
function huge_it_video_player_options_panel()
{
    $page_cat = add_menu_page('Theme page title', 'Video Player', 'manage_options', 'video_players_huge_it_video_player', 'video_players_huge_it_video_player', plugins_url('images/huge_it_video_player_logo_for_menu.png', __FILE__));
    $page_option = add_submenu_page('video_players_huge_it_video_player', 'General Options', 'General Options', 'manage_options', 'Options_video_player_styles', 'Options_video_player_styles');
	add_submenu_page('video_players_huge_it_video_player', 'Featured Plugins', 'Featured Plugins', 'manage_options', 'huge_it__video_player_featured_plugins', 'huge_it__video_player_featured_plugins');
		
	add_action('admin_print_styles-' . $page_cat, 'huge_it_video_player_admin_script');
    add_action('admin_print_styles-' . $page_option, 'huge_it_video_player_option_admin_script');
}
function huge_it__video_player_featured_plugins()
{
	include_once("admin/huge_it_featured_plugins.php");
}


function video_player_sliders_huge_it_slider()
{

    require_once("admin/video_player_slider_func.php");
    require_once("admin/video_player_slider_view.php");
    if (!function_exists('print_html_nav'))
        require_once("video_player_function/html_video_player_func.php");


    if (isset($_GET["task"]))
        $task = $_GET["task"]; 
    else
        $task = '';
    if (isset($_GET["id"]))
        $id = $_GET["id"];
    else
        $id = 0;
    global $wpdb;
    switch ($task) {

        case 'add_cat':
            add_slider();
            break;
		case 'add_shortcode_post':
            add_shortcode_post();
            break;
		case 'popup_posts':
            if ($id)
                popup_posts($id);
            break;
		case 'video_player_video':
            if ($id)
                video_player_video($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                video_player_video($id);
            }
            break;
		case 'video_player_upload':
            if ($id)
                video_player_upload($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                video_player_upload($id);
            }
            break;
		case 'video_player_vimeo':
            if ($id)
                video_player_vimeo($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                video_player_vimeo($id);
            }
            break;
        case 'edit_cat':
            if ($id)
                editslider($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                editslider($id);
            }
            break;

        case 'save':
            if ($id)
                apply_cat($id);
        case 'apply':
            if ($id) {
                apply_cat($id);
                editslider($id);
            } 
            break;
        case 'remove_cat':
            removeslider($id);
            showslider();
            break;
        default:
            showslider();
            break;
    }
}

function video_player_Options_slider_styles()
{
    require_once("admin/video_player_slider_options_func.php");
    require_once("admin/video_player_slider_options_view.php");
    if (isset($_GET['task']))
        if ($_GET['task'] == 'save')
            save_styles_options();
    showStyles();
}

//////////////////////////Huge it Slider ///////////////////////////////////////////

function huge_it_video_player_admin_script()
{
	wp_enqueue_media();
	wp_enqueue_style("jquery_ui", "http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css", FALSE);
	wp_enqueue_style("jquery_ui", plugins_url("style/jquery-ui.css", __FILE__), FALSE);
	wp_enqueue_style("admin_css", plugins_url("style/admin.style.css", __FILE__), FALSE);
	wp_enqueue_script("admin_js", plugins_url("js/admin.js", __FILE__), FALSE);
	wp_localize_script('admin_js', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
}


function huge_it_video_player_option_admin_script()
{
	wp_enqueue_script("jquery_old", "http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js", FALSE);
	wp_enqueue_script("simple_slider_js",  plugins_url("js/simple-slider.js", __FILE__), FALSE);
	wp_enqueue_style("simple_slider_css", plugins_url("style/simple-slider.css", __FILE__), FALSE);
	wp_enqueue_style("admin_css", plugins_url("style/admin.style.css", __FILE__), FALSE);
	wp_enqueue_script("admin_js", plugins_url("js/admin.js", __FILE__), FALSE);
	wp_enqueue_script('param_block2', plugins_url("elements/jscolor/jscolor.js", __FILE__));
	wp_localize_script('admin_js', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
}


function video_players_huge_it_video_player()
{

    require_once("admin/video_player_func.php");
    require_once("admin/video_player_view.php");
    if (!function_exists('print_html_nav'))
        require_once("video_player_function/html_video_player_func.php");


    if (isset($_GET["task"]))
        $task = $_GET["task"]; 
    else
        $task = '';
    if (isset($_GET["id"]))
        $id = $_GET["id"];
    else
        $id = 0;
    global $wpdb;
    switch ($task) {

        case 'add_cat':
            add_video_player();
            break;
		case 'video_player_video':
            if ($id)
                video_player_video($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                video_player_video($id);
            }
            break;
		case 'video_player_upload':
            if ($id)
                video_player_upload($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                video_player_upload($id);
            }
            break;
		case 'video_player_vimeo':
            if ($id)
                video_player_vimeo($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                video_player_vimeo($id);
            }
            break;
        case 'edit_cat':
            if ($id)
                editvideo_player($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "huge_it_video_players");
                editvideo_player($id);
            }
            break;

        case 'save':
            if ($id)
                apply_cat($id);
        case 'apply':
            if ($id) {
                apply_cat($id);
                editvideo_player($id);
            } 
            break;
        case 'remove_cat':
            removevideo_player($id);
            showvideo_player();
            break;
        default:
            showvideo_player();
            break;
    }


}

add_action("wp_ajax_video_player_ajax","wp_ajax_video_player_callback");

function wp_ajax_video_player_callback(){
	function get_youtube_thumb_id_from_url($url){						
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			if(!empty($match[1])){
				return $match[1];
			}else{
				return false;
			}
			
		}
	}
	
	if(isset($_POST['task'])){
		if($_POST['task']=="get_video_meta_from_url"){
			$video_url=$_POST['url'];
			$youtube_exp = explode("youtu", $video_url);
			$vimeo_exp = explode("vimeo", $video_url);
			$video_title="";
			$video_image="";
			if(isset($youtube_exp[1])){
				$video_id=get_youtube_thumb_id_from_url($video_url);
				$video_title="";
				$video_image='http://img.youtube.com/vi/'.$video_id.'/mqdefault.jpg';
				$type="youtube";
			}else{
				if(isset($vimeo_exp[1])){
					$vidid = explode( "/", $video_url);
					$vidid=end($vidid);
					$hash=file_get_contents("http://vimeo.com/api/v2/video/".$vidid.".php");
					$hash = unserialize($hash);
					$video_image=$hash[0]['thumbnail_large'];
					$video_title=$hash[0]['title'];
					$type="vimeo";
				}
			}
			
			if($video_title=="" && $video_image==""){
				echo json_encode(array("fail"=>1));
				die();
			}else{
				echo json_encode(array("success"=>1,"image_url"=>$video_image,"title"=>$video_title,"type"=>$type));
				die();
			}
		}
		if($_POST['task']=="get_video_thumb_from_id"){
			$video_id=$_POST['video_id'];
			$video_image="";
			if($_POST['type']=="youtube"){
				$video_image='http://img.youtube.com/vi/'.$video_id.'/mqdefault.jpg';
			}
			if($_POST['type']=="vimeo"){
				$hash=file_get_contents("http://vimeo.com/api/v2/video/".$video_id.".php");
				$hash = unserialize($hash);
				$video_image=$hash[0]['thumbnail_large'];
			}
			
			if(isset($video_image)){
				echo json_encode(array("success"=>1,"image_url"=>$video_image));
				die();
			}
		}
		
		if($_POST['task']=="change_video_link"){
			if(isset($_POST['type']) && !empty($_POST['type'])){
				$type=$_POST['type'];
			}
			if(isset($_POST['link']) && !empty($_POST['link'])){
				$link=$_POST['link'];
			}
			
			if($type=="youtube"){
				
				$video_id=get_youtube_thumb_id_from_url($link);
				if($video_id){
					$video_image='http://img.youtube.com/vi/'.$video_id.'/mqdefault.jpg';
				}
				
				
			}elseif($type=="vimeo"){
				
				$link_explode = explode( "/", $link);
				$video_id=end($link_explode);
				$hash=file_get_contents("http://vimeo.com/api/v2/video/".$video_id.".php");
				$hash = unserialize($hash);
				$video_image=$hash[0]['thumbnail_large'];
				
			}
			
			if(isset($video_image) && !empty($video_image)){
				echo json_encode(array("success"=>1,"video_image"=>$video_image,"video_id"=>$video_id));
				die();
			}else{
				echo json_encode(array("error"=>"Wrong Video Url"));
				die();
			}
		}
	}
}

function Options_video_player_styles()
{
    require_once("admin/video_player_Options_func.php");
    require_once("admin/video_player_Options_view.php");
    if (isset($_GET['task']))
        if ($_GET['task'] == 'save')
            save_styles_options();
    showStyles();
}
/**
 * Huge IT Widget
 */
class Huge_it_video_player_Widget extends WP_Widget {


	public function __construct() {
		parent::__construct(
	 		'Huge_it_video_player_Widget', 
			'Huge IT Video Player', 
			array( 'description' => __( 'Huge IT Video Player', 'huge_it_video_player' ), ) 
		);
	}

	
	public function widget( $args, $instance ) {
		extract($args);

		if (isset($instance['video_player_id'])) {
			$video_player_id = $instance['video_player_id'];

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;

			echo do_shortcode("[huge_it_video_player id={$video_player_id}]");
			echo $after_widget;
		}
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['video_player_id'] = strip_tags( $new_instance['video_player_id'] );
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}


	public function form( $instance ) {
		$selected_video_player = 0;
		$title = "";
		$video_players = false;

		if (isset($instance['video_player_id'])) {
			$selected_video_player = $instance['video_player_id'];
		}

		if (isset($instance['title'])) {
			$title = $instance['title'];
		}

        

        
		?>
		<p>
			
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<label for="<?php echo $this->get_field_id('video_player_id'); ?>"><?php _e('Select Video Album:', 'huge_it_video_player'); ?></label> 
				<select id="<?php echo $this->get_field_id('video_player_id'); ?>" name="<?php echo $this->get_field_name('video_player_id'); ?>">
				
				<?php
				 global $wpdb;
				$query="SELECT * FROM ".$wpdb->prefix."huge_it_video_players ";
				$rowwidget=$wpdb->get_results($query);
				foreach($rowwidget as $rowwidgetecho){
				?>
					<option <?php if($rowwidgetecho->id == $instance['video_player_id']){ echo 'selected'; } ?> value="<?php echo $rowwidgetecho->id; ?>"><?php echo $rowwidgetecho->name; ?></option>
					<?php } ?>
				</select>
		</p>
		<?php 
	}
}

add_action('widgets_init', 'register_Huge_it_video_player_Widget');  

function register_Huge_it_video_player_Widget() {  
    register_widget('Huge_it_video_player_Widget'); 
}



//////////////////////////////////////////////////////                                             ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////               Activate video_player                     ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////                                             ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////                                             ///////////////////////////////////////////////////////


function huge_it_video_player_activate()
{
    global $wpdb;

/// creat database tables



    $sql_huge_it_video_params = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "huge_it_video_params`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `value` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ";


    $sql_huge_it_videos = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "huge_it_videos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `video_player_id` varchar(200) DEFAULT NULL,
  `video_url_1` text,
  `image_url` text,
  `video_url_2` varchar(128) DEFAULT NULL,
  `sl_type` text NOT NULL,
  `video_width` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5";

    $sql_huge_it_video_players = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "huge_it_video_players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `album_single` text NOT NULL,
  `layout` text NOT NULL,
  `width` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `align` varchar(128) DEFAULT 'left',
  `margin_top` int(11) DEFAULT '5',
  `margin_bottom` int(11) DEFAULT '5',
  `autoplay` int(11) DEFAULT '0',
  `preload` int(11) DEFAULT '0',
  `published` text,
  `ht_videos` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ";



    $table_name = $wpdb->prefix . "huge_it_video_params";
    $sql_1 = <<<query1
INSERT INTO `$table_name` (`name`, `title`,`description`, `value`) VALUES

('video_pl_position', 'Position', 'Position', 'center'),
('video_pl_yt_autohide', 'Autohide Youtube Controls', 'Autohide Youtube Controls', '1'),
('video_pl_yt_fullscreen', 'Allow Full Screen', 'Allow Full Screen', '1'),
('video_pl_yt_showinfo', 'Show Video Information', 'Show Video Information', '1'),
('video_pl_vimeo_portrait', 'Show User Portrait', 'Show User Portrait', '1'),
('video_pl_playlist_head_size', 'Playlist Title Size', 'Playlist Title Size', '15'),
('video_pl_curtime_color', 'Current Time Text Color', 'Current Time Text Color', 'FFFFFF'),
('video_pl_durtime_color', 'Duration Time Text Color', 'Duration Time Text Color', 'DDDDDD'),
('video_pl_playlist_scroll_track', 'Playlist Scrollbar Track Color', 'Playlist Scrollbar Track Color', '444444'),
('video_pl_playlist_scroll_thumb', 'Playlist Scrollbar Thumb Color', 'Playlist Scrollbar Thumb Color', 'CCCCCC'),
('video_pl_playlist_scroll_thumb_hover', 'Playlist Scrollbar Thumb Hover Color', 'Playlist Scrollbar Thumb Hover Color', 'AAAAAA'),
('video_pl_playlist_head_color', 'Playlist Heading Color', 'Playlist Heading Color', 'FFFFFF'),
('video_pl_playlist_active_color', 'Playlist Active Color', 'Playlist Active Color', '525252'),
('video_pl_playlist_hover_color', 'Playlist Hover Color', 'Playlist Hover Color', '525252'),
('video_pl_playlist_hover_text_color', 'Playlist Hover Text Color', 'Playlist Hover Text Color', 'FFFFFF'),
('video_pl_playlist_active_text_color', 'Playlist Active Text Color', 'Playlist Active Text Color', 'FFFFFF'),
('video_pl_playlist_text_color', 'Playlist Text Color', 'Playlist Text Color', 'FFFFFF'),
('video_pl_border_size', 'Border Size', 'Border Size', '0'),
('video_pl_margin_bottom', 'margin bottom', 'margin bottom', '5'),
('video_pl_margin_top', 'Margin top', 'Margin top', '5'),
('video_pl_margin_right', 'Margin right', 'Margin right', '5'),
('video_pl_margin_left', 'Margin left', 'Margin left', '5'),
('video_pl_timeline_color', 'Time line color', 'Time line color', 'F12B24'),
('video_pl_timeline_buffering_color', 'Buffer color', 'Buffer color', 'FFFFFF'),
('video_pl_timeline_buffering_opacity', 'Buffer opacity', 'Buffer opacity', '40'),
('video_pl_timeline_background', 'Timeline background color', 'Timeline background color', 'FFFFFF'),
('video_pl_timeline_background_opacity', 'Timeline background opacity', 'Timeline background opacity', '20'),
('video_pl_buttons_color', 'Buttons color', 'Buttons color', 'FFFFFF'),
('video_pl_buttons_hover_color', ' Buttons hover color', ' Buttons hover color', 'FFFFFF'),
('video_pl_controls_panel_color', 'Controls color', 'Controls color', '333'),
('video_pl_controls_panel_opacity', 'Controls', 'Controls', '0'),
('video_pl_volume_background_color', 'Volume time color', 'Volume time color', 'FFFFFF'),
('video_pl_background_color', 'Background color', 'Background color', 'EEEEEE'),
('video_pl_playlist_color', 'Background color', 'Background color', '000000'),
('video_pl_timeline_slider_color', 'Slider color', 'Slider color', 'f12b24'),
('video_pl_title_font_size', 'Title font size', 'Title font size', '13'),
('video_pl_title_font_color', 'Title Font color', 'Title Font color', 'FFFFFF'),
('video_pl_title_background_color', 'Title background color', 'Title background color', '000000'),
('video_pl_title_show', 'show title', 'show title', 'on'),
('video_pl_border_color', 'Border color', 'Border color', '009BE3'),
('video_pl_yt_color', 'Youtube Color', 'Youtube Color', 'red'),
('video_pl_yt_annotation', 'Youtube Annotations', 'Youtube Annotations', '1'),
('video_pl_yt_theme', 'Youtube Theme', 'Youtube Theme', 'dark'),
('video_pl_vimeo_color', 'Vimeo Color', 'Vimeo Color', '00adef');

query1;

    $table_name = $wpdb->prefix . "huge_it_videos";
    $sql_2 = "
INSERT INTO 

`" . $table_name . "` (`name`, `video_player_id`, `video_url_1`, `image_url`, `video_url_2`, `sl_type`, `ordering`, `published`) VALUES
('Big Buck Bunny Trailer', '1', 'http://butlerccwebdev.net/support/html5-video/media/bigbuckbunnytrailer-480p.mp4', 'https://peach.blender.org/wp-content/uploads/bbb-splash.png', '', 'video', '0', '1')";


 $sql_2_1 = "
INSERT INTO 

`" . $table_name . "` (`name`, `video_player_id`, `video_url_1`, `image_url`, `video_url_2`, `sl_type`, `ordering`, `published`) VALUES
('Big Buck Bunny', '1', 'https://ia700408.us.archive.org/26/items/BigBuckBunny_328/BigBuckBunny_512kb.mp4', 'http://upload.wikimedia.org/wikipedia/commons/c/c5/Big_buck_bunny_poster_big.jpg', '', 'video', '0', '1')";

 $sql_2_2 = "
INSERT INTO 

`" . $table_name . "` (`name`, `video_player_id`, `video_url_1`, `image_url`, `video_url_2`, `sl_type`, `ordering`, `published`) VALUES
('Big Buck Bunny(Youtube)', '1', 'https://www.youtube.com/watch?v=YE7VzlLtp-4', 'http://img.youtube.com/vi/YE7VzlLtp-4/mqdefault.jpg', '', 'youtube', '0', '1')";


 $sql_2_3 = "
INSERT INTO 

`" . $table_name . "` (`name`, `video_player_id`, `video_url_1`, `image_url`, `video_url_2`, `sl_type`, `ordering`, `published`) VALUES
('Big Buck Bunny(Vimeo)', '1', 'https://vimeo.com/1084537', 'http://i.vimeocdn.com/video/20963649_640.jpg', '', 'vimeo', '0', '1')";

    $table_name = $wpdb->prefix . "huge_it_video_players";


    $sql_3 = "

INSERT INTO `$table_name` (`id`, `name`, `layout`, `width`, `album_single`, `ordering`, `published`, `ht_videos`) VALUES
(1, 'My First Video Album', 'right', '640', 'album', '1', '1', '1')";


    $wpdb->query($sql_huge_it_video_params);
    $wpdb->query($sql_huge_it_videos);
    $wpdb->query($sql_huge_it_video_players);


    if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "huge_it_video_params")) {
        $wpdb->query($sql_1);
    }
    if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "huge_it_videos")) {
      $wpdb->query($sql_2);
      $wpdb->query($sql_2_1);
      $wpdb->query($sql_2_2);
      $wpdb->query($sql_2_3);
    }
    if (!$wpdb->get_var("select count(*) from " . $wpdb->prefix . "huge_it_video_players")) {
      $wpdb->query($sql_3);
    }
	
	if(!$wpdb->get_row("select * from ".$wpdb->prefix."huge_it_video_params WHERE name='video_pl_timeline_background_opacity'")){
		$wpdb->query("INSERT INTO `".$wpdb->prefix."huge_it_video_params` (`name`, `title`,`description`, `value`) VALUES ('video_pl_timeline_background_opacity', 'Timeline background opacity', 'Timeline background opacity', '20')");
	}
	
	if(!$wpdb->get_row("select * from ".$wpdb->prefix."huge_it_video_params WHERE name='video_pl_timeline_buffering_opacity'")){
		$wpdb->query("INSERT INTO `".$wpdb->prefix."huge_it_video_params` (`name`, `title`,`description`, `value`) VALUES ('video_pl_timeline_buffering_opacity', 'Buffer color', 'Buffer color', '40')");
	}
	
	if(!$wpdb->get_row("select * from ".$wpdb->prefix."huge_it_video_params WHERE name='video_pl_controls_panel_opacity'")){
		$wpdb->query("INSERT INTO `".$wpdb->prefix."huge_it_video_params` (`name`, `title`,`description`, `value`) VALUES ('video_pl_controls_panel_opacity', 'Controls', 'Controls', '0')");
	}
}

register_activation_hook(__FILE__, 'huge_it_video_player_activate');