<?php

Class ModeloComentario
{
	function __construct(){



	}
	function Salvar($Comentario,$Nome,$Email,$Whatsapp,$Data,$Validacao){
		
		$Objeto = (object)["Comentario"=>$Comentario,"Nome" => $Nome,"Whatsapp"=>$Whatsapp,"Data"=>json_decode(json_encode($Data),true)["date"],"Validacao"=>$Validacao];


	

		 if(file_exists("../../PastaModelo/Dados/Comentarios.json")){
		 	$TempComentarios = json_decode(file_get_contents("../../PastaModelo/Dados/Comentarios.json"),true);

		 	
		 	array_push($TempComentarios,$Objeto);
		 	
		 	file_put_contents("../../PastaModelo/Dados/Comentarios.json", json_encode($TempComentarios));

		 }
		 
	}
	function Todos(){

		
	
	if(file_exists("../../PastaModelo/Dados/Comentarios.json")){
		 	$TempComentarios = json_decode(file_get_contents("../../PastaModelo/Dados/Comentarios.json"),true);

		 	$Comentarios="";

		 	foreach ($TempComentarios as $Id => $Temp) {
		 		if($Temp["Validacao"]==true){
		 		//echo(date("d/m/yy",strtotime($Temp["Data"] ) )." ás ".date("H:i",strtotime($Temp["Data"] ) ) ) ;	
		 		$Comentarios=$this->CriarComentario($Temp["Comentario"],$Temp["Nome"],date("d/m/yy",strtotime($Temp["Data"] ) )." ás ".date("H:i",strtotime($Temp["Data"] ) ) ).$Comentarios;
		 		}
		 	}
		 	$Comentarios='<div class="Comentario"><div>Comentário</div><div>Nome</div><div>Data</div></div>'.$Comentarios;
		return $Comentarios ;	 	
	}


	

	}


	function CriarComentario($Comentario,$Nome,$Data){

		$Temp = '<div class="Comentario"><div class="Resposta">'.$Comentario.'</div><div>'.$Nome.'</div><div>'.$Data.'</div></div>';

		return $Temp;
	}
}