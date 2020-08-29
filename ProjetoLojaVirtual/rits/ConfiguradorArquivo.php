<?php




function CarregarVisao($PonteiroClasse)
	{
	$CaminhoCarregamento = "../../PastaVisao/" . $PonteiroClasse . ".php";
	if (is_file($CaminhoCarregamento))
		{
		require_once ($CaminhoCarregamento);

		}
	}

function CarregarControlador($PonteiroClasse)
	{
	$CaminhoCarregamento = "../../PastaControlador/" . $PonteiroClasse . ".php";
	if (is_file($CaminhoCarregamento))
		{
		require_once ($CaminhoCarregamento);

		}
	}

function CarregarModelo($PonteiroClasse)
	{
	$CaminhoCarregamento = "../../PastaModelo/" . $PonteiroClasse . ".php";
	if (is_file($CaminhoCarregamento))
		{
		require_once ($CaminhoCarregamento);

		}
	}
session_start();
putenv("EMAIL=projeto5656@gmail.com");

spl_autoload_register('CarregarVisao');
spl_autoload_register('CarregarControlador');
spl_autoload_register('CarregarModelo');
?>