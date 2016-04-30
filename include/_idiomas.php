<h3>Idiomas:</h3>
<div class="idiomas">
  <input type="hidden" name="id_idiomas[]" value="<?php echo $vI['id']?>" />	
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="iInicio[]" value="<?php echo $vI['iInicio']?>" placeholder="início" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="iFinal[]" value="<?php echo $vI['iFinal']?>" placeholder="término" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
          <div class="controls">
            <select class="form-control" name="iCursando[]" id="status">
              <option>status</option>
              <option value="1" <?php echo @$vI['iCursando']=="1"?"selected":"";?>>cursando</option>
              <option value="2" <?php echo @$vI['iCursando']=="2"?"selected":"";?>>concluido</option>
              <option value="3" <?php echo @$vI['iCursando']=="3"?"selected":"";?>>trancado</option>
            </select>
          </div>
        </div>
    </div>
    <div class="col-md-4">
    	<div class="form-group">
        	<div class="controls">
          	<input type="text" class="form-control" name="iEscola[]" value="<?php echo $vI['iEscola']?>" placeholder="escola" />
        	</div>
      	</div>
    </div>
  </div>

  <div class="row">
  	<div class="col-md-5">
  		<div class="form-group">
        	<div class="controls">
          	<input type="text" class="form-control" name="iCurso[]" value="<?php echo $vI['iCurso']?>" placeholder="curso" />
        	</div>
      	</div>
  	</div>
  	<div class="col-md-5">
  		<div class="form-group">
        	<div class="controls">
          	<input type="text" class="form-control" name="iNivel[]" value="<?php echo $vI['iNivel']?>" placeholder="nível" />
        	</div>
      	</div>
  	</div>
  </div>

  <div class="row">
  	<div class="col-md-10">
  		<div class="form-group">
        	<div class="controls">
        	<textarea name="iDescricao[]" class="form-control" placeholder="descrição"><?php echo $vI['iDescricao']?></textarea>
        	</div>
      	</div>
  	</div>
  </div>

  <div class="remover-adicionar">
    <a class="btn removerIdioma btn-danger">remover</a>
  </div>
  
</div>

