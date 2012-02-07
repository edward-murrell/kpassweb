<?php

// TODO - Turn this into a singleton
class kpassweb_config {
}

// Set the desired realm
$config->addRealm ('EXAMPLE.COM','localhost');
$config->addRealm ('MULTI.EXAMPLE.COM',array('10.1.1.1','kdc2.local'));
// $config->addRealm ('MULTI.EXAMPLE.COM'); // configured via DNS / krb5.conf

/* TODO - Add these methods;
 * $config->getRealms() // returns array of valid realms
 * $config->getKDC($realm);


?>
