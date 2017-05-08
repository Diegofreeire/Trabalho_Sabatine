<?php 
$vetor = array();
for ($i=0; $i < $_POST['restricoes']; $i++) { 
	for ($j=0; $j < $_POST["variaveis"]; $j++) {
		$vetor["x$j"]["$i"] = $_POST["x$i$j"];
	}	
}

for ($i=count($vetor), $n = 0; $n < $_POST['restricoes']; $i++, $n++) { 
	for ($j=0; $j < $_POST["restricoes"]; $j++) {
		if ($j == $n) {
			$vetor["x$i"]["$j"] = 1;
		}else{
			$vetor["x$i"]["$j"] = 0;
		}		
	}
}
$tamanhoVetor = (count($vetor));
for ($i=0; $i < $_POST['restricoes']; $i++) { 
	for ($j=0; $j < $_POST["restricoes"]; $j++) {
		for ($k=0; $k < $tamanhoVetor; $k++) {
			if ($j == $i) {
				$vetor["l$i"]["$k"] = $vetor["x$k"]["$j"];
			}	
		}
	}	
}

$continuar = true;
//while($continuar){


	/*$vetor = array("x0" => array(1,2,-3),
		"x1" => array(1,2,-4),
		"x2" => array(1,2,-5),
		"x3" => array(1,0,0),
		"x4" => array(0,1,0));
	for ($i=0; $i < (count($vetor)-1) ; $i++) { 
		$vetor["z"]["$i"] = $vetor["x$i"][2];
	}

	//condição de parada por solução ótima da linha de Z
	/*foreach ($vetor["z"] as $v => $c) {
		if($c < 0){
			$continuar = true;
		}else{
			$continuar = false;
		}
	}*/

//}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<pre>
	<?php var_dump($vetor); ?>
</pre>

</body>
</html>