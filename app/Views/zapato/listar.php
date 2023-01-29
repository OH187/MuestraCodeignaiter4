<?= $cabecera ?>
<a class="btn btn-success mt-3 mb-3" href="<?=base_url('zapato/crear')?>">Agregar zapato</a>
<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Codigo</th>
            <th scope="col">Material</th>
            <th scope="col">Categoria</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($zapatos as $zapato): ?>
            <tr>
                <th><?=$zapato['id']?></th>
                <td><?=$zapato['codigoestilo']?></td>
                <td><?=$zapato['tipomaterial']?></td>
                
            <?php foreach ($categorias as $categoria): 
                /*evaluamos los id para mostrar el nombre*/
                if($categoria['id'] === $zapato['categoria_id']){ ?>

                <td><?=$categoria['nombre']?></td>

            <?php } endforeach; ?>

                <td class="center">
                            <a href="<?=base_url('zapato/editar/'.$zapato['id']); ?>" class="btn btn-info" type="button">Editar</a>
                            <a href="<?=base_url('zapato/borrar/'.$zapato['id']); ?>" class="btn btn-danger" type="button">Borrar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
            <!-- CATEGORIA TABLA -->
<a class="btn btn-success mt-3 mb-3" href="<?=base_url('categoria/crear')?>">Crear categoria</a>
<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <th><?=$categoria['id']?></th>
                <td><?=$categoria['nombre']?></td>
                <td class="center">
                            <a href="<?=base_url('categoria/editar/'.$categoria['id']); ?>" class="btn btn-info" type="button">Editar</a>
                            <a href="<?=base_url('categoria/borrar/'.$categoria['id']); ?>" class="btn btn-danger" type="button">Borrar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $pie ?>