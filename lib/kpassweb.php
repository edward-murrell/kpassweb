<?php

	class KPassWeb {
		public function giveMeSomeData($param) {

		private function change_krb_pass($user,$realm = $config->realm,$kdc =$config->kdc, $password,$newpassword) {
			$handle = kadm5_init_with_password($kdc, $realm, $user, $password);
			$result = kadm5_chpass_principal($handle, $user.'@'.$realm, $newpassword);
			kadm5_destroy($handle);	
		}
	


?>
