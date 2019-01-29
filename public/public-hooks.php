<?php
/*
  Hooks related to Public pages
*/
class H_Instafeed_Public_Hooks {
  function __construct() {
    add_shortcode( 'instafeed', array($this, 'instafeed') );
    add_action( 'enqueue_scripts', array($this, 'public_enqueue') );
  }

  /*
    Display instagram slider of a specific username

    @shortcode [instafeed USERNAME]
  */
  function instafeed( $atts, $content = null ) {
    if( !isset($atts[0]) ) { return false; }

    $username = $atts[0];
    $feed = $this->get_photos( $username );
    return $feed;
  }
  

  /*
    @action enqueue_scripts
  */
  function public_enqueue() {
    // Stylesheet
    wp_enqueue_style( 'app-public' , PLUGIN_NAME_DIR . 'assets/css/app-public.css' );

    // Javascript
    wp_enqueue_script( 'app-public', PLUGIN_NAME_DIR . 'assets/js/app-public.js', false, false, true );
  }


  //
  

  /*
    Get latest 20 photos of a user in JSON format

    @param $username (string)
    @param $endcursor (string) - Bit from the JSON data used to get the next 20 photos (pagination)
    @return array
  */
  private function get_photos( $username, $endcursor = '' ) {
    $cache = new Instagram\Storage\CacheManager('../../uploads/instafeed-cache');
    $api   = new Instagram\Api( $cache );

    $api->setUserName( $username );
    
    // if pagination
    if( $endcursor ) {
      $api->setEndCursor( $endcursor );
    }

    $feed = $api->getFeed();
    return $feed;
  }
}
