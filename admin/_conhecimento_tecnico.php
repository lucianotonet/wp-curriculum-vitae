<div class="container-fluid conhecimentotecnico">
  <h4><b>Conhecimento Técnico:</b></h4>
  <input type="hidden" name="id_conhecimento_tecnico[]" value="<?php echo $vCT['id']?>" />	
  <div class="row">
    <div class="col-md-5">
      <div class="form-group">
        <label class="control-label">Curso:</label>
        <div class="controls">
          <input type="text" class="form-control" name="ctCurso[]" value="<?php echo $vCT['ctCurso']?>" />
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <label class="control-label">Nível:</label>
        <div class="controls">
          <input type="text" class="form-control" name="ctNivel[]" value="<?php echo $vCT['ctNivel']?>" />
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <a class="btn removerConhecimentoTecnico pull-left btn-danger">Remover</a>
  </div>
  <div class="container-fluid">
    <p>&nbsp;</p>
  </div>
  
</div>

