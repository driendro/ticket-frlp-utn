    <div class="container">
    	<div class="row">
    		<div class="col my-4">
    			<img class="img-fluid mx-auto d-block" src="<?= base_url('assets/img/logo_comedor.png'); ?>" alt="">
    		</div>
    	</div>
    	<div class="row form-center">
    		<div class="col-4 my-3">
    			<?= form_open(current_url()); ?>
    			<div class="form-group mb-4">
    				<input type="number" class="form-control" placeholder="Ingrese su DNI" name="documento">
    			</div>
    			<div class="d-grid gap-2">
    				<button type="submit" class="btn btn-success">Generar nueva contraseña</button>
    			</div>
    			<?= form_close(); ?>
    		</div>
    	</div>
    </div>
