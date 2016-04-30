<div class="container-fluid formacaoAcademica">
  <h4><b>Forma&ccedil;&atilde;o Acad&ecirc;mica:</b></h4>
	<input type="hidden" name="id_formacao[]" value="<?php echo $vFA['id']?>" />
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label">Subtitulo:</label>
          <div class="controls">
            <input type="text" class="form-control" name="subtitulo[]" value="<?php echo $vFA['subtitulo']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">In&iacute;ciou(ano):</label>
          <div class="controls">
            <input type="text" class="form-control" name="iniciou[]" value="<?php echo $vFA['iniciou']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">Finalizou(ano):</label>
          <div class="controls">
            <input type="text" class="form-control" name="finalizou[]" value="<?php echo $vFA['finalizou']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="control-label">Status:</label>
          <div class="controls">
            <select class="form-control" name="status[]" id="status">
              <option value="0"></option>
              <option value="1" <?php echo @$vFA['status']=="1"?"selected":"";?>>Cursando</option>
              <option value="2" <?php echo @$vFA['status']=="2"?"selected":"";?>>Concluido</option>
              <option value="3" <?php echo @$vFA['status']=="3"?"selected":"";?>>Trancado</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label class="control-label">Nome Escola/Faculdade:</label>
          <div class="controls">
            <input type="text" class="form-control" name="escola_faculdade[]" value="<?php echo $vFA['escola_faculdade']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="form-group">
          <label class="control-label">Forma&ccedil;&atilde;o:</label>
          <div class="controls">
            <input type="text" class="form-control" name="formacao[]" value="<?php echo $vFA['formacao']?>" />
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="form-group">
          <label class="control-label">Cidade:</label>
          <div class="controls">
            <input type="text" class="form-control" name="cidade_escola_faculdade[]" value="<?php echo $vFA['cidade_escola_faculdade']?>" />
          </div>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="control-label">Estado:</label>
          <div class="controls">
            <input type="text" class="form-control" name="estado_escola_faculdade[]" value="<?php echo $vFA['estado_escola_faculdade']?>" />
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <a class="btn removerFormacao pull-left btn-danger">Remover</a>
    </div> 
    <div class="container-fluid">
      <p>&nbsp;</p>
    </div>

</div>


