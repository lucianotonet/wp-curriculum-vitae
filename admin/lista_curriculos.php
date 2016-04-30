<?php

global $wpdb, $wpcvp;

include_once( plugin_dir_path( __FILE__ ) . '../classes/estados.php' );  
	
$table = BD_CURRICULO;

$pg = $_GET['pg'];

$bNome    = $_POST['bnome'];
$bCidade  = $_POST['bcidade'];
$bEstado  = $_POST['bestado'];
$bBairro  = $_POST['bbairro'];
$bStatus  = $_POST['bstatus'];
$bArea  = $_POST['barea'];

$msg = $_GET['msg'];

$where = "";

if($bNome){
  $where .= " and LOWER(a.nome) LIKE  '%".strtolower($bNome)."%'";
}

if($bEstado){
  $where .= " and LOWER(a.estado) LIKE '%".strtolower($bEstado)."%'";
}

if($bCidade){
  $where .= " and LOWER(a.cidade) LIKE '%".strtolower($bCidade)."%'";
}

if($bBairro){
  $where .= " and LOWER(a.bairro) LIKE '%".strtolower($bBairro)."%'";
}

if($bStatus){
  $where .= " and a.status = '".$bStatus."'";
}

if($bArea){
  $where .= " and b.id = '".$bArea."'";
}

if($buscar){
	$where .= " and (nome LIKE  '%".$buscar."%' or descricao LIKE '%".$buscar."%')";
}


########### Função para excluir registro

if(isset($_POST['excl'])){
  
  $wpcvp->deleteTable($_POST['excl'], BD_CURRICULO);
  $wpcvp->deleteSub($_POST['excl'], BD_FORMA_ACADE, $qtdeFormacao);
  $wpcvp->deleteSub($_POST['excl'], BD_EXPERI_PROFIS, $qtdeExperiencia);
  $wpcvp->deleteSub($_POST['excl'], BD_CURSOS_PALEST, $qtdeCurso);
  $wpcvp->deleteSub($_POST['excl'], BD_IDIOMAS, $qtdeIdioma);
  $wpcvp->deleteSub($_POST['excl'], BD_CONHECI_TECNI, $qtdeConhecimento);
	
}

//######### INICIO Paginação
$numreg = 20; // Quantos registros por página vai ser mostrado
if (!isset($pg)) {
	$pg = 0;
}
$inicial = $pg * $numreg;

//######### FIM dados Paginação

$sql = "SELECT a.*,
			   b.area,
			   c.id as id_formacao,
			   d.id as id_experiencia,
			   e.id as id_curso_palestra,
         f.id as id_idioma,
         g.id as id_conhecimento_tecnico
		
		FROM ".BD_CURRICULO." a
		
			left join ".BD_AREA_SERVICOS." b
				on a.id_area = b.id
				
			left join ".BD_FORMA_ACADE." c
				on c.id_cadastro = a.id
				
			left join ".BD_EXPERI_PROFIS." d
				on d.id_cadastro = a.id
				
			left join ".BD_CURSOS_PALEST." e
				on e.id_cadastro = a.id

      left join ".BD_IDIOMAS." f
        on f.id_cadastro = a.id

      left join ".BD_CONHECI_TECNI." g
        on g.id_cadastro = a.id
		
		where 1=1 $where group by a.id order by a.nome asc LIMIT $inicial, $numreg ";
		
$query = $wpdb->get_results( $sql );

$sqlRow = "SELECT a.*,
				  b.area,
				  c.id as id_formacao,
			   	d.id as id_experiencia,
			   	e.id as id_curso_palestra,
          f.id as id_idioma,
          g.id as id_conhecimento_tecnico
		   
		   FROM ".BD_CURRICULO." a
		   
		   		left join ".BD_AREA_SERVICOS." b
					on a.id_area = b.id
					
				left join ".BD_FORMA_ACADE." c
					on c.id_cadastro = a.id
					
				left join ".BD_EXPERI_PROFIS." d
					on d.id_cadastro = a.id
					
				left join ".BD_CURSOS_PALEST." e
					on e.id_cadastro = a.id

        left join ".BD_IDIOMAS." f
          on f.id_cadastro = a.id

        left join ".BD_CONHECI_TECNI." g
          on g.id_cadastro = a.id
		   
		   where 1=1 $where group by a.id order by a.nome asc";
		   
$queryRow = $wpdb->get_results( $sqlRow );
$quantreg = $wpdb->num_rows; // Quantidade de registros pra paginação

wp_enqueue_style('wpcva_bootstrap', plugins_url('../css/bootstrap.min.css', __FILE__));

wp_enqueue_style('wpcvpa_style', plugins_url('css/style.css', __FILE__));
#wp_enqueue_style('wpcvpa_style_print', plugins_url('css/style-print.css', __FILE__), '', '', 'print');

wp_enqueue_script('jquery');	
wp_enqueue_script('wpcvpa_bootstrapJS', plugins_url('../js/bootstrap.min.js', __FILE__));
#wp_enqueue_script('wpcvpa_lightboxjs', plugins_url('../js/wpcv_lightbox.js', __FILE__));
wp_enqueue_script('wpcvpa_script', plugins_url('js/script.js', __FILE__));

?>

<div class="container-fluid">
  <h2 style="float:left;"><?php echo NAME_LIST_CURR ?></h2>

  <a class="bt_novo" href="?page=<?php echo URL_FOR_REG ?>">Novo cadastro</a>
  
  <div style="clear:both;"></div>
  
  <?php if(@$_GET['msg']==2){ ?>

        <div class="alert alert-success" style="text-align:center;">Currículo Atualizado com sucesso!</div>	

  <?php }elseif($msg==3){ ?>
  
        <div class="alert alert-success" style="text-align:center;">Registro deletado com sucesso!</div>	
      
  <?php }?>

  <div style="clear:both;"></div>
  <h3>Filtrar por:</h3>     
  <form action="#" method="post" accept-charset="utf-8">    
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Nome:</label>
          <div class="controls">
            <input type="text" name="bnome" value="<?php /*echo $bNome */ ?>" class="form-control" value="">
          </div>
        </div>
        
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">Estado:</label>
          <div class="controls">
            <select class="form-control" name="bestado" style="height:34px;" id="estado">
              <option></option>
              <?php
                
                  $sqlEstado = "SELECT estado FROM ".BD_CURRICULO." where estado <> ' ' group by estado order by estado asc";
                  $queryEstado = $wpdb->get_results( $sqlEstado );
              ?>
              <?php foreach($queryEstado as $kE => $vE){?>
                  <option value="<?php echo strtoupper($vE->estado) ?>" ><?php echo utf8_encode($estadoArray[strtoupper($vE->estado)])?></option>
              <?php }?>
            </select>
          </div>
        </div>
        
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Cidade:</label>
          <div class="controls">
            <select name="bcidade" class="form-control" style="height:34px;" id="cidade">
            <option></option>
            <?php
              
                $sqlCidade = "SELECT cidade FROM ".BD_CURRICULO." where cidade <> '' group by cidade order by cidade asc";
                $queryCidade = $wpdb->get_results( $sqlCidade );
            ?>
            <?php foreach($queryCidade as $kC => $vC){?>
                <option value="<?php echo $vC->cidade ?>" <?php /*echo $bCidade == $vC->cidade?'selected="selected"':'' */ ?>><?php echo $vC->cidade?></option>
            <?php }?>
          </select>
          </div>
        </div>
        
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">Bairro:</label>
          <div class="controls">
            <select name="bbairro" class="form-control" style="height:34px;" id="bairro">
            <option></option>
            <?php
              
                $sqlBairro = "SELECT bairro FROM ".BD_CURRICULO." where bairro <> '' group by bairro order by bairro asc";
                $queryBairro = $wpdb->get_results( $sqlBairro );
            ?>
            <?php foreach($queryBairro as $kB => $vB){?>
                <option value="<?php echo $vB->bairro ?>"><?php echo $vB->bairro?></option>
            <?php }?>
          </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">Status:</label>
                <select name="bstatus" class="form-control" style="height:34px;">
                    <option></option>
                    <option value="0" <?php echo $vB->status==0?"selected":"" ?> style="color:blue;">Aguardando</option>
                    <option value="1" <?php echo $vB->status==1?"selected":"" ?>style="color:red;">Reprovado</option>
                    <option value="2" <?php echo $vB->status==2?"selected":"" ?>style="color:green;">Aprovado</option>
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                
                <?php
                    global $wpdb;
                    $sqlArea = "SELECT * FROM ".BD_AREA_SERVICOS." where 1=1";
                    $queryArea = $wpdb->get_results( $sqlArea, ARRAY_A );
                ?>
                
                  <label class="control-label">&Aacute;rea de servi&ccedil;o:</label>
                  <div class="controls">
                    <select class="form-control" name="barea" style="height:34px;">
                          <option></option>
                      <?php foreach($queryArea as $kA => $vA){?>
                          <option value="<?php echo $vA['id']?>" <?php echo @$dado['id_area']==$vA['id']?"selected":"";?> ><?php echo $vA['area']?></option>
                      <?php }?> 
                    </select>
                  </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <button type="submit" name="filtrar" id="filtrar" class="btn btn-primary filtrarList" style="">Filtrar</button>  
    </div>
  </form>
  <div style="clear:both;"></div>

  <div class="linhaComando">
    <img src="<?php echo plugins_url('../img/cross.png', __FILE__) ?>" width="16" height="16" alt="Excluir registros" />
    <a href="javascript:registros.submit();">Excluir registro</a>
  </div>
  
  <div class="linhaComando">
    <img src="<?php echo plugins_url('../img/page_white_code.png', __FILE__) ?>" width="16" height="16" alt="Exportar emails em XML" />
    <a href="<?php echo plugins_url('../exportaEmails.php', __FILE__)?>" target="_blank">Exportar emails em XML.</a>
  </div>

  <div class="linhaComando">
    <img src="<?php echo plugins_url('../img/page_white_acrobat.png', __FILE__) ?>" width="16" height="16" alt="Criar relatório de currículos." />
    <a href="<?php echo plugins_url('include/curriculoPDF.php', __FILE__)?>" target="_blank">Criar relatório de currículos.</a>
  </div>
  
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Área de serviço</th>
        <th>Data cadastro</th>
        <th width="60" style="text-align:center;">E-mail</th>
        <th width="50" style="text-align:center;">Arquivo</th>
        <th width="50" style="text-align:center;">PDF</th>
        <th width="30">Status</th>
        <th width="30">Editar</th>
        <th width="30" style="text-align:center;"><input type="checkbox" id="checkAll" /></th>
      </tr>
    </thead>
    <tbody>
    <form action="?page=<?php echo URL_LIST_CURR ?>" name="registros" id="registros" method="post">
        <?php 
            $x=0;
            foreach($query as $k => $v){
            //print_r($v);
    		
    		if($v->estado_civil==1){
    			$civil = "Solteiro(a)";
    		}elseif($v->estado_civil==2){
    			$civil = "Viuvo(a)";
    		}elseif($v->estado_civil==3){
    			$civil = "Casado(a)";
    		}elseif($v->estado_civil==4){
    			$civil = "Divorciado(a)";
    		}elseif($v->estado_civil==5){
    			$civil = "Amigável";
    		}
        ?>
              <input type="hidden" id="id_registro_<?php echo $x?>" value="<?php echo $v->id ?>" />
              <tr>
                <td id="nomeUser_<?php echo $x?>"><?php echo $v->nome ?></td>
                
                <td ><a class="abrirDescricao" rel="<?php echo $x; ?>" data-id="<?php echo $v->id ?>" style="cursor:pointer;" >Descrição completa</a><?php #echo $v->descricao ?></td>
                <div style="display:none" id="curriculo_<?php echo $x; ?>" class="wpcv_lightbox_content" >
                    <div class="wpcvcontent" style='display:none; padding:10px; background:#fff; width:680px;'>
                       
                        <h3><center><?php echo $v->nome ?></center></h3>
                        <strong>Dados Pessoais:</strong>
                        <hr style="margin-top:0px; border-top: 1px solid #000;" />
                        
                        <p>
                            <strong>Nome:</strong> <?php echo $v->nome ?><br />
                            <strong>Telefone:</strong> <?php echo $v->telefone ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Celular:</strong> <?php echo $v->celular ?><br />
                            <strong>E-mail:</strong> <?php echo $v->email ?><br />
                            <strong>Site/Blog:</strong> <?php echo $v->site_blog ?><br />
                            <strong>Skype:</strong> <?php echo $v->skype ?><br />
                            <strong>Estado cívil:</strong> <?php echo $civil ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Idade:</strong> <?php echo $wpcvp->dataHora($v->idade, 6) ?><br />
                            <strong>Área pretendida:</strong> <?php echo $v->area ?><br />
                            <strong>Remuneração:</strong> R$ <?php echo $v->remuneracao ?>
                        </p>
                        
                        <p>
                            <strong>Endereço:</strong>
                            <?php echo $v->rua?>, <?php echo $v->numero?><br />
                            <?php echo $v->bairro?> - <?php echo $v->cidade?> - <?php echo $v->estado?><br />
                            <strong>CEP:</strong> <?php echo $v->cep?>
                        </p>
                        
                        <p>
                        	<strong>Descrição:</strong><br/>
                            <?php echo $v->descricao?>
                        </p>
                        
                        <strong>Formação Acadêmica:</strong>
                        <hr style="margin-top:0px; border-top: 1px solid #000;" />
                        <?php 
                              global $wpdb;
                              $sqlFormacao = "SELECT * FROM ".BD_FORMA_ACADE." where id_cadastro = ".$v->id."";
                              $queryFormacao = $wpdb->get_results( $sqlFormacao );
                              foreach($queryFormacao as $kFA => $vFA){
                        ?>
                            <p>
                                <?php echo $vFA->subtitulo?> - <?php echo $vFA->iniciou?>  
                                
                                <?php if($vFA->status == 1){ ?>
                                    e ainda cursando. Pré-visto para terminar em <?php echo $vFA->finalizou?>.
                                <?php }elseif($vFA->status == 2){ ?>
                                    <?php echo " - ".$vFA->finalizou?>.
                                <?php }elseif($vFA->status == 3){ ?>
                                    e foi trancado.
                                <?php } ?>
                                 <br />
                                
                                <?php echo $vFA->escola_faculdade?> - <?php echo $vFA->cidade_escola_faculdade?>-<?php echo $vFA->estado_escola_faculdade?><br />
                                <ul style="list-style:inside;">
                                    <li><?php echo $vFA->formacao?></li>
                                </ul>
                                
                            </p>
                        <?php } 
                            $qtdeFormacao = count($queryFormacao['subtitulo']);
                        ?>
                        
                        <strong>Experiência Profissional:</strong>
                        <hr style="margin-top:0px; border-top: 1px solid #000;" />
                        
                        <?php 
                              global $wpdb;
                              $sqlEProfi = "SELECT * FROM ".BD_EXPERI_PROFIS." where id_cadastro = ".$v->id."";
                              $queryEProfi = $wpdb->get_results( $sqlEProfi );
                              foreach($queryEProfi as $kEP => $vEP){
                        ?>
                            <p>
                                Empresa - <?php echo $vEP->empresa?>
                                
                                <?php if($vEP->site_empresa){ ?>
                                    (<a href="<?php echo $vEP->protocolo_site?><?php echo $vEP->site_empresa?>" target="_blank"><?php echo $vEP->site_empresa?></a>)
                                <?php } ?> - <?php echo $vEP->cargo?>. <br />
                                
                                Desde <?php echo $vEP->ano_inicio?> até 
                                
                                <?php if($vEP->status_ep == 1){ ?>
                                    dias atuais.<br/>
                                <?php }else{ ?>
                                    <?php echo $vEP->ano_final?>.<br/>
                                <?php }?>
                                Atividades desempenhadas: <?php echo $vEP->mais_cargo?>
                                
                            </p>
                        <?php }
                            $qtdeExperiencia = count($queryEProfi['subtitulo']);
                        ?>
                        
                        <strong>Cursos e Palestras:</strong>
                        <hr style="margin-top:0px; border-top: 1px solid #000;" />
                        
                        <?php 
                              $sqlCursoP = "SELECT * FROM ".BD_CURSOS_PALEST." where id_cadastro = ".$v->id."";
                              $queryCursoP = $wpdb->get_results( $sqlCursoP );
                              foreach($queryCursoP as $kCP => $vCP){
                        ?>
                                  <p>
                                    <?php echo $vCP->ano?> - 
                                    <?php if($vCP->tipo == 1){ ?>
                                        Curso - 
                                    <?php }else{?>
                                        Palestra - 
                                    <?php }?>
                                    <?php echo $vCP->curso_palestra?> - (<?php echo $vCP->escola?>) - <?php echo $vCP->horas?>
                                  </p>
                        <?php }
                            $qtdeCurso = count($queryCursoP['subtitulo']);
                        ?>

                        <strong>Idiomas:</strong>
                        <hr style="margin-top:0px; border-top: 1px solid #000;" />
                        
                        <?php 
                              $sqlIdioma = "SELECT * FROM ".BD_IDIOMAS." where id_cadastro = ".$v->id."";
                              $queryIdioma = $wpdb->get_results( $sqlIdioma );
                              foreach($queryIdioma as $kI => $vI){
                        ?>
                                  <p>
                                    <?php echo $vI->iInicio?> - 
                                    <?php if($vI->iCursando == 1){ ?>
                                        Pré-visto para  <?php echo $vI->iFinal?> -
                                    <?php }else{?>
                                        <?php echo $vI->iFinal?> -  
                                    <?php }?>
                                    <?php echo $vI->iEscola?> - <?php echo $vI->iCurso?> - <?php echo $vI->iNivel?> - <?php echo $vI->iDescricao?> <br/>
                                  </p>
                        <?php }
                            
                            $qtdeIdioma = count($queryIdioma['iCurso']);
                        ?>

                        <strong>Conhecimento Técnico:</strong>
                        <hr style="margin-top:0px; border-top: 1px solid #000;" />
                        
                        <?php 
                              $sqlCT = "SELECT * FROM ".BD_CONHECI_TECNI." where id_cadastro = ".$v->id."";
                              $queryCT = $wpdb->get_results( $sqlCT );
                              foreach($queryCT as $kCT => $vCT){
                        ?>
                                  <p>
                                    <?php echo $vCT->ctCurso?> - <?php echo $vCT->ctNivel?> <br/>
                                  </p>

                        <?php }
                            
                            $qtdeConhecimento = count($queryCT['ctCurso']);
                        ?>
                        
                        
                        <p>
                            <?php #echo nl2br($v->descricao) ?>
                        </p>
                        
                        
                        
                        <a href="mailto:<?php echo $v->email?>" target="_blank">
                            <img src="<?php echo plugins_url('../img/email.png', __FILE__)?>" width="16" height="16" alt="<?php echo $v->email?>" /> <?php echo $v->email?>
                        </a><br />
                        
                        <a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" >Veja o anúncio</a>
                    </div>
                </div>
                
                <td><?php echo $v->area ?></td>
                
                <td class="text-right">                 
                  <?php if( $v->new ){ ?><span class="label label-danger" id="cv_<?php echo $v->id ?>">NOVO</span><?php } ?>
                  <?php echo date( 'd/m/Y H:i', strtotime($v->created_at)) ?>
                </td>
                
                <td style="text-align:center;"><a href="mailto:<?php echo $v->email?>" target="_blank">
                <img src="<?php echo plugins_url('../img/email.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->email?>" /></a></td>
                
                <td style="text-align:center;"><a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" > <img src="<?php echo plugins_url('../img/page_white_text.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->curriculo?>" /></a></td>
                <td style="text-align:center;"><a href="<?php echo plugins_url('include/curriculoPDF.php?id_curriculo='.$v->id, __FILE__)?>" target="_blank" > <img src="<?php echo plugins_url('../img/page_white_acrobat.png', __FILE__) ?>" width="16" height="16" alt="Abrir currículo em PDF de <?php echo $v->nome?>" /></a></td>
                
                <td>
                    <select class="statusSelect" id="status_<?php echo $x?>" style="width: 130px;">
                        <option value="0" <?php echo $v->status == 0?"selected":""?>  style="color:blue;">Aguardando</option>
                        <option value="1" <?php echo $v->status == 1?"selected":""?> style="color:red;">Reprovado</option>
                        <option value="2" <?php echo $v->status == 2?"selected":""?> style="color:green;">Aprovado</option>
                    </select>
                </td>
                
                <td style="text-align:center;">
                    
                    <a href="?page=<?php echo URL_FOR_REG ?>&id_cadastro=<?php echo $v->id?>" >
                      <img src="<?php echo plugins_url('../img/user_edit.png', __FILE__)?>" width="16" height="16" alt="<?php echo $v->nome?>" style="padding:0;" /></a><br />
                    
                </td>
                
                <td style="text-align:center;">
                    <input type="checkbox" name="excl[]" value="<?php echo $v->id ?>" class="check" />
                </td>
                
              </tr>
              
        <?php $x++; }  ?>
    </form>
    </tbody>
  </table>
  
  <?php include( plugin_dir_path( __FILE__ ) . '../classes/paginacao2.php' ); ?>
  
</div>
<div id="black_overlay"></div>
<div id="black_overlay_status"></div>
<div id="aviso">
	<h4>Atualizando status</h4>
    <div id="avisoMensagem">
    	Aguarde um momento, enquanto atualizada status do currículo <strong><span id="nomeCurriculo"></span></strong>.
    </div>
    <div id="avisoMensagemErro" style="display:none;"><span id='fecharAviso'><strong>Clique aqui</strong></span> para fechar a mensagem.</div>
</div>