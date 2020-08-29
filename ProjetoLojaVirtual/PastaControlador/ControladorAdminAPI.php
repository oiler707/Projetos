<?php

Class ControladorAdminAPI
{
	function __construct(){

		
	}

	function ControladorAdminAPI(){
				$this->ValidarAcesso();
				include ("../../PastaVisao/AdminAPI.html");
		
	}	


	function ListarClientes(){
		$ModeloCliente = new ModeloCliente();

		$Clientes = $ModeloCliente->PegarClientes();




		echo json_encode($Clientes);	
	}


	function ExcluirProduto(){


		if(isset($_POST['ObjetoSistema'])){

			$ModeloProduto= new ModeloProduto();
			$Produtos = $ModeloProduto->PegarProdutos();


	

			foreach ($Produtos as $Key => $Prod) {

			if($Prod["Id"]==json_decode($_POST['ObjetoSistema'],true)['Id']){
				
				

				//$Validadores=["Em proparo","Pendente","Em entrega","Entregue","Cancelado"];
				
				

				if($Prod["Ativo"]==true){
					
					$Produtos[$Key]["Ativo"]=false;


				}

				
				

			}
		}
		$ModeloProduto->SalvarProdutos($Produtos);
		echo(true);
	}


	}

	function EditarProduto(){
			if(isset($_POST['ObjetoSistema'])){




				$IdProduto = json_decode($_POST['ObjetoSistema'],true)['Id'];
				$PrecoProduto= json_decode($_POST['ObjetoSistema'],true)['Preco'];
				$NomeProduco = json_decode($_POST['ObjetoSistema'],true)['Nome'];




				$ModeloProduto= new ModeloProduto();
				$Produtos = $ModeloProduto->PegarProdutos();

				$FiltroProdutoDiferente = array_filter($Produtos, function($var) {
	    			return ($var["Ativo"]==true && $var["Nome"] == json_decode($_POST['ObjetoSistema'],true)["Nome"] && $var["Id"] != json_decode($_POST['ObjetoSistema'],true)["Id"]);
				});
				$FiltroMesmoProduto=array_filter($Produtos, function($var) {
	    			return ($var["Ativo"]==true && $var["Nome"] == json_decode($_POST['ObjetoSistema'],true)["Nome"]&&  $var["Id"] == json_decode($_POST['ObjetoSistema'],true)["Id"] &&   $var["Preco"] == doubleval(json_decode($_POST['ObjetoSistema'],true)["Preco"]));
				});
				if($NomeProduco==""){
					echo("Nome deve ser preenchido.");
				}
				else if(count($FiltroProdutoDiferente)>0){
					
						echo("Esse produto já existe.");
					
				}

				else if(count($FiltroMesmoProduto)>0){

					
						echo("Você tem que editar algo antes.");
				}

				else if(!preg_match("/^[A-zÀ-ú ]*$/",$NomeProduco)) {
  					echo("Nome em formato inválido.");
				}	
				else if($PrecoProduto==""){
					echo("Preço deve ser preenchido.");
				}
				else{
					
							
							foreach ($Produtos as $Key => $Prod) {

							if($Prod["Id"]==json_decode($_POST['ObjetoSistema'],true)['Id']){
								
								

								//$Validadores=["Em proparo","Pendente","Em entrega","Entregue","Cancelado"];
								
								

								if($Prod["Ativo"]==true){
									
									$Produtos[$Key]["Nome"]=$NomeProduco;
									$Produtos[$Key]["Preco"]=doubleval($PrecoProduto);

								}

								
								

							}
					}
					$ModeloProduto->SalvarProdutos($Produtos);
					echo(true);

				}
		}


	}

		function CriarProduto(){
			if(isset($_POST['ObjetoSistema'])){
				
				$PrecoProduto= doubleval(json_decode($_POST['ObjetoSistema'],true)['Preco']);
				$NomeProduco = json_decode($_POST['ObjetoSistema'],true)['Nome'];

				$ModeloProduto = new ModeloProduto();

				$Produtos = $ModeloProduto->PegarProdutos();
				
				$FiltroProduto = array_filter($Produtos, function($var) {
	    			return ($var["Ativo"]==true && $var["Nome"] == json_decode($_POST['ObjetoSistema'],true)["Nome"]);
				});
				
				if($NomeProduco==""){
					echo("Nome deve ser preenchido.");
				}
				else if(count($FiltroProduto)>0){
					echo("Esse produto já existe.");

				}
				else if(!preg_match("/^[A-zÀ-ú ]*$/",$NomeProduco)) {
  					echo("Nome em formato inválido.");
				}	
				else if($PrecoProduto==""){
					echo("Preço deve ser preenchido.");
				}
				else{
					echo(true);

				$NovoId =end($Produtos)["Id"]+10;

				$NovoProduto = (object)["Id" => $NovoId,"Nome"=>$NomeProduco,"Preco"=>$PrecoProduto,"Ativo"=>true];

				array_push($Produtos,$NovoProduto);

				$ModeloProduto->SalvarProdutos($Produtos);


				}

	

		}


	}

	function ModificarStatus(){
		$IdPedido = json_decode($_POST['ObjetoSistema'],true)['Id'];
		$Status = json_decode($_POST['ObjetoSistema'],true)['Status'];


		$ModeloHistorico = new ModeloHistorico();
		$Historicos =  $ModeloHistorico->PegarHistoricos();

		
		foreach ($Historicos as $Key => $Hist) {

			if($Hist["Id"]==$IdPedido){
				
				

				$Validadores=["Em proparo","Pendente","Em entrega","Entregue","Cancelado"];
				
				$Filtro = array_filter($Validadores, function($var) {
		    		return ($var == json_decode($_POST['ObjetoSistema'],true)['Status']);
				});

				if(count($Status)>0 && $Hist["Status"]!=$Status){
					
					$Historicos[$Key]["Status"]=$Status;

					$IdCliente = $Hist["CodigoCliente"];
					
					$ModeloCliente = new ModeloCliente();
					$GLOBALS["TempCliente"]=$IdCliente;
					$Clientes = $ModeloCliente->PegarClientes();

					$Filtro = array_filter($Clientes, function($var) {
	    				return ($var["CodigoCliente"] == $GLOBALS["TempCliente"]);
					});

					$FiltroUnico=array_splice($Filtro, 0);

					$ModeloEmail = new ControladorEnvioEmail();

					$ModeloEmail->EnvioEmail($FiltroUnico[0]["Email"],$FiltroUnico[0]["Nome"],$IdPedido,$Status);
				}

				
				

			}
		}
		//$HistoricoFiltrado[0]["Status"]=$Status;
		$ModeloHistorico->SalvarHistoricos($Historicos);
		

	}	

	function BuscarPedidos(){
		$ModeloHistorico = new ModeloHistorico();
		$Historicos =  $ModeloHistorico->PegarHistoricos();
		$HistoricosArray = array_splice($Historicos,0);
		echo json_encode($HistoricosArray);	


	}
		function ValidarAcesso(){
		
			if(isset($_SESSION["UsuarioConectado"])){

			$ModeloCliente = new ModeloCliente();

			$Clientes = $ModeloCliente->PegarClientes();

			
			$Filtro = array_filter($Clientes, function($var) {
	    	return ($var["CodigoCliente"] == $_SESSION["UsuarioConectado"]);
			});

			

			if(count($Filtro)>0){
			$FiltroUnico = array_splice($Filtro,0);

				if($FiltroUnico[0]["Admin"]==true){
					
					return True;
				}
				else{
					
					header('Location: /ProjetoRITS/rits/LojaAPI/');
				}
				

			}	
			
			else{
				header('Location: /ProjetoRITS/');
			}
			

		}
		else{
				header('Location: /ProjetoRITS/');
			}

	}



}