<?php
/* kpassweb.php
 * JSON RPC PHP handler object to interface with fake and Kerberos backends.
 *
 * This file and it's surrounding application is licensed under version 3 of
 * the GNU General Public License. Further information can be found in the
 * LICENSE file in the root of this application.
 *
 * Copyright Edward Murrell, 2012
 * edward@murrell.co.nz
 */
class KPassWeb {

	private $conf;

	public function __construct() {
		$this->conf = new kpassweb_config();
	}

	public function get_realms($params) {
		return $this->conf->getRealms();
	}

	public function update_password ($params) {
		foreach (array('user','realm','password','newpassword') as $key) {
			if (!array_key_exists($key,$params))
				throw new Exception($key.' field not set.');
			if (empty($params[$key]))
				throw new Exception($key.' field is empty.');
		}
		
		if (($kdc = $this->conf->getKDC($params['realm'])) == false)
			throw new Exception($params['realm'].' does not exist on server.');

		if ($this->conf->testing())
			$method = 'fake_response';
		else
			$method = 'change_krb_pass';
		return $this->$method(	$params['user'],
										$params['realm'],
										$kdc,
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

	private function fake_response ($user,$realm,$kdc, $password,$newpassword) {
		if (strlen($newpassword) < 4)
			throw new Exception('Could not change password, perhaps it needs to be more complicated?');
		if ($password == 'password')
			return true;
		throw new Exception('Could not authenticate with current password. Did you type it correctly?');
	}


}

?>
