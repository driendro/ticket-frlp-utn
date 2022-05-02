    <div class="container">
    	<div class="row">
    		<div class="col my-3 text-center">
    			<p class="mb-0"><strong>ID:</strong> <?= $usuario->id; ?> - <strong>Tipo:</strong>
    				<?= $usuario->tipo; ?> - <strong>Legajo:</strong> <?= $usuario->legajo; ?> -
    				<strong>Documento:</strong> <?= $usuario->documento; ?>
    			</p>
    			<p class="mb-0"><strong>Apellido, Nombre:</strong> <?= $usuario->apellido; ?>, <?= $usuario->nombre; ?>
    				- <strong>Especialidad:</strong> <?= $usuario->especialidad; ?></p>
    			<p class="mb-0"><strong>Email:</strong> <?= $usuario->mail; ?> - <strong>Saldo:</strong>
    				$<?= $usuario->saldo; ?> - <strong>Costo:</strong>
    				$<?= $costoVianda; ?></p>
    			<h2 class="mb-0" id="compra">$0</h2>
    			<input type="number" id="saldoCuenta" value="<?= $usuario->saldo; ?>" hidden>
    			<input type="number" id="costoVianda" value="<?= $costoVianda; ?>" hidden>
    		</div>
    	</div>
    	<div class="ticket">
    		<div class="row">
    			<div class="col mt-3">
    				<h5 class="text-center">UTN FRLP Ticket Web - Compra</h5>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col my-2">
    				<img class="img-fluid mx-auto d-block" src="<?= base_url('assets/img/utn.png'); ?>" alt="">
    			</div>
    		</div>
    		<div class="row text-center">
    			<div class="col my-2">
    				<form method="post" action="<?= base_url('datos'); ?>" id="formCompraId">
    					<?php $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes']; ?>
    					<?php foreach ($dias as $key => $dia) : ?>
    						<?php
							$nroDia = date('N');
							$proximo = time() + ((7 - $nroDia + ($key + 1)) * 24 * 60 * 60);
							$proxima_fecha = date('d', $proximo);
							?>

    						<div class="my-1 form-check form-check-inline">
    							<fieldset <?= ($usuario->saldo < $costoVianda) || (in_array(date('Y-m-d', $proximo), array_column($comprados, 'dia_comprado'))) || (in_array(date('Y-m-d', $proximo), array_column($feriados, 'fecha'))) ? 'disabled' : ''; ?>>
    								<div class="form-check">
    									<input type="checkbox" class="form-check-input" id="check<?= ucwords($dia); ?>" name="check<?= ucwords($dia); ?>" value="<?= ucwords($dia); ?>" <?= (in_array(date('Y-m-d', $proximo), array_column($comprados, 'dia_comprado'))) ? 'checked' : ''; ?>>
    									<label class="form-check-label" for="check<?= ucwords($dia); ?>">
    										<?= ucwords($dia); ?> <?= $proxima_fecha; ?>
    									</label>
    								</div>
    								<fieldset id="<?= $dia; ?>" disabled>
    									<div>
    										<select class="form-select" name="selectTipo<?= ucwords($dia); ?>" id="selectTipo<?= ucwords($dia); ?>">
    											<option value="Comer aqui"> Comer aqui </option>
    											<option value="Llevar"> Para llevar </option>
    										</select>
    									</div>
    									<div>
    										<select class="form-select" name="selectTurno<?= ucwords($dia); ?>" id="selectTurno<?= ucwords($dia); ?>">
    											<option <?= (in_array(date('Y-m-d', $proximo), array_column($comprados, 'dia_comprado'))) && ($comprados['dia_comprado' == date('Y-m-d', $proximo)] == 'Turno 1') ? 'selected' : ''; ?> value="Turno 12:30"> 12:30 hs </option>
    											<option <?= (in_array(date('Y-m-d', $proximo), array_column($comprados, 'dia_comprado'))) && ($comprados['dia_comprado' == date('Y-m-d', $proximo)] == 'Turno 2') ? 'selected' : ''; ?> value="Turno 13:30"> 13:30 hs </option>
    										</select>
    									</div>
    									<div>
    										<select class="form-select" name="selectMenu<?= ucwords($dia); ?>" id="selectMenu<?= ucwords($dia); ?>">
    											<option value="Basico"> Básico </option>
    											<option value="Veggie"> Veggie </option>
    											<option value="Celiaco"> Celiaco </option>
    										</select>
    									</div>
    								</fieldset>
    							</fieldset>
    						</div>
    					<?php endforeach; ?>
    					<div class="form-check">
    						<div class="btn-group" role="group" aria-label="Basic example">
    							<button type="submit" id="btnCompra" class="btn btn-success mx-3" disabled>Comprar</button>
    							<button type="reset" id="btnReset" class="btn btn-warning mx-3">Reset</button>
    						</div>
    					</div>
    					<div id="totalCompra"></div>
    				</form>
    			</div>
    		</div>
    	</div>
    	<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
