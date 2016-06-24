<?php
global $wpdb, $wpcvp;

$id_cadastro = @$_GET['id_cadastro'];

if(isset($_POST['cadastrar'])){
	// print_r($_POST);
	// exit;
	include_once( plugin_dir_path( __FILE__ ) . 'include/enviarCadastro.php' );
}

$dado = $wpdb->get_row("SELECT a.*,
								 b.area,
								 c.id as id_formacao,
								 d.id as id_experiencia,
								 e.id as id_curso_palestra,
                 f.id as id_idiomas,
                 g.id as id_idiomas
						  
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
						  
						  where a.id = '".@$id_cadastro."'", ARRAY_A);

wp_enqueue_style('wpcvpa_style', plugins_url('css/style.css', __FILE__));						  
wp_enqueue_style('wpcvpa_bootstrap', plugins_url('../css/bootstrap.min.css', __FILE__));

wp_enqueue_script('jquery');	
wp_enqueue_script('wpcvpa_bootstrap', plugins_url('../js/bootstrap.min.js', __FILE__));
wp_enqueue_script('wpcvpa_scriptMask', plugins_url('../js/jquery.maskedinput-1.1.4.pack.js', __FILE__));
wp_enqueue_script('wpcvpa_scriptArea', plugins_url('../js/scriptArea.js', __FILE__));
wp_enqueue_script('wpcvpa_script', plugins_url('js/script.js', __FILE__));

?>

<div class="container-fluid">
  <?php if($id_cadastro){ ?>
  	<h2>Editar Cadastro: <?php echo $dado['nome']?></h2>  
  <?php }else{ ?>
  	<h2><?php echo NAME_FOR_REG ?></h2>  
  <?php } ?>
  
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active" id="bt_dadosPessoais">
        <a href="#">Dados Pessoais</a>
      </li>
      <li id="bt_formacaoAcademica">
        <a href="#">Forma&ccedil;&atilde;o Acad&ecirc;mica</a>
      </li>
      <li id="bt_experienciaProfissional">
        <a href="#">Experi&ecirc;ncia Profissional</a>
      </li>
      <li id="bt_cursosPalestras">
        <a href="#">Cursos e Palestras</a>
      </li>
      <li id="bt_idiomas">
        <a href="#">Idiomas</a>
      </li>
      <li id="bt_conhecimentoTecnico">
        <a href="#">Conhecimento Técnico</a>
      </li>
    </ul>
  </div>
  
  <?php if(@$_GET['msg']==2){ ?>
  
    <div class="alert alert-success" style="text-align:center;">Currículo Atualizado com sucesso!</div>	

  <?php }elseif(@$_GET['msg']==1){ ?>
  
      <div class="alert alert-success" style="text-align:center;">Currículo cadastrado com sucesso!</div>	
      
  <?php }?>
    
  <form id="formCadastro" name="formCadastro" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tipoF" value="admin" />
    
	<?php if($dado['id']) { ?>
    	<input type="hidden" name="mod" value="edit" />
        <input type="hidden" name="id_cadastro" id="id_cadastro" value="<?php echo $dado['id']; ?>" />
    <?php }else{ ?>
  		<input type="hidden" name="mod" value="new" />
    <?php }?>
    
    <div class="container-fluid" id="dadosPessoais">
		<?php ################################################################################################ ?>
        <? #inicio dados pessoais ?> 
        
        <div class="container-fluid">
        	<h4><b>Dados Pessoais</b></h4>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Nome:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="nome" value="<?php echo @$dado['nome']?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Sexo:</label>
                  <div class="controls">
                    <select class="form-control" name="sexo">
                      <option></option>	
                      <option value="0" 	<?php echo @$dado['sexo']=="0"?"selected":"" ?> >Feminino</option>
                      <option value="1" 	<?php echo @$dado['sexo']=="1"?"selected":""?>	>Masculino</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Estado c&iacute;vil:</label>
                  <div class="controls">
                    <select class="form-control" name="estado_civil">
                      <option value="0"></option>
                      <option value="1" <?php echo @$dado['estado_civil']=="1"?"selected":"";?>>Solteiro(a)</option>
                      <option value="2" <?php echo @$dado['estado_civil']=="2"?"selected":"";?>>Viuvo(a)</option>
                      <option value="3" <?php echo @$dado['estado_civil']=="3"?"selected":"";?>>Casado(a)</option>
                      <option value="4" <?php echo @$dado['estado_civil']=="4"?"selected":"";?>>Divorciado(a)</option>
                      <option value="5" <?php echo @$dado['estado_civil']=="5"?"selected":"";?>>Amigável</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Data de nascimento:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="idade" id="idade" value="<?php echo @$dado['idade']?>" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Telefone:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo @$dado['telefone']?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">Celular:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="celular" id="celular" value="<?php echo @$dado['celular']?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">E-mail:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="email" value="<?php echo @$dado['email']?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Skype:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="skype" value="<?php echo @$dado['skype']?>" />
                  </div>
                </div>
              </div>
            </div>

            <!--
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="control-label">Site/Blog:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="site_blog" value="<?php echo @$dado['site_blog']?>" />
                  </div>
                </div>
              </div>
            </div>
          -->

            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                
                <?php
                    global $wpdb;
                    $sqlArea = "SELECT * FROM ".BD_AREA_SERVICOS." where 1=1";
                    $queryArea = $wpdb->get_results( $sqlArea, ARRAY_A );
                ?>
                
                  <label class="control-label">Cargo pretendido:</label>
                  <div class="controls">
                    <select class="form-control" id="id_area" name="id_area">
                    	  <option value="0">Selecione uma área</option>
                      <?php foreach($queryArea as $kA => $vA){?>
                          <option value="<?php echo $vA['id']?>" <?php echo @$dado['id_area']==$vA['id']?"selected":"";?> ><?php echo $vA['area']?></option>
                      <?php }?>	
                      <option value="outro">Outro</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group" id="campoArea" style="display:none;">
                  <label class="control-label">Escreva sua &aacute;rea:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="area">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">CPF:</label>
                  <div style="clear:both;"></div>
                  <div class="controls">
                    
                    <div class="row">
                      <div class="col-md-9">
                        <input type="text" class="form-control pull-left" name="cpf" id="cpf" value="<?php echo @$dado['cpf'];?>">
                      </div>
                      <div class="col-md-1">
                        <img id="tick" src="<?php echo plugins_url('../img/wp-cv-correto.png', __FILE__) ?>" class="pull-left" width="16" height="16"/>
                        <img id="cross" src="<?php echo plugins_url('../img/wp-cv-incorreto.png', __FILE__) ?>" class="pull-left" width="16" height="16"/>
                      </div>
                    </div>
                    <span id="msgCpf">Só é permitido um CPF por cadastro.</span>
                    
                  </div>
                    
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Remunera&ccedil;&atilde;o:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="remuneracao" value="<?php echo @$dado['remuneracao'];?>" />
                  </div>
                </div>
              </div>
            </div>

            <!--
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label class="control-label">Login:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="login" value="<?php echo @$dado['login'];?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label class="control-label">Senha:</label>
                  <div class="controls">
                    <input type="password" class="form-control" name="senha">
                  </div>
                </div>
              </div>
            </div>
          -->

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label class="control-label">CEP:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="cep" value="<?php echo @$dado['cep'];?>" id="cep" />
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label">Rua:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="rua" value="<?php echo @$dado['rua'];?>" id="rua" />
                  </div>
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label class="control-label">N&ordm;:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="numero" value="<?php echo @$dado['numero'];?>" id="numero" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label">Bairro:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="bairro" value="<?php echo @$dado['bairro'];?>" id="bairro" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                  <label class="control-label">Cidade:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="cidade" value="<?php echo @$dado['cidade'];?>" id="cidade" />
                  </div>
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-group">
                  <label class="control-label">Estado:</label>
                  <div class="controls">
                    <input type="text" class="form-control" name="estado" value="<?php echo @$dado['estado'];?>" id="estado" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="control-label">Descri&ccedil;&atilde;o:</label>
                  <div class="controls">
                    <textarea class="form-control input-block-level" name="descricao"><?php echo @$dado['descricao'];?></textarea>
                  </div>
                </div>
              </div>
        </div>
    </div>
        <?php ################################################################################################ ?>
            
        <div class="form-group" style="margin-left:15px;">
        
          <label class="control-label">Enviar foto:</label>
          
          <?php if($dado['curriculo']){ ?>
              <input type="hidden" name="curriculoCar" value="<?php echo @$dado['curriculo'];?>" />
              <div class="well">
                  <a href="<?php echo content_url( 'uploads/curriculos/'.$dado['curriculo']); ?>" target="_blank" > <?php echo @$dado['curriculo'] ?></a>
              </div>
          <?php } ?>
          
          <div class="controls">

            <input type="hidden" name="curriculoCar" value="<?php echo @$dado['curriculo'];?>" id="curriculoCar" style="margin-bottom:-15px;" ><br />
            <input type="file" name="curriculo" id="curriculo" style="margin-bottom:-15px;" ><br />
          	<span id="msgFile">Não é permitido enviar arquivo com extensão <b><span id="ext"></span></b>. Extensões permitidas: <strong>pdf</strong>, <strong>doc</strong> e <strong>docx</strong>.
            </span>  
          </div><br />
          
        </div>
        
    </div>
    <? #fim dados pessoais ?>
    
    <? #Inicio formação acadêmica ?>
    <div class="container-fluid" id="formacaoAcademica" style="display:none;">
    	
        
        <?php 
            global $wpdb;
			
            $sqlFormacao = "SELECT * FROM ".BD_FORMA_ACADE." where id_cadastro = ".$dado['id']." order by id asc";
            $queryFormacao = $wpdb->get_results( $sqlFormacao, ARRAY_A);
            if($queryFormacao){

                foreach($queryFormacao as $kFA => $vFA){
                  include( plugin_dir_path( __FILE__ ) . '_formacao_academica.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . '_formacao_academica.php' );
            }
        ?>
         
        <div class="container-fluid">
          <a class="btn adicionarNovaFormacao pull-right btn-primary">Adicionar mais</a>
        </div>
    </div>
    <? #Fim formação acadêmica ?>
    
    <? #Inicio experiência profissional ?>
    <div class="container-fluid" id="experienciaProfissional" style="display:none;">
        
        <?php 
            global $wpdb;
            $sqlEProfi = "SELECT * FROM ".BD_EXPERI_PROFIS." where id_cadastro = ".$dado['id']." order by id asc";
            $queryEProfi = $wpdb->get_results( $sqlEProfi, ARRAY_A);
            if($queryEProfi){
                foreach($queryEProfi as $kEP => $vEP){
                  include( plugin_dir_path( __FILE__ ) . '_experiencia_profissional.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . '_experiencia_profissional.php' );
            }
        ?>
        
        <div class="container-fluid">
          <a class="btn adicionarNovaExperiencia pull-right btn-primary">Adicionar mais</a>
        </div>

    </div>
    <? #Fim experiência profissional ?>
    
    <? #inicio cursos e palestras ?>
    <div class="container-fluid" id="cursosPalestras" style="display:none;">

        <?php 
            global $wpdb;
            $sqlCursoP = "SELECT * FROM ".BD_CURSOS_PALEST." where id_cadastro = ".$dado['id']." order by id asc";
            $queryCursoP = $wpdb->get_results( $sqlCursoP, ARRAY_A );
            if($queryCursoP){
                foreach($queryCursoP as $kCP => $vCP){
                  include( plugin_dir_path( __FILE__ ) . '_curso_palestra.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . '_curso_palestra.php' );
            }
        ?>

        <div class="container-fluid">
          <a class="btn adicionarNovaCursoPalestra pull-right btn-primary">Adicionar mais</a>
        </div>
         
    </div>
    <? #Fim cursos e palestras ?>
    
    <? #Idiomas ?>
    <div class="container-fluid" id="idiomas" style="display:none;">
        <?php 
            global $wpdb;
            $sqlI = "SELECT * FROM ".BD_IDIOMAS." where id_cadastro = ".$dado['id']." order by id asc";
            $queryI = $wpdb->get_results( $sqlI, ARRAY_A );
            if($queryI){
                foreach($queryI as $kI => $vI){
                  include( plugin_dir_path( __FILE__ ) . '_idiomas.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . '_idiomas.php' );
            }
        ?>

        <div class="container-fluid">
          <a class="btn adicionarNovaIdioma pull-right btn-primary">Adicionar mais</a>
        </div>

    </div>
    <? #Fim idiomas ?>

    <? #Conhecimento ?>
    <div class="container-fluid" id="conhecimentoTecnico" style="display:none;">
        <?php 
            global $wpdb;
            $sqlCT = "SELECT * FROM ".BD_CONHECI_TECNI." where id_cadastro = ".$dado['id']." order by id asc";
            $queryCT = $wpdb->get_results( $sqlCT, ARRAY_A );
            if($queryCT){
                foreach($queryCT as $kCT => $vCT){
                  include( plugin_dir_path( __FILE__ ) . '_conhecimento_tecnico.php' );
                } 
            }else{ 
                  include( plugin_dir_path( __FILE__ ) . '_conhecimento_tecnico.php' );
            }
        ?>
        <div class="container-fluid">
          <a class="btn adicionarNovaConhecimentoTecnico pull-right btn-primary">Adicionar mais</a>
        </div>
    </div>
    <? #Fim conhecimento ?>


    <div class="container-fluid">
  	  <?php if($id_cadastro){ ?>
          <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-success">Atualizar</button>  
      <?php }else{ ?>
          <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-success">Cadastrar</button>
      <?php } ?>	
    </div>

  </form>

</div>


