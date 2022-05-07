<!DOCTYPE html>
<html lang="en">

<head>
	<style>

	</style>
</head>

<body>
	<div style="text-align: center;">
		<h1 style="margin: 1%;">Cierre de caja</h1>
		<h2 style="margin: 1%;"><?= $fecha; ?></h2>
		<p style="margin: 1%;"> Vendedor: <strong><?= $vendedor->nombre_usuario; ?></strong> -
			Cantidad de cargas: <strong><?= $cantidad; ?></strong> -
			Total de cargas: <strong>$ <?= $total; ?> -. </strong>
		</p>
	</div>

	<div style="align-items: center;">
		<table style="width: 100%; text-align: center;">
			<thead style="border-bottom: 3px solid #000">
				<tr>
					<th>Hora</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Monto</th>
					<th>Vendedor</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cargas as $key => $carga) : ?>
				<tr>
					<td style="border-bottom: 1px solid #ddd"><?= $carga->hora; ?></td>
					<td style="border-bottom: 1px solid #ddd"><?= $carga->nombre; ?></td>
					<td style="border-bottom: 1px solid #ddd"><?= $carga->apellido; ?></td>
					<td style="border-bottom: 1px solid #ddd"><?= $carga->monto; ?></td>
					<td style="border-bottom: 1px solid #ddd"><?= $carga->nombre_usuario; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</body>

</html>