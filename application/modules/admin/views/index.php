    <div class="container">
    	<div class="row form-center">
    		<div class="col-4 my-3">
    			<?= form_open(current_url()); ?>
    			<div class="row form-group mb-4 form-inline">
    				<input type="number" class="mb-2 form-control" placeholder="Ingrese DNI" name="numeroDni">
    				<button type="submit" class="btn btn-success">Buscar</button>
    			</div>
    			<?= form_close(); ?>
    		</div>
    	</div>
    	<?php if ((isset($usuario)) && ($usuario != FALSE)) : ?>
    	<div class="row form-center">
    		<div class="col-sm-2"></div>
    		<div class="col-sm-8">
    			<h2> <?= ucwords($usuario->tipo) ?>: <?= strtoupper($usuario->apellido) ?>,
    				<?= ucwords($usuario->nombre) ?>
    			</h2>
    			<form action="<?= base_url('admin/cargar_saldo'); ?>" method="post">
    				<div class="form-group row">
    					<label for="idSaldoActual" class="col-sm-2 col-form-label">Saldo actual:</label>
    					<div class="col-sm-10">
    						<input type="number" readonly class="form-control-plaintext" id="idSaldoActual"
    							value="<?= $usuario->saldo ?>">
    					</div>
    					<label for="idCarga" class="col-sm-2 col-form-label">Carga: </label>
    					<div class="col-sm-2">
    						<input type="number" class="form-control" name="carga" id="carga">
    					</div>
    					<div class="col-sm-8"></div>

    					<label class="col-sm-2 col-form-label">Legajo:</label>
    					<div class="col-sm-10">
    						<input type="text" readonly class="form-control-plaintext" value="<?= $usuario->legajo ?>">
    					</div>
    					<label class="col-sm-2 col-form-label">DNI:</label>
    					<div class="col-sm-10">
    						<input type="text" readonly name='dni' class="form-control-plaintext"
    							value="<?= $usuario->documento ?>">
    					</div>
    					<label class="col-sm-2 col-form-label">Especialidad:</label>
    					<div class="col-sm-10">
    						<input type="text" readonly class="form-control-plaintext"
    							value="<?= $usuario->especialidad ?>">
    					</div>

    					<label class="col-sm-2 col-form-label">E-Mail:</label>
    					<div class="col-sm-10">
    						<input type="text" readonly class="form-control-plaintext" value="<?= $usuario->mail ?>">
    					</div>
    				</div>
    				<div>
    					<button type="submit" class="btn btn-success mx-3">Cargar Saldo</button>
    					<a class="btn btn-primary" href="<?= base_url('admin/modificar_usuario'); ?>"
    						role="button">Modificar usuario</a>
    				</div>
    			</form>
    		</div>
    		<div class="col-sm-2"></div>
    	</div>

    	<?php elseif ((isset($usuario)) && ($usuario == FALSE)) : ?>
    	<div class="row form-center">
    		<div class="col-sm-2"></div>
    		<div class="col-sm-8">
    			<h2>Ese numero de documento no existe</h2>
    			<a class="btn btn-primary" href="<?= base_url('admin/nuevo_usuario'); ?>" role="button">Nuevo
    				usuario</a>
    		</div>
    		<div class="col-sm-2"></div>
    	</div>

    	<?php endif; ?>
    </div>