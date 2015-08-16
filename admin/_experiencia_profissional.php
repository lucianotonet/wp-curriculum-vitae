<div class="container-fluid experienciaprofissional"> 
  <h4><b>Experi&ecirc;ncia Profissional:</b></h4>
	<input type="hidden" name="id_experiencia[]" value="<?php echo @$vEP['id']?>" />
	
    <div class="form-group">
      <label class="control-label">Empresa:</label>
      <div class="controls">
        <input type="text" class="form-control" name="empresa[]" value="<?php echo @$vEP['empresa']?>" />
      </div>
    </div>

    <!--
	<div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label class="control-label">Protocolo:</label>
        <div class="controls">
          <select class="form-control" name="protocolo_site[]" >
            <option value="0"></option>
            <option value="http://" <?php echo @$vEP['protocolo_site']=="http://"?"selected":"";?>>http://</option>
            <option value="https://" <?php echo @$vEP['protocolo_site']=="https://"?"selected":"";?>>https://</option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="form-group">
        <label class="control-label">Site:</label>
        <div class="controls">
          <input type="text" class="form-control" name="site_empresa[]" value="<?php echo @$vEP['site_empresa']?>" />
        </div>
      </div>
    </div>
  </div>
-->

    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Cargo:</label>
          <div class="controls">
            <input type="text" class="form-control" name="cargo[]" value="<?php echo @$vEP['cargo']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">Desde(ano):</label>
          <div class="controls">
            <input type="text" class="form-control" name="ano_inicio[]" value="<?php echo @$vEP['ano_inicio']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">At&eacute;(ano):</label>
          <div class="controls">
            <input type="text" class="form-control" name="ano_final[]" value="<?php echo @$vEP['ano_final']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">Status:</label>
          <div class="controls">
            <select class="form-control" name="status_ep[]" id="status_ep">
              <option value="0"></option>
              <option value="1" <?php echo @$vEP['status_ep']=="1"?"selected":"";?>>Emprego atual</option>
              <option value="2" <?php echo @$vEP['status_ep']=="2"?"selected":"";?>>Emprego antigo</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    
    <div class="row">
      <div class="col-md-10">
        <div class="form-group">
          <label class="control-label">Atividades desempenhadas:</label>
          <div class="controls">
            <input type="text" class="form-control" name="mais_cargo[]" value="<?php echo @$vEP['mais_cargo']?>" />
          </div>
        </div>
      </div>
    </div>

    
    <div class="container-fluid">
      <a class="btn removerExperiencia pull-left btn-danger">Remover</a>
    </div>
    
    <div class="container-fluid">
      <p>&nbsp;</p>
    </div>

</div>


