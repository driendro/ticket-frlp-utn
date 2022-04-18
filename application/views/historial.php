    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <h2 class="text-center"># Historial de compras</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm text-center">
                        <thead>
                            <tr>
                                <th class="col">Fecha</th>
                                <th class="col">Hora</th>
                                <th class="col">Dia comprado</th>
                                <th class="col">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($compras as $compra): ?>
                                <tr>
                                    <td><?= $compra->fecha; ?></td>
                                    <td><?= $compra->hora; ?></td>
                                    <td><?= $compra->dia_comprado; ?></td>
                                    <td><?= $compra->precio; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
