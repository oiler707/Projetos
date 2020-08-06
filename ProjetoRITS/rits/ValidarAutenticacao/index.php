<?php

include('../ConfiguradorArquivo.php');

//$ModeloCliente = new ModeloCliente();

$ControladorAutenticacao = new ControladorAutenticacao();

$ControladorAutenticacao->ValidarAutenticacao();
?>