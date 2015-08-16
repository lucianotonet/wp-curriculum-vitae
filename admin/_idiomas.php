<div class="container-fluid idiomas">
  <h4><b>Idiomas:</b></h4>
  <input type="hidden" name="id_idiomas[]" value="<?php echo $vI['id']?>" />	
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label class="control-label">Início:</label>
        <div class="controls">
          <input type="text" class="form-control" name="iInicio[]" value="<?php echo $vI['iInicio']?>" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label class="control-label">Término:</label>
        <div class="controls">
          <input type="text" class="form-control" name="iFinal[]" value="<?php echo $vI['iFinal']?>" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
          <label class="control-label">Status:</label>
          <div class="controls">
            <select class="form-control" name="iCursando[]" id="status">
              <option></option>
              <option value="1" <?php echo @$vI['iCursando']=="1"?"selected":"";?>>Cursando</option>
              <option value="2" <?php echo @$vI['iCursando']=="2"?"selected":"";?>>Concluido</option>
              <option value="3" <?php echo @$vI['iCursando']=="3"?"selected":"";?>>Trancado</option>
            </select>
          </div>
        </div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
        	<label class="control-label">Escola:</label>
        	<div class="controls">
          	<input type="text" class="form-control" name="iEscola[]" value="<?php echo $vI['iEscola']?>" />
        	</div>
      	</div>
    </div>
  </div>

  <div class="row">
  	<div class="col-md-5">
  		<div class="form-group">
        	<label class="control-label">Curso:</label>
        	<div class="controls">
          	<input type="text" class="form-control" name="iCurso[]" value="<?php echo $vI['iCurso']?>" />
        	</div>
      	</div>
  	</div>
  	<div class="col-md-5">
  		<div class="form-group">
        	<label class="control-label">Nível:</label>
        	<div class="controls">
          	<input type="text" class="form-control" name="iNivel[]" value="<?php echo $vI['iNivel']?>" />
        	</div>
      	</div>
  	</div>
  </div>

  <div class="row">
  	<div class="col-md-10">
  		<div class="form-group">
        	<label class="control-label">Descrição:</label>
        	<div class="controls">
        	<textarea name="iDescricao[]" class="form-control"><?php echo $vI['iDescricao']?></textarea>
        	</div>
      	</div>
  	</div>
  </div>

  <div class="container-fluid">
    <a class="btn removerIdioma pull-left btn-danger">Remover</a>
  </div>

  <div class="container-fluid">
    <p>&nbsp;</p>
  </div>
  
</div>

