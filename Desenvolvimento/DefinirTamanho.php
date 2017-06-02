<?php
	include"Principal.php";
?>
	<div class="container" >
		<section class="tabelaRestricao">
			<form method="POST" action="SimplexMaximizando.php" class="form-inline">
				<select class="form-control" required="required" name="objetivo[]">\
					<optgroup label="Objetivo é:">\
						<option value="1">Maxmizar</option>\
						<option value="2">Minimizar</option>\
					</optgroup>\
				</select>
				<?php
				echo "Z = ";
				for ($i=0; $i < $_POST["variaveis"]; $i++) {
						echo "<input type='number' class='form-control' required='required' name='x$i' id='x$i'>x$i ";
				}
				
				echo "</br>Restrições :</br>";
					for ($i=0; $i < $_POST["restricoes"]; $i++) {
						for ($j=0; $j < $_POST["variaveis"]; $j++) {
							echo "<input type='number' class='form-control' name='x$i$j'>x$j ";
						}
							echo "<= <input type='number' class='form-control' required='required' name='b$i' id='b$i' > </br>";
					}
			 ?>
			Quantidade máxima de iterações:
			<input type="number" name="limitacao" value="20">
			Solução direta: 
			<input type="hidden" name="direto" value="0">
			<input type="checkbox" name="direto" value="1">
			<input type="hidden" name="variaveis" value="<?=$_POST['variaveis']?>" class="variaveis">
			<input type="hidden" name="restricoes" value="<?=$_POST['restricoes']?>" class="restricoes1"> 
			<input type="submit" name="" class="next">
			</form>
			<button type="" class="back">Voltar</button>
		</section>
	</div>
</body>
</html> 