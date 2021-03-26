<?php
/*
Plugin Name: Bdigital Custom Head Tags
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function headtags_register_meta_boxes() {
    add_meta_box( 'headtags', __( 'Additional Head Tags', 'headtags' ), 'headtags_callback', 'post' );
}

add_action( 'add_meta_boxes', 'headtags_register_meta_boxes' );

function headtags_callback( $post ) {
    echo "<textarea name='headtags' id='headtags' style='width: 100%; height: 250px'>".stripslashes(urldecode(get_post_meta( get_the_ID(), 'headtags', true )))."</textarea>";
}

function hook_headtags() {
    //dont show on front page
	if(is_front_page()){
    ?>
	<!--front-->
    <?php
	} else {
	    //output custom header content
		echo stripslashes(urldecode(get_post_meta( get_the_ID(), 'headtags', true )));
	}
}
add_action('wp_head', 'hook_headtags');

function header_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'headtags'
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, urlencode($_POST[$field]) );
        }
     }
 }
 add_action( 'save_post', 'header_save_meta_box' );
