    <div class="container">
        <div class="row">
            <div class="col my-4">
                <h2 class="text-center">Bienvenido, <?= $usuario->nombre; ?></h2>
                <p class="text-center">Saldo actual: $<?= number_format($usuario->saldo, 2); ?></p>
                <!-- <p class="text-center">Monto a acreditar: $<?= number_format($monto_acreditar, 2); ?></p> -->
        </div>
        <div class="alert alert-warning text-center" role="alert" hidden>
            Deberá enviarse el comprobante a soporte@example.com para validar la operación. El mismo sera corroborado por un de nuestros administradores,
            y luego por correo se le informara si fue aprobado o rechazado.
        </div>
        <div class="row form-center">
            <div class="col-10 col-md-8 col-xl-7 my-5">
            <?php foreach ($links as $link) : ?>
                <form action="<?= base_url('usuario/carga_virtual/add') ?>" method="POST" class="d-inline" target='_blanck' onsubmit="setTimeout(() => { location.reload(); }, 2000);">
                    <input type="hidden" name="id_link" value="<?= $link->id; ?>">
                    <button type="submit" class="btn btn-primary mt-2">Cargar: $<?= $link->valor; ?></button>
                </form>
            <?php endforeach; ?>
        </div>
        </div>
    </div>

