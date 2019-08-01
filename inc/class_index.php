<?php

/**
 * @package    base-wpPwa
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {die;}


class class_index {


	function register(){

	}

}
////////////////////////////////////////
/// Me falta tratar de que funcque offline


//If class exist call class from variable
if(class_exists( 'class_index'))
{
	$class_index = new class_index();
	$class_index->register();
}



  if(isset($_POST['submit']))
  {
      update_option( 'checkForm',      'lleno', '', 'yes' );
      saveMethod();
  }


  if ( is_null( get_option('checkForm' ))) {
  //No hay variables crearlas

  add_option( 'namePWA',      'namePWA', '', 'yes' );
  add_option( 'shortName',    'shortName', '', 'yes' );
  add_option( 'startPag',     'startPag', '', 'yes' );
  add_option( 'description',  'Description', '', 'yes' );
  add_option( 'icon',          'Icon url 512px', '', 'yes' );
  add_option( 'displayMode',   'fullscreen | standalone | minimal-ui', '', 'yes' );
  add_option( 'orientation',    'Landscape | Portrait | both', '', 'yes' );
  add_option( 'themeColor',      'black', '', 'yes' );
  add_option( 'backgroundColor',  'black', '', 'yes' );

}

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

  if(!$namePWA)			{$namePWA = "name PWA";}
  if(!$shortName)		{$shortName = "short Name";}
  if(!$startPag)		{$startPag =  $url ;}
  if(!$description)	{$description = "Some Description";}
  if(!$icon)				{$icon = plugins_url('/assets/images/icons-512.png', __FILE__);}
  if(!$showBanner)	{$showBanner = 'on';}
  if(!$textBanner)	{$textBanner = 'Click Here to get this app';}
  if(!$displayMode)	{$displayMode = "fullscreen";}
  if(!$orientation)	{$orientation = "portrait";}
  if(!$themeColor)	{$themeColor = "#161e65";}
  if(!$backgroundColor){$backgroundColor = "#161e65";}



//para subir imagenes
if ( ! function_exists( 'wp_handle_upload' ) ) {
  require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

function saveMethod(){
  require_once plugin_dir_path( __FILE__ ).'../base-wpPwa.php';
    writeManifestJson();

  if ( !is_null( get_option('checkForm') )) {
              //No hay variables crearlas
         update_option( 'namePWA',          $_POST["pwaName"], '', 'yes' );
         update_option( 'shortName',        preg_replace('/\s+/', ' ',$_POST["shortName"]), '', 'yes' );
         update_option( 'startPag',         $_POST["startPag"], '', 'yes' );
         update_option( 'description',      preg_replace('/\s+/', ' ',$_POST["description"]), '', 'yes' );

         update_option( 'showBanner',      $_POST["showBanner"], '', 'yes' );
         update_option( 'textBanner',      $_POST["textBanner"], '', 'yes' );
         update_option( 'displayMode',      $_POST["displayMode"], '', 'yes' );
         update_option( 'orientation',      $_POST["orientation"], '', 'yes' );
         update_option( 'themeColor',       $_POST["themeColor"], '', 'yes' );
         update_option( 'backgroundColor',  $_POST["backgroundColor"], '', 'yes' );


    }

    //Maneja el subir imagenes
    // Set variables
    $default_image = plugins_url('img/no-image.png', __FILE__);

    if ( !is_null( $_FILES['file']['name'])) {

          $uploadedfile = $_FILES['file'];
          $upload_overrides = array( 'test_form' => false );
          $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

          if ( $movefile && ! isset( $movefile['error'] ) ) {
            $size = getimagesize($movefile["url"]);

            if($size[0] > 512){
              echo'<h2 class="dashicons-before dashicons-welcome-comments"> image size must be max 512px </h2> ';
            }else{
              update_option( 'icon',           $movefile["url"], '', 'yes' );
            }

          //var_dump( $movefile );
          } else {
            echo $movefile['error'];
          }

    }

    //add_action( 'get_header', 'addJson' );
}



 ?>







<div class="pwa_wrap">
<div class="card">


	<h2 class="dashicons-before dashicons-image-filter"> Add to Home Screen</h2>

		<p> sometimes referred to as the web app install prompt, makes it easy for users to install your Progressive Web App on their mobile or desktop device. After the user accepts the prompt, your PWA will be added to their launcher, and it will run like any other installed app. Fill the information about your application such as its name, author, icon, and description.</p>


      <form id='optionIndex' name="form1" method="post" action="admin.php?page=PWA_marioPlug" method="post" enctype='multipart/form-data'>

      <label id="manifest-name">Name</label>
      <input type="text" name="pwaName" id="pwaName" value="<?php  echo $namePWA ?>">

      <label id="manifest-Shorname">short Name</label>
      <input type="text" name="shortName" id="pwaShortName" value="<?php  echo $shortName ?> ">

      <!-- <label id="manifest-starturl">Start Page</label>
      <input type="text" name="startPag" id="startPag" value="//echo $startPag "> -->

      <label id="manifest-description">Description</label>
      <textarea  name="description" id="description" value="<?php  echo $description ?> ">
      <?php  echo $description ?>
      </textarea>




  <label id="manifest-icon">Icon</label>
  <div class='image-preview-wrapper'>
    <img id='image-preview' src='<?php  echo $icon ?>' height='100'>
    <input type='file' name='file'  multiple="false" >
  </div>


<!-- Rectangular switch -->
<label id="manifest-icon">Show banner to all browse <?php  echo $showBanner ?></label>
 <div class=" bannerShow">
    <label class="switch ">
    <input name="showBanner" type="checkbox" <?php echo ($showBanner == 'on' ? 'checked' : ''); ?> >
      <span class="slider"></span>
    </label>
  </div>

<label id="manifest-icon">Install Text Banner</label>
<input type="text" name="textBanner" id="textBanner" value="<?php  echo $textBanner ?>">



<label id="manifest-orientation">Select</label>
<select name="orientation" id="orientation">
<option value="landscape" <?php if (get_option( 'orientation') == 'landscape' ) echo 'selected' ; ?> >landscape</option>
<option value="portrait" <?php if (get_option( 'orientation') == 'portrait' ) echo 'selected' ; ?> >portrait</option>
<option value="natural" <?php if (get_option( 'orientation') == 'natural' ) echo 'selected' ; ?>>natural</option>
</select>

<label id="manifest-display">Display mode</label>
<select name="displayMode" id="displayMode">
<option value="fullscreen" <?php if (get_option( 'displayMode') == 'fullscreen' ) echo 'selected' ; ?> >Fullscreen - App takes whole display</option>
<option value="standalone" <?php if (get_option( 'displayMode') == 'standalone' ) echo 'selected' ; ?> >Standalone - Native app feeling</option>
<option value="minimal-ui" <?php if (get_option( 'displayMode') == 'minimal-ui' ) echo 'selected' ; ?>>Minimal browser controls</option>
</select>


<label id="manifest-theme-color">Theme Color</label>
<input name="themeColor" id="themeColor" type="color" value="<?php  echo $themeColor ?>" />

<label id="manifest-background-color">Background Color</label>
<input name="backgroundColor" id="backgroundColor" type="color" value="<?php  echo $backgroundColor ?>" />


			<hr />
			<p class="submit">
       <input type="submit"  class="button button-primary" name="submit" value="Submit">

			</p>
			</form>





	</div>
	</div>
