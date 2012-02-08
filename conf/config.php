<?php
// Set the desired realm, and the kdc to use
kpassweb_config::testing(true); // change this to false to use Kerberos code
kpassweb_config::addRealm ('EXAMPLE.COM','localhost');
kpassweb_config::addRealm ('SUBDOMAIN.EXAMPLE.COM','kdc.subdomain.example.com');
?>
