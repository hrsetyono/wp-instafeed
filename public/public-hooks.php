<?php
/*
  Hooks related to Public pages
*/
class Instafeed_Public_Hooks {
  function __construct() {
    add_shortcode( 'instafeed', array($this, 'instafeed_shortcode') );
    add_action( 'wp_enqueue_scripts', array($this, 'register_assets') );
  }

  /*
    Display instagram slider of a specific username

    @shortcode [instafeed]
  */
  function instafeed_shortcode( $atts, $content = null ) {
    if( !isset($atts['username']) ) { return false; } // must have username

    $this->enqueue_assets();

    // filter attributes and set default value
    $atts = shortcode_atts( array(
      'username' => '',
      'items-per-slide' => '4/3/2',
    ), $atts );

    $this->output_slider( $atts ); 
  }
  

  /*
    @action enqueue_scripts
  */
  function register_assets() {
    if( !wp_script_is( 'h-slider', 'enqueued' ) ) {
      wp_register_style( 'h-slider' , INSTAFEED_URL . '/assets/css/h-slider.css' );
    }

    if( !wp_script_is( 'h-lightbox', 'enqueued' ) ) {
      wp_register_style( 'h-lightbox' , INSTAFEED_URL . '/assets/css/h-lightbox.css' );
    }

    // Javascript
    wp_register_script( 'h-slider', INSTAFEED_URL . '/assets/js-vendor/h-slider.min.js', array('jquery'), false, true );
    wp_register_script( 'h-lightbox', INSTAFEED_URL . '/assets/js-vendor/h-lightbox.min.js', array('jquery'), false, true );
  }


  //
  

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

  /*
    Enqueue necessary assets
  */
  private function enqueue_assets() {
    if( !wp_script_is( 'h-slider', 'enqueued' ) ) {
      wp_enqueue_style( 'h-slider' );
    }

    if( !wp_script_is( 'h-lightbox', 'enqueued' ) ) {
      wp_enqueue_style( 'h-lightbox' );
    }

    wp_enqueue_script( 'h-slider' );
    wp_enqueue_script( 'h-lightbox' );
  }

  /*
    Slider template
  */
  private function output_slider( $atts ) {
    $data = self::get_data( $atts['username'] );

    ?>
    <div class="h-instafeed-slider" data-ips="<?php echo $atts['items-per-slide']; ?>">
      <?php foreach( $data->medias as $photo ):
        $caption = preg_replace( '/\s#\w+/', '', $photo->caption );
        $src = $photo->thumbnails[3]->src; ?>
        
        <a href="<?php echo $photo->displaySrc; ?>" title="<?php echo $caption; ?>">
          <img src="<?php echo $src; ?>">
        </a>
        
      <?php endforeach; ?>
    </div>
    <?php
  }
}
