$j = jQuery.noConflict();

$j(document).ready(function(){
	var url_atual = window.location.href;
	var var_visible = $j('#variaveis');
	var restri_visible = $j('#restricoes');
	var var_oculta = $j('.variaveis').val();
	var restri_oculta = $j('.restricoes1').val();
	var button_hidden  = $j('.btn-enviar');
	var back = $j('.back');

	if(url_atual  == "http://localhost/Simplex/Trabalho_Sabatine/Desenvolvimento/DefinirTamanho.php"){
		//alert("variaveis: " + var_oculta);
		//alert("restricoes: " + restri_oculta);	
		var_visible.val(var_oculta);
		restri_visible.val(restri_oculta);
		button_hidden.hide();

	}
	$j(back).click(function(){
			 history.back()
		})

});	