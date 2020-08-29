<?php

Class ModeloCliente
{
	function __construct(){




		date_default_timezone_set('America/Sao_Paulo');
		$GLOBALS["Cliente"]=[
		(object)["CodigoCliente" => 13536,"Nome"=>"Euler Porto Neto","Email"=>"Oiler707@gmai.com","Telefone"=>"47-99641-9300","Endereco"=>"Rua Alameda 44","UserLogin"=>"Euler","Senha"=>"Porto","Admin"=>False],
		(object)["CodigoCliente" => 13537,"Nome"=>"Renato Porto Neto","Email"=>"Renato707@gmai.com","Telefone"=>"47-99642-9300","Endereco"=>"Rua Alameda 47","UserLogin"=>"Admin","Senha"=>"Admin","Admin"=>True],
		(object)["CodigoCliente" => 13538,"Nome"=>"Pablo Porto Neto","Email"=>"Pablo@gmai.com","Telefone"=>"47-99641-9302","Endereco"=>"Rua Alameda 45","UserLogin"=>"Euler3","Senha"=>"Porto","Admin"=>False],
		];
	}


	function PegarClientes(){
		 
		 if(file_exists("../../PastaModelo/Clientes.json")){
		 	$ArquivoClientes = file_get_contents("../../PastaModelo/Clientes.json");

		 }
		 else{
		 	$ArquivoClientes = file_get_contents("PastaModelo/Clientes.json");

		 }
		 
		 return json_decode($ArquivoClientes,true);
	}

	function SalvarClientes($data){

		$SalvarClientes = json_encode($data);

		 if(file_exists("../../PastaModelo/Clientes.json")){
		 	
		 	file_put_contents("../../PastaModelo/Clientes.json", $SalvarClientes);

		 }
		 else{
		 	
		 	file_put_contents("PastaModelo/Clientes.json", $SalvarClientes);

		 }


		

	}

	

}

?>