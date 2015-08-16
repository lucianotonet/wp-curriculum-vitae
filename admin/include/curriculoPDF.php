<?php
	
   	include('../../../../../wp-config.php');
   	include('../../admin/include/funcoes.php');
   	include('../../classes/MPDF/mpdf.php');
   
   	$wls_curriculo 					         = $table_prefix . 'wls_curriculo';
	  $wls_areas 						           = $table_prefix . 'wls_areas';
	  $wls_curriculo_options 			     = $table_prefix . 'wls_curriculo_options';
	  $wls_formacao_academica 		     = $table_prefix . 'wls_formacao_academica';
	  $wls_experiencia_profissional 	 = $table_prefix . 'wls_experiencia_profissional';
	  $wls_cursos_palestras 			     = $table_prefix . 'wls_cursos_palestras';
      
    #echo DB_HOST;
   	// conecta ao banco de dados 
   	$con = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD) or trigger_error(mysql_error(),E_USER_ERROR); 
   	// seleciona a base de dados em que vamos trabalhar 
   	mysql_select_db(DB_NAME, $con); 
      
   	$where = "";
   
   	$where .= $_GET['id_curriculo']?"a.id = '".$_GET['id_curriculo']."'":"1=1";
   	#$where .= $_GET['cargo']?" and a.cargo = '".$_GET['cargo']."'":"";
   
   	// cria a instruÃ§Ã£o SQL que vai selecionar os dados 
   	$sql = "SELECT 	a.*,
				  	b.area,
				  	c.id as id_formacao,
			   	  	d.id as id_experiencia,
			   	  	e.id as id_curso_palestra
		   
		   	FROM ".$wls_curriculo." a
		   
		   		left join ".$wls_areas." b
					on a.id_area = b.id
					
				left join ".$wls_formacao_academica." c
					on c.id_cadastro = a.id
					
				left join ".$wls_experiencia_profissional." d
					on d.id_cadastro = a.id
					
				left join ".$wls_cursos_palestras." e
					on e.id_cadastro = a.id
		   
		   	where $where group by a.nome order by a.nome asc"; 
		
   	// executa a query 
   	$query = mysql_query($sql, $con) or die(mysql_error()); 
   
   	$mpdf=new mPDF('utf-8', 'A4');
   	
   
   	
   	$x=1;
         			 
   	while($dados = mysql_fetch_array($query, MYSQL_ASSOC)){
	   	
      $html = '';
      $html .= '<html>
          <head>
            <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
            <style type="text/css" media="all">
            </style>
          </head>
          <body style="font-family: Arial; margin:0px; padding:0px;">';

	   	############################################################################################
	   	#CurrÃ­culo

	   	if($dados['estado_civil']==1){
  			$civil = "Solteiro(a)";
  		}elseif($dados['estado_civil']==2){
  			$civil = "Viuvo(a)";
  		}elseif($dados['estado_civil']==3){
  			$civil = "Casado(a)";
  		}elseif($dados['estado_civil']==4){
  			$civil = "Divorciado(a)";
  		}elseif($dados['estado_civil']==5){
  			$civil = "Amigável";
  		}

   		$html .= '<img src="http://andora.com.br/imgs/andora-curriculo.jpg"><br><h3><center>Currículo de '.$dados['nome'].'</center></h3>
        <strong>Dados Pessoais:</strong>
        <hr />
        
        <p>
            <strong>Nome:</strong> '.$dados['nome'].'<br />
            <strong>Cidade:</strong> '.$dados['cidade'].'<br />
            <strong>Estado cívil:</strong> '.$civil.'
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Data de Nascimento:</strong> '.$dados['idade'].'<br />
            <strong>Área pretendida:</strong> '.$dados['area'].'<br />
            <strong>Remuneração:</strong> R$ '.$dados['remuneracao'].'
        </p>
        
        <p>
        	<strong>Descrição:</strong><br/>
            '.$dados['descricao'].'
        </p>
        
        <strong>Formação Acadêmica:</strong>
        <hr />';

      	$sqlFormacao = "SELECT * FROM ".$wls_formacao_academica." where id_cadastro = ".$dados['id']."";
      	$queryFormacao = mysql_query($sqlFormacao, $con) or die(mysql_error()); 
      	while($dadosFormacao = mysql_fetch_array($queryFormacao, MYSQL_ASSOC)){

            $html .= '<p>'.$dadosFormacao['subtitulo'].' - '.$dadosFormacao['iniciou'].'';
                
            if($dadosFormacao['status'] == 1){
                $html .= ' e ainda cursando. Pré-visto para terminar em '.$dadosFormacao['finalizou'].'.';
            }elseif($dadosFormacao['status'] == 2){
                $html .= ' - '.$dadosFormacao['finalizou'].'.';
            }elseif($dadosFormacao['status'] == 3){
                $html .= ' e foi trancado.';
            }
                
            $html .= '<br />
                
                '.$dadosFormacao['escola_faculdade'].' - '.$dadosFormacao['cidade_escola_faculdade'].'-'.$dadosFormacao['estado_escola_faculdade'].'<br />
                <ul style="list-style:inside;">
                    <li>'.$dadosFormacao['formacao'].'</li>
                </ul>
                
            </p>';
        }

        $html .= '<strong>Experiência Profissional:</strong>
        <hr />';
              
        $sqlEProfi = "SELECT * FROM ".$wls_experiencia_profissional." where id_cadastro = ".$dados['id']."";
        $queryEProfi = mysql_query($sqlEProfi, $con) or die(mysql_error()); 
      	while($dadosEProfi = mysql_fetch_array($queryEProfi, MYSQL_ASSOC)){
        
            $html .= '<p>Empresa - '.$dadosEProfi['empresa'].'';
                
            if($dadosEProfi['site_empresa']){
                $html .= ' (<a href="'.$dadosEProfi['protocolo_site'].$dadosEProfi['site_empresa'].'" target="_blank">'.$dadosEProfi['site_empresa'].'</a>)';
            } 

            $html .=' - '.$dadosEProfi['cargo'].'. <br />
                Desde '.$dadosEProfi['ano_inicio'].' até'; 
                
            if($dadosEProfi['status_ep'] == 1){
                $html .=' dias atuais.<br/>';
            }else{
                $html .=' '.$dadosEProfi['ano_final'].'.<br/>';
            }
                $html .='Atividades desempenhadas: '.$dadosEProfi['mais_cargo'].'
            </p>';
        }

        $html .= '<strong>Cursos e Palestras:</strong>
        <hr />';
        
         
        $sqlCursoP = "SELECT * FROM ".$wpdb->prefix."wls_cursos_palestras where id_cadastro = ".$dados['id']."";
        $queryCursoP = mysql_query($sqlCursoP, $con) or die(mysql_error()); 
      	while($dadosCursoP = mysql_fetch_array($queryCursoP, MYSQL_ASSOC)){
        
            $html .= '<p>'.$dadosCursoP['ano'].' -'; 
            if($vCP->tipo == 1){
               $html .= 'Curso - ';
            }else{
               $html .= 'Palestra - ';
            }
            
            $html .= ''.$dadosCursoP['curso_palestra'].' - ('.$dadosCursoP['escola'].') - '.$dadosCursoP['horas'].'</p>';

        }

        $html .= '<strong>Idiomas:</strong>
        <hr />';
        

        $sqlIdioma = "SELECT * FROM ".$wpdb->prefix."wls_idiomas where id_cadastro = ".$dados['id']."";
        $queryIdioma = $wpdb->get_results( $sqlIdioma );
        foreach($queryIdioma as $kI => $vI){

            $html .= '<p>'.$vI->iInicio ." - ";

            if($vI->iCursando == 1){ 
              $html .= ' Pré-visto para  '.$vI->iFinal.' - ';
            }else{
              $html .=' '.$vI->iFinal.' - ';  
            }
            $html .= ' '.$vI->iEscola.' - '.$vI->iCurso.' - '.$vI->iNivel.' - '.$vI->iDescricao.' </p>';
        }

        $html .= '<strong>Conhecimento Técnico:</strong>
        <hr />';
        
        
        $sqlCT = "SELECT * FROM ".$wpdb->prefix."wls_conhecimento_tecnico where id_cadastro = ".$dados['id']."";
        $queryCT = $wpdb->get_results( $sqlCT );
        foreach($queryCT as $kCT => $vCT){
        
            $html .= '<p>'.$vCT->ctCurso.' - '.$vCT->ctNivel.'</p>';

        }


            
        $html .= '
                    </div>
                </div>';

	   	############################################################################################
  		$x++;
      if($GET_['id_curriculo']){
        
        $mpdf->WriteHTML($html);
      }else{
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
      }
    
      $html .= '</body></html>';

   	}
   
   	
   
   	//$mpdf=new mPDF();
   	
   	$mpdf->Output();

	   
?>