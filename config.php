<?php
define('SANDBOX', false);
define('DEBUG', false);

define('MP_KEY',   'APP_USR-1b6a772b-2ab4-486e-aed5-448572f97094');
define('MP_TOKEN', 'APP_USR-6811308923825446-071919-ece240d08c5abafd93685a68b598dada-432089967');

define('CLIENT_ID', '6811308923825446');
define('CLIENT_SECRET', '9QCDuQ8MFZfQSftJV6K9DYyUWG9DsnRd');

define('OPCAO_CARTAO', true);
define('OPCAO_BOLETO', true);

define('PIXEL_CARTAO', true);
define('PIXEL_BOLETO', true);

define('REDIRECIONAR_APOS_PAGAMENTO', 'https://pagamento.megaofertasbr.com');
define('SITE_URL',     'https://pagamento.megaofertasbr.com/');
define('NOTIFICA_URL', 'https://pagamento.megaofertasbr.com/retorno.php');

define('BANCO_HOST', 'localhost');
define('BANCO_USER', 'pmeg8744_db');
define('BANCO_PASS', 'Thmpv77d6f94376');
define('BANCO_DB',   'pmeg8744_checkout');

$con = new mysqli(BANCO_HOST, BANCO_USER, BANCO_PASS, BANCO_DB) or die("Connect failed: %s\n". $con -> error);
