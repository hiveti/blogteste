//var $jMask = jQuery.noConflict();
jQuery(document).ready(function() {
	// Configuração padrão.

	//CPF
	jQuery("#cpf").mask("999.999.999-99");
	
	//CEP
	jQuery("#cep").mask("99999-999");

	//Telefone1, Telefone2 e Celular
	jQuery(".fonefixo").mask("(99)9999-9999");

	
	//jQuery.mask.definitions['~']='[+-]';
	//Inicio Mascara Telefone
	jQuery('.fone').focusout(function(){
		var phone, element;
		element = jQuery(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
			element.mask("(99) 99999-999?9");
		} else {
			element.mask("(99) 9999-9999?9");
		}
	}).trigger('focusout');
	
	jQuery("#rg").mask("99.999.999-*");

	//Data
	jQuery(".date").mask("99/99/9999");
	
	//Data hora
	jQuery(".dateTime").mask("99/99/9999 99:99");

	jQuery(".time").mask("99:99");

	//Teste de depoimentos
    
 	/*jQuery(".valor").maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});*/

});