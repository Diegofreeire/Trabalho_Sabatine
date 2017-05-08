<?php 
$vetor = array();
for ($i=0; $i < $_POST['restricoes']; $i++) { 
	for ($j=0; $j < $_POST["variaveis"]; $j++) { 
		array_push($vetor, array("x$i" => $_POST["x$i$j"]));
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
<?php var_dump($vetor); ?>
</body>
</html>