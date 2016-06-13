<?php
require '../../vendor/autoload.php';

include_once '../controller/GoogleClientCtrl.php';

$googleClient = new GoogleClientCtrl();

$googleClient->generateCredentials();

?>