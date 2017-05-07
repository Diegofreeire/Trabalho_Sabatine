<?php 
require_once("Principal.php");
	echo "Z = ";
	for ($i=0; $i < $_POST["variaveis"]; $i++) { 
			echo "<input type='text' name='x$i'> x$i";
	}

	echo "</br>Restrições</br>";

	for ($i=0; $i < $_POST["restricoes"]; $i++) { 
		for ($j=0; $j < $_POST["variaveis"]; $j++) { 
			echo "<input type='text' name='x$i'> x$i";
		}
			echo "<= <input type='text' name=''> </br>";
	}
 ?>

</body>
</html>