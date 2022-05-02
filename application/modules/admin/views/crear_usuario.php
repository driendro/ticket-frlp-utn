    	<div class="container">
    		<div class="row">
    			<div class="col-10 my-3">
    				<h1>Crear nuevo usuario</h1>
    				<?= form_open(current_url()); ?>
    				<div class="form-group col">
    					<div class="row">
    						<label for="idSaldoActual" class="col-sm-2 col-form-label">Saldo inicial:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="number" class="form-control" name="saldo">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Legajo:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="number" class="form-control" name="legajo">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">DNI:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="number" class="form-control" name="dni">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Nombre:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="text" class="form-control" name="nombre">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Apellido:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="text" class="form-control" name="apellido">
    						</div>
    					</div>
    					<div class="row" id="claustroSelec">
    						<label class="col-sm-2 col-form-label">Claustro:</label>
    						<div class="col-md-3">
    							<select class="mb-2 form-select" name="claustro">
    								<option selected>Seleccione Claustro</option>
    								<option value="Estudiante">Estudiate</option>
    								<option value="Docente">Docente</option>
    								<option value="No Docente">No Docente</option>
    							</select>
    						</div>
    					</div>
    					<div class="row" id="especialidadSelec">
    						<label class="col-sm-2 col-form-label">Especialidad:</label>
    						<div class="col-md-3">
    							<select class="mb-2 form-select" name="especialidad">
    								<option selected>Seleccione Carrera</option>
    								<option value="Civil">Ing. Civil</option>
    								<option value="Electrica">Ing. Electrica</option>
    								<option value="Industrial">Ing. Idustrial</option>
    								<option value="Mecanica">Ing. Mecanica</option>
    								<option value="Quimica">Ing. Quimica</option>
    								<option value="Sistmeas">Ing. en Sistemas</option>
    							</select>
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">E-Mail:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="text" class="form-control" name="email">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Tiene beca:</label>
    						<div class="col-md-3">
    							<select class="mb-2 form-select" name="beca">
    								<option value="No">No</option>
    								<option value="Si">Si</option>
    							</select>
    						</div>
    					</div>
    					<div>
    						<button type="submit" class="btn btn-success">Crear usuario</button>
    					</div>
    					<?= form_close(); ?>
    				</div>
    			</div>
    		</div>
    	</div>