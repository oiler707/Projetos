<?php

Class ModeloCidades
{
	function __construct(){




		
	}


	function PegarCidades(){
		 
		 if(file_exists("../../PastaModelo/Cidades.json")){
		 	$Temporario = file_get_contents("../../PastaModelo/Cidades.json");

		 }
		 else{
		 	$Temporario = file_get_contents("PastaModelo/Cidades.json");

		 }
		 
		 return json_decode($Temporario,true);
	}

}

?>