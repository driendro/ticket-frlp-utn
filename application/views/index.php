    <div class="container">
    	<div class="row">
    		<div class="col my-3 text-center">
    			<p class="mb-0"><strong>ID:</strong> <?= $usuario->id_usuario; ?> - <strong>Tipo:</strong>
    				<?= $usuario->tipo; ?> - <strong>Legajo:</strong> <?= $usuario->legajo; ?> -
    				<strong>Documento:</strong> <?= $usuario->documento; ?>
    			</p>
    			<p class="mb-0"><strong>Apellido, Nombre:</strong> <?= $usuario->apellido; ?>, <?= $usuario->nombre; ?>
    				- <strong>Especialidad:</strong> <?= $usuario->especialidad; ?></p>
    			<p class="mb-0"><strong>Email:</strong> <?= $usuario->mail; ?> - <strong>Saldo:</strong>
    				$<?= $usuario->saldo; ?></p>
    			<h2 class="mb-0" id="compra"></h2>
    			<input id="saldoCuenta" value="<?= $usuario->saldo; ?>" hidden>
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
    					<?php foreach ($dias as $key => $dia): ?>
    					<?php
    							$nroDia = date('N');
    							$proximo = time() + ((7-$nroDia+($key+1)) * 24 * 60 * 60 );
    							$proxima_fecha = date('d', $proximo);
    						?>

    					<div class="my-1 form-check form-check-inline">
    						<fieldset
    							<?= ($usuario->saldo < 180) || (in_array(date('Y-m-d', $proximo), array_column($fechas, 'fecha'))) ? 'disabled' : ''; ?>>
    							<div class="form-check">
    								<input type="checkbox" class="form-check-input" id="check<?= ucwords($dia); ?>"
    									name="check<?= ucwords($dia); ?>" value="<?= ucwords($dia); ?>">
    								<label class="form-check-label"
    									for="check<?= ucwords($dia); ?>"><?= ucwords($dia); ?>
    									<?= $proxima_fecha; ?></label>
    							</div>
    							<fieldset id="<?= $dia; ?>" disabled>
    								<div class="form-check">
    									<input type="checkbox" class="form-check-input" id="checkTipo<?= $key; ?>"
    										name="checkTipo<?= $key; ?>" value="Para llevar">
    									<label class="form-check-label" for="checkTipo<?= $key; ?>">Para llevar</label>
    								</div>
    								<div class="form-check">
    									<input class="form-check-input" type="radio"
    										name="radioTurno<?= ucwords($dia); ?>" id="radioTurno<?= ucwords($dia); ?>1"
    										value="Turno 1" checked>
    									<label class="form-check-label" for="radioTurno<?= ucwords($dia); ?>1">Turno
    										1</label>
    								</div>
    								<div class="form-check">
    									<input class="form-check-input" type="radio"
    										name="radioTurno<?= ucwords($dia); ?>" id="radioTurno<?= ucwords($dia); ?>2"
    										value="Turno 2">
    									<label class="form-check-label" for="radioTurno<?= ucwords($dia); ?>2">Turno
    										2</label>
    								</div>
    							</fieldset>
    						</fieldset>
    					</div>
    					<?php endforeach; ?>
    					<div class="form-check">
    						<div class="btn-group" role="group" aria-label="Basic example">
    							<button type="submit" id="btnCompra" class="btn btn-primary mx-3"
    								disabled>Comprar</button>
    							<button type="reset" id="btnReset" class="btn btn-warning mx-3">Reset</button>
    						</div>
    					</div>
    					<div id="totalCompra"></div>
    				</form>
    			</div>

    		</div>
    	</div>
    </div>
    <script src="<?= base_url('assets/js/scripts.js'); ?>"></script>