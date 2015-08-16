<div class="container-fluid cursospalestras">
  <h4><b>Cursos e Palestras:</b></h4>
  <input type="hidden" name="id_curso_palestra[]" value="<?php echo $vCP['id']?>" />	
  <div class="row">
    <div class="col-md-10">
      <div class="form-group">
        <label class="control-label">Curso/Palestra:</label>
        <div class="controls">
          <input type="text" class="form-control" name="curso_palestra[]" value="<?php echo $vCP['curso_palestra']?>" />
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label class="control-label">Escola:</label>
        <div class="controls">
          <input type="text" class="form-control" name="escola[]" value="<?php echo $vCP['escola']?>" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label class="control-label">Ano:</label>
        <div class="controls">
          <input type="text" class="form-control" name="ano[]" value="<?php echo $vCP['ano']?>" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label class="control-label">Horas cursada:</label>
        <div class="controls">
          <input type="text" class="form-control" name="horas[]" value="<?php echo $vCP['horas']?>" />
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label class="control-label">Tipo:</label>
        <div class="controls">
          <select class="form-control" name="tipo[]" id="tipo">
            <option value="0"></option>
            <option value="1" <?php echo @$vCP['tipo']=="1"?"selected":"";?>>Curso</option>
            <option value="2" <?php echo @$vCP['tipo']=="2"?"selected":"";?>>Palestra</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  
  <div class="container-fluid">
    <a class="btn removerCursoPalestra pull-left btn-danger">Remover</a>
  </div>
  <div class="container-fluid">
    <p>&nbsp;</p>
  </div>
  
</div>

