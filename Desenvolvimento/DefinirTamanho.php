<?php
	include"TelaPrincipal.html";
?>
	<div class="container" >
		<section class="tabelaRestricao">
			<form method="POST" action="SimplexMaximizando.php" class="form-inline">
				<?php
				echo "Z = ";
				for ($i=0; $i < $_POST["variaveis"]; $i++) {
						echo "<input type='text' class='form-control' name='x$i' id='x$i'>x$i ";
				}

				echo "</br>Restrições :</br>";
					for ($i=0; $i < $_POST["restricoes"]; $i++) {
						for ($j=0; $j < $_POST["variaveis"]; $j++) {
							echo "<input type='text' class='form-control' name='x$i$j'>x$j ";
						}
							echo "<= <input type='text' class='form-control' name='b$i' id='b$i' > </br>";
					}
			 ?>
			<input type="hidden" name="variaveis" value="<?=$_POST['variaveis']?>" class="variaveis">
			<input type="hidden" name="restricoes" value="<?=$_POST['restricoes']?>" class="restricoes1"> 
			<input type="submit" name="" class="next">
			</form>
			<button type="" class="back">Voltar</button>
		</section>
	</div>
</body>
</html> 