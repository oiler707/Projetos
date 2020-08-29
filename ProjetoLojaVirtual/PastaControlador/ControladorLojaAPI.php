<?php

Class ControladorLojaAPI
{
	function __construct(){

		
	}

	function ControladorLojaAPI(){

		//echo("Entrou");
		$this->ValidarAcesso();
		include ("../../PastaVisao/LojaAPI.html");
		
	}	
	
	function BuscarProdutos(){
			$ModeloProduto= new ModeloProduto();
			$Produtos = $ModeloProduto->PegarProdutos();
			
			//echo(json_encode(json_decode(json_encode($Produtos),true)));
			echo(json_encode($Produtos));
		

	}

	function BuscarProdutosAtivos(){
			$ModeloProduto= new ModeloProduto();
			$Produtos = $ModeloProduto->PegarProdutosAtivos();
			
			//echo(json_encode(json_decode(json_encode($Produtos),true)));
			echo(json_encode($Produtos));

	}

	function BuscarHistoricoCliente(){
		

		//echo json_encode($GLOBALS["Historico"]);	
		$ModeloHistorico = new ModeloHistorico();
		$Historicos =  $ModeloHistorico->PegarHistoricos();


		$Filtrado = array_filter($Historicos, function($var) {
	    return ($var['CodigoCliente'] == $_SESSION["UsuarioConectado"]);
	});


		echo json_encode(array_splice($Filtrado,0));	

		//echo json_encode($GLOBALS["Historico"]);
		
	}


	function RemoverPedido(){

		if(isset($_POST['ObjetoSistema'])){

				$ModeloHistorico = new ModeloHistorico();
				$Historicos =  $ModeloHistorico->PegarHistoricos();

		
				$ModeloHistorico = new ModeloHistorico();
				$Historicos =  $ModeloHistorico->PegarHistoricos();

				$Filtrado = array_filter($Historicos, function($var) {
	    				return ($var['Id'] != json_decode($_POST['ObjetoSistema'],true)['Id']);
				});

				$Filtrado = array_filter($Historicos, function($var) {
	    				return ($var['Id'] == json_decode($_POST['ObjetoSistema'],true)['Id']);
				});
				if(count($Filtrado)>0){
					$FiltradoUnico = array_splice($Filtrado , 0);
					if($FiltradoUnico[0]["Status"]=="Pendente"){
						$Salvar = array_filter($Historicos, function($var) {
	    					return ($var['Id'] != json_decode($_POST['ObjetoSistema'],true)['Id']);


						});




						$ModeloHistorico->SalvarHistoricos($Salvar);
						echo(true);

						$ModeloCliente = new ModeloCliente();

			
						$Clientes = $ModeloCliente->PegarClientes();

						$Filtro = array_filter($Clientes, function($var) {
							return ($var["CodigoCliente"] == $_SESSION["UsuarioConectado"]);
						});
						$FiltroUnico=array_splice($Filtro, 0);

						$ModeloEmail = new ControladorEnvioEmail();

						$ModeloEmail->DisparoPedido(json_decode($_POST['ObjetoSistema'],true)['Id'],$FiltroUnico[0]["Nome"],2);
					}
				}
				
//echo(json_encode($GLOBALS["Historico"] ));
		}
	}


	function AdicionarPedido(){
		if(isset($_POST['ObjetoSistema'])){
			date_default_timezone_set('America/Sao_Paulo');
			$ObjetoSistema=$_POST['ObjetoSistema'];
			$Produtos=json_decode($ObjetoSistema,true)["Produtos"];
			$Total=json_decode($ObjetoSistema,true)["Total"];
			$Status="Pendente";
			$Data=new DateTime();
			
			foreach ($Produtos as $key => $Prod) {
				$Produtos[$key]["Id"]=intval($Prod["Id"]);
				$Produtos[$key]["Quantidade"]=intval($Prod["Quantidade"]);
			}
			
			$ModeloHistorico = new ModeloHistorico();
			$Historicos =  $ModeloHistorico->PegarHistoricos();

			$NovoCodigo =end($Historicos)["Id"]+10;

			$NovoPedido = (object)["Id"=>$NovoCodigo,"CodigoCliente" => $_SESSION["UsuarioConectado"],"Data"=>json_decode(json_encode($Data),true)["date"],"Status"=>"Pendente","Produtos"=>$Produtos,"Total"=>intval($Total)];

			array_push($Historicos,$NovoPedido);

			$ModeloHistorico->SalvarHistoricos($Historicos);
		
			echo(true);
		
			$ModeloCliente = new ModeloCliente();

			
			$Clientes = $ModeloCliente->PegarClientes();

			$Filtro = array_filter($Clientes, function($var) {
				return ($var["CodigoCliente"] == $_SESSION["UsuarioConectado"]);
			});
			$FiltroUnico=array_splice($Filtro, 0);

			$ModeloEmail = new ControladorEnvioEmail();

			$ModeloEmail->DisparoPedido($NovoCodigo,$FiltroUnico[0]["Nome"],1);

		}


	}

	function EditarPedido(){
		if(isset($_POST['ObjetoSistema'])){

			$ObjetoSistema=$_POST['ObjetoSistema'];
			$Produtos=json_decode($ObjetoSistema,true)["Produtos"];
			$Total=json_decode($ObjetoSistema,true)["Total"];
			$IdPedido=json_decode($ObjetoSistema,true)["IdPedido"];
			$Status="Pendente";
			$Data=new DateTime();
			$CodigoCliente=1;

			$ModeloHistorico = new ModeloHistorico();
			$Historicos =  $ModeloHistorico->PegarHistoricos();
			foreach ($Historicos as $key => $Hist) {
				if($Hist["Id"]==$IdPedido && $_SESSION["UsuarioConectado"]==$Hist["CodigoCliente"]&&$Hist["Status"]=="Pendente"){
					$Historicos[$key]["Produtos"]=$Produtos;
					$Historicos[$key]["Total"]=doubleval($Total);

				}
			}
			$ModeloHistorico->SalvarHistoricos($Historicos);

			//echo(json_encode(json_decode($_POST['ObjetoSistema'],true)));
		}
	}
	

	function ValidarAcesso(){
		if(isset($_SESSION["UsuarioConectado"])){

			return True;
		}
		else{
			header('Location: /ProjetoLojaVirtual/');


		}


	}


/*	function ValidarAutenticacao(){
		
		if(isset($_POST['ObjetoSistema'])){
			$ObjetoSistema=json_decode($_POST['ObjetoSistema'],true);
	


			if($ObjetoSistema["Usuario"]=="Euler"&&$ObjetoSistema["Senha"]=="Porto"){
				echo true;
			}
			else{
				echo false;
			}

		}
		
	}

*/

}
?>