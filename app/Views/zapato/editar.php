<?=$cabecera ?>
    <h2>Formulario crear</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Actualizar datos del zapato</h5>
            <p class="card-text">

            <!-- site_url('/guardar') con esto le decimos que envíea la ruta a esa url -->
            <form method="post" action="<?=site_url('zapato/actualizar')?>" enctype="multipart/form-data"> <!-- enctype es importante para envio de archivos -->
                <input type="hidden" id="id" name="id" value="<?=$zapato['id']?>"> 
                <?= session()->getFlashdata('error') ?>
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /> 
                
                <div class="form-group">
                    <label for="codigoestilo">Codigo</label>
                    <input id="codigoestilo" value="<?=$zapato['codigoestilo']?>" class="form-control" type="text" name="codigoestilo">
                </div>

                <div class="form-group">
                    <label for="tipomaterial">Material</label>
                    <input id="tipomaterial" value="<?=$zapato['tipomaterial']?>" class="form-control" type="text" name="tipomaterial">
                </div>

                                    <!-- CATEGORIA -->
                <div class="form-group">
                    <fieldset>
                    <legend>Categoria</legend>
                    <label for="categoria_id">Categorias</label>
                        <select class="margin-auto" name="categoria_id" id="categoria_id">
                            <option value="" selected disabled>Selecione</option>

                            <!-- Mostramos la categoria que tiene el dato, viene desde Zapato Controller -->
                            <?php foreach($categorias as $categoria): ?>
                                <option 
                                        <?php echo $categoria['id'] === $zapato['categoria_id'] ? 'selected' : ''; ?>
                                        value="<?php echo $categoria['id']; ?>" > 
                                        <!-- Muestra los nombres de los vendedores en las opciones de select-->
                                        <?php echo $categoria['nombre']?>
                                </option>
                            <?php  endforeach;?>
                                
                            </select>
                    </fieldset>
                </div> 


                <button class="btn btn-success" type="submit">Guardar</button>
                <a href="<?=base_url('listar'); ?>" class="btn btn-info">Cancelar</a>
            </form>
            </p>
        </div>
    </div>
<?=$pie ?>