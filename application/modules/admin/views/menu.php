    <div class="container">
    	<div class="row">
    		<div class="col mt-5">
    			<h1 class="text-center"># Menu</h1>
    		</div>
    	</div>
    	<div class="row d-flex justify-content-center">
    		<div class="col-8">
    			<?= form_open(current_url()); ?>
    			<table class="table table-sm">
    				<thead>
    					<tr>
    						<th>Día</th>
    						<th>Menu Basico</th>
    						<th>Opción Veggie</th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php foreach ($menu as $key => $item) : ?>
    					<tr>
    						<td><?= $item->dia; ?></td>
    						<td> <input name="basico_<?= $item->id; ?>" type="text" value="<?= $item->menu1; ?>"> </td>
    						<td> <input name="veggie_<?= $item->id; ?>" type="text" value="<?= $item->menu2; ?>"> </td>
    					</tr>
    					<?php endforeach; ?>
    				</tbody>
    			</table>
    			<div class="row">
    				<div class="btn-group">
    					<button class="btn btn-success mx-5" type="submit">Actualizar
    						Menu</button>
    				</div>
    			</div>
    			<?= form_close(); ?>
    		</div>
    	</div>
    </div>