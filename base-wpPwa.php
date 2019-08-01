<?php
/**
 * @package     base-wpPwa
 */
/*
		@wordpress-plugin
		Plugin Name:       PWA_marioPlug
		Plugin URI:        mariolafuente.com
		Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
		Version:           1.0.0
		Author:            mariolafuente.com
		Author URI:        mariolafuente.com
		License:           GPL-2.0+
		License URI:       http://www.gnu.org/licenses/gpl-2.0.txt

		Copyright YEAR PLUGIN_AUTHOR_NAME (email : admin@mariolafuente.com)
		(Plugin Name) is free software: you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation, either version 2 of the License, or
		any later version.

		(Plugin Name) is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
		GNU General Public License for more details.

*/

//Pluging name must be equal to name of the folder base-wpPwa
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {die;}



class pwaPluging
{

	public $pluginName;
	public $pluginNameandFolder;

	function __construct(){
		//asigno a pluginName la base del directorio pero le quito el folder base-wpPwa/
		$this->pluginNameandFolder = plugin_basename( __FILE__ );
		$this->pluginName = 'PWA_marioPlug';

    		// load the user class
	//	include  plugin_dir_path( __FILE__ ).'inc/class_index.php';


	}



	function register(){

//add_action( 'admin_init', array( $class_index, 'addSection' ) );

		add_action('admin_enqueue_scripts', array($this, 'AdminEnqueue'));
		//add_action('wp_enqueue_scripts' lo pone al frontend

		add_action('admin_menu', array($this, 'add_admin_pages'));

    //pone un adcional en install plugin Activate | Delete settings
    add_filter("plugin_action_links_$this->pluginNameandFolder", array($this, 'setting_link'));

		//Escribe manifest en el index header
		if ( ! function_exists( 'class_insert_manifest' ) ) {
			require_once plugin_dir_path( __FILE__ ). 'inc/class_insert_manifest.php';
    }


    if(get_option( 'showBanner') == 'on'){
      add_action('wp_footer', 'footerDiv');
      add_action( 'wp_enqueue_scripts', 'enqueue_script' );
    }

	}



 function copyCoworker(){
  $src = plugin_dir_path( __FILE__ ). 'assets/js/service-worker.js';  // source folder or file
  $dest = get_home_path();   // destination folder or file
  shell_exec("cp -r $src $dest");

  }



	function add_admin_pages() {

		add_menu_page(
			'PWA',  									//Menu Page Title
			'PWA', 										//menu_title
			'manage_options', 				//'manage_options give wp capability
			$this->pluginName,  				//or 'options-general.php' $menu_slug must by unic
			 array($this, 'admin_index'),	//$function in this class call action
			'dashicons-store', 						//icon
			6      											//$position
			);

	}

function admin_index(){
    //requiere template principal pg Index
		require_once plugin_dir_path( __FILE__ ).'inc/class_index.php';

  }



  	function AdminEnqueue(){
		// enqueue all scripts
		wp_enqueue_style( 'css-pwa', plugins_url('/assets/style.css', __FILE__));

	}


	function setting_link($links){
		// Activate | Delete page=pwa_marioPlug page=PWA_marioPlug
		$setting_link = '<a href="admin.php?page='.$this->pluginName.'">Settings</a>';
			array_push($links, $setting_link );
		return $links;
	}

	function activate(){
    $this->copyCoworker();
		//flush rewrite rules always in activate or deactivate
	 flush_rewrite_rules( );
	}

	function deactivate(){
	//flush  delete CPT
	flush_rewrite_rules( );
	}

	function uninstall(){
		//delete CPT and data from db

	}


}


//If class exist call class from variable
if(class_exists( 'pwaPluging'))
{
	$pwaPluging = new pwaPluging();
	$pwaPluging->register();
}

function enqueue_script() {
	wp_enqueue_style( 'front-pwa', plugins_url('/assets/pwaFront.css', __FILE__));
	wp_enqueue_script( 'appPromp',  plugins_url('/assets/js/appPromp.js', __FILE__), true );
}

function footerDiv(){

?>
<div id='insallApp' >
<div class="level1">
	<img   src="<?php echo get_option('icon'); ?>" >
	<span class="installTex"><?php echo get_option( 'textBanner'); ?></span>
</div>

<div class="level2">
<button id='btnYes'>Install</button>
</div>
<button id='btnNo'>X</button>
</div>
<?php
}



//Write JSON Manifest
function writeManifestJson(  ) {

 $url =  get_site_url();
 echo $url;
  $namePWA         = get_option( 'namePWA');
  $shortName       = get_option( 'shortName');
  $startPag        = get_option( 'startPag');
  $description     = get_option( 'description');
	$icon            = get_option( 'icon');
  $showBanner      = get_option( 'showBanner');
  $textBanner      = get_option( 'textBanner');
  $displayMode     = get_option( 'displayMode');
  $orientation     = get_option( 'orientation');
  $themeColor      = get_option( 'themeColor');
  $backgroundColor = get_option( 'backgroundColor');

  if(!$namePWA)			{$namePWA 		= "name PWA";}
	if(!$shortName)		{$shortName 	= "short Name";}
	if(!$startPag)		{$startPag 		=  $url."/" ;}
	if(!$description)	{$description = "Some Description";}
	if(!$icon)				{$icon 				= plugins_url('/assets/images/icons-512.png', __FILE__);}
  if(!$showBanner)	{$showBanner 	= 'on';}
  if(!$textBanner)	{$textBanner 	= 'Click Here to get this app';}
	if(!$displayMode)	{$displayMode = "fullscreen";}
	if(!$orientation)	{$orientation = "portrait";}
	if(!$themeColor)	{$themeColor 	= "#161e65";}
  if(!$backgroundColor){$backgroundColor = "#161e65";}
  //form esta en el class_index


//		"gcm_sender_id": "103953800507",
	$jsonFile = '
	{
		"short_name": "'.$shortName .'",
		"name": "'.$namePWA .'",
		"icons": [
			{
				"src": "'.$icon .'",
				"type": "image/png",
				"sizes": "192x192"
			},
			{
				"src": "'.$icon .'",
				"type": "image/png",
				"sizes": "512x512"
			}
		],
		"start_url": "'.$startPag .'",
		"background_color": "'.$backgroundColor .'",
		"display": "'.$displayMode .'",
		"theme_color": "'.$themeColor .'"
	}
';



  $file   = plugin_dir_path( __FILE__ ) . '/assets/js/manifest.json';
  $file2  = plugin_dir_path( __FILE__ ) . '/assets/js/manifest.webmanifest';

  if(file_exists($file)){ unlink($file); }
  if(file_exists($file2)){ unlink($file2); }


  $open = fopen( $file, "a" );
  $open2 = fopen( $file2, "a" );

  $write = fputs( $open, $jsonFile );
  $write = fputs( $open2, $jsonFile );

  fclose( $open );
  fclose( $open2 );

  echo'Json';


}

//Activation
register_activation_hook(__File__, array($pwaPluging, 'activate'));


//deactivation
register_deactivation_hook(__File__, array($pwaPluging, 'deactivate'));


//Unistall

