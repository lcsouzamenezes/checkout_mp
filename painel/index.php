<?php

session_start();

include('../config.php');
include('../funcoes.php'); 


$logado = isset($_SESSION['logado']) ? (bool) $_SESSION['logado'] : false; 

if (isset($_GET['sair'])) {
	$_SESSION['logado'] = false;

	header("Location: ". SITE_URL ."painel");
	exit;
}

if (isset($_POST['login'])) {
	$post = method_post();
	$login = isset($post['login']) ? $post['login'] : '';
	$senha = isset($post['senha']) ? $post['senha'] : '';

	if (empty($login)) {
		$mensagem = 'Preencha corretamente o campo Login';
	} else if (!is_valid_email($login)) {
		$mensagem = 'Preencha corretamente o campo Login';
	} else if (empty($senha)) {
		$mensagem = 'Preencha corretamente o campo Senha';
	} else {
		$query = mysqli_query($con, "SELECT * 
			FROM admins
			WHERE 
				adminLogin  = '$login' AND
				adminSenha  = '$senha' AND
				adminStatus = 1
			LIMIT 1");

		$lista = mysqli_fetch_array($query);
		if (isset($lista['adminID'])) {
			$_SESSION['logado'] = true;

			header("Location: ". SITE_URL ."painel");
			exit;
		} else {
			$mensagem = 'Login ou Senha Inválida';
		}
	}
} 

if (isset($_GET['status'])) {
	require_once('../lib/mercadopago.php');
	$query2 = mysqli_query($con, "SELECT * FROM pedidos ORDER BY pedidoID DESC");
	$array2 = array();
	while($row = mysqli_fetch_array($query2)){
		$array2[] = $row['pedidoIDMP'];
	};
	$mp = new MP (MP_TOKEN);
	foreach ($array2 as $value) {
		if ($value != null) {
			$payment_info = $mp->get("/v1/payments/". $value, false);
			$statusSwitch = $payment_info["response"]["status"];
			switch ($statusSwitch) {
					case "approved": 
						$status = "2";          
						break;
					case "pending": 
						$status = "1";
						break;
					case "in_process": 
						$status = "1";          
						break;
					case "rejected": 
						$status = "3";
						break;
					case "refunded": 
						$status = "3";
						break;
					case "cancelled": 
						$status = "3";
						break;
					case "in_mediation": 
						$status = "1";
						break;
					default:
						$status = "1";
			};
			$query = mysqli_query($con, "UPDATE pedidos SET pedidoStatus='$status' WHERE pedidoIDMP='$value' LIMIT 1;") or die(mysqli_error($con));
		} else {
			
		}
	}
	header("Location: ". SITE_URL ."painel/?pg=pedidos");
}
if (isset($_GET['csv']))  {
	$query_csv = mysqli_query($con, "SELECT * FROM pedidos ORDER BY pedidoData DESC");
	if($query_csv->num_rows > 0){
		$delimiter = ",";
		$filename = "pedidos_" . date('Y-m-d') . ".csv";
		$f = fopen('php://memory', 'w');

		$fields = array('pedidoNome', 'pedidoEmail', 'pedidoTelefone', 'pedidoCPF', 'pedidoCEP', 'pedidoEnderecoRua', 'pedidoEnderecoNumero', 'pedidoEnderecoBairro', 'pedidoEnderecoCidade', 'pedidoEnderecoEstado', 'pedidoEnderecoComplemento', 'pedidoProduto', 'pedidoValor');
		fputcsv($f, $fields, $delimiter);
		while($row = $query_csv->fetch_assoc()){
			$status = ($row['status'] == '1')?'Active':'Inactive';
			$lineData = array($row['pedidoNome'], $row['pedidoEmail'], $row['pedidoTelefone'], $row['pedidoCPF'], $row['pedidoCEP'], $row['pedidoEnderecoRua'], $row['pedidoEnderecoNumero'], $row['pedidoEnderecoBairro'], $row['pedidoEnderecoCidade'], $row['pedidoEnderecoEstado'], $row['pedidoEnderecoComplemento'], $row['pedidoProduto'], $row['pedidoValor'], $status);
			fputcsv($f, $lineData, $delimiter);
		};
		fseek($f, 0);
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		fpassthru($f);
	};
	exit(); 
}
?>

<html>
<head>
	<title>Administração</title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta charset="UTF-8">

	<!-- Google web fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,700i&display=swap" rel="stylesheet">

	<!-- CSS -->
	<link href="<?php echo SITE_URL .'css/bootstrap.css'; ?>" rel="stylesheet"> 
	<link href="<?php echo SITE_URL .'css/font-awesome.css'; ?>" rel="stylesheet"> 
	<link href="<?php echo SITE_URL .'css/painel.css?v=2.'. ANE_VERSAO; ?>" rel="stylesheet">  

</head>
<body>
	<div class="container">
		<?php
		$mensagem = '';

		if ($logado) {
			$pagina = isset($_GET['pg']) ? anti_injection($_GET['pg']) : 'pedidos'; ?>

			<div class="painel">
				<div class="row">
					<div class="col-md-3">
						<ul class="list-group">
						  	<li class="list-group-item">
						  		<a href="<?php echo SITE_URL .'painel/?pg=pedidos'; ?>"></i> Pedidos</a>
						  	</li>
						  	<li class="list-group-item">
						  		<a href="<?php echo SITE_URL .'painel/?pg=produtos'; ?>"></i> Produtos</a>
						  	</li>
						  	<li class="list-group-item">
						  		<a href="<?php echo SITE_URL .'painel/?pg=usuarios'; ?>"></i> Usuários</a>
						  	</li>
						  	<li class="list-group-item">
						  		<a href="<?php echo SITE_URL .'painel/?sair'; ?>"></i> Sair</a>
						  	</li>
						</ul>
					</div>
					<div class="col-md-9">
						<?php
						if (is_file($pagina . '.php')) { 
							include($pagina . '.php');
						} else {
							include('produtos.php');
						} ?>
					</div>
				</div>
			</div>

			<?php
		} else { ?>
			<div class="login-form">
	    		<form action="" method="post">
	        		<h2 class="text-center">Acesso</h2>       
	        			<div class="form-group">
	            			<input name="login" type="text" class="form-control" placeholder="Login" required="required">
	        			</div>
	        			<div class="form-group">
	            			<input name="senha" type="password" class="form-control" placeholder="Senha" required="required">
	        			</div>
	        			<div class="form-group">
	            			<button type="submit" class="btn btn-primary btn-block">Acessar</button>
	        			</div>
	    		</form>
			</div>
			<?php
		} ?>

	</div>

	<script>
		<?php echo empty($mensagem) ? '' : "alert('$mensagem')"; ?>
	</script>
</body>
</html>
