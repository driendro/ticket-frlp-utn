    <div class="container-fluid">
        <div class="row">
            <div class="col mt-5">
                <h1 class="text-center"># Menú</h1>
            </div>
        </div>
        <div class="row d-flex justify-content-center lign-items-stretch flex-row">
            <?php foreach ($menu as $item) : ?>
            <div class="card mb-3" style="width: 20rem; background-color: #f7f7f7">
                <div class="card-header conteiner-flud" style="background-color: dodgerblue; text-align: center;">
                    <h3><?= $item->dia; ?></h3>
                </div>
                <div class="card-body" style="background-color: #ffffff">
                    <h5 style=" text-align: center;">Básico: <?= $item->menu1; ?></h5>
                    <h6 style="text-align: center;">Vegano: <?= $item->menu2; ?></h6>
                    <!-- <h6 style="text-align: center;">Sin TACC: <?= $item->menu2; ?></h6> -->
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>