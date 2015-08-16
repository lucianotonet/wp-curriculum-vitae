<?php

global $wpdb, $wpcvp;

if(isset($_POST['cadastrar'])){
	include_once(plugin_dir_path( __FILE__ ) . 'admin/include/enviarCadastro.php' );
}

$sqlF = "SELECT a.*,
			  b.area,
			  c.id as id_formacao,
			  d.id as id_experiencia,
			  e.id as id_curso_palestra,
        f.id as id_idioma,
        g.id as id_idioma
	   
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
	   
			where a.id = '".@$_SESSION['id_cadastro']."' ";
		
		
		$queryF = $wpdb->get_results( $sqlF, ARRAY_A );
		
		foreach($queryF as $kF => $vF){
			$dadosF = $vF;
		}


?>
	
    <div class="menu-curriculos">
      <ul class="nav navbar-nav">
        <li class="active" id="bt_dadosPessoais">
          <a href="javascript:0">1 Dados Pessoais</a>
        </li>
        <li id="bt_formacaoAcademica">
          <a href="javascript:0">2 Forma&ccedil;&atilde;o Acad&ecirc;mica</a>
        </li>
        <li id="bt_experienciaProfissional">
          <a href="javascript:0">3 Experi&ecirc;ncia</a>
        </li>
        <li id="bt_cursosPalestras">
          <a href="javascript:0">4 Cursos/Palestras</a>
        </li>
        <li id="bt_idiomas">
          <a href="#">5 Idiomas</a>
        </li>
        <li id="bt_conhecimentoTecnico">
          <a href="#">6 Conhecimento Técnico</a>
        </li>
      </ul>
    </div>
    
<div class="form-curriculos">
	
  

  <?php if(@$_GET['msg']==1){ ?>
  
  	  <div class="alert alert-success" style="text-align:center; color: #3c763d;">Curriculo cadastrado com sucesso!</div>	
      
  <?php }elseif(@$_GET['msg']==2){ ?>
  
  	  <div class="alert alert-success" style="text-align:center; color: #3c763d;">Curriculo Atualizado com sucesso!</div>	
  
  <?php }elseif(@$_GET['msg']==3){ ?>
      
      <div class="alert alert-success" style="text-align:center; color: #3c763d;">Conta excluido com sucesso!</div>	
      
  <?php }?>
  
  <form id="wp-curriculo-cadastro" name="wp-curriculo-cadastro" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tipoF" value="site" />
    
    <?php if(@$_SESSION['logado']==1 && @$dadosF['id']) { ?>
    	
        <input type="hidden" name="mod" value="edit" />
        <input type="hidden" name="id_cadastro" value="<?php echo @$dadosF['id']; ?>" />
        <div class="form-group">
          <div class="controls">
            <span style="font-size:14px;">Excluir a conta</span> <input type="checkbox" name="excluirConta" value="1" style="margin-top:-2px;"> 
          </div>
        </div>
        
    <?php }else{ ?>
    
  		<input type="hidden" name="mod" value="new" />
        <input type="hidden" name="excluirConta" value="0" />
        
    <?php }?>
    
    <div id="dadosPessoais">
        <h3>Informações Pessoais:</h3>
        
        <div class="row">
        	<div class="col-md-7">
            	<div class="form-group">
                  <div class="controls">
                    <input type="text" name="nome" class="form-control" value="<?php echo @$dadosF['nome']?>" placeholder="nome" /> 
                  </div>
                </div>
            </div>
            <div class="col-md-5">
            	<div class="form-group">
                  <div class="controls">
                    <select class="form-control" name="sexo">
                      <option>sexo</option> 
                      <option value="0"   <?php echo @$dadosF['sexo']=="0"?"selected":"" ?> >feminino</option>
                      <option value="1"   <?php echo @$dadosF['sexo']=="1"?"selected":""?> >masculino</option>
                    </select>
                  </div>
                </div>
            </div>
        </div>
        
        
        <div class="row">
          <div class="col-md-6">
                <div class="form-group">
                  <div class="controls">
                    <select name="estado_civil" class="form-control">
                        <option value="0">estado cívil</option>
                        <option value="1" <?php echo @$dadosF['estado_civil']=="1"?"selected":"";?>>solteiro(a)</option>
                        <option value="2" <?php echo @$dadosF['estado_civil']=="2"?"selected":"";?>>viuvo(a)</option>
                        <option value="3" <?php echo @$dadosF['estado_civil']=="3"?"selected":"";?>>casado(a)</option>
                        <option value="4" <?php echo @$dadosF['estado_civil']=="4"?"selected":"";?>>divorciado(a)</option>
                        <option value="5" <?php echo @$dadosF['estado_civil']=="5"?"selected":"";?>>união estável</option>
                    </select>
                  </div>
                </div>
            </div>
          <div class="col-md-6">
                <div class="form-group">
                  <div class="controls">
                    <input type="text" name="idade" value="<?php echo @$dadosF['idade']?>" class="form-control" id="idade" placeholder="data de nascimento" />
                  </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <div class="controls">
                    <input type="text" name="telefone" id="telefone" value="<?php echo @$dadosF['telefone']?>" class="form-control" id="telefone" placeholder="telefone" />
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <div class="controls">
                    <input type="text" name="celular" value="<?php echo @$dadosF['celular']?>" class="form-control" id="celular" placeholder="celular"/>
                  </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
          <div class="controls">
            <input type="email" name="email" value="<?php echo @$dadosF['email']?>" class="form-control" placeholder="e-mail"> 
          </div>
        </div>
        
        <!-- <div class="form-group">
          <label class="control-label">Site/blog:</label>
          <div class="controls">
            <input type="text" name="site_blog" value="<?php echo @$dadosF['site_blog']?>" class="form-control"> 
          </div>
        </div> -->
        
        <div class="form-group">
          <div class="controls">
            <input type="text" name="skype" value="<?php echo @$dadosF['skype']?>" class="form-control" placeholder="skype">
          </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <?php              
                      
                      $sqlArea = "SELECT * FROM ".BD_AREA_SERVICOS." where 1=1 group by area";
                      $queryArea = $wpdb->get_results( $sqlArea );
                  ?>
                  <div class="controls">
                    <select name="id_area" class="form-control" id="id_area">
                      <option value="0">selecione sua área pretendida</option>
                      <?php foreach($queryArea as $k => $v){?>
                          <option value="<?php echo $v->id?>" <?php echo @$dadosF['id_area']==$v->id?"selected":"";?> ><?php echo $v->area?></option>
                      <?php }?>
                      <option value="outro">Outra área</option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="campoArea" style="display:none;">
                    <div class="controls">
                        <input type="text" name="area" class="form-control" placeholder="escreva sua área"/>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
          <div class="controls">
            <input type="text" name="remuneracao" value="<?php echo @$dadosF['remuneracao']?>" class="form-control" placeholder="remuneração"> 
          </div>
        </div>

        <!--
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <div class="controls">
                    <input type="text" name="login" value="<?php echo @$dadosF['login']?>" class="form-control" placeholder="login"> 
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <div class="controls">
                    <input type="password" name="senha" value="" class="form-control" placeholder="senha">  
                  </div>
                </div>
            </div>
        </div>
        -->

        <div class="form-group">
          <div class="controls">
          
            <div class="row">
                <div class="col-md-10">
                    <input type="text" name="cpf" value="<?php echo @$dadosF['cpf']?>" class="form-control" id="cpf" placeholder="cpf" />
                </div>
                <div class="col-md-2">
                    <img id="tick" src="<?php echo plugins_url('img/wp-cv-correto.png', __FILE__) ?>" class="pull-left" width="16" height="16"/>
                    <img id="cross" src="<?php echo plugins_url('img/wp-cv-incorreto.png', __FILE__) ?>" class="pull-left" width="16" height="16"/>
                </div>
            </div>
           
            <span id="msgCpf">Só é permitido um cadastro por CPF.</span>
          </div>
        </div>
        
        <div class="form-group">
          <div class="controls">
            
            <input type="text" name="cep" value="<?php echo @$dadosF['cep']?>" class="form-control" id="cep" placeholder="cep" /> 
          </div>
        </div>
                
      <div class="row">
            <div class="col-md-9">
                <div class="form-group rua">
                <div class="controls">
                  <input type="text" name="rua" id="rua" value="<?php echo @$dadosF['rua']?>" class="form-control" placeholder="rua" /> 
                </div>
              </div>
            </div>
            <div class="col-md-3">
                <div class="form-group numero">
                  <div class="controls">
                    <input type="text" name="numero" id="numero" value="<?php echo @$dadosF['numero']?>" class="form-control" placeholder="nº"/> 
                  </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
          <div class="controls">
            <input type="text" name="bairro" id="bairro" value="<?php echo @$dadosF['bairro']?>" class="form-control" placeholder="bairro" /> 
          </div>
        </div>
        
        <div class="row">
            <div class="col-md-9">
                <div class="form-group cidade">
                  <div class="controls">
                    <input type="text" name="cidade" id="cidade" value="<?php echo @$dadosF['cidade']?>" class="form-control" placeholder="cidade" /> 
                  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group estado">
                  <div class="controls">
                    <input type="text" name="estado" id="estado" value="<?php echo @$dadosF['estado']?>" class="form-control" placeholder="estado" /> 
                  </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
          <div class="controls">
            <textarea class="form-control" name="descricao" placeholder="observações"><?php echo @$dadosF['descricao']?></textarea>
          </div>
        </div>
        
        <?php if($dadoF['curriculo']){ ?>
            <input type="hidden" name="curriculoCar" value="<?php echo @$dadoF['curriculo'];?>" />
            <div class="container-fluid">
                <label class="control-label">Arquivo já salvo:</label>	
                <div class="well">
                    <a href="<?php echo content_url( 'uploads/curriculos/'.@$dadosF['curriculo']); ?>" target="_blank" > <?php echo @$_SESSION['curriculo'] ?></a>
                </div>
            </div>
        <?php } ?>
          
        <div class="form-group">
          <label class="control-label">Envie uma foto sua:</label>
          <div class="controls">
            <input type="file" name="curriculo" class="input-medium input-block-level" id="curriculo" />
            <span id="msgFile">Não é permitido enviar arquivo com extensão <b><span id="ext"></span></b>. Extensões permitidas: <strong>pdf</strong>, <strong>doc</strong> e <strong>docx</strong>.</span>  
          </div>
        </div>
        <span>Para completar o seu currículo, passe para a próxima etapa.</span><br>
        <a href="#" class="btn btn-success next-step pull-right">Próxima etapa</a>

    </div>
    
    
    <div id="formacaoAcademica" style="display:none;">
        <?php 
            global $wpdb;
            $sqlFormacao = "SELECT * FROM ".BD_FORMA_ACADE." where id_cadastro = ".$dadosF['id']." order by id desc";
            $queryFormacao = $wpdb->get_results( $sqlFormacao, ARRAY_A );
            if($queryFormacao){
                foreach($queryFormacao as $kFA => $vFA){
                  include( plugin_dir_path( __FILE__ ) . 'include/_formacao_academica.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . 'include/_formacao_academica.php' );
            }
        ?>
        <div class="adicionar-btn">
          <a class="btn adicionarNovaFormacao pull-right btn-primary">adicionar mais</a>
        </div>
        <span>Para completar o seu currículo, passe para a próxima etapa.</span><br>
        <a href="#" class="btn btn-success next-step pull-right">Próxima etapa</a>
        <a href="#" class="btn btn-success prev-step">Etapa anterior</a>
    </div>
    
    <div id="experienciaProfissional" style="display:none;">
        <?php 
            global $wpdb;
            $sqlEProfi = "SELECT * FROM ".BD_EXPERI_PROFIS." where id_cadastro = ".$dadosF['id']." order by id desc";
            $queryEProfi = $wpdb->get_results( $sqlEProfi, ARRAY_A );
            if($queryEProfi){
                foreach($queryEProfi as $kEP => $vEP){
                  include( plugin_dir_path( __FILE__ ) . 'include/_experiencia_profissional.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . 'include/_experiencia_profissional.php' );
            }
        ?>
        <div class="adicionar-btn">
          <a class="btn adicionarNovaExperiencia pull-right btn-primary">adicionar mais</a>
        </div>
        <span>Para completar o seu currículo, passe para a próxima etapa.</span><br>
        <a href="#" class="btn btn-success next-step pull-right">Próxima etapa</a>
        <a href="#" class="btn btn-success prev-step">Etapa anterior</a>
    </div>
    
  <div id="cursosPalestras" style="display:none;">
        <?php 
            global $wpdb;
            $sqlCursoP = "SELECT * FROM ".BD_CURSOS_PALEST." where id_cadastro = ".$dadosF['id']." order by id desc";
            $queryCursoP = $wpdb->get_results( $sqlCursoP, ARRAY_A );
            if($queryCursoP){
                foreach($queryCursoP as $kCP => $vCP){
                  include( plugin_dir_path( __FILE__ ) . 'include/_curso_palestra.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . 'include/_curso_palestra.php' );
            }
        ?>
        <div class="adicionar-btn">
          <a class="btn adicionarNovaCursoPalestra pull-right btn-primary">adicionar mais</a>
        </div>
        <span>Para completar o seu currículo, passe para a próxima etapa.</span><br>
        <a href="#" class="btn btn-success next-step pull-right">Próxima etapa</a>
        <a href="#" class="btn btn-success prev-step">Etapa anterior</a>
    </div>

    <? #Idiomas ?>
    <div id="idiomas" style="display:none;">
        <?php 
            global $wpdb;
            $sqlI = "SELECT * FROM ".BD_IDIOMAS." where id_cadastro = ".$dado['id']." order by id desc";
            $queryI = $wpdb->get_results( $sqlI, ARRAY_A );
            if($queryI){
                foreach($queryI as $kI => $vI){
                  include( plugin_dir_path( __FILE__ ) . 'include/_idiomas.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . 'include/_idiomas.php' );
            }
        ?>
        <div class="adicionar-btn">
          <a class="btn adicionarNovaIdioma pull-right btn-primary">adicionar mais</a>
        </div>
        <span>Para completar o seu currículo, passe para a próxima etapa.</span><br>
        <a href="#" class="btn btn-success next-step pull-right">Próxima etapa</a>
        <a href="#" class="btn btn-success prev-step">Etapa anterior</a>
    </div>
    <? #Fim idiomas ?>

    <? #Conhecimento ?>
    <div id="conhecimentoTecnico" style="display:none;">
        <?php 
            global $wpdb;
            $sqlCT = "SELECT * FROM ".BD_CONHECI_TECNI." where id_cadastro = ".$dado['id']." order by id desc";
            $queryCT = $wpdb->get_results( $sqlCT, ARRAY_A );
            if($queryCT){
                foreach($queryCT as $kCT => $vCT){
                  include( plugin_dir_path( __FILE__ ) . 'include/_conhecimento_tecnico.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . 'include/_conhecimento_tecnico.php' );
            }
        ?>        
    </div>
    <? #Fim conhecimento ?>
    

  </form>
</div>
