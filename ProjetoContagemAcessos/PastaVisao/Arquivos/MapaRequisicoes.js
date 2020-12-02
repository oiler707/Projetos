var Norma='<?=$MapaEstilo?>';
var MapaAcessos = '<?=$MapaAcessos?>';
console.log(MapaAcessos);
document.getElementById("Cidades").style.display="none";
document.getElementsByClassName("MapaRequisicoes")[0].style.visibility="collapse";

var TemporarioAcessos= JSON.parse('<?=$TemporarioAcessos?>');

function AtualizarCoresMapa(){
	ArrayTemporario=["BR-AC", "BR-AL", "BR-AM", "BR-AP", "BR-BA", "BR-CE", "BR-DF", "BR-ES", "BR-GO", "BR-MA", "BR-MG", "BR-MS", "BR-MT", "BR-PA", "BR-PB", "BR-PE", "BR-PI", "BR-PR", "BR-RJ", "BR-RN", "BR-RO", "BR-RR", "BR-RS", "BR-SC", "BR-SE", "BR-SP", "BR-TO"]
	
	ArrayTemporario.forEach(function(e){
		var MaximoAcessosMapaRegiao = (TemporarioAcessos.filter(x=>x.Acessos)[0]==undefined)?100:TemporarioAcessos.filter(x=>x.Acessos)[0].Acessos
	var RGBVarianteAcessosMapa=(200-(TemporarioAcessos.filter(x=>x.Estado==e)[0].Acessos/MaximoAcessosMapaRegiao)*200);
	
	document.getElementsByTagName("svg")[0].getElementById(e).style.fill="rgb("+RGBVarianteAcessosMapa+","+RGBVarianteAcessosMapa+",255)";
	document.getElementsByTagName("svg")[0].getElementById(e).style.stroke="rgb(0,0,0)";
	document.getElementsByTagName("svg")[0].getElementById(e).style.strokeWidth="0.1";
	})

}
/*

*/

function AtualizarCidadesAcessos(Estado,EstadoExtenso,PosX,PosY){
	document.getElementById("Cidades").getElementsByTagName("div")[0].innerHTML=EstadoExtenso;

document.getElementById("Cidades").getElementsByTagName("div")[1].innerHTML=
	TemporarioAcessos.filter(x=>x.Estado==Estado)[0]["Acessos"]+" acessos";

	document.getElementById("Cidades").style.top=PosY;
	document.getElementById("Cidades").style.left=PosX;
}

setTimeout(function(){
	

	document.getElementsByClassName("MapaRequisicoes")[0].innerHTML=MapaAcessos;
	
	
	//document.getElementsByClassName("MapaRequisicoes")[0].innerHTML+=loadFile('../../PastaVisao/Imagens/Brazil.svg');
	
	document.getElementsByClassName("MapaRequisicoes")[0].innerHTML+=Norma;
	setTimeout(function(){
		
		FuncoesInicializarAposMapa();
		AtualizarCoresMapa()},256);
},16)

function FuncoesInicializarAposMapa(){
	document.getElementsByClassName("MapaRequisicoes")[0].style.visibility="visible";
	document.getElementsByTagName("svg")[0].onclick = function(e){if(e.target.nodeName=="path"){
	 	AtualizarCoresMapa();
		
		e.target.style.fill="rgb(100,100,0)";
		e.target.style.cursor="pointer";
		//var RelativoPosicaoImagemX=e.clientX+window.pageXOffset+document.getElementsByTagName("svg")[0].getBoundingClientRect().x
		RelativoPosicaoImagemX=e.clientX+window.pageXOffset
		

		//var RelativoPosicaoImagemY=e.clientY+window.pageYOffset+document.getElementsByTagName("svg")[0].getBoundingClientRect().y
		var RelativoPosicaoImagemY=e.clientY+window.pageYOffset

		document.getElementById("Cidades").style.display="block";
		AtualizarCidadesAcessos(e.target.id,e.target.getAttribute("title"),(RelativoPosicaoImagemX-100),(RelativoPosicaoImagemY-75));

	}

}

document.getElementsByTagName("svg")[0].onmouseover = function(e){if(e.target.nodeName=="path"){
		e.target.style.fill="rgb(100,100,0)";
		e.target.style.cursor="pointer";
		
	}

}
document.getElementsByTagName("svg")[0].onmouseout = function(e){if(e.target.nodeName=="path"){
		 AtualizarCoresMapa();
	}

}
}

function AbrirSVG(Caminho) {
  var result = null;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", Caminho, false);
  xmlhttp.send();
  if (xmlhttp.status==200) {

  		 result = xmlhttp.responseText;
  		 
  }
 
 return result;
}