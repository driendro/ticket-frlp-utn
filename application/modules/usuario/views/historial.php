    <div class="container">
    	<div class="row">
    		<div class="col mt-5">
    			<h2 class="text-center"># Historial de compras</h2>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col">
    			<div class="table-responsive">
    				<table class="table table-sm text-center">
    					<thead>
    						<tr>
    							<th class="col">Fecha</th>
    							<th class="col">Hora</th>
    							<th class="col">Dia comprado</th>
    							<th class="col">Precio</th>
    							<th class="col">Menu</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php foreach ($compras as $compra) : ?>
    							<tr>
    								<td><?= $compra->fecha; ?></td>
    								<td><?= $compra->hora; ?></td>
    								<td><?= $compra->dia_comprado; ?></td>
    								<td><?= $compra->precio; ?></td>
    								<td><?= $compra->menu; ?></td>
    								<?php if (isset($devolucion)) : ?>
    									<td><?= form_open(current_url()); ?>
    										<input type="text" name='compraId' id='compraId' value="<?= $compra->id ?>" hidden>
    										<button type="submit" id="btnDevolverCompra" class="btn btn-danger mx-3">Devolver</button>
    									</td>
    									<?= form_close(); ?>
    								<?php endif; ?>
    							</tr>
    						<?php endforeach; ?>
    					</tbody>
    				</table>
    			</div>
    		</div>
    	</div>
    </div>
