<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name: bitcraftX Like Dislikes
 * Description: The Agency WordPress plugin boilerplate
 * Author: Agency
 * Version: 1.0
 * Author URI: httsp://bitcraftx.com/
 */

/*
 * GETTING STARTED WITH THE STARTER
 * ---------------------------------------------------------
 *
 * Every time you use the bitcraftX Like Dislikes you need to do
 * run a few find/replaces on the files.
 *
 * On this file you need to process the following strings:
 *
 * 1. bxlikes_dislikes
 * 2. bitcraftX Like Dislikes
 * 3. bxlikes_dislikes
 * 4. nb-likes-dislikes
 *
 * Then rename this file, the template tags file and the title in the plugin options.
 *
 * FOLDER STRUCTURE
 * Should you need to add any vendor libraries (think API wrappers),
 * add them to a folder called 'libs'. Initiate the classes in __construct.
 *
 * CONSISTENT DOCUMENTATION
 * All functions you write in this class should be documented in phpDoc,
 * including what the function does, what params it takes and what it outputs.
 * You can see the full phpDoc syntax here: goo.gl/09S2wc
 *
 * WRAPPING UP
 * Keep code clean. Once you've done these steps, remove these instructions
 *
 */



if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/*==========  Activation Hook  ==========*/
register_activation_hook( __FILE__, array( 'bxLikes_Dislikes', 'install' ) );


/**
 * Main bxLikes_Dislikes Class
 *
 * @class bxLikes_Dislikes
 * @version 0.1
 */
class bxLikes_Dislikes {

	public $errors = false;
	public $notices = false;
	public $slug = 'nb-likes-dislikes';

	function __construct() {

		$this->path = plugin_dir_path(__FILE__);
		$this->folder = basename($this->path);
		$this->dir = plugin_dir_url(__FILE__);
		$this->version = '1.0';

		$this->errors = false;
		$this->notice = false;

		// Actions
		add_action('init', array($this, 'setup'), 10, 0);
		add_action('wp_enqueue_scripts', array($this, 'scripts'));
		//add_action('wp_loaded', array($this , 'forms'));
		//add_action('parse_request', array($this , 'custom_url_paths'));
		add_action('admin_menu', array($this, 'register_menu_page'));
		add_action('admin_menu', array($this, 'register_submenu_page'), 11);
		//add_action('admin_menu', array($this, 'rename_first_submenu_entry'), 11);
		// add_action('admin_menu', array($this, 'register_options_page'));

		// Shortcodes
		// add_shortcode('students', array($this, 'shortcode'));

		// Notices (add these when you need to show the notice)
		// add_action( 'admin_notices', array($this, 'admin_success'));
		// add_action( 'admin_notices', array($this, 'admin_error'));

	}

   /**
    * Install
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public static function install() {

		/**
		*
		* Add methods here that should be run when the plugin is activated.
		*
		**/

	}

   /**
    * Setup
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public function setup() {

		// register types
		$this->register_types();
		register_setting( 
		    'bxlikes_dislikes_options', 
		    'bxlikes_dislikes_post_type', 
		    'admin_options_sanitize' 
		);
		register_setting( 
		    'bxlikes_dislikes_options', 
		    'bxlikes_dislikes_test', 
		    'admin_options_sanitize' 
		);
		register_setting( 
		    'bxlikes_dislikes_options', 
		    'bxlikes_dislikes_test2', 
		    'admin_options_sanitize' 
		);


	}

	/**
	 * Rgisters Main Menu
	 * @return false
	 */
	function register_menu_page(){

		$page_title = 'bitcraftX Likes Dislikes';
		$menu_title = 'NB Likes Dislikes';
		$capability = 'manage_options';
		$menu_slug  = 'bxlikes_dislikes_options';
		$function   = array($this, 'include_options');
		$icon_url   = 'dashicons-thumbs-up';
		$position   = 4;

		add_menu_page( $page_title,
		             $menu_title, 
		             $capability, 
		             $menu_slug, 
		             $function, 
		             $icon_url, 
		             $position );


		//add_options_page('bitcraftX Like Dislikes', 'bitcraftX Like Dislikes', 'manage_options', 'bxlikes_dislikes_options', array($this, 'include_options'));
		//add_action('admin_init', array($this, 'plugin_options'));
	}

	/**
	 * Register SubMenu Page
	 * @return false
	 */
	function register_submenu_page(){
		$menu_slug  = 'bxlikes_dislikes_options';
   		add_submenu_page( $menu_slug, 'Custom Post Type Admin', 'Submissions', 'manage_options','edit.php?post_type=likes_dislikes');
   		add_filter('parent_file', array($this, 'fix_admin_parent_file'));

		
	}

	/**
	 * Enable Correct highlighting of menu
	 * @param  string $parent_file Parent Menu Entry
	 * @return string              New Parent Menu Entry
	 */
	function fix_admin_parent_file($parent_file){
	    global $submenu_file, $current_screen;
	    if($current_screen->post_type == 'likes_dislikes') {
	        $submenu_file = 'edit.php?post_type=likes_dislikes';
	        $parent_file = 'bxlikes_dislikes_options';
	    }
	    return $parent_file;
	}

	

   /**
    * Register Types
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public function register_types() {


		/*==========  POST TYPE NAME  ==========*/

		$args = array(
			'labels'             => self::build_type_labels('Page Popularity', 'Page Popularities'),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'            => false,
			//'show_in_menu'       => 'edit.php?post_type=likes_dislikes',
			// 'show_in_menu' => 'bxlikes_dislikes_options',
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'likes-dislikes' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_icon'			 => 'dashicons dashicons-thumbs-up',
			'menu_position'      => 40,
			'supports'           => array( 'title', 'editor', 'page-attributes' )
		);

		 register_post_type( 'likes_dislikes', $args );


	}

   /**
    * Build Type Labels
    * ---------------------------------------------
    * @param  $name   | String | Singular Name
    * @param  $plural | String | Plural Name
    * @return Array
    * ---------------------------------------------
    **/

	private static function build_type_labels($name, $plural) {

		return array(
			'name'               => $plural,
			'singular_name'      => $name,
			'add_new'            => "Add New",
			'add_new_item'       => "Add New $name",
			'edit_item'          => "Edit $name",
			'new_item'           => "New $name",
			'all_items'          => "All $plural",
			'view_item'          => "View $name",
			'search_items'       => "Search $plural",
			'not_found'          => "No " . strtolower($plural) . " found",
			'not_found_in_trash' => "No " . strtolower($plural) . " found in trash",
			'parent_item_colon'  => '',
			'menu_name'          => $plural
		);

	}

   /**
    * Scripts
    * ---------------------------------------------
    * @return null
    * ---------------------------------------------
    **/

	public function scripts() {

		// wp_enqueue_script('jquery.validate', '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js', array('jquery'), $this->version, true);

	}


   /**
    * Forms
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public function forms() {

		if (!isset($_POST['bxlikes_dislikes_action'])) return;

		switch ($_POST['bxlikes_dislikes_action']) {

			case 'action':
				// $this->action($_POST);
				break;

			default:
				break;
		}

	}


   /**
    * Custom URL Paths
    * ---------------------------------------------
    * @param  $wp | Object
    * @return false
    * ---------------------------------------------
    **/

	public function custom_url_paths($wp) {

		$pagename = (isset($wp->query_vars['pagename'])) ? $wp->query_vars['pagename'] : $wp->request;

		switch ($pagename) {

			case 'nb-likes-dislikes/api':
				// $this->api($_GET);
				break;

			default:
				break;

		}

	}

   /**
    * Register Options Page
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public function register_options_page() {

		// main page
		// add_options_page('bitcraftX Like Dislikes', 'bitcraftX Like Dislikes', 'manage_options', 'bxlikes_dislikes_options', array($this, 'include_options'));
		// add_action('admin_init', array($this, 'plugin_options'));

	}


   /**
    * Include Options Page
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public function include_options() { require('templates/options.php'); }



   /**
    * Plugin Options
    * ---------------------------------------------
    * @return false
    * ---------------------------------------------
    **/

	public function plugin_options() {

		$options = array(
			'bxlikes_dislikes_test',
			'bxlikes_dislikes_test2'
		);

		foreach ($options as $option) {
			register_setting('bxlikes_dislikes_options', $option);
		}

	}

	/**
	 * Shortcode Include
	 */
	public function shortcode() {

		$errors = $this->errors;

		ob_start();
		// include $this->template('template.php');
		return ob_get_clean();

	}

	/**
	 * Outputs a WordPress error notice
	 *
	 * Push your error to $this->errors then show with:
	 * add_action( 'admin_notices', array($this, 'admin_error'));
	 */
	public function admin_error() {

		if(!$this->errors) return;

		foreach($this->errors as $error) :

	?>

		<div class="error settings-error notice is-dismissible">

			<p><strong><?php print $error ?></strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>

		</div>

	<?php

		endforeach;

	}

	/**
	 * Outputs a WordPress notice
	 *
	 * Push your error to $this->notices then show with:
	 * add_action( 'admin_notices', array($this, 'admin_success'));
	 */
	public function admin_success() {

		if(!$this->notices) return;

		foreach($this->notices as $notice) :

	?>

		<div class="updated settings-error notice is-dismissible">

			<p><strong><?php print $notice ?></strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>

		</div>

	<?php

		endforeach;

	}




   /**
    * Template
    * ---------------------------------------------
    * @param $filename | String | name of the template
    * @return false
    * ---------------------------------------------
    **/
	public function template($filename) {

		// check theme
		$theme = get_template_directory() . '/'.$this->slug.'/' . $filename;

		if (file_exists($theme)) {
			$path = $theme;
		} else {
			$path = $this->path . 'templates/' . $filename;
		}
		return $path;

	}


   /**
    * Template Include
    * ---------------------------------------------
    * @param $template | String   | name of the template
    * @param $data     | Anything | Data to pass to a template
    * @param $name     | String   | Data value name
    * @return false
    * ---------------------------------------------
    **/

	public function template_include($template,$data = null,$name = null){

		if(isset($name)){ ${$name} = $data; }
		$path = $this->template($template);
		include($path);
	}

   /**
    * Redirect
    * ---------------------------------------------
    * @param $path | String/Int | url of post id
    * @return false
    * ---------------------------------------------
    **/

	public function redirect($path) {

		if(is_numeric($path)){ $path = get_permalink($path); }
		wp_safe_redirect( $path );
	  	exit();

	}

   

}


/**
 * @var class bxlikes_dislikes $bxlikes_dislikes
 */

require_once('nb-functions.php');
$bxlikes_dislikes = new bxlikes_dislikes();




