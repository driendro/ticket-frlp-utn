    	<div class="row form-center">
    		<div class="col-sm-2"></div>
    		<div class="col-sm-8">
				<h1>Crear nuevo usuario</h1>
    			<form action="cargar_saldo" method="post">
    				<div class="form-group col">
						<div class="row">
							<label for="idSaldoActual" class="col-sm-2 col-form-label">Saldo inicial:</label>
							<div class="col-sm-3">
								<input type="number" class="form-control" name="saldo">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">Legajo:</label>
							<div class="col-sm-3">
								<input type="number" class="form-control" name="legajo">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">DNI:</label>
							<div class="col-sm-3">
								<input type="number" class="form-control" name="dni">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">Especialidad:</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="especialidad">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">E-Mail:</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="email">
							</div>
						</div>
    				</div>
    				<button type="submit" class="btn btn-success">Crear usuario</button>
    			</form>
    		</div>
    		<div class="col-sm-2"></div>
    	</div>
