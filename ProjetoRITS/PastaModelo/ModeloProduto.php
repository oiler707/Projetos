	<?php

Class ModeloProduto
{
	function __construct(){

		date_default_timezone_set('America/Sao_Paulo');

		$GLOBALS["Produto"]=[(object)['Id' => 1,"Nome" => "Hamburguer","Preco"=>4.50],
		(object)['Id' => 2,"Nome" => "Refrigerante","Preco"=>3.50],
		(object)['Id' => 3,"Nome" => "Sanduiche","Preco"=>5.00],
		];
	}



	function PegarProdutos(){
		 
		 if(file_exists("../../PastaModelo/Produtos.json")){
		 	$Arquivo = file_get_contents("../../PastaModelo/Produtos.json");

		 }
		 else{
		 	$Arquivo = file_get_contents("PastaModelo/Produtos.json");

		 }
		 //echo(json_encode($Arquivo));
		 return json_decode($Arquivo,true);
	}
	function PegarProdutosAtivos(){
		 if(file_exists("../../PastaModelo/Produtos.json")){
		 	$Arquivo = file_get_contents("../../PastaModelo/Produtos.json");

		 }
		 else{
		 	$Arquivo = file_get_contents("PastaModelo/Produtos.json");

		 }
		 $Filtro = array_filter(json_decode($Arquivo,true), function($var) {
	    	return ($var["Ativo"] == true);
			});
		 $FiltroUnico = array_splice($Filtro,0);
		 //echo(json_encode($Arquivo));
		 return $FiltroUnico;

	}

	function SalvarProdutos($data){

		$SalvarProdutos = json_encode($data);

		 if(file_exists("../../PastaModelo/Produtos.json")){
		 	
		 	file_put_contents("../../PastaModelo/Produtos.json", $SalvarProdutos);

		 }
		 else{
		 	
		 	file_put_contents("PastaModelo/Produtos.json", $SalvarProdutos);

		 }


		

	}


}

?>


