    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <h2 class="text-center">Historico de Movimientos</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-sm text-center dataTables">
                        <thead>
                            <tr>
                                <th class="col">Fecha</th>
                                <th class="col">Hora</th>
                                <th class="col">Movimiento</th>
                                <th class="col">Monto</th>
                                <th class="col">Saldo</th>
                                <th class="col">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($compras as $compra) : ?>
                            <tr>
                                <td><?= $compra->fecha; ?></td>
                                <td><?= $compra->hora; ?></td>
                                <td><?= $compra->transaccion; ?></td>
                                <td><?= $compra->monto; ?></td>
                                <td><?= $compra->saldo; ?></td>
                                <td>info</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if (!isset($primera)) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("usuario/ultimos-movimientos"); ?>"
                            aria-label="Primera">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset($links)) : ?>
                    <?php foreach ($links as $link) : ?>
                    <?php if (isset($link['act'])) : ?>
                    <li class="page-item active">
                        <span class="page-link">
                            <?= $link['num']; ?>
                        </span>
                    </li>
                    <?php else : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("usuario/ultimos-movimientos/{$link['id']}"); ?>">
                            <?= $link['num']; ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!isset($ultima)) : ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url("usuario/ultimos-movimientos/{$ultimo}"); ?>"
                            aria-label="Ultima">
                            <span aria-hidden="true">&raquo;</span>
                            <!-- <span class="sr-only">Siguiente</span> -->
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>