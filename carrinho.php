<!DOCTYPE>
<?php //Inclui arquivo php no projeto
session_start();

include("funcoes/funcoes.php");
?>

<html>
	<head>
		<title>Plataforma de Negociacao de Mercadorias</title> <!--Titulo do projeto-->
		
		
	<link rel="stylesheet" href="design/design.css" media="all" /> <!--Comando para integrar o design criado em css-->
	</head>
	
<body>
	<!--Estrutura-->
	<div class="main_wrapper"> <!--classe de divisão-->
	
		<!--Comeco do cabecalho-->
		<div class="header_wrapper">
		
			<a  href="index.php"><img id="logo" src="imagens/logo.jpg" /></a> <!--insere logo-->
			<img id="banner" src="imagens/ad_banner.gif" /> <!--Insere banner-->
		</div>
		<!--Fim do cabecalho-->
		
		<!--Comeco do Menu-->
		<div class="menubar">
		
			<ul id="menu">
				<li><a href="index.php">Inicio</a></li>
				<li><a href="produtos.php">Produtos</a></li>
				<li><a href="adm_area/inserir_produto.php">Vender</a></li>
				<li><a href="carrinho.php">Carrinho</a></li>
			
			
			</ul>
			
			<div id="form">
			<form method="get" action="resultados.php" enctype="multipart/form-data" >
				<input type="text" name="user_query" placeholder="Procurar produto" />
				<input type="submit" name="search" value="Procurar" />
			</form>
			
			</div>
		
		</div>
		<!--Fim do Menu-->
		
		<!--comeco da estrutura de conteúdo-->
		<div class="content_wrapper">
			
			<div id="sidebar">
			
				<div id="sidebar_title">Categorias</div>
				
				<ul id="produtos">
				
				<?php gettipos(); ?> <!--Chama funcão-->
				
				<ul>
			
			<div id="sidebar_title">Marcas e Editoras</div>
				
				<ul id="produtos">
				
					<?php getmarcas(); ?> 
					
			</div>
		
			<div id="content_area">
			<?php cart(); ?>
			<div id="shopping_cart">
			
					<span style="float:right; font-size:18px; padding:5px; line-height:40px;">
					
					Bem Vindo! <b style="color:yellow">Suas Compras-</b>Total de Itens: <?php total_items(); ?>  Preco: <?php total_price(); ?> <a href="carrinho.php" style="color:yellow"> Ir para Carrinho
					</a>
					
					</span>
			
			</div>
			
			
			<div id="content_box">
			
			<form action="" method="post" enctype="multipart/form-data">
			
			<table align="center" width="700" bgcolor="skyblue">
				
				<tr align="center">
					<th>Remover</th>
					<th>Produto(s)</th>
					<th>Quantidade</th>
					<th>Preco Unitario</th>
				
				
				
				</tr>
				
				<?php
	$total = 0;
	
	global $con;
	
	$ip = getIp();
	
	$sel_price = "select * from cart where ip_add='$ip'";
	
	$run_price = mysqli_query($con, $sel_price);
	
	
	while($p_price=mysqli_fetch_array($run_price)){
		
		$pro_id = $p_price['p_id'];
		$pro_qtd = $p_price['qty'];
		
		$pro_price = "select * from produtos where codigo_produto='$pro_id'";
		
		$run_pro_price = mysqli_query($con, $pro_price);
		
		while ($pp_price = mysqli_fetch_array($run_pro_price)){
			
		$product_price = array($pp_price['preco_produto']);	
		
		$product_title = $pp_price['titulo_produto'];
		
		$product_image = $pp_price['imagem_produto'];
		
		$single_price = $pp_price['preco_produto'];
		
		
		$values = array_sum($product_price);
		
		$total += $values * $pro_qtd ;
	
	            ?>
				
				<tr align="center">
					<td><input type="checkbox" name="remover[]" value="<?php echo $pro_id; ?>"/></td>
					<td><?php echo $product_title; ?><br>
					<img src="adm_area/imagem_produtos/<?php echo $product_image;?>" width="100" height="100"/>
					</td>
					<td><input type="text" size="4" name="qty" value="<?php echo $pro_qtd;?>"/></td>
					
					<?php
					if(isset($_POST['update_cart'])){
						
						$qty = $_POST['qty'];
						$ip = getIp();
						$update_qty = "update cart set qty='$qty' where p_id='$pro_id' and ip_add='$ip'";
						
						$run_qty = mysqli_query($con, $update_qty);
						
						$_SESSION ['qty'] = $qty;
						
						$total = $total*$qty;
						echo "<script>window.open('carrinho.php','_self')</script>";
						 
						
						
					}
					
					if(isset($_POST['finalizar'])){
						
						attcarrinho();
					}
					
					
					?>
					<td><?php echo "R$" . $single_price; ?></td>
				</tr>
				
				
				
				
	            <?php } } ?>
		
				<tr align="right">
					<td colspan="4"><b>Subtotal:</b></td>
					<td colspan="4"><?php echo  "R$" . $total; ?></td>
				</tr>
				
				<tr align="center">
					<td colspan="0"><input type="submit" name="removerb" value="Remover"/></td>
					<td colspan="0"><input type="submit" name="update_cart" value="Atualizar Quantidade"/></td>
					<td><input type="submit" name="continue" value="Continuar Comprando"/></td>
					<td colspan="0"><input type="submit" name="finalizar" value="Finalizar"/></td>
				</tr>
				
				
			</table>
			
			
			</form>
			
			<?php

			
			
			
			$ip = getIp();
			
			if(isset($_POST['removerb']  )){
			 
			 foreach($_POST['remover'] as $remove_id){
				
				 $delete_product="delete from cart where p_id='$remove_id' AND ip_add='$ip'";
				
				 $run_delete = mysqli_query($con, $delete_product);
				
				
				 if($run_delete) {
					
					 echo "<script>window.open('carrinho.php','_self')</script>";
					
				    }
			    }
		    }
			
			if(isset($_POST['continue'])){
				
			 echo "<script>window.open('index.php','_self')</script>";
			
			}
			

		
			?>
			
			</div>
			</div>
		</div>
		<!--Fim da estrutura de conteúdo-->
		
		
		
		<div id="footer">
		
		<h2 style="text-align:center; padding-top:30px;">&copy; 2016 by Plataforma de Negociacao de Mercadorias</h2> 
		
		</div>
		
	</div>
<!--Fim da Estrutura-->


</body>
</html>