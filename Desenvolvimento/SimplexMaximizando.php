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
$b = array();
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

$pivo["linha"] = $linha;
$pivo["coluna"] = $coluna;




$continuar = true;
while($continuar){

	//condição de parada por solução ótima da linha de Z
	foreach ($vetor["z"] as $v => $c) {
		if($c < 0){
			$continuar = true;
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
	<?php var_dump($b); ?>
<h1>Vetor Pivo</h1>	
	<?= var_dump($pivo)?>

</pre>

</body>
</html>