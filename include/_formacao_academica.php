<h3>Forma&ccedil;&atilde;o Acad&ecirc;mica:</h3>
<div class="formacaoAcademica">
    <input type="hidden" name="id_formacao[]" value="<?php echo $vFA['id']?>" />    

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="subtitulo[]" value="<?php echo $vFA['subtitulo']?>" placeholder="subtitulo (graduação, pós...)"/>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="iniciou[]" value="<?php echo $vFA['iniciou']?>" placeholder="iniciou (ano)" />
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="finalizou[]" value="<?php echo $vFA['finalizou']?>" placeholder="finalizou (ano)"/>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="controls">
                    <select class="form-control" name="status[]" id="status">
                        <option value="0">status</option>
                        <option value="1" <?php echo @$vFA['status']=="1"?"selected":"";?>>cursando</option>
                        <option value="2" <?php echo @$vFA['status']=="2"?"selected":"";?>>concluído</option>
                        <option value="3" <?php echo @$vFA['status']=="3"?"selected":"";?>>trancado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="escola_faculdade[]" value="<?php echo $vFA['escola_faculdade']?>" placeholder="nome escola/faculdade" />
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="formacao[]" value="<?php echo $vFA['formacao']?>" placeholder="formação/curso" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="cidade_escola_faculdade[]" value="<?php echo $vFA['cidade_escola_faculdade']?>" placeholder="cidade" />
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <div class="controls">
                    <input type="text" class="form-control" name="estado_escola_faculdade[]" value="<?php echo $vFA['estado_escola_faculdade']?>" placeholder="uf" />
                </div>
            </div>
        </div>
    </div>
    <div class="remover-adicionar">
        <a class="btn removerFormacao btn-danger">remover</a>
    </div>     
</div>