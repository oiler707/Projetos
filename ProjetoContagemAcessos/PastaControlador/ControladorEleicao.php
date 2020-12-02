<?php

Class ControladorEleicao
{
	function __construct(){
		

		
	}
	function ComenteAqui(){
		$Menu=file_get_contents("../../PastaVisao/Arquivos/Menu.html");
		$Corpo=file_get_contents("../../PastaVisao/Arquivos/EnvioComentario.html");
		$Rodape=file_get_contents("../../PastaVisao/Arquivos/Rodape.html");
		include ("../../PastaVisao/Principal.html");
	}
	function PrefeitoVerdade(){
		$Menu=file_get_contents("PastaVisao/Arquivos/Menu.html");
		$Corpo=file_get_contents("PastaVisao/Arquivos/Corpo.html");
		//$Corpo="<div class='Corpo'><div>Desativado por enquanto</div></div>";
		$Rodape=file_get_contents("PastaVisao/Arquivos/Rodape.html");
		include ("PastaVisao/Principal.html");

		
		$url = 'http://ip-api.com/json/'.$_SERVER['REMOTE_ADDR'];
		$contents = file_get_contents($url);
		
		if($contents !== false){
			
			
   		 	$ModeloAcessos= new ModeloAcessos();
			$Comentarios = $ModeloAcessos->Salvar(json_decode($contents,true));
			
		}
	}

	function VisualizarDashBoard(){
		$Menu=file_get_contents("../../PastaVisao/Arquivos/Menu.html");
		
		$Rodape=file_get_contents("../../PastaVisao/Arquivos/Rodape.html");
		

		$ModeloAcessos= new ModeloAcessos();
		
		$Corpo=file_get_contents("../../PastaVisao/Arquivos/DashBoard.html");
		

		include ("../../PastaVisao/Principal.html");
	}
	function VisualizarDashBoardDia(){
		
		$DiaAnterior="2020-01-01";
		$DiaPosterior="2025-01-01";
		
		if(isset($_GET["DiaAnterior"])&&$_GET["DiaAnterior"]!=""){
			$DiaAnterior=$_GET["DiaAnterior"];

		}
		if(isset($_GET["DiaPosterior"])&&$_GET["DiaPosterior"]!=""){
			$DiaPosterior=$_GET["DiaPosterior"];
			
		}
		
		$ModeloAcessos= new ModeloAcessos();
		echo($ModeloAcessos->QuantidadeAcessosPeriodo($DiaAnterior,$DiaPosterior));

	}

	function MapaVisualizacoesAcessos(){
		$Menu=file_get_contents("../../PastaVisao/Arquivos/Menu.html");
		
		$Rodape=file_get_contents("../../PastaVisao/Arquivos/Rodape.html");
		//$Corpo="<div class='Corpo'><div>Quantidade de acessos por estado</div>";
		
		//$Corpo.="<div class='MapaRequisicoes'></div>";
		$Corpo=file_get_contents("../../PastaVisao/Arquivos/MapaRequisicoes.html");
		//$Corpo.='</div>';
		include ("../../PastaVisao/Principal.html");
	}
	function NaBocaDoPovo(){
		
		$ModeloComentario= new ModeloComentario();
		$Comentarios = $ModeloComentario->Todos();

		$Menu=file_get_contents("../../PastaVisao/Arquivos/Menu.html");
		

		$Rodape=file_get_contents("../../PastaVisao/Arquivos/Rodape.html");
		
		$TempCorpo=file_get_contents("../../PastaVisao/Arquivos/Comentarios.html");
		$Corpo = sprintf($TempCorpo,$Comentarios);

		
		include ("../../PastaVisao/Principal.html");
	}
	function MapaAcessos(){
		$ModeloAcessos= new ModeloAcessos();
		$DiaAnterior="2020-01-01";
		$DiaPosterior="2025-01-01";
		
		if(isset($_GET["DiaAnteriorAcessoMapa"])&&$_GET["DiaAnteriorAcessoMapa"]!=""){
			$DiaAnterior=$_GET["DiaAnteriorAcessoMapa"];

		}
		if(isset($_GET["DiaProximoAcessoMapa"])&&$_GET["DiaProximoAcessoMapa"]!=""){
			$DiaPosterior=$_GET["DiaProximoAcessoMapa"];
			
		}
		
		$TemporarioAcessos= json_encode($ModeloAcessos->QuantidadeAcessosPorRegiao($DiaAnterior,$DiaPosterior),true);

		$MapaAcessos=file_get_contents("../../PastaVisao/Imagens/Brazil.svg");
		$MapaEstilo=file_get_contents("../../PastaVisao/Arquivos/EstiloMapa.css");

		include ("../../PastaVisao/Arquivos/MapaRequisicoes.js");
	}

	function PizzaPeriodo(){
		$Total=130;
		$Acessos=40;

		$DiaAnterior="2020-01-01";
		$DiaPosterior="2025-01-01";
		
		if(isset($_GET["DiaAnterior"])&&$_GET["DiaAnterior"]!=""){
			$DiaAnterior=$_GET["DiaAnterior"];

		}
		if(isset($_GET["DiaPosterior"])&&$_GET["DiaPosterior"]!=""){
			$DiaPosterior=$_GET["DiaPosterior"];
			
		}
		
		$ModeloAcessos= new ModeloAcessos();
		$Total = $ModeloAcessos->QuantidadeDeAcessos();
		$Acessos = $ModeloAcessos->QuantidadeAcessosPeriodo($DiaAnterior,$DiaPosterior);

		$TotalUsuariosDiariamente=$ModeloAcessos->QuantidadeDeAcessosUnicosPorDia();
		$TotalUsuariosPeriodo=$ModeloAcessos->QuantidadeUnicosPeriodo($DiaAnterior,$DiaPosterior);
		
		$CssPizza=preg_replace("/\r|\n/", "",file_get_contents('../../PastaVisao/Arquivos/GraficoPizza.css'));

		$ArquivoPizza= preg_replace("/\r|\n/", "",file_get_contents('../../PastaVisao/Arquivos/GraficoPizza.html'));
		

		include ("../../PastaVisao/Arquivos/DashBoard.js");

	}
	function TotalAcessos(){
		$ModeloAcessos= new ModeloAcessos();
		
		echo($ModeloAcessos->QuantidadeDeAcessos());
	}

	function TotalAcessosPorDia(){
		$ModeloAcessos= new ModeloAcessos();
		echo($ModeloAcessos->QuantidadeDeAcessosUnicosPorDia());
		
	}

	function AcessoChart(){
		

		
		$DPosterior= new DateTime('now');
		$DAnterior=	 new DateTime('now');
		$DAnterior->sub(new DateInterval('P20D'));
		$DiaAnterior = $DAnterior->format('Y-m-d');
		$DiaPosterior= $DPosterior->format('Y-m-d');
		if(isset($_GET["DiaAnterior"])&&$_GET["DiaAnterior"]!=""){
			$DiaAnterior=$_GET["DiaAnterior"];

		}
		if(isset($_GET["DiaPosterior"])&&$_GET["DiaPosterior"]!=""){
			$DiaPosterior=$_GET["DiaPosterior"];
			
		}

		$dateInterval = (new DateTime($DiaAnterior))->diff(new DateTime($DiaPosterior));
		
		if($dateInterval->days>40){
			
			$DAnterior  = new DateTime($DiaPosterior);
			$DAnterior->sub(new DateInterval('P20D'));
			$DiaAnterior = $DAnterior->format('Y-m-d');

		}
		

		$ModeloAcessos= new ModeloAcessos();
		$auxe = $ModeloAcessos->AcessosPeriodoChart($DiaAnterior,$DiaPosterior);
		$Dias=json_encode($auxe[0]);
		$Data=json_encode($auxe[1]);

		$ChartHTML=preg_replace("/\r|\n/", "",file_get_contents("../../PastaVisao/Arquivos/DashChart.html"));
		$ChartCSS=preg_replace("/\r|\n/", "",file_get_contents("../../PastaVisao/Arquivos/DashChart.css"));

		include ("../../PastaVisao/Arquivos/ContentDashChart.js");
		include ("../../PastaVisao/Arquivos/ContentDashChart2.js");
	
		include ("../../PastaVisao/Arquivos/DashChart.js");
		
	}
}	