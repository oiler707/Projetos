<?php

Class ModeloAcessos
{
	function __construct(){
		date_default_timezone_set('America/Sao_Paulo');
	}
	function Salvar($Acesso){
		
		//$Objeto = (object)["Comentario"=>$Comentario,"Nome" => $Nome,"Whatsapp"=>$Whatsapp,"Data"=>json_decode(json_encode($Data),true)["date"],"Validacao"=>$Validacao];
		
		if($Acesso["status"]==true){

				$Objeto=(object)[
				
				"Pais"=>$Acesso["countryCode"],
				"Estado"=>$Acesso["region"],
				"Cidade"=>$Acesso["city"],
				"Latitude"=>$Acesso["lat"],
				"Longitude"=>$Acesso["lon"],
				"IP"=>$Acesso["query"],
				"IP"=>$Acesso["query"],
				"Data"=>date('Y-m-d H:i:s')
				];
			
				$Arquivo = $this->LerArquivo();
				array_push($Arquivo,$Objeto);
				$this->GravarArquivo($Arquivo );


		}

	}
	function QuantidadeDeAcessos(){
		$Arquivo = $this->LerArquivo();


		return count($Arquivo);
	}
	function QuantidadeDeAcessosUnicosPorDia(){
		$Arquivo = $this->LerArquivo();
		

		$TempIP=[];
		foreach ($Arquivo as $TempArquivo) {
			$TempObjeto=(object)["Data"=>date("d/m/yy",strtotime($TempArquivo["Data"])),"IP"=>$TempArquivo['IP']];
			if(!in_array($TempObjeto,$TempIP,false)){
				//echo(json_encode($TempObjeto,dio_truncate(fd, offset)));
			
				

				array_push($TempIP, $TempObjeto);
			}
		}
		return count($TempIP);
	}
	function QuantidadeUnicosPeriodo($DiaAnterior,$DiaPosterior){
		$Arquivo = $this->LerArquivo();
		

		$TempIP=[];
		foreach ($Arquivo as $TempArquivo) {
			if(($TempArquivo["Data"]>=$DiaAnterior)&&($TempArquivo["Data"]<=date("Y-m-d",strtotime($DiaPosterior."+1 day") ) ) ){


			$TempObjeto=(object)["Data"=>date("d/m/yy",strtotime($TempArquivo["Data"])),"IP"=>$TempArquivo['IP']];
			

			if(!in_array($TempObjeto,$TempIP,false)){
				//echo(json_encode($TempObjeto,dio_truncate(fd, offset)));
			
				

				array_push($TempIP, $TempObjeto);
			}
		}
		
	}
		return count($TempIP);
	}


	function QuantidadeAcessosPeriodo($DiaAnterior,$DiaPosterior){
		$Arquivo = $this->LerArquivo();
		$TempIP=[];
		
		

		foreach ($Arquivo as $TempArquivo) {
			
			if(($TempArquivo["Data"]>=$DiaAnterior)&&($TempArquivo["Data"]<=date("Y-m-d",strtotime($DiaPosterior."+1 day") ) ) ){

				array_push($TempIP,$TempArquivo["IP"]);
			}

		}

		return count($TempIP);
	}
	function AcessosPeriodoChart($DiaAnterior,$DiaPosterior){
		$Arquivo = $this->LerArquivo();
		$TempIP=[];
		$Data=[];
		$DiaAdicional = $DiaAnterior;
		
		while($DiaAdicional<=$DiaPosterior){
			 array_push($TempIP,date("d/m",strtotime($DiaAdicional)));
			 array_push($Data,$this->QuantidadeAcessosPeriodo($DiaAdicional,$DiaAdicional));

			 $aux = date("Y-m-d",strtotime($DiaAdicional."+1 day") );
			 $DiaAdicional = $aux;

		} 


		return [$TempIP,$Data];
	} 


	function QuantidadeAcessosPorRegiao($DiaAnterior,$DiaPosterior){
		$Arquivo = $this->LerArquivo();
		
		$TemporarioAcessos=[(object)["Estado"=>"BR-AC","Acessos"=>0],
							(object)["Estado"=>"BR-AL","Acessos"=>0], 
							(object)["Estado"=>"BR-AM","Acessos"=>0], 
							(object)["Estado"=>"BR-AP","Acessos"=>0],
							(object)["Estado"=>"BR-BA","Acessos"=>0],
							(object)["Estado"=>"BR-CE","Acessos"=>0],
							(object)["Estado"=>"BR-DF","Acessos"=>0], 
							(object)["Estado"=>"BR-ES","Acessos"=>0], 
							(object)["Estado"=>"BR-GO","Acessos"=>0], 
							(object)["Estado"=>"BR-MA","Acessos"=>0], 
							(object)["Estado"=>"BR-MG","Acessos"=>0], 
							(object)["Estado"=>"BR-MS","Acessos"=>0], 
							(object)["Estado"=>"BR-MT","Acessos"=>0], 
							(object)["Estado"=>"BR-PA","Acessos"=>0], 
							(object)["Estado"=>"BR-PB","Acessos"=>0], 
							(object)["Estado"=>"BR-PE","Acessos"=>0], 
							(object)["Estado"=>"BR-PI","Acessos"=>0], 
							(object)["Estado"=>"BR-PR","Acessos"=>0], 
							(object)["Estado"=>"BR-RJ","Acessos"=>0], 
							(object)["Estado"=>"BR-RN","Acessos"=>0], 
							(object)["Estado"=>"BR-RO","Acessos"=>0], 
							(object)["Estado"=>"BR-RR","Acessos"=>0], 
							(object)["Estado"=>"BR-RS","Acessos"=>0], 
							(object)["Estado"=>"BR-SC","Acessos"=>0], 
							(object)["Estado"=>"BR-SE","Acessos"=>0], 
							(object)["Estado"=>"BR-SP","Acessos"=>0], 
							(object)["Estado"=>"BR-TO","Acessos"=>0],
							];
		
	
		foreach ($Arquivo as $TempArquivo) {

		
			//$TemporarioAcessos.filter()
			$GLOBALS["TemporarioAcesso"]=$TempArquivo["Estado"] ;
			$GLOBALS["TemporarioData"]=$TempArquivo["Data"] ;
			
			$GLOBALS["DiaAnterior"]=$DiaAnterior ;
			$GLOBALS["DiaPosterior"]=date("Y-m-d",strtotime($DiaPosterior."+1 day"));
			$Filtrado = array_filter($TemporarioAcessos, function($var) {

	    			return ($var->Estado=="BR-".$GLOBALS["TemporarioAcesso"]&&
	    				$GLOBALS["TemporarioData"]>=$GLOBALS["DiaAnterior"]&&
	    				$GLOBALS["TemporarioData"]<=$GLOBALS["DiaPosterior"]);
			});
	
			if(count($Filtrado)>0){
				$FiltroUnico=array_splice($Filtrado, 0);
				$FiltroUnico[0]->Acessos+=1;
			}
			//print_r($FiltroUnico[0]->Estado);	
			
		}

		
		
		return $TemporarioAcessos;
		//print_r($TemporarioAcessos);
	}



	function LerArquivo(){
		
	 	if(file_exists("../../PastaModelo/Dados/Acessos.json")){
			return json_decode(file_get_contents("../../PastaModelo/Dados/Acessos.json"),true);

		}
		else if(file_exists("PastaModelo/Dados/Acessos.json")){

			return json_decode(file_get_contents("PastaModelo/Dados/Acessos.json"),true);

		}

	}

	function GravarArquivo($Arquivo){
		if(file_exists("../../PastaModelo/Dados/Acessos.json")){
			file_put_contents("../../PastaModelo/Dados/Acessos.json", json_encode($Arquivo));
		}
		else if(file_exists("PastaModelo/Dados/Acessos.json")){

			file_put_contents("PastaModelo/Dados/Acessos.json", json_encode($Arquivo));
		}
	}
}

?>