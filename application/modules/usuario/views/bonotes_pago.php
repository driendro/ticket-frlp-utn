    <div class="container">
        <div class="row">
            <div class="col my-4">
                <h2 class="text-center">Bienvenido, <?= $usuario->nombre; ?></h2>
                <p class="text-center">Saldo actual: $<?= number_format($usuario->saldo, 2); ?></p>
                <p class="text-center">Monto a acreditar: $<?= number_format($monto_acreditar, 2); ?></p>
        </div>
        <div class="row form-center">
            <div class="col-10 col-md-8 col-xl-7 my-5">
            <?php foreach ($links as $link) : ?>
                <a href="<?= $link->link; ?>" class="btn btn-primary mt-2">Cargar $<?= $link->valor; ?> </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>