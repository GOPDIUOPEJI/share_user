<?php
class ShareUser {
	/*This method includes file with admin-page interface*/
	public function get_interface($plugin_name){
		$args['plugin_name'] = $plugin_name;
		include( plugin_dir_path( __FILE__ ) . 'views/interface.php');
		
	}

	public function is_user_administrator() {
		if ( current_user_can( 'manage_options' ) ) {
		    return true;
		} else {
		    return false;
		}
	}

	public function get_user_meta_data($user_id) {
		$result['address'] = esc_attr( get_the_author_meta( 'address', $user_id ) );
		$result['phone'] = esc_attr( (int)get_the_author_meta( 'phone', $user_id ) );
		$result['gender'] = esc_attr( get_the_author_meta( 'gender', $user_id ) );
		$result['maristat'] = esc_attr( get_the_author_meta( 'maristat', $user_id ) );
		return $result;
	}

}