<?php
/**
* Plugin Name: Share User Plugin
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Paul
* Author URI: http://yourwebsiteurl.com/
**/
include plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
include plugin_dir_path( __FILE__ ) . 'class.ShareUser.php';

function add_menupage(){
    add_menu_page( 'Share User', 'Share User', 'edit_posts', 'share_user', 'interface_function', 'dashicons-admin-tools', 99 ); 
}

function interface_function() {
    $share_user = new ShareUser();
    $share_user->get_admin_page(get_plugin_data(__FILE__)['Name']);
}

add_action( 'admin_menu', 'add_menupage' );

function add_user_profile_fields( $user ) { 
    $share_user = new ShareUser();
    $share_user->generate_rsa($user->ID);
	$share_user->get_interface();
    $enc = $share_user->encrypt_string('asdasdasd', $user->ID);
}

add_action( 'show_user_profile', 'add_user_profile_fields' );
add_action( 'edit_user_profile', 'add_user_profile_fields' );

function save_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    $share_user = new ShareUser();
    update_user_meta( $user_id, 'address', $share_user->encrypt_string($_POST['address'], $user_id));
    update_user_meta( $user_id, 'phone', $share_user->encrypt_string($_POST['phone'], $user_id) );
    update_user_meta( $user_id, 'gender', $share_user->encrypt_string($_POST['gender'], $user_id) );
    update_user_meta( $user_id, 'maristat', $share_user->encrypt_string($_POST['maristat'], $user_id) );
}

add_action( 'personal_options_update', 'save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_user_profile_fields' );
