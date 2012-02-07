<?php
/* 
 *
 */
class kpassweb_config {
	private static $instance;
	protected $realms;

	public function __construct() {
		$this->realms = array();
	}

    public static function singleton()
    {
        if (!isset(self::$instance))
            self::$instance = new kpassweb_config;
        return self::$instance;
    }

	public static function addRealm($realm = null, $host = '127.0.0.1') {
		$conf = self::singleton();
		// TODO - check for realm validity
		// TODO - check for host validity
		$conf->realms[$realm] = $host;
	}
	public static function getRealms() {
		$conf = self::singleton();
		return array_keys($conf->realms);
	}
	public function getKDC($realm) {
		$conf = self::singleton();
		if (!array_key_exists($realm,$conf->realms))
			return false;
		else
			return $conf->realms[$realm];
	}

}

// Set the desired realm
kpassweb_config::addRealm ('EXAMPLE.COM','localhost');
kpassweb_config::addRealm ('SUBDOMAIN.EXAMPLE.COM','localhost');

/* $kpassweb_config->addRealm ('MULTI.EXAMPLE.COM',array('10.1.1.1','kdc2.local'));
 * $kpassweb_config->addRealm ('MULTI.EXAMPLE.COM'); // configured via DNS / krb5.conf
 *
 * TODO - Add these methods;
 * $config->getRealms() // returns array of valid realms
 * $config->getKDC($realm);
 */
?>
