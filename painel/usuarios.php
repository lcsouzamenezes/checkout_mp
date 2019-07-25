<?php
if (isset($_GET['add']) || isset($_GET['edit'])) { 

	$action = SITE_URL .'painel/?pg=usuarios&add'; 
	$id     = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;

	if (isset($_GET['edit']))
		$action = SITE_URL .'painel/?pg=usuarios&edit=' . $id; 

	if (isset($_POST['adminLogin'])) {
		$post = method_post();

		if (empty($post['adminLogin'])) {
			$mensagem = 'Preencha corretamente o campo Login';
		} else {

			if ($id > 0) {
				$query = mysqli_query($con, "UPDATE admins SET 
						adminLogin  = '". $post['adminLogin'] ."'
						". (empty($post['adminSenha']) ? '' : ",adminSenha  = '". $post['adminSenha'] ."' ") ."
					WHERE
						adminID = $id
					LIMIT 1;") or die(mysqli_error($con));

				if ($query) {
					$mensagem = 'Alterações foram salvas';
				} else {
					$mensagem = 'Erro ao alterar';
				}

			} else {

				$codigo = md5(uniqid(rand(), true));

				$query = mysqli_query($con, "INSERT INTO admins
					(adminLogin,
					adminSenha) 
					VALUES
					('". $post['adminLogin'] ."',
					'". $post['adminSenha'] ."')") or die(mysqli_error($con));
		
				if ($query) {
					$mensagem = 'Registro foi adicionado';
				} else {
					$mensagem = 'Erro ao adicionar';
				}
			}
		}
	} 

	$lista = array();
	if ($id > 0) {
		$query = mysqli_query($con, "SELECT * 
			FROM admins
			WHERE 
				adminID = $id
			LIMIT 1");

		$lista = mysqli_fetch_array($query); 
	} ?>

	<h2 class="painel-titulo"><?php echo isset($_GET['add']) ? 'Adicionar' : 'Editar'; ?></h2>

	<form action="<?php echo $action; ?>" method="POST">
		<div class="form-group">
			<label>Email</label>
			<input type="text" name="adminLogin" value="<?php echo isset($lista['adminLogin']) ? $lista['adminLogin'] : ''; ?>" class="form-control" />
		</div>

		<div class="form-group">
			<label>Senha (Preencha somente para alterar ou criar)</label>
			<input type="password" name="adminSenha" value="" class="form-control" />
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-block">Salvar alterações</button>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<button type="button" class="btn btn-primary btn-block" onclick="location.href='<?php echo $action = SITE_URL .'painel/?pg=usuarios'; ?>';">Volar</button>
				</div>
			</div>
		</div>
	</form>

	<?php
} else {

	if (isset($_GET['excluir'])) {
		$id = (int) $_GET['excluir'];
		if ($id > 0) {
			$query = mysqli_query($con, "DELETE FROM admins 
				WHERE
					adminID = $id
				LIMIT 1;");

			if ($query) {
				$mensagem = 'Registro foi removido';
			} else {
				$mensagem = 'Erro ao remover';
			}
		}
	}

	$query = mysqli_query($con, "SELECT * 
		FROM admins");

	$total = mysqli_num_rows($query); ?>

	<h2 class="painel-titulo"><?php echo $total; ?> - Admins</h2>

	<div class="painel-botoes">
		<a href="<?php echo SITE_URL .'painel/?pg=usuarios&add'; ?>" class="btn btn-primary">+ Admin</a>
	</div>

	<table class="table table-bordered">
	  	<tr>
	    	<th>Login</th>
	    	<th></th>
	  	<tr>

	  	<?php
	  	if ($total == 0) { ?>
	  		<tr>
	  			<td class="text-center" colspan="2"><i>Nenhum registro</i></td>
	  		</tr>
	  		<?php
	  	} else { 
	  		while ($lista = mysqli_fetch_array($query)) { ?>
			  	<tr>
			    	<td><?php echo $lista['adminLogin']; ?></td>
			    	<td width="110">
			    		<div class="btn-group">
			    			<a href="<?php echo SITE_URL .'painel/?pg=usuarios&edit='. $lista['adminID']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
			    			<a href="<?php echo SITE_URL .'painel/?pg=usuarios&excluir='. $lista['adminID']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
			    		</a>
			    	</td>
			  	</tr>
			  	<?php
			}
		} ?>
	<table>
	<?php
} 