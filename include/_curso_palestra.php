<h3>Cursos e Palestras:</h3>
<div class="cursospalestras">
  <input type="hidden" name="id_curso_palestra[]" value="<?php echo $vCP['id']?>" />	
  <div class="row">
    <div class="col-md-10">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="curso_palestra[]" value="<?php echo $vCP['curso_palestra']?>" placeholder="curso/palestra" />
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="escola[]" value="<?php echo $vCP['escola']?>" placeholder="escola" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="ano[]" value="<?php echo $vCP['ano']?>" placeholder="ano" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <div class="controls">
          <input type="text" class="form-control" name="horas[]" value="<?php echo $vCP['horas']?>" placeholder="horas cursadas" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <div class="controls">
          <select class="form-control" name="tipo[]" id="tipo">
            <option value="0">tipo</option>
            <option value="1" <?php echo @$vCP['tipo']=="1"?"selected":"";?>>curso</option>
            <option value="2" <?php echo @$vCP['tipo']=="2"?"selected":"";?>>palestra</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  
  <div class="remover-adicionar">
    <a class="btn removerCursoPalestra btn-danger">remover</a>
  </div>
  
</div>
