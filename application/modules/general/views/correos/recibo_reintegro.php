    <div class="container-fluid">
        <div class="row">
            <div class="col mt-5">
                <h2 class="text-center">Reintegro</h2>
                <p>
                    Codigo: <?= $recivoNumero; ?> <br>
                    Fecha: <?= date('d \d\e F \d\e Y', strtotime($fechaHoy)); ?> <br>
                    Hora: <?= date('H:i', strtotime($horaAhora)); ?>
                </p>

            </div>
        </div>
        <div class="row">
            <div class="col">
                
                <p>Si ha recibido este correo electrónico, se debe a que el comedor universitario no funcionó el día
                    <strong><?= date('d \d\e F \d\e Y', strtotime($compra->dia_comprado)); ?></strong>. Debido a que realizó una
                    compra para ese día, se le ha reintegrado el costo de la misma.</p>

                <h2>Detalle del reintegro</h2>

                <ul>
                    <li><strong>Devolución:</strong> $<?= $compra->precio; ?></li>
                    <li><strong>Su nuevo saldo:</strong> $<?= $saldo; ?></li>
                </ul>

                <p>Atentamente,</p>

                <p><strong>Equipo del Comedor Universitario</strong></p>
            </div>
        </div>
    </div>