
(function ($) {
	
	$("#linkEsqueceu").click(function(){
		
		$("#formEsqueceuSenha").css("display","block");
		
	});
	
	$(document).ready(function(){

		
		//Mascara para o campo CPF
		$("#cpf").mask("999.999.999-99");
		$("#cep").mask("99999-999");
		$("#telefone").mask("(99)9999-9999");
		$("#idade").mask("99/99/9999");

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
		
		$("span#wpcvp_linkEsqueceu").click(function(){
					
			$("#wpcvp_formLoginSenha").fadeOut('slow');
			$("#wpcvp_formEsqueceuSenha").delay( 430 ).fadeIn('slow');
			
		});
		
		$("span#wpcvp_linkLogin").click(function(){
			
			$("#wpcvp_formEsqueceuSenha").fadeOut('slow');
			$("#wpcvp_formLoginSenha").delay( 430 ).fadeIn('slow');
			
		});
		
		$('#bt_dadosPessoais').click(function(){
			abaCategorias('dadosPessoais');
		});
		
		$('#bt_formacaoAcademica, #dadosPessoais a.next-step').click(function(){
			console.log('heere;');
			abaCategorias('formacaoAcademica');
		});
		
		$('#bt_experienciaProfissional, #formacaoAcademica a.next-step').click(function(){
			abaCategorias('experienciaProfissional');
		});
		
		$('#bt_cursosPalestras, #experienciaProfissional a.next-step').click(function(){
			abaCategorias('cursosPalestras');
		});

		$('#bt_idiomas, #cursosPalestras a.next-step').click(function(){
			abaCategorias('idiomas');
		});

		$('#bt_conhecimentoTecnico, #idiomas a.next-step').click(function(){
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
			
			$('#dadosPessoais').css('display', 'none');
			$('#formacaoAcademica').css('display', 'none');
			$('#experienciaProfissional').css('display', 'none');
			$('#cursosPalestras').css('display', 'none');
			$('#idiomas').fadeOut("slow");
			$('#conhecimentoTecnico').fadeOut("slow");
			
			$('#'+aba).css('display', 'block');
		}
		
	});
	
	//Função que checa se já existe um cadastro com o mesmo CPF
	$(document).ready(function(){
		$('#cpf').keyup(cpf_check); 
	});
	
	function cpf_check(){
		var cpf = $('#cpf').val();
		if(cpf == '' || cpf.length < 14){
			$('#cpf').css('border', '3px #CCC solid');
			$('#tick').hide();
		}else{
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: 'action=checkCpf&cpf='+ cpf,
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
		if($.trim($("#cep").val()) != ""){
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
		var estado = $('#estado').val();
		$('#cidade').html("<option value=\"\">Carregando...</option>");
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
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
		var estado = $('#estado').val();
		var cidade = $('#cidade').val();
		$('#bairro').html("<option value=\"\">Carregando...</option>");
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
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
	
	$(function () {
		function removeCampo() { 
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
		
		removeCampo(); 
		
		$(".adicionarNovaFormacao").click(function () { 
			novoCampo = $("div.formacaoAcademica:last").clone();
			novoCampo.find("input").val(""); 
			novoCampo.find("textarea").val(""); 
			novoCampo.find("select").val(""); 
			novoCampo.fadeIn('slow').insertAfter("div.formacaoAcademica:last");
			removeCampo(); 
		});
	});
	
	
	$(function () {
		function removeCampo2() { 
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
	
		removeCampo2(); 
	
		$(".adicionarNovaExperiencia").click(function () { 
			novoCampo = $("div.experienciaprofissional:last").clone();
			novoCampo.find("input").val(""); 
			novoCampo.find("textarea").val(""); 
			novoCampo.find("select").val("");  
			novoCampo.fadeIn('slow').insertAfter("div.experienciaprofissional:last");
			removeCampo2(); 
		});
	});
	
	$(function () {
		function removeCampo3() { 
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
	
		removeCampo3(); 
	
		$(".adicionarNovaCursoPalestra").click(function () { 
			novoCampo = $("div.cursospalestras:last").clone();
			novoCampo.find("input").val(""); 
			novoCampo.find("textarea").val(""); 
			novoCampo.find("select").val(""); 
			novoCampo.fadeIn('slow').insertAfter("div.cursospalestras:last");
			removeCampo3(); 
		});
	});

	$(function () {
		function removeCampoIdioma() { 
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
	
		removeCampoIdioma(); 
	
		$(".adicionarNovaIdioma").click(function () { 
			novoCampo = $("div.idiomas:last").clone();
			novoCampo.find("input").val(""); 
			novoCampo.find("textarea").val(""); 
			novoCampo.find("select").val(""); 
			novoCampo.fadeIn('slow').insertAfter("div.idiomas:last");
			removeCampoIdioma(); 
		});
	});

	$(function () {
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
	});

	
	$('input#curriculo').change(function(){
		
		var arquivo = $('#curriculo').val();		
		//var id_registro = $('#id_registro').val();
		//var nomeUser = $('#nomeUser_'+num).html();
		$("#msgFile").fadeOut('slow');
				
		jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
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

	
	$(document).ready(function(){	
		$("#black_overlay").click(function(){
			$('.wpcv_lightbox_content').fadeOut("slow");
			$('#black_overlay').fadeOut("slow");
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
	});
	
	
	
	

}(jQuery));

