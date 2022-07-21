<h1>Test Transacciones</h1>
<p>
    <?php if (isset($error)) : ?>
    <?php foreach ($error as $e) : ?>
    <? print_r($e); ?>
    <?php endforeach; ?>
    <?php endif; ?>
</p>