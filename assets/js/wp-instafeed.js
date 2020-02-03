(function( $ ) {

  document.addEventListener('DOMContentLoaded', onReady );

  function onReady() {
    activateSlider();
    activateLightbox();
  }

  /**
   * Activate the slider
   */
  function activateSlider() {
    $('.h-instafeed-slider').each( function() {
      let $slider = $(this);
      let ips = $slider.data('ips').split('/'); // items per slide
  
      let responsive = {};
      if( ips.length > 1 ) { responsive['767'] = ips[1]; }
      if( ips.length > 2 ) { responsive['480'] = ips[2]; };
  
      $(this).hSlider( {
        itemsPerSlide: ips[0],
        responsive: responsive
      } );
    });
  }

  /**
   * Activate hLightbox
   */
  function activateLightbox() {
    $('.h-instafeed-slider a, .h-instafeed-gallery a').hLightbox();
  }


})( jQuery );


// Trigger
jQuery(document).ready( () => {
  
});