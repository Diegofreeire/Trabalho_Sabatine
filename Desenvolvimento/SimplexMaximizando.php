<?php 
$vetor = array();
for ($i=0; $i < $_POST['restricoes']; $i++) {//pegar os valores das restrições
	for ($j=0; $j < $_POST["variaveis"]; $j++) {
		$vetor["x$j"]["$i"] = $_POST["x$i$j"];
	}
}

$j;
for ($i=count($vetor), $n = 0; $n < $_POST['restricoes']; $i++, $n++) { //gerar valores das variaveis de folga
	for ($j=0; $j < $_POST["restricoes"]; $j++) {
		if ($j == $n) {
			$vetor["x$i"]["$j"] = 1;
		}else{
			$vetor["x$i"]["$j"] = 0;
		}
	}
}

$tamanhoVetor = (count($vetor));//pegar o tamanho do vetor apenas com as variaveis, sem a base

for ($i=0; $i < $_POST['restricoes']; $i++) {//pegando valores da coluna b
	$vetor["b"]["$i"] = $_POST["b$i"];
}

for ($i=0; $i < $_POST["variaveis"]; $i++) { //pegar valores de z
	$vetor["z"]["$i"] = $_POST["x$i"] * -1;
}

for ($i=count($vetor["z"]); $i < $tamanhoVetor; $i++) { //completar as colunas valores de Z com 0
	$vetor["z"]["$i"] = 0;
}	

for ($i=0; $i < $_POST['restricoes']; $i++) { //gerando as linhas
	for ($j=0; $j < $_POST["restricoes"]; $j++) {
		for ($k=0; $k < $tamanhoVetor; $k++) {
			if ($j == $i) {
				$vetor["l$i"]["$k"] = $vetor["x$k"]["$j"];
			}	
		}
	}	
}
$b = array();

$continuar = true;
while($continuar){
	//pegar coluna do pivo
	$a = min($vetor["z"]);

	$coluna;
	for ($i=0; $i < $vetor["z"]; $i++) {
		if($a == $vetor["z"]["$i"]){
			$coluna = $i;
			break;
		}
	}
	//multiplicar coluna do pivo por b

	for ($i=0; $i < count($vetor["b"]); $i++) { 
		$b[$i] = $vetor["b"]["$i"] * $vetor["x$coluna"]["$i"];
	}
	//pegar linha do pivo
	$colunaB = min($b);
	$linha;
	for ($i=0; $i < $b; $i++) {
		if($colunaB == $b["$i"]){
			$linha = $i;
			break;
		}
	}

	//Pivo
	$pivoLinha = $linha;
	$pivoColuna = $coluna;
	$valorPivo = $vetor["l$pivoLinha"]["$pivoColuna"];

	//realizar cálculo da linha do pivo
	for ($i=0; $i < count($vetor["z"]); $i++) { 
		$vetor["l$pivoLinha"]["$i"] = $valorPivo;
	}

	//anular os valores da coluna do pivo linha * - valor da coluna do pivo
	$valorColunaPivo;

	for ($i=0; $i < count($vetor["x0"])-1; $i++) { 
		if("l$i" != "l$pivoLinha")
		{
			$valorColunaPivo = $vetor["l$i"]["$pivoColuna"];
			if ($valorColunaPivo != 0) {
				for ($j=0; $j < count($vetor["z"]); $j++) { 
					$vetor["l$i"]["$j"] = ($vetor["l$pivoLinha"]["$j"] * (-($valorColunaPivo))) + $vetor["l$i"]["$j"];
				}
			}		
		}
	}
	for ($i=0; $i < count($vetor["x0"])-1; $i++) { 
		$valorColunaPivo = $vetor["z"]["$pivoColuna"];
		if ($valorColunaPivo != 0) {
			for ($j=0; $j < count($vetor["z"]); $j++) { 
				$vetor["z"]["$j"] = ($vetor["l$pivoLinha"]["$j"] * (-($valorColunaPivo))) + $vetor["z"]["$j"];
			}
		}
	}

	//condição de parada por solução ótima da linha de Z
	foreach ($vetor["z"] as $v => $c) {
		if($c < 0){
			$continuar = true;
			break;
		}else{
			$continuar = false;
		}
	}

}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<pre>
<h1>Vetor Posicoes</h1>	
	<?php var_dump($vetor); ?>
<h1>Vetor Base</h1>	
<h1>Vetor Pivo</h1>	
	<?= var_dump($pivo)?>

</pre>

</body>
</html>