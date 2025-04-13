    <div class="container">
        <div class="row">
            <div class="col my-4">
                <img class="img-fluid mx-auto d-block" src="<?= base_url('assets/img/logo_comedor.png'); ?>" alt="">
            </div>
        </div>
        <div class="row form-center">
            <div class="col-6 col-md-5 col-xl-4 my-3">
            <?php foreach ($links as $link) : ?>
                <a href="<?= $link->link; ?>" class="btn btn-primary mt-2">Cargar $<?= $link->monto; ?> </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>