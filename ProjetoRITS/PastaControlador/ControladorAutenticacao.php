<?php

Class ControladorAutenticacao
{
	function __construct(){
		

	
	}


	function ControladorAutenticacao(){
		if(isset($_SESSION["UsuarioConectado"])){

			$ModeloCliente = new ModeloCliente();

			$Clientes = $ModeloCliente->PegarClientes();

			
			$Filtro = array_filter($Clientes , function($var) {
	    	return ($var["CodigoCliente"] == $_SESSION["UsuarioConectado"]);
			});

			if(count($Filtro)>0){
			$FiltroUnico = array_splice($Filtro,0);

				if($FiltroUnico[0]["Admin"]==true){
					
					header('Location: /ProjetoRITS/rits/AdminAPI/');
				}
				else{
					
					header('Location: /ProjetoRITS/rits/LojaAPI/');
				}
				

			}	
			else{
				
				
				header('Location: /ProjetoRITS/');
			}

			

		}



		include ("PastaVisao/VisaoAutenticacao.html");
		
	}	



	function CadastroCliente(){

				if(isset($_SESSION["UsuarioConectado"])){

			$ModeloCliente = new ModeloCliente();

			$Clientes = $ModeloCliente->PegarClientes();

			
			$Filtro = array_filter($Clientes , function($var) {
	    	return ($var["CodigoCliente"] == $_SESSION["UsuarioConectado"]);
			});

			if(count($Filtro)>0){
			$FiltroUnico = array_splice($Filtro,0);

				if($FiltroUnico[0]["Admin"]==true){
					
					header('Location: /ProjetoRITS/rits/AdminAPI/');
				}
				else{
					
					header('Location: /ProjetoRITS/rits/LojaAPI/');
				}
				

			}	
			else{
				
				
				header('Location: /ProjetoRITS/');
			}

			

		}





		
		include ("../../PastaVisao/NovoCliente.html");
		
	}



	function ValidarAutenticacao(){
		
		if(isset($_POST['ObjetoSistema'])){
			$ObjetoSistema=json_decode($_POST['ObjetoSistema'],true);
			
			$ModeloCliente = new ModeloCliente();

			$Clientes = $ModeloCliente->PegarClientes();
			

			$Filtro = array_filter($Clientes, function($var) {
	    	return ($var["UserLogin"] == strtolower(json_decode($_POST['ObjetoSistema'],true)["Usuario"]) && $var["Senha"]==strtolower(json_decode($_POST['ObjetoSistema'],true)["Senha"]) );
			});
			
			if(count($Filtro)>0){
				$FiltroUnico = array_splice($Filtro,0);
				
				if($FiltroUnico[0]["Admin"]==true){
					$_SESSION["UsuarioConectado"]=$FiltroUnico[0]["CodigoCliente"];
					
					echo "admin";
				}
				else{
					$_SESSION["UsuarioConectado"]=$FiltroUnico[0]["CodigoCliente"];
					
					echo true;
				}
				

			}
			else{
				
				echo false;
			}
		}
		
	}
	function ValidarCadastro(){

		if(isset($_POST['ObjetoSistema'])){
			$ObjetoSistema=json_decode($_POST['ObjetoSistema'],true);
	


			$ModeloCliente = new ModeloCliente();

			$Clientes = $ModeloCliente->PegarClientes();

			$FiltroEmail = array_filter($Clientes, function($var) {
	    		return ($var["Email"] == json_decode($_POST['ObjetoSistema'],true)["Email"]);
			});

			$FiltroTelefone = array_filter($Clientes, function($var) {
	    		return ($var["Telefone"]==json_decode($_POST['ObjetoSistema'],true)["Telefone"]);
			});

			$FiltroUsuario = array_filter($Clientes, function($var) {
	    		return ($var["UserLogin"] == strtolower(json_decode($_POST['ObjetoSistema'],true)["Usuario"]))	;
			});

			if(json_decode($_POST['ObjetoSistema'],true)["Usuario"]==""){

				echo("Login deve ser preenchido");
			}
			else if(count($FiltroUsuario)>0){

				echo("Login já cadastrado em outro cliente.");
			}
			
			else if(json_decode($_POST['ObjetoSistema'],true)["Senha"]==""){

				echo("Senha deve ser preenchido");
			}

			else if(json_decode($_POST['ObjetoSistema'],true)["Nome"]==""){

				echo("Nome deve ser preenchido");
			}
			else if(!preg_match("/^[a-zA-Z ]*$/",json_decode($_POST['ObjetoSistema'],true)["Nome"])) {
  				echo("Nome em formato inválido.");
			}	

			else if(json_decode($_POST['ObjetoSistema'],true)["Email"]==""){

				echo("Email deve ser preenchido");
			}
			else if (!filter_var(json_decode($_POST['ObjetoSistema'],true)["Email"], FILTER_VALIDATE_EMAIL)) {
			  	echo("Email em formato inválido.");
			}
			else if(count($FiltroEmail)>0){

				echo("Email já cadastrado em outro cliente.");
			}
			else if(json_decode($_POST['ObjetoSistema'],true)["Telefone"]==""){
				echo("Telefone deve ser preenchido.");

			}
			else if($this->ValidarTelefone(json_decode($_POST['ObjetoSistema'],true)["Telefone"])==false){
				echo("Telefone em formato inválido.");

			}
			else if(count($FiltroTelefone)>0){

				echo("Telefone já cadastrado em outro cliente.");
			}
			else if(json_decode($_POST['ObjetoSistema'],true)["Endereco"]==""){
				echo("Endereco deve ser preenchido.");

			}
			else if(count($FiltroTelefone)==0 && count($FiltroEmail)==0 && count($FiltroUsuario)==0){

				//$NovoCliente = 
		    //$HistoricoFiltrado[0]["Status"]=$Status;
				//$ModeloCliente->SalvarHistoricos($Clientes);

				$ObjetoSistema=json_decode($_POST['ObjetoSistema'],true);

				$NovoCodigo =end($Clientes)["CodigoCliente"]+10;

				//$NovoCliente = '{"CodigoCliente":'+strval($NovoCodigo);

				//$NovoCliente = "{CodigoCliente:".$NovoCodigo.',Nome:'.$ObjetoSistema["Nome"].',Email:'.$ObjetoSistema["Email"].',Telefone:'.$ObjetoSistema["Telefone"].',Endereco:'.$ObjetoSistema["Endereco"].',UserLogin:'.$ObjetoSistema["Usuario"].',Senha:'.$ObjetoSistema["Senha"].',Admin:false}';
				
				//$NovoCliente = "{'CodigoCliente':".$NovoCodigo.",'Nome':".$ObjetoSistema['Nome'].",'Email':".$ObjetoSistema['Email'].",'Telefone':".$ObjetoSistema['Telefone'].",'Endereco':".$ObjetoSistema['Endereco'].",'UserLogin':".$ObjetoSistema['Usuario'].",'Senha':".$ObjetoSistema['Senha'].",'Admin':false}";
				

				$NovoCliente = (object)["CodigoCliente" => $NovoCodigo,"Nome"=>$ObjetoSistema['Nome'],"Email"=>$ObjetoSistema['Email'],"Telefone"=>$ObjetoSistema['Telefone'],"Endereco"=>$ObjetoSistema['Endereco'],"UserLogin"=>strtolower($ObjetoSistema['Usuario']),"Senha"=>strtolower($ObjetoSistema['Senha']),"Admin"=>false];

				array_push($Clientes,$NovoCliente);

				$ModeloCliente->SalvarClientes($Clientes);


				echo true ;








			}


		}

	}

	function Desconectar(){

		session_destroy();
		echo true;
	}
	function ValidarTelefone($telefone){
    $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

    $regexTelefone = "/^[0-9]{11,12}$/";

    //$regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
    if (preg_match($regexTelefone, $telefone)) {
        return true;
    }else{
        return false;
    }
}
}
?>