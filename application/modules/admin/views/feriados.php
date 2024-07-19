<div class="container">
    <div class="row mt-2 d-flex justify-content-center">
        <div class="col-6">
            <h2 class="text-center">Calendario del Comedor Universitario</h2>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col d-flex justify-content-center">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary"
                                href="<?= base_url('admin/configuracion/feriados_list/'.($año-1)) ?>">Año Anterior</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary"
                                href="<?= base_url('admin/configuracion/feriados_list/'.$año) ?>"><?= $año ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary"
                                href="<?= base_url('admin/configuracion/feriados_list/'.($año+1)) ?>">Año Siguiente</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!-- ################################################ -->
    <!-- ################################################ -->

    <!-- ################################################ -->
    <!-- ################################################ -->
    <div class="row mt-2">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-sm text-center dataTables">
                    <?php if (!empty($feriados)) : ?>
                    <thead>
                        <tr>
                            <th>Día de la Semana</th>
                            <th>Día</th>
                            <th>Mes</th>
                            <th>Motivo</th>
                            <th>
                                <!-- <a class="btn btn-success btn-sm" href="#">
                                    <i class="bi bi-plus-square"></i>
                                </a>
                                <a class="btn btn-success btn-sm" href="#">
                                    <i class="bi bi-filetype-csv"></i>
                                </a> -->
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feriados as $feriado) : ?>
                        <tr>
                            <td class="align-middle"><?= date('l', strtotime($feriado->fecha)); ?></td>
                            <td class="align-middle"><?= date('d', strtotime($feriado->fecha)); ?></td>
                            <td class="align-middle"><?= date('F', strtotime($feriado->fecha)); ?></td>
                            <td class="align-middle"><?= $feriado->detalle; ?></td>
                            <td>
                                <a class="btn btn-danger btn-sm"
                                    href="<?= base_url('admin/configuracion/feriados_list/'.$año.'/d/'.$feriado->id) ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else : ?>
                <h3 class="text-center">No hay feriados cargados para el año <?= $año ?>.</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row form-center">
        <h1 class="text-center">Añadir Feriado</h1>
        <div class="col-12">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Añadir una fecha
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <?= form_open(base_url('admin/conf/feriados/add/fecha')); ?>
                            <p>Indique la fecha y el motivo del feriado:</p>
                            <div class="input-group mb-3">
                                <input type="date" value="<?= date('Y-m-d') ?>" name="fecha_feriado"
                                    class="form-control" required>
                                <input type="text" placeholder="Especifique el motivo del feriado"
                                    name="fecha_feriado_motivo" class="form-control" required>
                                <input type="int" value="<?= $año ?>" name="ano" class="form-control" hidden>
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit">Agregar</button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Añadir desde un CSV
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <?= form_open(base_url('admin/conf/feriados/add/csv'), array("enctype"=>"multipart/form-data")); ?>
                        <div class="row d-flex justify-content-center align-items-stretch flex-row form-center g-3">
                            <div class="col-12 col-md-6">
                                <input class="form-control" type="file" name="archivo_csv">
                            </div>
                            <div class="col-2 col-md-1">
                                <span style="background-color: #f7f7f7;"
                                    class="col-3 fw-bold border-0 input-group-text">Sep:</span>
                            </div>
                            <div class="col-3 col-md-1">
                                <select class="mb-1 form-select" name="separador">
                                    <option selected value=";">;</option>
                                    <option value=",">,</option>
                                </select>
                            </div>
                            <input type="int" value="<?= $año ?>" name="ano" class="form-control" hidden>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary mt-2"> Aceptar </button>
                        </div>
                        <?= form_close(); ?>
                        <h5 class="col-12 text-center">El CSV a subir debe ser como el del <a
                                href="<?= base_url('download/carga_feriados.csv'); ?>">modelo</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>