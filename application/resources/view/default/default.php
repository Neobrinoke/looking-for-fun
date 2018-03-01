<?php ob_start() ?>

Default

<?= var_dump($user); ?>

<?= var_dump($gameAccount); ?>


<?php
$content = ob_get_clean();

include(__DIR__ . '/../base.php');
?>