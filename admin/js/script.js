(function ($) {

	var countChecked = function() {
  		
  		if($( "#checkAll" ).attr('checked')){
  			
  			$( ".check" ).attr('checked', 'checked');	
  		}else{
  			$( ".check" ).removeAttr('checked');
  		}
  		
	};
	
	$( "#checkAll" ).on( "click", countChecked );

	function showAviso2(nome){
		$("#nomeArea").html(nome);
		$("#aviso").fadeIn('slow');
		$("#black_overlay").fadeIn('slow');
	}
	
	function hiddenAviso2(){
		$("#aviso").fadeOut('slow');
		$("#black_overlay").fadeOut('slow');
	}
	
	$(document).ready(function () {
		function slideout() {
		 	setTimeout(function () {
		 		$("#response").slideUp("slow", function () {});
		 	},
		 	2000);
		}
		
		$(".areaEdit").bind("click", updateText);
		
		var OrigText, NewText;
		
		$(".save").live("click", function () {
			
			var rel = $(this).attr("rel");
			NewText = $(".edit").val();
			
			showAviso2(NewText);
			
			jQuery.ajax({
					type: 'POST',
					url: 'admin-ajax.php',
					data: 'action=wpcvp_editArea&rel=' + rel + '&texto=' + NewText,
					cache: true,
					success: function(response){
						//alert(response);
						hiddenAviso2();
						
					}
			});
			
			/*$("#loading").fadeIn('slow');
			
		 	var id = $(this).parent().attr("id");
		 	var data = '?id=' + id + '&amp;text=' + NewText;
			
			$.post("update.php", data, function (response) {
				$("#response").html(response);
		 		$("#response").slideDown('slow');
		 		slideout();
		 		$("#loading").fadeOut('slow');
			});
			
			*/
			$(this).parent().html(NewText).removeClass("selected").bind("click", updateText);
			
		});
		
		$(".revert").live("click", function () {
			$(this).parent().html(OrigText).removeClass("selected").bind("click", updateText);
		});
		
		function updateText() {
			$('span').removeClass("areaEdit");
			//alert($(this).attr("rel"));
		 	OrigText = $(this).html();
		 	$(this).addClass("selected").html('<form ><input type="text" class="edit" value="' + OrigText + '" />&nbsp; &nbsp;</form><a href="#" class="save" rel="'+$(this).attr("rel")+'"><img src="../wp-content/plugins/wp-curriculo-vitae-premium/img/tick.png" border="0" width="16" height="16"/></a>&nbsp; &nbsp;<a href="#" class="revert"><img src="../wp-content/plugins/wp-curriculo-vitae-premium/img/cross.png" border="0" width="16" height="16"/></a>').unbind('click', updateText);
		}
	});
			

	//Mascara para o campo CPF
	$(document).ready(function(){
		if($("#cpf").length || $("#cep").length ){
			$("#cpf").mask("999.999.999-99");
			$("#cep").mask("99999-999");
			$("#telefone").mask("(99)9999-9999");
			$("#idade").mask("99/99/9999");
		}

		function str_replace(busca,subs,valor){
            var ret=valor;
            var pos=ret.indexOf(busca);
            while(pos!=-1){
                ret=ret.substring(0,pos)+subs+ret.substring(pos+busca.length,ret.length);
                pos=ret.indexOf(busca);
            }
            return ret;
        }
		function mascara(valor,masc){
		var res=valor,mas=str_replace("?","",str_replace("9","",masc));
		for(var i=0;i<mas.length;i++){
			res=str_replace(mas.charAt(i),"",res);
			mas=str_replace(mas.charAt(i),"",mas);
		}
		var ret="";
		for(var i=0;i<masc.length&&res!="";i++){
			switch(masc.charAt(i)){
				case"?":
					ret+=res.charAt(0);
					res=res.substring(1,res.length);
					break;
				case"9":
					while(res!=""&&(res.charCodeAt(0)>57||res.charCodeAt(0)<48))res=res.substring(1,res.length);
					if(res!=""){
						ret+=res.charAt(0);
						res=res.substring(1,res.length);
					}
					break;
				default:
					ret+=masc.charAt(i);
				}
			}
			return ret;
		}

		$("#celular").keyup(function(){
			if($(this).val().length <= 13)
				$(this).val( mascara($(this).val(), '(99)9999-9999') );
			else
				$(this).val( mascara($(this).val(), '(99)99999-9999') );
		})
	});
	
	//Função que checa se já existe um cadastro com o mesmo CPF
	$(document).ready(function(){
		$('#cpf').keyup(cpf_check);
		
	});
	
	function showAviso(nome){
		$("#nomeCurriculo").html(nome);
		$("#aviso").fadeIn('slow');
		$("#black_overlay_status").fadeIn('slow');
	}
	
	function hiddenAviso(){
		$("#aviso").fadeOut('slow');
		$("#black_overlay_status").fadeOut('slow');
	}
	
	$("#fecharAviso").click(function(){
		hiddenAviso()
	});
	
	$('input#curriculo').change(function(){
		
		var arquivo = $('input#curriculo').val();
		
		//var id_registro = $('#id_registro').val();
		//var nomeUser = $('#nomeUser_'+num).html();
		$("#msgFile").fadeOut('slow');
				
		jQuery.ajax({
				type: 'POST',
				url: 'admin-ajax.php',
				data: 'action=wpcvp_verificarArquivo&arquivo=' + arquivo,
				cache: true,
				success: function(response){
					
					//alert(response.substring(0,response.length - 1));
					var retorno = response.substring(0,response.length - 1)
					response = retorno;
					$("#ext").html(response);
					if(response=="pdf" || response=="doc" || response=="docx" || response=="jpeg" || response=="jpg" || response=="png"){
						//alert("correto");
					}else{
						//alert("errado");
						$("#msgFile").fadeIn('slow');
					}
				}
		});
		
	});
	
	$('select.statusSelect').change(function(){
		
		var nome = $(this).attr('id');
		
		
		var num = nome.replace("status_", "");
		
		var id_registro = $('#id_registro_'+num).val();
		var nomeUser = $('#nomeUser_'+num).html();
		
		var status = $(this).val();
		
		//alert(id_registro);

		showAviso(nomeUser);
		
		jQuery.ajax({
				type: 'POST',
				url: 'admin-ajax.php',
				data: 'action=wpcvp_curriculoStatus&id_registro='+ id_registro + '&status=' + status,
				cache: true,
				success: function(response){
					//alert(response);
					hiddenAviso();
					/*if(response==10){
						hiddenAviso();
					}else{
						$("#aviso h4").html("Erro na atualização");
						$("#avisoMensagem").html(response);
						$("#avisoMensagemErro").css("display","block");
					}*/
					
					
				}
			});
		
	});
	
	function cpf_check(){
		var cpf = $('#cpf').val();
		if(cpf == '' || cpf.length < 14){
			$('#cpf').css('border', '3px #CCC solid');
			$('#tick').hide();
		}else{
			jQuery.ajax({
				type: 'POST',
				url: 'admin-ajax.php',
				data: 'action=wpcvp_checkCpf&cpf='+ cpf,
				cache: false,
				success: function(response){
					//alert(response);
					if(response >= 10){
						$('#cpf').css('border', '3px #C33 solid');
						$('#tick').hide();
						$('#cross').fadeIn();
						$('#msgCpf').fadeIn();
						$('#cadastrar').prop('disabled', true);
						
						
					}else{
						$('#cpf').css('border', '3px #090 solid');
						$('#cross').hide();
						$('#msgCpf').hide();
						$('#tick').fadeIn();
						$('#cadastrar').prop('disabled', false);
					}
				}
			});
		}
	
	}
	
	//Preenche o o endereço com o cep preenchido 
	$(document).ready(function(){
		$('#cep').keyup(getEndereco); 
	});
	
	function getEndereco() {
		// Se o campo CEP não estiver vazio
		//alert(1);
		if($.trim($("#cep").val()) != ""){
			//alert($.trim($("#cep").val()));
			/*
			Para conectar no serviço e executar o json, precisamos usar a função
			getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
			dataTypes não possibilitam esta interação entre domínios diferentes
			Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
			http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
			*/
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
				// o getScript dá um eval no script, então é só ler!
				//Se o resultado for igual a 1
				if (resultadoCEP["tipo_logradouro"] != '') {
					if (resultadoCEP["resultado"]) {
						// troca o valor dos elementos
						$("#rua").val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
						$("#bairro").val(unescape(resultadoCEP["bairro"]));
						$("#cidade").val(unescape(resultadoCEP["cidade"]));
						$("#estado").val(unescape(resultadoCEP["uf"]));
						$("#numero").focus();
					}
				}
			});
		}
	}
	
	//carregar o bairro baseando na cidade que foi escolhida
	$(document).ready(function(){
		$('#estado').change(carregar_cidade);
		$('#cidade').change(carregar_bairro); 
	});
	
	function carregar_cidade(){
		var estado = $('#estado option:selected').val();
		//alert(estado);
		$('#cidade').html("<option value=\"\">Carregando...</option>");
		jQuery.ajax({
			type: 'POST',
			url: 'admin-ajax.php',
			data: 'action=wpcvp_carregar_cidade&estado='+ estado,
			cache: false,
			success: function(response){
				//alert(response);
				$('#cidade').removeAttr('disabled');
				$('#cidade').html(response);
			}
		});
	}
	
	function carregar_bairro(){
		var estado = $('#estado option:selected').val();
		var cidade = $('#cidade option:selected').val();
		$('#bairro').html("<option value=\"\">Carregando...</option>");
		jQuery.ajax({
			type: 'POST',
			url: 'admin-ajax.php',
			data: 'action=wpcvp_carregar_bairro&estado=' + estado + '&cidade=' + cidade,
			cache: false,
			success: function(response){
				//alert(response);
				$('#bairro').removeAttr('disabled');
				$('#bairro').html(response);
			}
		});
	}
	
	function dirname (path) {
	  // http://kevin.vanzonneveld.net
	  // +   original by: Ozh
	  // +   improved by: XoraX (http://www.xorax.info)
	  // *     example 1: dirname('/etc/passwd');
	  // *     returns 1: '/etc'
	  // *     example 2: dirname('c:/Temp/x');
	  // *     returns 2: 'c:/Temp'
	  // *     example 3: dirname('/dir/test/');
	  // *     returns 3: '/dir'
	  return path.replace(/\\/g, '/').replace(/\/[^\/]*\/?$/, '');
	}
	
	$("#black_overlay").click(function(){
		$('.wpcv_lightbox_content').css('display','none');
		$('.wpcvcontent').css('display','none');
		$('#black_overlay').css('display','none');
	})
	
	$("a.abrirDescricao").click(function(){

		var rel = $(this).attr('rel');

		$('#black_overlay').css('display','block');
		//$("#"+wpcvboxcontent).css("display","block");
		
		$( "#curriculo_"+rel ).animate({
//		  width: [ "toggle", "swing" ],
//		  height: [ "toggle", "swing" ],
		  opacity: "toggle"
		}, 500, "swing", function() {
    		//$( '.wpcvcontent' ).css( 'display', 'block' );
			$( '.wpcvcontent' ).fadeIn( "fast", function() {
    			// Animation complete
  			});
  		});
	});
	
	//Remove Formação 
	function removeFormacao() { 
		$(".removerFormacao").unbind("click"); 
		$(".removerFormacao").bind("click", function () { 
			i=0; 
			
			$("div.formacaoAcademica").each(function () { 
				i++; 
			}); 
			
			if (i>1) { 

				$(this).parent().parent().fadeOut('slow', function(){$(this).remove();});
			} 
		}); 
	} 
	
	removeFormacao(); //Remove Formação 
	
	//Adiciona formação
	$(".adicionarNovaFormacao").click(function () { 
		novoCampo = $("div.formacaoAcademica:last").clone();
		novoCampo.find("input").val(""); 
		novoCampo.find("textarea").val(""); 
		novoCampo.find("select").val(""); 
		novoCampo.fadeIn('slow').insertAfter("div.formacaoAcademica:last");
		removeFormacao();
	});
	
	

	function removeExperiencia() { 
		$(".removerExperiencia").unbind("click"); 
		$(".removerExperiencia").bind("click", function () { 
			i=0; 
			
			$("div.experienciaprofissional").each(function () { 
				i++; 
			}); 
			
			if (i>1) { 
				$(this).parent().parent().fadeOut('slow', function(){$(this).remove();});
			} 
		}); 
	} 

	removeExperiencia(); 

	$(".adicionarNovaExperiencia").click(function () { 
		novoCampo = $("div.experienciaprofissional:last").clone();
		novoCampo.find("input").val(""); 
		novoCampo.find("textarea").val(""); 
		novoCampo.find("select").val("");
		novoCampo.fadeIn('slow').insertAfter("div.experienciaprofissional:last");
		removeExperiencia(); 
	});

	

	function removeCurso() { 
	
		$(".removerCursoPalestra").unbind("click"); 
		$(".removerCursoPalestra").bind("click", function () { 
			i=0; 
			
			$("div.cursospalestras").each(function () { 
				i++; 
			}); 
			
			if (i>1) { 
				$(this).parent().parent().fadeOut('slow', function(){$(this).remove();});
			} 
		}); 
	} 

	removeCurso(); 

	$(".adicionarNovaCursoPalestra").click(function () { 
		novoCampo = $("div.cursospalestras:last").clone();
		novoCampo.find("input").val(""); 
		novoCampo.find("textarea").val(""); 
		novoCampo.find("select").val("");
		novoCampo.fadeIn('slow').insertAfter("div.cursospalestras:last");
		removeCurso(); 
	});

	function removeIdioma() { 
	
		$(".removerIdioma").unbind("click"); 
		$(".removerIdioma").bind("click", function () { 
			i=0; 
			
			$("div.idiomas").each(function () { 
				i++; 
			}); 
			
			if (i>1) { 
				$(this).parent().parent().fadeOut('slow', function(){$(this).remove();});
			} 
		}); 
	} 

	removeIdioma(); 

	$(".adicionarNovaIdioma").click(function () { 
		novoCampo = $("div.idiomas:last").clone();
		novoCampo.find("input").val(""); 
		novoCampo.find("textarea").val(""); 
		novoCampo.find("select").val(""); 
		novoCampo.fadeIn('slow').insertAfter("div.idiomas:last");
		removeIdioma(); 
	});

	function removeConhecimentoTecnico() { 
	
		$(".removerConhecimentoTecnico").unbind("click"); 
		$(".removerConhecimentoTecnico").bind("click", function () { 
			i=0; 
			
			$("div.conhecimentotecnico").each(function () { 
				i++; 
			}); 
			
			if (i>1) { 
				$(this).parent().parent().fadeOut('slow', function(){$(this).remove();});
			} 
		}); 
	} 

	removeConhecimentoTecnico(); 

	$(".adicionarNovaConhecimentoTecnico").click(function () { 
		novoCampo = $("div.conhecimentotecnico:last").clone();
		novoCampo.find("input").val(""); 
		novoCampo.find("textarea").val(""); 
		novoCampo.find("select").val("");
		novoCampo.fadeIn('slow').insertAfter("div.conhecimentotecnico:last");
		removeConhecimentoTecnico(); 
	});
	
	$('#bt_dadosPessoais').click(function(){
		abaCategorias('dadosPessoais');
	});
	
	$('#bt_formacaoAcademica').click(function(){
		abaCategorias('formacaoAcademica');
	});
	
	$('#bt_experienciaProfissional').click(function(){
		abaCategorias('experienciaProfissional');
	});
	
	$('#bt_cursosPalestras').click(function(){
		abaCategorias('cursosPalestras');
	});

	$('#bt_idiomas').click(function(){
		abaCategorias('idiomas');
	});

	$('#bt_conhecimentoTecnico').click(function(){
		abaCategorias('conhecimentoTecnico');
	});
	
	function abaCategorias(aba){
		//alert(aba);
		
		$('#bt_dadosPessoais').removeClass('active');
		$('#bt_formacaoAcademica').removeClass('active');
		$('#bt_experienciaProfissional').removeClass('active');
		$('#bt_cursosPalestras').removeClass('active');
		$('#bt_idiomas').removeClass('active');
		$('#bt_conhecimentoTecnico').removeClass('active');
		
		$('#bt_'+aba).addClass('active');
		
		$('#dadosPessoais').fadeOut("slow");
		$('#formacaoAcademica').fadeOut("slow");
		$('#experienciaProfissional').fadeOut("slow");
		$('#cursosPalestras').fadeOut("slow");
		$('#idiomas').fadeOut("slow");
		$('#conhecimentoTecnico').fadeOut("slow");
		
		$('#'+aba).fadeIn("slow");
	}
	
	$('#tipo_envio').change(function(){
		
		if($('#tipo_envio').val() == 2){
			
			$('#personalizarSMTP').fadeIn('slow');
			
		}else{
			
			$('#personalizarSMTP').fadeOut('slow');
			
		}
	});
	
	$('#autenticacao').click(function(){
		if($("#autenticacao").is(':checked')){
			$('#usuarioSenha').fadeIn('slow');
		}else{
			$('#usuarioSenha').fadeOut('slow');
		}
	});
	
}(jQuery));

