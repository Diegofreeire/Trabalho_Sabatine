<form method="POST" action="SimplexMaximizando.php">
	<?php 
require_once("Principal.php");
	echo "Z = ";
	for ($i=0; $i < $_POST["variaveis"]; $i++) { 
			echo "<input type='text' name='x$i'> x$i";
	}

	echo "</br>Restrições</br>";

	for ($i=0; $i < $_POST["restricoes"]; $i++) { 
		for ($j=0; $j < $_POST["variaveis"]; $j++) { 
			echo "<input type='text' name='x$j' id='x$i$j'> x$j";
		}
			echo "<= <input type='text' name='' id='b$i%j'> </br>";
	}
 ?>

 <input type="submit" name="" class="btn btn-primary">
</form>


</body>
</html> 