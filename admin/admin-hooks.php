<?php
/*
  Hooks related to Admin pages
*/
class H_Instafeed_Admin_Hooks {
  function __construct() {
    // add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue') );
  }

  /*
    @action admin_enqueue_scripts
  */
  function admin_enqueue() {
    // Stylesheet
    wp_enqueue_style( 'app-admin' , H_INSTAFEED_URL . '/assets/css/app-admin.css' );

    // Javascript
    wp_enqueue_script( 'app-admin', H_INSTAFEED_URL . '/assets/js/app-admin.js', false, false, true );
  }
}
