<?php

$con = mysqli_connect("mysql.hostinger.com.br","u403052679_proj","ninosuzy","u403052679_proj"); //conexão do banco de dados 

if (mysqli_connect_errno())
 {
	echo "Falha ao conectar com MySQL" . mysqli_connect_error();
 }
 
 function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}
 
 
 
 function cart(){
	
	if(isset($_GET['add_cart'])){

	global $con;
	
	$ip = getIp();
	
	$pro_id = $_GET['add_cart'];
	
	$check_pro = "select * from cart where ip_add='$ip' AND p_id='$pro_id'";
	
	
	$run_check = mysqli_query($con, $check_pro);
	
	if(mysqli_num_rows($run_check)>0){
	
	echo "";
		
	}
	else{
	
	$insert_pro = "insert into cart (p_id,ip_add,qty)values('$pro_id','$ip',1)";
		
	$run_pro = mysqli_query($con, $insert_pro);
	
	echo "<script>window.open('index.php','_self')</script>";
	
	}
	
}  
if(isset($_GET['pro_id'])){
	global $con;
	
	$ip = getIp();
	
	$pro_id = $_GET['pro_id'];
	
	$check_pro = "select * from cart where ip_add='$ip' AND p_id='$pro_id'";
	
	$run_check = mysqli_query($con, $check_pro);
	
	if(mysqli_num_rows($run_check)>0){
	
	echo "";
		
	}
	else{
	
	$insert_pro = "insert into cart (p_id,ip_add,qty)values('$pro_id','$ip',1)";
		
	$run_pro = mysqli_query($con, $insert_pro);
	
	echo "<script>window.open('index.php','_self')</script>";
	
	}
	
}  
 
} 

//total de itens
function total_items(){
	
	if(isset($_GET['add_cart'])){
		
		global $con;
		
		$ip = getIp();
		
		$get_items = "select * from cart where ip_add='$ip'";
		
		$run_items = mysqli_query($con, $get_items);
		
		$count_items = mysqli_num_rows($run_items);
		}
		
		else{
			global $con;
			
			$ip = getIp();
		
		$get_items = "select * from cart where ip_add='$ip'";
		
		$run_items = mysqli_query($con, $get_items);
			
		$count_items = mysqli_num_rows($run_items);	
			
			
		}
		
		
	echo $count_items;	
	}

// Armazenando preco dos itens no carrinho

function total_price(){
	
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
			
		$values = array_sum($product_price);
		
		$total +=$values * $pro_qtd;
		
		}
		
		}
		
		echo "R$" . $total;
		
		
		
		
	}
	
	
	
	

	
	
	
	
	


//Pegando as categorias

function gettipos(){
	
	global $con;
	
	$get_tipos = "select * from tipos"; //armazena o valor da tabela na variável 
	
	$run_tipos = mysqli_query($con, $get_tipos);
	
	while($row_tipos=mysqli_fetch_array($run_tipos)){
		
		$id_tipo = $row_tipos['id_tipo']; //armazena o valor da coluna na variável
		$titulo_tipo = $row_tipos['titulo_tipo'];//armazena o valor da coluna na variável
	
	echo "<li><a href='index.php?tipo=$id_tipo'>$titulo_tipo</a></li>";//exibe o conteudo encontrado nas colunas
	}
}
	
//Pegando as marcas

function getmarcas(){
	
	global $con;
	
	$get_marcas = "select * from marcas"; //armazena o valor da tabela na variável 
	
	$run_marcas = mysqli_query($con, $get_marcas);
	
	while($row_marcas=mysqli_fetch_array($run_marcas)){
		
		$id_marca = $row_marcas['id_marca']; //armazena o valor da coluna na variável
		$titulo_marca = $row_marcas['titulo_marca'];//armazena o valor da coluna na variável
	
	echo "<li><a href='index.php?marca=$id_marca'>$titulo_marca</a></li>";//exibe o conteudo encontrado nas colunas
	}
	
	
}

function getPro(){
	
	if(!isset($_GET['tipo'])){
		if(!isset($_GET['marca'])){	
	global $con;
	
	$get_pro = "select * from produtos  where quantidade_produto > 0 order by RAND() LIMIT 0,4";
	
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
				
				<p><b> Preco:R$ $pro_preco </b></p>
				
				<a href='detalhes.php?pro_id=$pro_id' style='float:left;'>Detalhes</a>
				<a href='index.php?add_cart=$pro_id'><button style='float:right'>Add ao Carrinho</button></a>
				
			
			</div>
		
		
		";
		
		
		
	}
	}
	
	
	
	}	
}

function attcarrinho(){
	
		$ipca = getIp();
	
	global $con;
	
	$get_proc = "select * from cart where ip_add = '$ipca'";
	
	
	
	$run_proc = mysqli_query($con, $get_proc);
	
	
	while($row_proc=mysqli_fetch_array($run_proc)){
		
		$pro_idc = $row_proc['p_id'];
		$pro_quantidadec = $row_proc['qty'];
		
						
		$update_qtyc ="update produtos set quantidade_produto = quantidade_produto - '$pro_quantidadec' where codigo_produto = '$pro_idc'";
						
		$run_qtyc = mysqli_query($con, $update_qtyc);
	}
	
	$update_qtyc ="delete from cart where ip_add = '$ipca'";
						
		$run_qtyc = mysqli_query($con, $update_qtyc);
						
	echo"<script>alert('Compra realizada com sucesso!')</script>";
} 

function getTipoPro(){
	
	if(isset($_GET['tipo'])){
		
		$cat_id = $_GET['tipo'];
	
	global $con;
	
	$get_tipo_pro = "select * from produtos where tipo_produto = '$cat_id' and quantidade_produto > 0";
	
	$run_tipo_pro = mysqli_query($con, $get_tipo_pro);
	
	$count_tipos = mysqli_num_rows($run_tipo_pro);
	

	
	while($row_tipo_pro=mysqli_fetch_array($run_tipo_pro)){
		
		$pro_id = $row_tipo_pro['codigo_produto'];
		$pro_tipo = $row_tipo_pro['tipo_produto'];
		$pro_titulo = $row_tipo_pro['titulo_produto'];
		$pro_quantidade = $row_tipo_pro['quantidade_produto'];
		$pro_preco = $row_tipo_pro['preco_produto'];
		$pro_imagem = $row_tipo_pro['imagem_produto'];
		
			if($count_tipos==0){
		
				echo"
			<h2>Nenhuma produto nessta categoria</h2>";
	
			}
	else{
		
		echo"
			 <div id='single_product'>
			
				<h3>$pro_titulo</h3>
				
				<img src='adm_area/imagem_produtos/$pro_imagem' width='180' height='180' />
				
				<p><b> Preco:R$ $pro_preco </b></p>
				
				<a href='detalhes.php?pro_id=$pro_id' style='float:left;'>Detalhes</a>
				<a href='index.php?pro_id=$pro_id'><button style='float:right'>Add ao Carrinho</button></a>
			</div>
	    ";
		}
		
		
	}
	
	
	
	
	}	
}

function getMarcaPro(){
	
	if(isset($_GET['marca'])){
		
		$marca_id = $_GET['marca'];
	
	global $con;
	
	$get_marca_pro = "select * from produtos where marca_produto= '$marca_id' and quantidade_produto > 0";
	
	$run_marca_pro = mysqli_query($con, $get_marca_pro);
	
	$count_marcas = mysqli_num_rows($run_marca_pro);
	

	
	while($row_marca_pro=mysqli_fetch_array($run_marca_pro)){
		
		$pro_id = $row_marca_pro['codigo_produto'];
		$pro_tipo = $row_marca_pro['tipo_produto'];
		$pro_titulo = $row_marca_pro['titulo_produto'];
		$pro_quantidade = $row_marca_pro['quantidade_produto'];
		$pro_preco = $row_marca_pro['preco_produto'];
		$pro_imagem = $row_marca_pro['imagem_produto'];
		
			if($count_marcas==0){
		
				echo"
			<h2>Nenhuma produto nessta categoria</h2>";
	
			}
	else{
		
		echo"
			 <div id='single_product'>
			
				<h3>$pro_titulo</h3>
				
				<img src='adm_area/imagem_produtos/$pro_imagem' width='180' height='180' />
				
				<p><b> Preco:R$ $pro_preco </b></p>
				
				<a href='detalhes.php?pro_id=$pro_id' style='float:left;'>Detalhes</a>
				<a href='index.php?pro_id=$pro_id'><button style='float:right'>Add ao Carrinho</button></a>
			</div>
	    ";
		}
		
		
	}
	
	
	
	
	}	
}















?>