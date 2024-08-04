<?php setlocale(LC_ALL, "spanish"); ?>
<?php
    $diasSemana=[
        "Monday"    => "Lunes",
        "Tuesday"   => "Martes",
        "Wednesday" => "Miércoles",
        "Thursday"  => "Jueves",
        "Friday"    => "Viernes",
        "Saturday"  => "Sábado",
        "Sunday"    => "Domingo"
    ];
    $meses=[
        "January"   => "Enero",
        "February"  => "Febrero",
        "March"     => "Marzo",
        "April"     => "Abril",
        "May"       => "Mayo",
        "June"      => "Junio",
        "July"      => "Julio",
        "August"    => "Agosto",
        "September" => "Septiembre",
        "October"   => "Octubre",
        "November"  => "Noviembre",
        "December"  => "Diciembre"
    ];
?>

<div class="row justify-content-center">
    <?php if (!empty($compras)) : ?>
    <div class="row justify-content-center">
        <div class="col-11 col-md-7 col-xl-6 text-center my-5">
            <h1 class="text-center"> Devolver compras </h1>
            <?= form_open(current_url()); ?>
            <?php foreach ($compras as $compra) : ?>
            <div class="input-group mb-3">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Devolver comedor del
                        <b><?= $diasSemana[date('l', strtotime($compra->dia_comprado))].', '.date('d', strtotime($compra->dia_comprado)).' de '.$meses[date('F', strtotime($compra->dia_comprado))]; ?></b>
                        (Menu: <b><?= $compra->menu; ?></b>)
                    </label>
                    <input class="form-check-input" type="checkbox" role="switch"
                        name="devolver_<?= date("N", strtotime($compra->dia_comprado)) - 1; ?>"
                        value=" <?= $compra->id; ?>">
                </div>
            </div>
            <?php endforeach; ?>
            <button type="submit" id="btnCompra" class="btn btn-danger mx-3">Devolver</button>
            <button type="reset" id="btnReset" class="btn btn-warning mx-3">Reset</button>
            <?= form_close(); ?>
        </div>
    </div>
    <?php else : ?>
    <div class="row justify-content-center">
        <h1 class="text-center"> No existen compras realizadas para la proxima semana </h1>
        <div class="btn-group col-4" role="group" aria-label="Basic example">
            <a href=" <?= base_url('usuario'); ?>" class="btn btn-info mx-3">Comprar</a>
        </div>
    </div>
    <?php endif; ?>
</div>