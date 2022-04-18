    <div class="container">
    	<div class="row">
    		<div class="col mt-5">
    			<h5 class="title text-center">UTN FRLP Ticket Web - Cambiar contraseña</h5>
    		</div>
    	</div>
    	<div class="row form-center">
    		<div class="col-5 my-3">
    			<?= form_open(current_url()); ?>
    			<div class="mb-4">
    				<input type="password" class="form-control" name="password_anterior"
    					placeholder="Contraseña que actualmente usa para ingresar al sistema">
    			</div>
    			<div class="mb-4">
    				<input type="password" class="form-control" name="password_nuevo" placeholder="Nueva contraseña">
    			</div>
    			<div class="mb-4">
    				<input type="password" class="form-control" name="password_confirmado"
    					placeholder="Confirme la nueva contraseña que va a utilizar">
    			</div>
    			<div class="d-grid gap-2">
    				<button type="submit" class="btn btn-primary">Cambiar contraseña</button>
    			</div>
    			<?= form_close(); ?>
    		</div>
    	</div>
    </div>