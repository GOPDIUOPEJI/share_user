<?php
use phpseclib\Crypt\RSA;

class ShareUser {

	public function generate_rsa($user_id) {
		if(file_exists(ABSPATH . '/wp-admin' . '/private.txt')){
			return;
		}
		$rsa = new RSA();
		extract($rsa->createKey());
		$put = file_put_contents( ABSPATH . '/wp-admin' . '/private.txt', $privatekey);
		update_user_meta( $user_id, 'ShareUser_publickey', $publickey );
	}
	/*This method includes file with admin-page interface*/
	public function get_interface(){
		include( plugin_dir_path( __FILE__ ) . 'views/interface.php');
	}

	public function get_admin_page() {
		include( plugin_dir_path( __FILE__ ) . 'views/admin_page.php');
	}
	public function encrypt_string($string, $user_id) {
		$rsa = new RSA();
		$publickey = esc_attr( get_the_author_meta( 'ShareUser_publickey', $user_id ) );
		$rsa->loadKey($publickey);
		$rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
		$ciphertext = $rsa->encrypt($string);
		$ciphertext = base64_encode($ciphertext);
		return $ciphertext;
	}

	public function decrypt_string($string, $user_id) {
		$string = base64_decode($string);
		$rsa = new RSA();
		$privatekey = file_get_contents(ABSPATH . '/wp-admin' . '/private.txt');
		$rsa->loadKey($privatekey);
		$rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
		$ciphertext = $rsa->decrypt($string);
		return $ciphertext;
	}

	public static function is_user_administrator() {
		if ( current_user_can( 'manage_options' ) ) {
		    return true;
		} else {
		    return false;
		}
	}

	public function get_user_meta_data($user_id) {
		$result['address'] = esc_attr( get_the_author_meta( 'address', $user_id ) );
		$result['phone'] = esc_attr( get_the_author_meta( 'phone', $user_id ) );
		$result['gender'] = esc_attr( get_the_author_meta( 'gender', $user_id ) );
		$result['maristat'] = esc_attr( get_the_author_meta( 'maristat', $user_id ) );
		return $result;
	}
}