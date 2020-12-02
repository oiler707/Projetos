self.onmessage = event => { 

	if(event.data.Fator=="MapaRequisicoes"){
		MapaRequisicoes(event.data.Fragmento);
	}

}

function MapaRequisicoes(Fragmento){
		
		var xhttp = new XMLHttpRequest();

		var Parametros="?DiaAnteriorAcessoMapa="+Fragmento.DiaAnterior+"&DiaProximoAcessoMapa="+Fragmento.DiaProximo;

		xhttp.open("GET", "../Rotas/MapaAcessos/"+Parametros, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send();
		xhttp.onreadystatechange = function () {
		    if (this.readyState == 4 && this.status == 200) {
		    	//console.log(this.response);
				

				var Sucesso=this.response;
		    	
				self.postMessage({Sucesso:Sucesso});
			}
	}
}
