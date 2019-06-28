<?php
/**
* Plugin Name: Share User Plugin
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Paul
* Author URI: http://yourwebsiteurl.com/
**/

include( plugin_dir_path( __FILE__ ) . 'class.ShareUser.php');

function add_user_profile_fields( $user ) { 
    $share_user = new ShareUser();
	$share_user->get_interface(get_plugin_data(__FILE__)['Name']);
}

add_action( 'show_user_profile', 'add_user_profile_fields' );
add_action( 'edit_user_profile', 'add_user_profile_fields' );

function save_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'address', $_POST['address'] );
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
    update_user_meta( $user_id, 'gender', $_POST['gender'] );
    update_user_meta( $user_id, 'maristat', $_POST['maristat'] );
}

add_action( 'personal_options_update', 'save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_user_profile_fields' );
