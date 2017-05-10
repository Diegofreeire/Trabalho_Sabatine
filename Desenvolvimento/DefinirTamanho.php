<?php
	include"Principal.html";
?>
	<div class="container">
		<section class="tabelaRestricao">
			<form method="POST" action="SimplexMaximizando.php">
				<?php
				echo "Z = ";
				for ($i=0; $i < $_POST["variaveis"]; $i++) {
						echo "<input type='text' name='x$i' id='x$i'> x$i";
				}

				echo "</br>Restrições</br>";
					for ($i=0; $i < $_POST["restricoes"]; $i++) {
						for ($j=0; $j < $_POST["variaveis"]; $j++) {
							echo "<input type='text' name='x$i$j'> x$j";
						}
							echo "<= <input type='text' name='b$i' id='b$i' > </br>";
					}
			 ?>
			<input type="hidden" name="variaveis" value="<?=$_POST['variaveis']?>">
			<input type="hidden" name="restricoes" value="<?=$_POST['restricoes']?>">
			 <input type="submit" name="" class="btn btn-primary">
			</form>
		</section>
	</div>
</body>
</html> 