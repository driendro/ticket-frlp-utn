<html>

<head>
</head>

<body>

	<p>Hola <strong><?= strtoupper($apellido); ?>, <?= ucwords($nombre); ?></strong>:</p>
	<p> Ha solicitado una nueva contraseña para la cuenta de <strong>Ticket Web</strong> asociada al documento
		<strong><?= $dni; ?></strong>.
	</p>

	<p>Su nueva contraseña es: <strong><?= $password; ?></strong></p>

	<p>Por favor, vuelva a cambiar su contraseña en cuanto se conecte.</p>

	<p> A su disposición, </br> El equipo de <strong>Ticket Web</strong></p>

</body>

</html>