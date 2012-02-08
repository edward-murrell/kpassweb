<?php
/* kpassweb_config.php
 * Provides kpassweb_config singleton object code for configuration
 * of realms in the kpassweb web application
 *
 * This file and it's surrounding application is licensed under version 3 of
 * the GNU General Public License. Further information can be found in the
 * LICENSE file in the root of this application.
 *
 * Copyright Edward Murrell, 2012
 * edward@murrell.co.nz
 */
class kpassweb_config {
	private static $instance;
	protected $realms;
	protected $testing;

	public function __construct() {
		$this->realms = array();
		$this->testing = false;
	}

    public static function singleton()
    {
        if (!isset(self::$instance))
            self::$instance = new kpassweb_config;
        return self::$instance;
    }

    public static function testing($test = null)
    {
		$conf = self::singleton();
		if ($test == null)
			return $conf->testing;
		else
			$conf->testing = $test;
    }

	public static function addRealm($realm = null, $host = '127.0.0.1') {
		$conf = self::singleton();
		// TODO - check for realm validity
		// TODO - check for host validity
		// TODO - allow ability to give array of hosts
		$conf->realms[$realm] = $host;
	}
	public static function getRealms() {
		$conf = self::singleton();
		return array_keys($conf->realms);
	}
	public static function getKDC($realm) {
		$conf = self::singleton();
		if (!array_key_exists($realm,$conf->realms))
			return false;
		else
			return $conf->realms[$realm];
	}

}
?>
