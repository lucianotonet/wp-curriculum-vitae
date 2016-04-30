<?php

global $wpdb, $wpcvp;
	
$pg = $_GET['pg'];

foreach ($_POST as $key=>$value){
  ${$key} = $value;
}

$headBusca = "";

$busca? 	$headBusca .= $buscar.".&nbsp;&nbsp;":"";
$bairro? 	$headBusca .= $bairro."&nbsp;-&nbsp;":"";
$cidade? 	$headBusca .= $cidade."&nbsp;-&nbsp;":"";
$estado? 	$headBusca .= $estado.".":"";

echo $headBusca;

$where = "";


if($buscar != ''){
	$where .= " and ( LOWER(a.nome) LIKE  '%".strtolower($buscar)."%' or LOWER(a.descricao) LIKE '%".strtolower($buscar)."%' or LOWER(b.area) LIKE '%".strtolower($buscar)."%')";
}

if($bairro != ''){
	$where .= " and LOWER(a.bairro) LIKE  '%".strtolower($bairro)."%'";
}

if($cidade != ''){
	$where .= " and LOWER(a.cidade) LIKE  '%".strtolower($cidade)."%'";
}

if($estado != ''){
	$where .= " and LOWER(a.estado) LIKE  '%".strtolower($estado)."%'";
}

######### INICIO Paginação
$numreg = 20; // Quantos registros por página vai ser mostrado
if (!isset($pg)) {
	$pg = 0;
}

$inicial = $pg * $numreg;

######### FIM dados Paginação

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
		
		where 1=1 and a.status = 2 $where group by a.id order by a.nome asc LIMIT $inicial, $numreg ";
		
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
		   
		   where 1=1 and a.status = 2 $where group by a.id order by a.nome asc";
		   
$queryRow = $wpdb->get_results( $sqlRow );
$quantreg = $wpdb->num_rows; // Quantidade de registros pra paginação

include( plugin_dir_path( __FILE__ ) . 'classes/estados.php' );

?>

        <form id="wp-curriculo-busca-rapida" method="post">
          <input type="hidden" id="url_ajax" value="<?php echo admin_url( 'admin-ajax.php' ); ?>"  />
          <div class="form-group">
            <div class="controls">
              <input type="text" name="buscar" placeholder="Nome, área de atuação, experiência..." class="form-control" > 
            </div>
          </div>   
          
          
          <div class="form-group">
            <div class="controls">
              <select name="estado" class="form-control" id="estado">
                <option value="">Selecione o estado</option>
                <?php
              
                    $sqlEstado = "SELECT estado FROM ".BD_CURRICULO." where 1=1 and status = 2 group by estado";
                    $queryEstado = $wpdb->get_results( $sqlEstado );
                ?>
                <?php foreach($queryEstado as $kE => $vE){?>
                    <option value="<?php echo $vE->estado?>"><?php echo utf8_encode($estadoArray[$vE->estado])?></option>
                <?php }?>
              </select>
            </div>
          </div>   
          
          <div class="form-group">
            <div class="controls">
              <select name="cidade" class="form-control" disabled="disabled" id="cidade">
                <option value="">Selecione a cidade</option>
              </select>
            </div>
          </div>   
          
          <div class="form-group">
            <div class="controls">
              <select name="bairro" class="form-control" disabled="disabled" id="bairro">
                <option value="">Selecione o bairro</option>
              </select>
            </div>
          </div>   
          <button type="submit" name="novaSenha" class="btn btn-primary">Pesquisar</button>          

        </form>
        <div style="clear:both; height:30px; "></div>
<table class="wp-curriculo-table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Área de serviço</th>
              <th width="50" style="text-align:center;">E-mail</th>
              <th width="50" style="text-align:center;">Arquivo</th>
            </tr>
          </thead>
          <tbody>
          <?php 
		  $x=1;
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
				
				if($v->status=="2"){
                ?>
                <tr>
                  <td><?php echo $v->nome ?></td>
                  
                  <td ><a class="abrirDescricao" rel="<?php echo $x; ?>" style="cursor:pointer;">Visualizar</a></td>
                  
                  <td><?php echo $v->area ?></td>
                  
                  <td style="text-align:center;"><a href="mailto:<?php echo $v->email?>" target="_blank">
                  <img src="<?php echo plugins_url('img/email.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->email?>" /></a></td>
                  
                  <td style="text-align:center;">
                    <?php if($v->curriculo != ""){ ?>
                              <a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" > <img src="<?php echo plugins_url('../img/page_white_text.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->curriculo?>" /></a>
                    <?php  }else{ ?>
                              -
                    <?php  } ?>
                  </td>
                  <div style="display:none" class="wpcv_lightbox_content" id="curriculo_<?php echo $x; ?>">
                    <div class="wpcvcontent" style='padding:10px; background:#fff;'>
                       
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
                        	<strong>Endereço:</strong><br/>
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
                        <?php }?>
                        
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
                                Mais experiência: <?php echo $vEP->mais_cargo?>
                                
                                
                            </p>
                        <?php }?>
                        
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
                <?php }?>

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
                      		<img src="<?php echo plugins_url('img/email.png', __FILE__)?>" width="16" height="16" alt="<?php echo $v->email?>" /> <?php echo $v->email?>
                        </a><br />
                    </div>
                </div>
                
                </tr>
                
          <?php } $x++; }  ?>
            
          </tbody>
        </table>
		<div id="black_overlay"></div>        
		<?php 
			
			if($quantreg > $numreg){
				// Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> 
				include( plugin_dir_path( __FILE__ ) . 'classes/paginacao.php' ); 
			}
		?>

