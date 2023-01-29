<?=$cabecera ?>
    <h2>Formulario crear categoria</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ingrese el nombre de la categoria</h5>
            <p class="card-text">

            <!-- site_url('/guardar') con esto le decimos que envíea la ruta a esa url -->
            <form method="post" action="<?=site_url('categoria/guardar')?>" enctype="multipart/form-data"> <!-- enctype es importante para envio de archivos -->
            
            <!-- Security -->
            <?= session()->getFlashdata('error') ?>
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            
            <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input id="nombre"  value="<?=old('nombre')?>" class="form-control" type="text" name="nombre">
                </div>
                
                <button class="btn btn-success" type="submit">Guardar</button>
                <a href="<?=base_url('listar'); ?>" class="btn btn-info">Cancelar</a>
            </form>
            </p>
        </div>
    </div>
<?=$pie ?>