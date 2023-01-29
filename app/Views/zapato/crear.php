<?=$cabecera ?>
    <h2>Formulario para agregar zapato</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ingresar zapato</h5>
            <p class="card-text">

            <!-- site_url('/guardar') con esto le decimos que envíea la ruta a esa url -->
            <form method="post" action="<?=site_url('zapato/guardar')?>" enctype="multipart/form-data"> <!-- enctype es importante para envio de archivos -->
            
            <!-- Security -->
            <?= session()->getFlashdata('error') ?>
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            
                <div class="form-group">
                    <label for="codigoestilo">Codigo del estilo</label>
                    <input id="codigoestilo"  value="<?=old('codigoestilo')?>" class="form-control" type="text" name="codigoestilo">
                </div>

                <div class="form-group">
                    <label for="tipomaterial">Tipo de material</label>
                    <input id="tipomaterial"  value="<?=old('tipomaterial')?>" class="form-control" type="text" name="tipomaterial">
                </div>
                
                <div class="form-group">
                    <fieldset>
                    <legend>Categoria</legend>
                    <label for="categoria_id">Categorias</label>
                        <select class="margin-auto" name="categoria_id" id="categoria_id">
                            <option value="" selected disabled>Selecione</option>

                            <?php foreach($categorias as $categoria): ?>
                            <option 
                                    <?php /*foreach($zapatos as $zapato):
                                            if($categoria['id'] === $zapato['categoria_id']){
                                                'selected';
                                            }else{*/
                                            ?>
                                            value="<?php echo $categoria['id']; ?>" >
                                            <!-- Muestra los nombres de los vendedores en las opciones de select-->
                                        <?php echo $categoria['nombre']?>
                                    <?php  //} endforeach;?>
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