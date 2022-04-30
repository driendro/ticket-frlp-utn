    	<div class="container">
    		<div class="row">
    			<div class="col-10 my-3">
    				<h1>Modificar usuario</h1>
    				<?= form_open(current_url()); ?>
    				<div class="form-group col">
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Legajo:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="number" class="form-control" name="legajo"
    								value="<?= explode("-", $usuario->legajo)[1] ?>">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">DNI:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="number" class="form-control" name="dni" value="<?= $usuario->documento ?>">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Nombre:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="text" class="form-control" name="nombre" value="<?= $usuario->nombre ?>">
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">Apellido:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="text" class="form-control" name="apellido" value="<?= $usuario->apellido ?>">
    						</div>
    					</div>
    					<div class="row" id="claustroSelec">
    						<label class="col-sm-2 col-form-label">Claustro:</label>
    						<div class="col-md-3">
    							<select class="mb-2 form-select" name="claustro">
    								<option <?= ($usuario->tipo == 'alumno') ? 'selected' : ''; ?> value="Estudiante">
    									Estudiante</option>
    								<option <?= ($usuario->tipo == 'docente') ? 'selected' : ''; ?> value="Docente">Docente
    								</option>
    								<option <?= ($usuario->tipo == 'no docente') ? 'selected' : ''; ?> value="No Docente">
    									No Docente</option>
    							</select>
    						</div>
    					</div>
    					<div class="row" id="especialidadSelec">
    						<label class="col-sm-2 col-form-label">Especialidad:</label>
    						<div class="col-md-3">
    							<select class="mb-2 form-select" name="especialidad">
    								<option <?= ($usuario->especialidad == 'civil') ? 'selected' : ''; ?>
    									value="Ing. Civil">Ing. Civil</option>
    								<option <?= ($usuario->especialidad == 'electrica') ? 'selected' : ''; ?>
    									value="Ing. Electrica">Ing. Electrica</option>
    								<option <?= ($usuario->especialidad == 'industrial') ? 'selected' : ''; ?>
    									value="Ing. Industrial">Ing. Idustrial</option>
    								<option <?= ($usuario->especialidad == 'mecanica') ? 'selected' : ''; ?>
    									value="Ing. Mecanica">Ing. Mecanica</option>
    								<option <?= ($usuario->especialidad == 'quimica') ? 'selected' : ''; ?>
    									value="Ing. Quimica">Ing. Quimica</option>
    								<option <?= ($usuario->especialidad == 'sistemas') ? 'selected' : ''; ?>
    									value="Ing. en Sistmeas">Ing. en Sistemas</option>
    							</select>
    						</div>
    					</div>
    					<div class="row">
    						<label class="col-sm-2 col-form-label">E-Mail:</label>
    						<div class="mb-2 col-sm-3">
    							<input type="text" class="form-control" name="email" value="<?= $usuario->mail ?>">
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
    						<button type="submit" class="btn btn-success">Actualizar usuario</button>
    					</div>
    					<?= form_close(); ?>
    				</div>
    			</div>
    		</div>
    	</div>