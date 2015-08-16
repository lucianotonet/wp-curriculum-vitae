<h3>Conhecimento Técnico:</h3>
<div class="conhecimentotecnico">
  <input type="hidden" name="id_conhecimento_tecnico[]" value="<?php echo $vCT['id']?>" />	
  <div class="row">
    <div class="col-md-5">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="ctCurso[]" value="<?php echo $vCT['ctCurso']?>" placeholder="curso" />
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="ctNivel[]" value="<?php echo $vCT['ctNivel']?>" placeholder="nível" />
        </div>
      </div>
    </div>
  </div>

  <div class="remover-adicionar">
    <a class="btn removerConhecimentoTecnico pull-right btn-danger">remover</a>
  </div>
  
</div>
  <div class="adicionar-btn">
    <a class="btn adicionarNovaConhecimentoTecnico pull-right btn-primary">adicionar mais</a>
  </div>

  <a href="#" class="btn btn-success prev-step">Etapa anterior</a>
  <button type="submit" id="cadastrar" name="cadastrar" class="btn btn-primary">Cadastrar Currículo</button>
