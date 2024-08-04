
<div class="container">
    <div class="row">
        <div class="col mt-5">
            <h2 class="text-center"># Historial de cargas</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th style="text-align: left;" class="col">Fecha</th>
                            <th class="col">Hora</th>
                            <th class="col">Nombre</th>
                            <th class="col">Apellido</th>
                            <th style="text-align: right;" class="col">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cargas as $carga) : ?>
                        <tr>
                            <td style="text-align: left;"><?= $carga->fecha; ?></td>
                            <td><?= $carga->hora; ?></td>
                            <td><?= $carga->nombre; ?></td>
                            <td><?= $carga->apellido; ?></td>
                            <td style="text-align: right;" id=>$ <?= $carga->monto; ?>.-</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>