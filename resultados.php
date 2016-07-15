<!DOCTYPE>
<?php //Inclui arquivo php no projeto
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
				<li><a href="#">Minha conta</a></li>
				<li><a href="adm_area/inserir_produto.php">Vender</a></li>
				<li><a href="cart.php">Carrinho</a></li>
				<li><a href="#">Contato</a></li>
			
			
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
			
			<div id="shopping_cart">
			
					<span style="float:right; font-size:18px; padding:5px; line-height:40px;">
					
					Bem Vindo! <b style="color:yellow">Suas Compras-</b>Total de Itens: <?php total_items(); ?>  Preco: <?php total_price(); ?> <a href="carrinho.php" style="color:yellow"> Ir para Carrinho
					</a>
					
					</span>
			
			</div>
			<div id="content_box">
			<?php
			
			if(isset($_GET['search'])){
				
			$search_query = $_GET['user_query'];
			
			
		$get_pro = "select * from produtos where palavraschave_produto like'%$search_query%'";
	
	$run_pro = mysqli_query($con, $get_pro);
	
	while($row_pro=mysqli_fetch_array($run_pro)){
		
		$pro_id = $row_pro['codigo_produto'];
		$pro_tipo = $row_pro['tipo_produto'];
		$pro_titulo = $row_pro['titulo_produto'];
		$pro_quantidade = $row_pro['quantidade_produto'];
		$pro_preco = $row_pro['preco_produto'];
		$pro_imagem = $row_pro['imagem_produto'];
		
		echo"
			<div id='single_product'>
			
				<h3>$pro_titulo</h3>
				
				<img src='adm_area/imagem_produtos/$pro_imagem' width='180' height='180' />
				
				<p><b> R$ $pro_preco </b></p>
				
				<a href='detalhes.php?pro_id=$pro_id' style='float:left;'>Detalhes</a>
				<a href='index.php?pro_id=$pro_id'><button style='float:right'>Add ao Carrinho</button></a>
				
			
			</div>
			";
		
		
	    }	
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