<?php
require_once '../lib/jsonrpcphp/includes/jsonRPCServer.php';
require_once '../lib/kpassweb.php';
require_once '../conf/config.php';

$rpcHandler = new KPassWeb();
jsonRPCServer::handle($rpcHandler)
	or print 'no request';

?>
