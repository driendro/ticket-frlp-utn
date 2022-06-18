    <div class="container">
        <div class="row form-center">
            <h1 class="text-center"> Descargar Informes</h1>
            <div class="col-8">
                <?= form_open(base_url('admin/informe/diario')); ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span style="background-color: #f7f7f7;" class="fw-bold border-0 input-group-text">Cierre de
                            caja del
                        </span>
                    </div>
                    <input type="date" value="<?= date('Y-m-d') ?>" name="cierre_fecha" class="form-control"
                        value="<?= date('d-m-Y') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-success" formtarget="_blanck" type="submit">Descargar</button>
                    </div>
                </div>
                <?= form_close(); ?>
                <?= form_open(base_url('admin/informe/semana')); ?>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span style="background-color: #f7f7f7;" class="fw-bold border-0 input-group-text">Cierre de
                            caja desde el </span>
                    </div>
                    <input type="date" name="cierre_fecha_1" class="form-control">
                    <div class="input-group-prepend">
                        <span style="background-color: #f7f7f7;" class="fw-bold border-0 input-group-text">hasta el
                        </span>
                    </div>
                    <input type="date" name="cierre_fecha_2" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-success" formtarget="_blanck" type="submit">Descargar</button>
                    </div>
                </div>
                <?= form_close(); ?>
                <?= form_open(base_url('admin/informe/pedido')); ?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span style="background-color: #f7f7f7;" class="fw-bold border-0 input-group-text">Resumen de
                            pedidos desde el </span>
                    </div>
                    <input type="date" name="semana_fecha_1" class="form-control">
                    <div class="input-group-prepend">
                        <span style="background-color: #f7f7f7;" class="fw-bold border-0 input-group-text">hasta el
                        </span>
                    </div>
                    <input type="date" name="semana_fecha_2" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-success" formtarget="_blanck" type="submit">Descargar</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>