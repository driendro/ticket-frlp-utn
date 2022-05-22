<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/utn.png'); ?>">
    <title><?= $titulo; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('admin'); ?>">Ticket</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mr-auto">
                    <?php if ($this->session->userdata('is_admin')) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/menu'); ?>">Menu</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $this->session->userdata('apellido'); ?>,
                                <?= $this->session->userdata('nombre'); ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/historial'); ?>">Historial de
                                        cargas</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/nuevo_usuario'); ?>">Crear nuevo
                                        usuario</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/listados'); ?>">Descargar
                                        Listados</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/informe'); ?>" target="_blank">Cierre
                                        de Caja</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a>
                                </li>
                            </ul>
                        </li>
                        <?php if ($this->session->userdata('admin_lvl') == 1) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/crear_vendedor'); ?>">Menu</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
