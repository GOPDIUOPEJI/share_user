<?php
use phpseclib\Crypt\RSA;

class ShareUser {
	/* This method generates rsa public and private keys private key saved in 'wp-admin' folder */
	public function generate_rsa($user_id) {
		if(file_exists(ABSPATH . '/wp-admin' . '/private.txt')){
			return;
		}
		$rsa = new RSA();
		extract($rsa->createKey());
		$put = file_put_contents( ABSPATH . '/wp-admin' . '/private.txt', $privatekey);
		update_user_meta( $user_id, 'ShareUser_publickey', $publickey );
	}
	/*This method includes file with fields for user-page */
	public function get_interface(){
		include( plugin_dir_path( __FILE__ ) . 'views/interface.php');
	}

	/*This method includes admin-page content*/
	public function get_admin_page($plugin_name) {
		$args['plugin_name'] = $plugin_name;
		include( plugin_dir_path( __FILE__ ) . 'views/admin_page.php');
	}
	/*This method encrypts string with rsa-public key and return encrypted string in base64*/
	public function encrypt_string($string, $user_id) {
		$rsa = new RSA();
		$publickey = esc_attr( get_the_author_meta( 'ShareUser_publickey', $user_id ) );
		$rsa->loadKey($publickey);
		$rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
		$ciphertext = $rsa->encrypt($string);
		$ciphertext = base64_encode($ciphertext);
		return $ciphertext;
	}
	/*This method decodes string from base64 and decrypts with rsa-private key*/
	public function decrypt_string($string, $user_id) {
		$string = base64_decode($string);
		$rsa = new RSA();
		$privatekey = file_get_contents(ABSPATH . '/wp-admin' . '/private.txt');
		$rsa->loadKey($privatekey);
		$rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
		$ciphertext = $rsa->decrypt($string);
		if(!$ciphertext){
			return "Decryption Error, file private key is WRONG!";
		}
		return $ciphertext;
	}
	/*This method returns true if current user is administrator and false if not*/
	public static function is_user_administrator() {
		if ( current_user_can( 'manage_options' ) ) {
		    return true;
		} else {
		    return false;
		}
	}
	/*This methodreturns user meta fields */
	public function get_user_meta_data($user_id) {
		$result['address'] = $this->decrypt_string(esc_attr( get_the_author_meta( 'address', $user_id ) ), $user_id);
		$result['phone'] = $this->decrypt_string(esc_attr( get_the_author_meta( 'phone', $user_id ) ), $user_id);
		$result['gender'] = $this->decrypt_string(esc_attr( get_the_author_meta( 'gender', $user_id ) ), $user_id);
		$result['maristat'] = $this->decrypt_string(esc_attr( get_the_author_meta( 'maristat', $user_id ) ), $user_id);
		return $result;
	}

	/*This method checks is valid rsa-keys*/
	public function test_rsa($user_id) {
		$encrypted = $this->encrypt_string('test', $user_id);
		$decrypted = $this->decrypt_string($encrypted, $user_id);
		if($decrypted != 'test'){
			return false;
		} else {
			return true;
		}
	}
}