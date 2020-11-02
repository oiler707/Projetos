<?php

Class ControladorFormulario
{
	function __construct(){
		

		
	}





	function Principal(){
		
		include ("PastaVisao/Principal.html");
	}


	function ConsultarCidades(){
		$Temporario= new ModeloCidades();
		$Cidades = $Temporario->PegarCidades();
		if(isset($_GET["estado"])){
			$Filtro = array_filter($Cidades, function($var) {
		    					return ($var['sigla'] ==$_GET["estado"]);
			});
		
			echo json_encode(array_splice($Filtro, 0),true);
		}
		else{
			echo json_encode(false);
		}
	}


	function ValidarFormulario(){

		if(isset($_POST["Formulario"])){
			$TemporarioFormulario =json_decode($_POST["Formulario"],true);
			$Requeridos=["NomeCliente","SobrenomeCliente","DataNascimento","CodigoTelefone","NumeroTelefone"];
			
			$RequeridoNoMinimoUm=[["ConheceuAnuncio","ConheceuFacebook","ConheceuGoogle","ConheceuIndicacao"
			,"ConheceuInstagram","ConheceuOutros","ConheceuOutrosInformado","ConheceuSite"],
			["EspecificaLocalDor1","EspecificaLocalDor2","EspecificaLocalDor3"]];

			$RequeridoSegundo=[["ConheceuOutros","ConheceuOutrosInformado"],["SimGravida","TempoGravida"],["SintomasOutros","SintomaOutrosInformado"],["SimExercicioFisico","FrequenciaExercicio"]];

			$RequeridoApenasUm=[["SimGravida","NaoGravida"],["SimMarcapasso","NaoMarcapasso"],["SimHemofilico","NaoHemofilico"]];

			$TemporarioRetorno = true;
			$DefinicaoErro="";

			foreach ($Requeridos as $Requ) {
				if(isset($TemporarioFormulario[$Requ])){
					if($TemporarioFormulario[$Requ]==""){
						$TemporarioRetorno = false;
						$DefinicaoErro=$Requ;
					}
					
				}
				else{
					$TemporarioRetorno = false;
					$DefinicaoErro=$Requ;
				}
			}


			foreach ($RequeridoNoMinimoUm as $RequNoMiniUm) {
				$TempReto=false;
				foreach ($RequNoMiniUm as $TempRequNoMiniUm) {
					if(isset($TemporarioFormulario[$TempRequNoMiniUm])){
						if($TemporarioFormulario[$TempRequNoMiniUm]==true){
							$TempReto=true;

						}

					}
				}

				if($TempReto==false){
					$TemporarioRetorno=false;
					$DefinicaoErro=$RequNoMiniUm[0];
				}

			}

			foreach ($RequeridoSegundo as $RequSegu) {
				if(isset($TemporarioFormulario[$RequSegu[0]])){
					if($TemporarioFormulario[$RequSegu[0]]==true){

						if(isset($TemporarioFormulario[$RequSegu[1]])){
							if($TemporarioFormulario[$RequSegu[1]]==""){
								$TemporarioRetorno=false;
								$DefinicaoErro=$RequSegu[1];
							}

						}
						else{
							$TemporarioRetorno=false;
							$DefinicaoErro=$RequSegu[1];
						}

					}

				}


			}

			foreach ($RequeridoApenasUm as  $RequApenUm) {
				if(isset($TemporarioFormulario[$RequApenUm[0]])&&isset($TemporarioFormulario[$RequApenUm[1]]) ){
					if(($TemporarioFormulario[$RequApenUm[0]]==$TemporarioFormulario[$RequApenUm[1]])&&((int)$TemporarioFormulario[$RequApenUm[0]]+(int)$TemporarioFormulario[$RequApenUm[1]])!=1){

						$TemporarioRetorno=false;
						$DefinicaoErro=$RequApenUm[0];
					}
				}
				else{
					$TemporarioRetorno=false;
					$DefinicaoErro=$RequApenUm[0];
				}
			}
			
			
//		if(Formulario[e[0]]==Formulario[e[1]]&& ((Formulario[e[0]]+Formulario[e[1]])!=1) ){
				
			echo json_encode((object)["PaginaErro"=>$this->VerificarPaginaErro($DefinicaoErro),"Validado"=>$TemporarioRetorno],true);

		
		}
		else{
			
			echo json_encode((object)["PaginaErro"=>$this->VerificarPaginaErro($DefinicaoErro),"Validado"=>false]);
		}
	}


	function VerificarPaginaErro($ErroTemporario){
		$ObjetoErro =[(object)["PaginaErro"=>0,"Especificos"=>["NomeCliente","SobrenomeCliente","DataNascimento","CodigoTelefone","NumeroTelefone","ConheceuAnuncio","ConheceuOutrosInformado"]],
				(object)["PaginaErro"=>1,"Especificos"=>["SimGravida","SimMarcapasso","SimHemofilico","TempoGravida"]],
				(object)["PaginaErro"=>2,"Especificos"=>["SintomaOutrosInformado"]],
				(object)["PaginaErro"=>3,"Especificos"=>["EspecificaLocalDor1"]],
				(object)["PaginaErro"=>4,"Especificos"=>["FrequenciaExercicio"]]

				];

				foreach ($ObjetoErro as $ObjeErro) {

					if(in_array($ErroTemporario,$ObjeErro->Especificos)){
						return $ObjeErro->PaginaErro;

					}

				}

		return 0;	

	}

}	