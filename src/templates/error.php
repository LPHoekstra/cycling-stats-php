<?php
include(__DIR__ . "/../../index.php");
ob_start(); ?>

<h1>Une erreur s'est produite</h1>
<h2><?= $errorMsg ?></h2>

<?php $content = ob_get_clean();

require_once(__DIR__ . "/layout.php"); ?>