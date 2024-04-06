<?php
require_once 'Importar.php';

$importador = new Importar();

$importador->customers("customers.csv");

$importador->brandCustomer("customers.csv");
?>
