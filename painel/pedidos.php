<?php

if (isset($_GET['view'])) {
	$pedidoID = (int) $_GET['view'];
	if ($pedidoID > 0) {
		if (isset($_POST['pedidoStatus'])) {
			$pedidoStatus = (int) $_POST['pedidoStatus'];
			if ($pedidoStatus > 0) {
				$query = mysqli_query($con, "UPDATE pedidos SET 
					pedidoStatus = '". $pedidoStatus  ."'
				WHERE
					pedidoID = $pedidoID
				LIMIT 1;") or die(mysqli_error($con));
			}
		}

		$query = mysqli_query($con, "SELECT * 
			FROM pedidos
			WHERE
				pedidoID = $pedidoID
			ORDER BY pedidoID DESC");

		$total = mysqli_num_rows($query);
		if ($total > 0) { 
			$lista = mysqli_fetch_array($query); ?> 

			<form action="" method="POST">
				<div class="form-group">
					<strong>Status</strong>
					<select name="pedidoStatus" class="form-control">
						<?php
						foreach (arrStatus() as $k => $v) {
							echo '<option value="'. $k .'" '. ($lista['pedidoStatus'] == $k ? 'selected' : '') .'>'. $v .'</option>';
						} ?>
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Salvar alteração</button>
				</div>
			</form>

			<div class="form-group">
				<strong>Código</strong><br />
				<?php echo $lista['pedidoCodigo']; ?>
			</div>

			<div class="form-group">
				<strong>Forma de Pagamento</strong><br />
				<?php echo $lista['pedidoPagamento']; ?>
			</div>

			<div class="form-group">
				<strong>Valor</strong><br />
				<?php echo $lista['pedidoValor']; ?>
			</div>

			<div class="form-group">
				<strong>Frete</strong><br />
				<?php echo $lista['pedidoFrete']; ?>
			</div>

			<div class="form-group">
				<strong>Data</strong><br />
				<?php echo date('d/m/Y H:i:s', strtotime($lista['pedidoData'])); ?>
			</div>

			<div class="form-group">
				<strong>Cliente</strong><br />
				<?php echo $lista['pedidoNome']; ?>
			</div>

			<div class="form-group">
				<strong>Email</strong><br />
				<?php echo $lista['pedidoEmail']; ?>
			</div>

			<div class="form-group">
				<strong>Telefone</strong><br />
				<?php echo $lista['pedidoTelefone']; ?>
			</div>

			<div class="form-group">
				<strong>CPF</strong><br />
				<?php echo $lista['pedidoCPF']; ?>
			</div>

			<div class="form-group">
				<strong>Endereço</strong><br />
				<?php echo $lista['pedidoEnderecoRua'] .', '. $lista['pedidoEnderecoNumero'] .' - '. $lista['pedidoEnderecoBairro'] .' - '. $lista['pedidoEnderecoCidade'] .' / '. $lista['pedidoEnderecoEstado'] .' - CEP: '. $lista['pedidoCEP'] .' - Complemento: '. $lista['pedidoEnderecoComplemento']; ?>
			</div>
			<?php
		}
	}
} else {
	if (isset($_GET['excluir'])) {
		$id = (int) $_GET['excluir'];
		if ($id > 0) {
			$query = mysqli_query($con, "DELETE FROM pedidos 
				WHERE
					pedidoID = $id
				LIMIT 1;");

			if ($query) {
				$mensagem = 'Produto foi removido';
				header("Location: ". SITE_URL.'/painel/?pg=pedidos');
			} else {
				$mensagem = 'Erro ao remover produto';
			}
		}
	}


	$query = mysqli_query($con, "SELECT * FROM pedidos ORDER BY pedidoData DESC");

  
$limit = 10;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  
  
$sql = "SELECT * FROM pedidos ORDER BY pedidoData DESC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($con, $sql);

	$total = mysqli_num_rows($query); ?>

	<h2 class="painel-titulo">Total de Pedidos: <?php echo $total; ?><span><a class="btn btn-primary" href="<?php echo SITE_URL ?>painel/?status=true">Atualizar Status</a><a class="btn btn-success" href="<?php echo SITE_URL ?>painel/?csv=true">Exportar CSV</a></span></h2>
	<div style="overflow: auto; width: 100%">
		<table class="table table-bordered table-striped">
			<tr>
				<th>Código</th>
				<th>ID MP</th>
				<th>Cliente</th>
				<th>Produto</th>
				<th>Valor</th>
				<th>Status</th>
				<th></th>
			<tr>

			<?php
			if ($total == 0) { ?>
				<tr>
					<td class="text-center" colspan="6"><i>Nenhum registro</i></td>
				</tr>
				<?php
			} else { 
				while ($lista = mysqli_fetch_array($rs_result)) { ?>
					<tr>
						<td width="80"><span class="label label-default"><?php echo $lista['pedidoCodigo']; ?></span></td>
						<td><?php echo $lista['pedidoIDMP']; ?></td>
						<td>
							<strong><?php echo $lista['pedidoNome']; ?></strong><br />
							<small>
								CPF: <?php echo $lista['pedidoCPF']; ?><br />
								<?php echo $lista['pedidoEmail']; ?><br />
								<?php echo $lista['pedidoTelefone']; ?>
							</small>
						</td>
						<td><?php echo $lista['pedidoProduto']; ?></td>
						<td><?php echo $lista['pedidoValor']; ?></td>
						<td><span class="label label-default"><?php 	
							$arrStatus = arrStatus();
							$statusID  = $lista['pedidoStatus'];

							echo $arrStatus[$statusID]; ?></span>
						</td>
						<td width="100">
							<div class="btn-group">
								<a href="<?php echo SITE_URL .'painel/?pg=pedidos&view='. $lista['pedidoID']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
								<a href="<?php echo SITE_URL .'painel/?pg=pedidos&excluir='. $lista['pedidoID']; ?>" onclick="return  confirm('Você quer mesmo excluir?')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
							</a>
						</td>
					</tr>
					
					<?php

				}
			} ?>
		</table>
	</div>
	<!--pagination  -->
	<?php  
			$total_pages = ceil($total / $limit);  
			$pagLink = "<ul class='pagination'>";  
			for ($i=1; $i<=$total_pages; $i++) {  
						$pagLink .= "<li><a href='?pg=pedidos&page=".$i."'>".$i."</a></li>";  
			};  
			echo $pagLink . "</ul>";  
		?>	
	<?php
}