<?php
/**
 * Plugin Name: Feature Plugin for Geek Adventures
 * Plugin URI: none
 * Description: ACF Repeater Shortcode based on FranciscoG's acf_repeater_shortcode.php https://gist.github.com/FranciscoG/c393d9bc6e0a89cd79d1fd531eccf627
 * Version: 0.1
 * Text Domain: https://geekadventures.org
 * Author: Mendel Kurland
 * Author URI: https://ifyouwillit.com
 */

//ACF Repeater Shortcode based on FranciscoG's acf_repeater_shortcode.php https://gist.github.com/FranciscoG/c393d9bc6e0a89cd79d1fd531eccf627

function my_acf_repeater($atts, $content='') {
  extract(shortcode_atts(array(
    "field" => null,
    "sub_fields" => null,
    "post_id" => null
  ), $atts));
  if (empty($field) || empty($sub_fields)) {
    // silently fail? is that the best option? idk
    return "";
  }
  $sub_fields = explode(",", $sub_fields);
  
  $_finalContent = '';
  if( have_rows($field, $post_id) ):
    while ( have_rows($field, $post_id) ) : the_row();
      
      $_tmp = $content;
      foreach ($sub_fields as $sub) {
        $subValue = get_sub_field(trim($sub));
        $_tmp = str_replace("%$sub%", $subValue, $_tmp);
      }
      $_finalContent .= do_shortcode( $_tmp );
    endwhile;
  else :  
    $_finalContent = "$field does not have any rows";
  endif;
  return $_finalContent;
}
add_shortcode("acf_repeater", "my_acf_repeater");