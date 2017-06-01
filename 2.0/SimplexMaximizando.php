<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
include"TelaPrincipal.html";
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
	$base["$n"] = "x$i";//base recebendo as variáveis iniciais
	for ($j=0; $j < $_POST["restricoes"]+1; $j++) {
		if ($j == $n) {
			$vetor["x$i"]["$j"] = 1;
		}else{
			$vetor["x$i"]["$j"] = 0;
		}
	}
}

//pegar o tamanho do vetor apenas com as variaveis, sem b
$tamanhoVetor = (count($vetor));

//pegando valores da coluna b, será o último X dentor do vetor
for ($i=0; $i < $_POST['restricoes']; $i++) {
	$vetor["x$tamanhoVetor"]["$i"] = $_POST["b$i"];
}	

$vetor["x$tamanhoVetor"]["$i"] = "0";

//COLUNA DE B
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

$i;
$linhaZ = $tamanhoLinha - 1;
$min = 1;

//caso minimizar, inverter solução
if ($_POST['objetivo'] == 2) {
		$min = -1;
}

for ($j=0 ; $j < count($vetor["l$linhaZ"])-1; $j++) {
	$solucao["$j"] = $vetor["l$linhaZ"]["$j"] * $min;
}

//negativar a linha de Z
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

//realizar controle de limite
$limiteMaximo = 20;
$maximo = 0;

//realizar um iteração no simplex
while($continuar && ($maximo < $limiteMaximo)){
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
	}

	//pegar linha do pivo
	$cB = $b["0"];
	$linha;
	for ($i=0; $i < count($b)-1; $i++) {
		if(($cB <= $b["$i"]) && $cB > 0){
			$cB = $b["$i"];
			$linha = $i;
		}
	}

	for ($trocaC=0; $trocaC < count($base); $trocaC++) { 
		if($trocaC == $linha){
			$base["$trocaC"] = "x$coluna";
		}
	}

	//Pivo
	$pivoLinha = $linha;
	$pivoColuna = $coluna;
	$valorPivo = $vetor["l$pivoLinha"]["$pivoColuna"];

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
	$maximo++;
	//---LEMBRAR DE MUDAR ESSA PARTE PARA ARRUMAR PASSO A PASSO---//
	if (!($_POST["direto"] == 1)) {?>
		<div class="container">

<h1>RESULTADO</h1>
<h3>Tabela</h3>
<div class="table-responsive">
<table class="table">
<tr>
	<td>Base</td>
	?>
	<?php 
	for ($j=0; $j < count($vetor["l0"])-1; $j++) { 
	 	?>
	 	<td>
	 		<?php echo "x$j" ?>
	 	</td>
	 	<?php 
	 } ?>
	 <td>b</td>
</tr>
<?php 
	for ($i=0; $i < count($vetor["x0"]) ; $i++) {
	
 ?>
 	<tr>
 		<td><?php if ($i != $linhaZ) {
 			?>
 			<?= $base["$i"]?>
 			<?php 
 		}else
 		echo "Z"; ?></td>
 		<?php
 			for($j=0; $j < count($vetor["l0"]); $j++){
		?>
 				<td><?=$vetor["l$i"]["$j"]?></td>
		<?php
 			}
 		?>
 	</tr>
 <?php
 	}
 ?>
 </table>
 </div>

		
 	</div><?php 
 		}
}
if ($maximo >= $limiteMaximo) {
	echo "<h1>Solução Ilimitada</h1>";
}?>

<div class="container">

<h1>RESULTADO</h1>
<h3>Tabela</h3>
<div class="table-responsive">
<table class="table">
<tr>
	<td>Base</td>
	<?php 
	for ($j=0; $j < count($vetor["l0"])-1; $j++) { 
	 	?>
	 	<td>
	 		<?php echo "x$j" ?>
	 	</td>
	 	<?php 
	 } ?>
	 <td>b</td>
</tr>
<?php 
	for ($i=0; $i < count($vetor["x0"]) ; $i++) {
	//echo "linha $i </br>"; 
	//	var_dump($vetor["l$i"]);
	
 ?>
 	<tr>
 		<td><?php if ($i != $linhaZ) {
 			?>
 			<?= $base["$i"]?>
 			<?php 
 		}else
 		echo "Z"; ?></td>
 		<?php
 			for($j=0; $j < count($vetor["l0"]); $j++){
		?>
 				<td><?=$vetor["l$i"]["$j"]?></td>
		<?php
 			}
 		?>
 	</tr>
 <?php
 	}
 ?>
 </table>
 </div>

		
 	</div>
<div class="container">
<h3>Solução</h3>
		<?php 
		$existe;
 		$posicaoE;
 			for ($i=0; $i < count($vetor["l0"])-1; $i++) {
				for ($j=0; $j < count($base); $j++) { 
					$existe = false;
					if ("x$i" == $base["$j"]) {
						$existe = true;
						$posicaoE = $j;
						break;
					}
					else
						$existe = false;
				}
				if (!$existe) {
					echo "x$i = 0";
					echo "</br>";
				}else{
					echo "$base[$posicaoE] = ";
						?>
					<?=$vetor["l$j"]["$colunaB"]?>
					<?php 
					echo "</br>";
				}
				
			}
			
			echo "Z =";
			?>
				<?=$vetor["l$linhaZ"]["$colunaB"]?>
				</div>
				<?php

//Analise de sensibilidade

//Preço Sombra

//Pegar os valores na linha de Z das variáveis de folga(f)
for ($i=$qtdNaoBasicas, $a=0; $i < $tamanhoVetor; $i++, $a++) { 
	$precoSombra[$a] = $vetor["l$linhaZ"]["$i"];
}
//Pegar valores da coluna de b
for ($i=0; $i < count($vetor["x0"]); $i++) { 
	$b[$i] = $vetor["l$i"]["$colunaB"];
}
//Gerar vetor com calculo de, linha da coluna de b dividido por linha da coluna da variavel de folga
//Multiplicar por menos 1 o resultado

for ($i=0; $i < count($precoSombra); $i++) {
	for ($j=0; $j < count($vetor["x$colunaB"]) - 1; $j++) { 
		for ($k=$qtdNaoBasicas; $k < count($vetor["l0"]) - 1; $k++) { 
			if ($vetor["l$j"]["$k"] == 0) {
				$analiseSensibilidade[$j][$k] = 0;
			}else{
				$analiseSensibilidade[$j][$k] = ($b[$j]/$vetor["l$j"]["$k"] ) * -1 ;
			}			
		}
		//pegar o menor valor maior que zero;
		asort($analiseSensibilidade[$j]);
		for ($k=$qtdNaoBasicas; $k < count($vetor["l0"]) - 1; $k++) { 
			if ($analiseSensibilidade[$j][$k] < 0) {
				$analiseSensibilidade[$j]["min"] = $analiseSensibilidade[$j][$k];
			//	var_dump($analiseSensibilidade[$j]["min"]);
				break;
			}
		}
		//pegar o menor valor menor que zero;
		if ($precoSombra[$j] != 0) {
			arsort($analiseSensibilidade[$j]);
			for ($k=$qtdNaoBasicas; $k < count($vetor["l0"]) - 1; $k++) { 
				if ($analiseSensibilidade[$j][$k] > 0) {
					$analiseSensibilidade[$j]["max"] = $analiseSensibilidade[$j][$k];
			//		var_dump($analiseSensibilidade[$j]["max"]);
					break;
				}
			}
		}else
		{
			$analiseSensibilidade[$j]["max"] = "infinito";
		}
		
	}

}

for ($i=0; $i < count($precoSombra); $i++) { 
	# code...
}

 ?>

<div class="container">
	<h2>Análise de Sensibilidade</h2>

 <table class="table">
 	<tr>
 		<td>
 			Variáveis
 		</td>
 		<td>
 			Preço Sombra
 		</td>
 		<td>
 			Min
 		</td>
 		<td>
 			Max
 		</td>
 	</tr>
	 <?php 
	for ($i=$qtdNaoBasicas, $a=0; $i < count($analiseSensibilidade) + $qtdNaoBasicas; $i++, $a++) {
		?>

		<tr>
		<td>
		<?php
		echo "x$i";
	?>
	</td>
	<td>
		<?=$precoSombra[$a]?>
	</td>
	<td>
		<?=$analiseSensibilidade[$a]["min"]?>
	</td>
	<td>
		<?=$analiseSensibilidade[$a]["max"]?>
	</td>
	</tr>
	<?php

}
 ?>
 </table>
 </div>
</body>
</html>




