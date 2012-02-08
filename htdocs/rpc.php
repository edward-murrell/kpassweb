<?php
/* rpc.php
 * RPC handler for KPassWeb. Handles entry into the PHP application. Loads
 * all libraries and configuration. This should be the only PHP file directly
 * accessible from the web. 
 *
 * This file and it's surrounding application is licensed under version 3 of
 * the GNU General Public License. Further information can be found in the
 * LICENSE file in the root of this application.
 *
 * Copyright Edward Murrell, 2012
 * edward@murrell.co.nz
 */
require_once '../lib/jsonrpcphp/includes/jsonRPCServer.php';
require_once '../lib/kpassweb_config.php';
require_once '../lib/kpassweb.php';
require_once '../conf/config.php';

$rpcHandler = new KPassWeb();
jsonRPCServer::handle($rpcHandler)
	or print 'no request';

?>
