    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <h5 class="title text-center">Cambiar contraseña</h5>
            </div>
        </div>
        <div class="row form-center">
            <div class="col-7 col-md-5 col-xl-4 my-3">
                <?= validation_errors('<div><p class="text-center alert alert-danger">', '</p></div>'); ?>
                <?= form_open(current_url()); ?>
                <div class="mb-4">
                    <input type="password" class="form-control" name="password_anterior"
                        placeholder="Contraseña Actual">
                </div>
                <div class="mb-4">
                    <input type="password" class="form-control" name="password_nuevo" placeholder="Nueva Contraseña">
                </div>
                <div class="mb-4">
                    <input type="password" class="form-control" name="password_confirmado"
                        placeholder="Confirme Nueva Contraseña">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>