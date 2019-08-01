<?php
if ( ! defined( 'WPINC' ) ) {die;}

$namePWA;
$shortName;
$startPag;
$description;
$icon;

$orientation;
$themeColor;
$backgroundColor;


class class_inset_manifest
{

  function register()
  {

    add_action( 'wp_head', 'manifest_header');
    add_action( 'wp_head', 'register_my_service_worker' );

  }



}

//If class exist call class from variable
if(class_exists( 'class_inset_manifest'))
{
	$class_inset_manifest = new class_inset_manifest();
	$class_inset_manifest->register();
}




  function register_my_service_worker () {
    $dest = get_site_url();
    echo "<script>navigator.serviceWorker.register('".$dest.'/service-worker.js'."')</script>";
  }




  function manifest_header(){

 $url = site_url();
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


   if(!$namePWA)		{$namePWA = "name PWA";}
	if(!$shortName)		{$shortName = "short Name";}
	if(!$startPag)		{$startPag =  $url ;}
	if(!$description)	{$description = "Some Description";}
	if(!$icon)				{$icon = plugins_url('/assets/images/icons-512.png', __FILE__);}
  //if(!$showBanner)	{$showBanner = 1;}
	if(!$displayMode)	{$displayMode = "fullscreen";}
	if(!$orientation)	{$orientation = "portrait";}
	if(!$themeColor)	{$themeColor = "#161e65";}
  if(!$backgroundColor){$backgroundColor = "#161e65";}

  //plugins_url('../assets/images/touch-icon-iphone.png', __FILE__);
  //plugins_url('../assets/images/ms-icon-144x144.png', __FILE__);
    ?>
<!--  head section Icons-->
<meta name="msapplication-TileColor"  content="<?php echo $backgroundColor ?>">
<meta name="theme-color"              content="<?php echo  $themeColor ?>">

<meta name="msapplication-TileImage"  content="<?php  echo $icon ?>">
<link rel="apple-touch-icon"          href="<?php  echo $icon ?>">
<meta name="mobile-web-app-capable"   content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="msapplication-starturl"    content="<?php  echo $startPag ?>">
<!-- <link href="/apple_splash_750.png" sizes="750x1334" rel="apple-touch-startup-image" /> -->

<link rel="manifest"  href="<?php echo plugins_url('../assets/js/manifest.json', __FILE__); ?>" />
<link rel="manifest" href="<?php echo plugins_url('../assets/js/manifest.webmanifest', __FILE__); ?>">
    <?php
  }

