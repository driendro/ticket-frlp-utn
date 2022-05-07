    <div class="container">
    	<div class="row">
    		<div class="col mt-5">
    			<h1 class="text-center"># Menu</h1>
    		</div>
    	</div>
    	<div class="row d-flex justify-content-center">
    		<div class="col-8">
    			<table class="table table-sm">
    				<thead>
    					<tr>
    						<th>Día</th>
    						<th class="text-center">Menu</th>
    						<th class="text-end">Opción Vegetaria</th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php foreach ($menu as $item) : ?>
    					<tr>
    						<td><?= $item->dia; ?></td>
    						<td class="text-center"><?= $item->menu1; ?></td>
    						<td class="text-end"><?= $item->menu2; ?></td>
    					</tr>
    					<?php endforeach; ?>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>