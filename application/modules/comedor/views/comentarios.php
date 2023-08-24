<div class="container">
    <?php echo validation_errors(); ?>
    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    
    <form action="<?= base_url('comedor/agregar_comentario'); ?>" method='post' ?>
    <div class='form-group'>
        <label for='comentario'>Deje aquí su comentario:</label>
        <textarea class='form-control' name='comentario' rows='4' placeholder='Ingrese su comentario...'></textarea>
    </div>
    <button type='submit' class='btn btn-primary' name='agregar_comentario' id="submitButton">Enviar</button>
    </form>
</div>