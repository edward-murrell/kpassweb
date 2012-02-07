<?php

// TODO - Turn this into a singleton
class kpassweb_config {
	private static $instance;
	private $realms;

	public function __construct() {
		$this->realms = array(); 
	}

    public static function singleton()
    {
        if (!isset(self::$instance))
            self::$instance = new kpassweb_config;
        return self::$instance;
    }

	public function addRealm($realm = null, $host = '127.0.0.1') {
		// TODO - check for realm validity
		// TODO - check for host validity
		$this->realms[$realm] = $host;
	}
	public function getRealms() {
		return array_keys($this->realms);
	}
	public function getKDC($realm) {
		if (!array_key_exists($realm,$this->realms))
			return false;
		else
			return $this->realms[$realm];
	}

}

// Set the desired realm
$kpassweb_config->addRealm ('EXAMPLE.COM','localhost');
$kpassweb_config->addRealm ('SUBDOMAIN.EXAMPLE.COM','localhost');

/* $kpassweb_config->addRealm ('MULTI.EXAMPLE.COM',array('10.1.1.1','kdc2.local'));
 * $kpassweb_config->addRealm ('MULTI.EXAMPLE.COM'); // configured via DNS / krb5.conf
 *
 * TODO - Add these methods;
 * $config->getRealms() // returns array of valid realms
 * $config->getKDC($realm);
 */

?>
