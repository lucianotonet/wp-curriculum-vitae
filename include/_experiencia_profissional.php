<h3>Experi&ecirc;ncia Profissional:</h3>
<div class="experienciaprofissional"> 
	<input type="hidden" name="id_experiencia[]" value="<?php echo @$vEP['id']?>" />
	
    <div class="form-group">
      <div class="controls">
        <input type="text" class="form-control" name="empresa[]" value="<?php echo @$vEP['empresa']?>" placeholder="empresa" />
      </div>
    </div>
	<!--<div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <div class="controls">
            <select class="form-control" name="protocolo_site[]" >
              <option value="0">protocolo</option>
              <option value="http://" <?php echo @$vEP['protocolo_site']=="http://"?"selected":"";?>>http://</option>
              <option value="https://" <?php echo @$vEP['protocolo_site']=="https://"?"selected":"";?>>https://</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="form-group">
          <div class="controls">
            <input type="text" class="form-control" name="site_empresa[]" value="<?php echo @$vEP['site_empresa']?>" placeholder="site" />
          </div>
        </div>
      </div>
    </div>-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <div class="controls">
            <input type="text" class="form-control" name="cargo[]" value="<?php echo @$vEP['cargo']?>" placeholder="cargo" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <div class="controls">
            <input type="text" class="form-control" name="ano_inicio[]" value="<?php echo @$vEP['ano_inicio']?>" placeholder="desde (ano)" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <div class="controls">
            <input type="text" class="form-control" name="ano_final[]" value="<?php echo @$vEP['ano_final']?>" placeholder="até (ano)" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <div class="controls">
            <select class="form-control" name="status_ep[]" id="status_ep">
              <option value="0">status</option>
              <option value="1" <?php echo @$vEP['status_ep']=="1"?"selected":"";?>>emprego atual</option>
              <option value="2" <?php echo @$vEP['status_ep']=="2"?"selected":"";?>>emprego antigo</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <div class="form-group">
          <div class="controls">
            <input type="text" class="form-control" name="mais_cargo[]" value="<?php echo @$vEP['mais_cargo']?>" placeholder="atividades desempenhadas" />
          </div>
        </div>
      </div>
    </div>
    
    <div class="remover-adicionar">
      <a class="btn removerExperiencia pull-left btn-danger">remover</a>
    </div>

</div>

