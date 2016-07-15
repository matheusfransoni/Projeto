<!DOCTYPE>

<?php

include("includes/db.php");

?>
<html>
	<head>
		<title>Inserir Produto</title>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector:'textarea' });</script>
	</head>

<body bgcolor="skyblue">

	<form action="inserir_produto.php" method="post" enctype="multipart/form-data">
	
		<table align="center" width="600" border="2" bgcolor="orange">
		
			<tr align="center">
				<td colspan="7"><h2>Inserir novo produto aqui</h2></td>
            </tr>
			
			<tr>
				<td align="right"><b> Tipo do Produto:</b></td>
				<td>
				<select name="tipo_produto" required>
				<option>Selecione o tipo desejado</option>
				<?php
				$get_tipos = "select * from tipos"; //armazena o valor da tabela na variável 
	
				$run_tipos = mysqli_query($con, $get_tipos);
	
				while($row_tipos=mysqli_fetch_array($run_tipos)){
		
					$id_tipo = $row_tipos['id_tipo']; //armazena o valor da coluna na variável
					$titulo_tipo = $row_tipos['titulo_tipo'];//armazena o valor da coluna na variável
	
					echo "<option value='$id_tipo'>$titulo_tipo</option>";//exibe o conteudo encontrado nas colunas
				}
				
				?>
				
				</select>
				</td>
			</tr>
			
			<tr>
				<td align="right"><b>Nome do Produto:</b></td>
				<td><input type ="text" name="titulo_produto" required/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Quantidade do Produto:</b></td>
				<td><input type ="text" name="quantidade_produto" required/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Preco do Produto:</b></td>
				<td><input type ="text" name="preco_produto" required/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Descricão do Produto:</b></td>
				<td><textarea name="descricao_produto" cols="20" rows="10" /></textarea></td>
			</tr>
			
			<tr>
				<td align="right"><b>Marca do produto:</b></td>
				<td>
				<select name="marca_produto" required>
				<option>Selecione a marca </option>
				<?php
				$get_marcas = "select * from marcas"; //armazena o valor da tabela na variável 
	
				$run_marcas = mysqli_query($con, $get_marcas);
	
				while($row_marcas=mysqli_fetch_array($run_marcas)){
					$id_marca = $row_marcas['id_marca']; //armazena o valor da coluna na variável
					$titulo_marca = $row_marcas['titulo_marca'];//armazena o valor da coluna na variável
	
					echo "<option value='$id_marca'>$titulo_marca</option>";//exibe o conteudo encontrado nas colunas
					
				}
				
				?>
				
				</select>
				
				</td>
			</tr>
			
			<tr>
				<td align="right"><b>Imagem do Produto:</b></td>
				<td><input type ="file" name="imagem_produto" required/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Palavras Chave:</b></td>
				<td><input type ="text" name="palavraschave_produto" required/></td>
			</tr>
			
			<tr align="center">
				<td colspan="7"><input type ="submit" name="insert_post" value="Enviar" /></td>
			</tr>
			
			

			

			


        
		</table>
		
	</form>
</body>	
</html>

<?php

	if(isset($_POST['insert_post'])){
	
		//Armazenado o texto dos campos
		$tipo_produto = $_POST['tipo_produto'];
		$titulo_produto = $_POST['titulo_produto'];
		$quantidade_produto = $_POST['quantidade_produto'];
		$preco_produto = $_POST['preco_produto'];
		$descricao_produto = $_POST['descricao_produto'];
		$palavraschave_produto = $_POST['palavraschave_produto'];
		$marca_produto = $_POST['marca_produto'];
		
		//Armazenando imagem do campo
		$imagem_produto = $_FILES['imagem_produto']['name'];
		$imagem_produto_tmp = $_FILES['imagem_produto']['tmp_name'];
		
		move_uploaded_file($imagem_produto_tmp,"imagem_produtos/$imagem_produto");
		
		$inserir_produto = "insert into produtos 
		(tipo_produto,titulo_produto,quantidade_produto,preco_produto,descricao_produto,imagem_produto,palavraschave_produto, marca_produto) values 
		('$tipo_produto','$titulo_produto','$quantidade_produto','$preco_produto','$descricao_produto','$imagem_produto','$palavraschave_produto','$marca_produto')";
		
		$inserir_pro = mysqli_query($con, $inserir_produto);
		
		if($inserir_pro){
			
		echo"<script>alert('Produto salvo com sucesso')</script>";
		echo"<script>window.open('inserir_produto.php','_self')</script>";
			
		}
		
	
	
	
	
	}
?>