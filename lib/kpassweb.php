<?php
	class KPassWeb {

	public function update_password ($params) {
		foreach (array('user','realm','password','newpassword') as $key) {
			if (!array_key_exists($key,$params))
				throw new Exception($key.' field not set.');
			if (empty($params[$key]))
				throw new Exception($key.' field is empty.');
		}
		// Add check against realm here
		return $this->change_password(	$params['user'],
										$params['realm'],
										'127.0.0.1', // Specify better way to get KDC
										$params['password'],
										$params['newpassword']);
	}

	private function change_krb_pass ($user,$realm,$kdc, $password,$newpassword) {
		$handle = kadm5_init_with_password($kdc, $realm, $user, $password);
		if ($handle == false)
			throw new Exception('Could not authenticate with current password. Did you type it correctly?');
		$result = kadm5_chpass_principal($handle, $user.'@'.$realm, $newpassword);
		if ($result == false)
			throw new Exception('Could not change password, perhaps it needs to be more complicated?');
		kadm5_destroy($handle);
		return true;
	}
}

?>
