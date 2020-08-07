<?php
/**
 * Plugin Name: JAG API SLUG
 * Description: *****************
 * Plugin URI:
 * Author: Kenny
 * Version: 1.1.1
 * Author URI:
 *
 * Text Domain: jag-api
 */
require_once ('JagApiSlug.php');
use Jag\JagApiSlug;
// call class JAG
$jag_api = new JagApiSlug();

// call action ajax main
add_action( 'wp_ajax_action_slug_api', 'f_action_slug_api' );
add_action( 'wp_ajax_nopriv_action_slug_api', 'f_action_slug_api' );
function f_action_slug_api(){
    $data = $_POST['data'];
    /// call layout each slug with include
include_once('layouts/layout_'.$data['slug'].'.php');
    die();
}