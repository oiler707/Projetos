<?php

Class ControladorComentarios
{
	function __construct(){
		

		
	}

	function EnviarComentario(){
		date_default_timezone_set('America/Sao_Paulo');
		if(isset($_POST['ObjetoSistema'])){


			$Comentario = json_decode($_POST['ObjetoSistema'],true)['Comentario'];
			$Nome = json_decode($_POST['ObjetoSistema'],true)['Nome'];
			$Email = json_decode($_POST['ObjetoSistema'],true)['Email'];
			$Whatsapp = json_decode($_POST['ObjetoSistema'],true)['Whatsapp'];
			$Data=new DateTime();
			$Validacao=false;

			$ModeloComentario= new ModeloComentario();
			$ModeloComentario->Salvar($Comentario,$Nome,$Email,$Whatsapp,$Data,$Validacao);


			//Salvar($Comentario,$Nome,$Email,$Whatsapp,$Data,$Validacao);
			//echo(json_encode(json_decode($_POST['ObjetoSistema'],true)));
		}

		echo("Comentário salvo com sucesso!");
		
	}
	
}	