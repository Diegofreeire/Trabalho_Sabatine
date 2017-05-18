<?php 
$vetor = array();
$base = array();
//pegar os valores das restrições, os valores das variáveis X
$i;
for ($i=0; $i < $_POST['restricoes']; $i++) {
	for ($j=0; $j < $_POST["variaveis"]; $j++) {
		$vetor["x$j"]["$i"] = $_POST["x$i$j"];
	}
}

//pegando valores de Z nas colunas
$k;
$j;
for ($j=0; $j < $_POST["variaveis"]; $j++) { 
	if($vetor["x$j"]){		
		for ($k=0; $k < $_POST['variaveis']; $k++) {
			if ($_POST["x$k"]) {
				if ($k == $j) {
					$vetor["x$j"]["$i"] = $_POST["x$k"];
				}				
			}
			else
				$vetor["x$j"]["$i"] = 0;
		}
	}
}

$qtdNaoBasicas = count($vetor);//variaveis da solução

//gerar valores das variaveis de folga, valores das variáveis F, porém para melhor implementação continuara com X
for ($i = $qtdNaoBasicas, $n = 0; $n < $_POST['restricoes']; $i++, $n++) {
	$base["$i"] = "x$i";
	for ($j=0; $j < $_POST["restricoes"]+1; $j++) {
		if ($j == $n) {
			$vetor["x$i"]["$j"] = 1;
		}else{
			$vetor["x$i"]["$j"] = 0;
		}
	}
}
var_dump($base);
//pegar o tamanho do vetor apenas com as variaveis, sem b
$tamanhoVetor = (count($vetor));

//pegando valores da coluna b, será o último X dentor do vetor
for ($i=0; $i < $_POST['restricoes']; $i++) {
	$vetor["x$tamanhoVetor"]["$i"] = $_POST["b$i"];
}	

$vetor["x$tamanhoVetor"]["$i"] = "0";
$colunaB = $tamanhoVetor;
$tamanhoSolucao = count($vetor);
$tamanhoColuna = count($vetor["x0"]);

//gerando as linhas da tabela com que vai se trabalhar
//ultima linha a de Z
$tamanhoLinha = $_POST['restricoes'] + 1;
for ($i=0; $i < $tamanhoSolucao; $i++) { 
	for ($j=0; $j < $tamanhoLinha; $j++) {
		$k=0;
		for ($k=0; $k < $tamanhoSolucao; $k++) {
			if ($j == $i) {
				$vetor["l$i"]["$k"] = $vetor["x$k"]["$j"];
			}	
		}
	}
}
//negativar a linha de Z

$i;
$linhaZ = $tamanhoLinha - 1;

for ($j=0; $j < count($vetor["l$linhaZ"])-1; $j++) { 
	$vetor["l$linhaZ"]["$j"] = $vetor["l$linhaZ"]["$j"] * -1;
}

	for ($i=0; $i < count($vetor["l$linhaZ"]) - 1; $i++) { 
		if($vetor["l$linhaZ"]["$i"] < 0){
			$continuar = true;
			break;
		}else{
			$continuar = false;
		}
	}

while($continuar){
	//pegar coluna do pivo
	$a = $vetor["l$linhaZ"]["0"];

	$coluna;
	for ($i=0; $i < count($vetor["l$linhaZ"])-1; $i++) {
		if(($a >= $vetor["l$linhaZ"]["$i"]) && $vetor["l$linhaZ"]["$i"] < 0){
			$a = $vetor["l$linhaZ"]["$i"];
			$coluna = $i;
		}
	}

	$b = array();
	//multiplicar coluna do pivo por b
	for ($i=0; $i < count($vetor["x$colunaB"]); $i++) { 
		$b["$i"] = $vetor["l$i"]["$coluna"] * $vetor["l$i"]["$colunaB"];
		var_dump($vetor["l$i"]["$coluna"]);
	}
	var_dump($b);

	//pegar linha do pivo
	$cB = $b["0"];
	$linha;
	for ($i=0; $i < count($b)-1; $i++) {
		if(($cB <= $b["$i"]) && $cB > 0){
			$cB = $b["$i"];
			$linha = $i;
		}
	}
	echo "$cB";


	//Pivo
	$pivoLinha = $linha;
	$pivoColuna = $coluna;
	$valorPivo = $vetor["l$pivoLinha"]["$pivoColuna"];
	echo "$valorPivo";
	echo "$pivoColuna";
	echo "$pivoLinha";
	echo "$linhaZ";
	//realizar cálculo da linha do pivo
	for ($i=0; $i < count($vetor["l$linhaZ"]); $i++) { 
		$vetor["l$pivoLinha"]["$i"] = $vetor["l$pivoLinha"]["$i"]/$valorPivo;
	}

	//anular os valores da coluna do pivo linha * - valor da coluna do pivo + valor da linha
	$valorColunaPivo;

	for ($i=0; $i < count($vetor["x0"]) ; $i++) { 
		if("l$i" != "l$pivoLinha")
		{
			$valorColunaPivo = $vetor["l$i"]["$pivoColuna"];
			echo "$valorColunaPivo";
				for ($j=0; $j < count($vetor["l$linhaZ"]); $j++) { 
					$vetor["l$i"]["$j"] = (($vetor["l$pivoLinha"]["$j"] * (-($valorColunaPivo))) + $vetor["l$i"]["$j"]);
			}		
		}
	}
	for ($i=0; $i < count($vetor["x0"]); $i++) {
		$valorColunaPivo = $vetor["l$linhaZ"]["$pivoColuna"];
		if ($valorColunaPivo != 0) {
			for ($j=0; $j < count($vetor["l$linhaZ"]); $j++) {
				$vetor["l$linhaZ"]["$j"] = ($vetor["l$pivoLinha"]["$j"] * (-($valorColunaPivo))) + $vetor["l$linhaZ"]["$j"];
			}
		}
	}

	//condição de parada por solução ótima da linha de Z
	for ($i=0; $i < count($vetor["l$linhaZ"]) - 1; $i++) { 
		if($vetor["l$linhaZ"]["$i"] < 0){
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
<h1>Vetor B</h1>	
<h1>Vetor Pivo</h1>	

</pre>

</body>
</html>

<?php

/*
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
*/ ?>