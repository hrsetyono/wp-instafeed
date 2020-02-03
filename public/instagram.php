<?php
/*
  Hooks related to Public pages
*/
class Instafeed_Public_Hooks {
  function __construct() {
    add_shortcode( 'instafeed', array($this, 'instafeed_shortcode') );
    
    add_action( 'wp_enqueue_scripts', array($this, 'register_assets') );
  }

  /**
   * Display instagram slider of a specific username
   * @shortcode [instafeed]
   */
  function instafeed_shortcode( $atts, $content = null ) {
    // if has no username
    if( !isset($atts['username']) ) {
      trigger_error( "Instagram username isn't set" );
      return;
    }

    // filter attributes and set default value
    $atts = shortcode_atts( [
      'username' => '',
      'items-per-slide' => '4/3/2',
      'items' => '',
    ], $atts );

    // if not slider
    if( !empty( $atts['items'] ) ) {
      $this->enqueue_assets( 'gallery' );
      $this->output_gallery( $atts );
    }
    else {
      $this->enqueue_assets( 'slider' );
      $this->output_slider( $atts ); 
    }
  }
  
  /**
   * @action enqueue_scripts
   */
  function register_assets() {
    // CSS
    if( !wp_style_is( 'h-slider', 'registered' ) ) {
      wp_register_style( 'h-slider' , INSTAFEED_URL . '/assets/css/h-slider.css' );
    }
    if( !wp_style_is( 'h-lightbox', 'registered' ) ) {
      wp_register_style( 'h-lightbox' , INSTAFEED_URL . '/assets/css/h-lightbox.css' );
    }

    // JS
    if( !wp_script_is( 'h-slider', 'registered' ) ) {
      wp_register_script( 'h-slider', INSTAFEED_URL . '/assets/js-vendor/h-slider.min.js', array('jquery'), false, true );
    }
    if( !wp_script_is( 'h-lightbox', 'registered' ) ) {
      wp_register_script( 'h-lightbox', INSTAFEED_URL . '/assets/js-vendor/h-lightbox.min.js', array('jquery'), false, true );
    }

    wp_register_script( 'wp-instafeed', INSTAFEED_URL . '/assets/js/wp-instafeed.js', array('jquery'), false, true );
  }
  


  /**
   * Output image gallery using Instagram photos
   */
  private function output_gallery( $atts ) {
    $data = self::get_data( $atts['username'] );
    $loop = 0;
    $content = '';
    
    foreach( $data->medias as $photo ) {
      $caption = preg_replace( '/\s#\w+/', '', $photo->caption );
      $src = $photo->thumbnails[3]->src;
      
      $content .= "<a href='{$photo->displaySrc}' title='{$caption}'>
        <img src='{$src}'>
      </a>";

      $loop++;
      if( $loop >= $atts['items'] ) { break; }
    }

    echo "<div class='h-instafeed-gallery' data-count='{$atts['items']}'>
      {$content}
    </div>";
  }

  /**
   * Output image slider using Instagram photos
   */
  private function output_slider( $atts ) {
    $data = self::get_data( $atts['username'] );
    $content = '';

    foreach( $data->medias as $photo ) {
      $caption = preg_replace( '/\s#\w+/', '', $photo->caption );
      $src = $photo->thumbnails[3]->src;
      
      $content .= "<a href='{$photo->displaySrc}' title='{$caption}'>
        <img src='{$src}'>
      </a>";
    }

    echo "<div class='h-instafeed-gallery' data-ips='{$atts['items-per-slide']}'>
      {$content}
    </div>";
  }

  
  /*
    Get latest 20 photos of a user in JSON format

    @param $username (string)
    @param $endcursor (string) - Bit from the JSON data used to get the next 20 photos (pagination)
    @return array
  */
  static function get_data( $username, $endcursor = '' ) {
    require_once INSTAFEED_PATH . '/vendor/autoload.php';
    
    $cache = new Instagram\Storage\CacheManager('wp-content/instafeed-');
    $api   = new Instagram\Api( $cache );

    $api->setUserName( $username );
    
    // if pagination
    if( $endcursor ) {
      $api->setEndCursor( $endcursor );
    }

    $feed = $api->getFeed();
    return $feed;
  }


  /**
   * Enqueue assets for Slider
   */
  private function enqueue_assets( $type = 'slider' ) {
    wp_enqueue_style( 'h-lightbox' );
    wp_enqueue_script( 'h-lightbox' );

    wp_enqueue_script( 'wp-instafeed' );

    if( $type === 'slider' ) {
      wp_enqueue_script( 'h-slider' );
      wp_enqueue_style( 'h-slider' );
    }
  }

}
