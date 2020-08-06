<?php

Class ModeloHistorico
{
	function __construct(){

		date_default_timezone_set('America/Sao_Paulo');
		$GLOBALS["Historico"]=[
		(object)['Id' => 1,"CodigoCliente" => 13536,'Data'=>new DateTime('2020-01-01T02:30:00'),
		"Status"=>"Pendente","Produtos"=>[(object)['Id' => 2,"Quantidade" => 11],(object)['Id' => 1,"Quantidade" => 7]],"Total"=>55.50],
		(object)['Id' => 2,"CodigoCliente" => 13536,'Data'=>new DateTime('2020-12-01T02:20:00'),
		"Status"=>"Em entrega","Produtos"=>[(object)['Id' => 2,"Quantidade" => 3],(object)['Id' => 1,"Quantidade" => 2]],"Total"=>25.50],];
		;
	}


		function PegarHistoricos(){
		 
		 if(file_exists("../../PastaModelo/Historicos.json")){
		 	$Arquivo = file_get_contents("../../PastaModelo/Historicos.json");

		 }
		 else{
		 	$Arquivo = file_get_contents("PastaModelo/Historicos.json");

		 }
		 //echo(json_encode($Arquivo));
		 return json_decode($Arquivo,true);
	}
	
	function SalvarHistoricos($data){

		$SalvarHistorico = json_encode($data);

		 if(file_exists("../../PastaModelo/Historicos.json")){
		 	
		 	file_put_contents("../../PastaModelo/Historicos.json", $SalvarHistorico);

		 }
		 else{
		 	
		 	file_put_contents("PastaModelo/Historicos.json", $SalvarHistorico);

		 }


		

	}


}

?>