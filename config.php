<?php
define('SANDBOX', false);
define('DEBUG', false);

define('MP_KEY',   'suas key aqui');
define('MP_TOKEN', 'suas key aqui');

define('OPCAO_CARTAO', true);
define('OPCAO_BOLETO', true);

define('PIXEL_CARTAO', true);
define('PIXEL_BOLETO', true);

define('REDIRECIONAR_APOS_PAGAMENTO', '');
define('SITE_URL',     '');
define('NOTIFICA_URL', '');

define('BANCO_HOST', 'localhost');
define('BANCO_USER', '');
define('BANCO_PASS', '');
define('BANCO_DB',   '');

$con = new mysqli(BANCO_HOST, BANCO_USER, BANCO_PASS, BANCO_DB) or die("Connect failed: %s\n". $con -> error);
