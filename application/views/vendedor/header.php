<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
	<title><?= $titulo; ?></title>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url('ticket'); ?>">Ticket</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
				aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarHeader">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('#'); ?>">Menu</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('contacto'); ?>">Contacto</a>
					</li>
					<?php if($this->session->userdata('id_vendedor')): ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
							data-bs-toggle="dropdown"
							aria-expanded="false"><?= $this->session->userdata('apellido'); ?>,
							<?= $this->session->userdata('nombre'); ?></a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li>
								<a class="dropdown-item" href="<?= base_url('#'); ?>">Historial de
									ventas</a>
							</li>
							<li>
								<a class="dropdown-item" href="<?= base_url('admin/nuevo_usuario'); ?>">Crear nuevo usuario</a>
							</li>
							<li>
								<a class="dropdown-item" href="<?= base_url('#'); ?>">Cambiar
									contraseña</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li>
								<a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a>
							</li>
						</ul>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
