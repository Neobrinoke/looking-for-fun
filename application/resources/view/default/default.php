<?php ob_start() ?>

Default

<?= $a ?>
<?= $b ?>

<?php
$content = ob_get_clean();

include(__DIR__ . '/../base.php');
?>