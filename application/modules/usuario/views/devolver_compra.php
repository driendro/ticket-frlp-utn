<?php setlocale(LC_ALL, "spanish"); ?>
<div class="container">
    <?php if (!empty($compras)) : ?>
    <div class="row form-center">
        <h1 class="text-center"> Devolver compras </h1>
        <div class="col-10 col-md-7 col-lg-4 my-3">
            <?php $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes']; ?>
            <?php $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]; ?>
            <?= form_open(current_url()); ?>
            <?php $key = 0; ?>
            <?php foreach ($compras as $compra) : ?>
            <?php
                    $nroDia = date('N');
                    $proximo = time() + ((7 - $nroDia + ($key + 1)) * 24 * 60 * 60);
                    $proxima_fecha = date('Y-m-d', $proximo);
                    ?>
            <div class="input-group mb-3">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Devolver comedor del
                        <b><?= ucwords($dias[date('N', strtotime($compra->dia_comprado)) - 1]); ?></b>
                        <?= date("N", strtotime($compra->dia_comprado)) ?> de
                        <?= $meses[date('n', strtotime($compra->dia_comprado)) - 1] ?> (Menu:
                        <b><?= $compra->menu; ?></b>)
                    </label>
                    <input class="form-check-input" type="checkbox" role="switch"
                        name="devolver_<?= date("N", strtotime($compra->dia_comprado)) - 1; ?>"
                        value=" <?= $compra->id; ?>">
                </div>
            </div>
            <?php $key = $key + 1; ?>
            <?php endforeach; ?>
            <button type="submit" id="btnCompra" class="btn btn-danger mx-3">Devolver</button>
            <button type="reset" id="btnReset" class="btn btn-warning mx-3">Reset</button>
            <?= form_close(); ?>
        </div>
    </div>
    <?php else : ?>
    <div class="row form-center">
        <h1 class="text-center"> No existen compras realizadas para la proxima semana </h1>
        <div class="btn-group col-4" role="group" aria-label="Basic example">
            <a href=" <?= base_url('usuario'); ?>" class="btn btn-info mx-3">Comprar</a>
        </div>
    </div>
    <?php endif; ?>
</div>