    <div class="container">
        <div class="row">
            <div class="col my-4">
                <img class="img-fluid mx-auto d-block" src="<?= base_url('assets/img/logo_comedor.png'); ?>" alt="">
            </div>
        </div>
        <div class="row form-center">
            <div class="col-6 col-md-5 col-xl-4 my-3">
                <?= form_open(current_url()); ?>
                <div class="form-group mb-4">
                    <input type="number" class="form-control" placeholder="Ingrese su DNI" name="documento">
                </div>
                <div class="form-group mb-4">
                    <input type="password" class="form-control" placeholder="Su contraseña" name="password">
                </div>
                <?php if ($this->session->flashdata('error') != null) : ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success') != null) : ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Ingresar</button>
                    <a href="<?= base_url('usuario/recovery'); ?>" class="btn btn-primary mt-2">Restablecer
                        contraseña</a>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>