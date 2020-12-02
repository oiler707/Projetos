self.onmessage = event => { 
	
	if(event.data.Fator=="AcessosTotal"){
		AcessosTotal();
	}
	if(event.data.Fator=="AcessosDia"){
		AcessosDia();
	}

	if(event.data.Fator=="AcessosPizza"){

		AcessosPizza(event.data.Fragmento);
	}
	if(event.data.Fator=="AcessoChart"){

		AcessoChart(event.data.Fragmento);
	}
}


function AcessosTotal(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "../Rotas/TotalAcessos/", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();

	xhttp.onreadystatechange = function () {
	if (this.readyState == 4 && this.status == 200) {
	    	//console.log(this.response);
		var Sucesso='document.getElementById("TotalAcessos").innerHTML='+this.response;
			
			
				self.postMessage({Sucesso:Sucesso});
		}
	}
}

function AcessosDia(){
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "../Rotas/TotalAcessosDia/", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();
	xhttp.onreadystatechange = function () {
	if (this.readyState == 4 && this.status == 200) {

		var Sucesso='document.getElementById("TotalAcessosDia").innerHTML='+this.response;
		
		var Norma = ''
		
				self.postMessage({Sucesso:Sucesso});
		
		}
	}
}


function AcessosPizza(Fragmento){
		var xhttp = new XMLHttpRequest();
		
		var Parametros="?DiaAnterior="+Fragmento.DiaAnterior+"&DiaPosterior="+Fragmento.DiaProximo;

		xhttp.open("GET", "../Rotas/PizzaPeriodo/"+Parametros, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send();

		xhttp.onreadystatechange = function () {
		    if (this.readyState == 4 && this.status == 200) {
		    	
		    	var Sucesso=this.response;
		    	
				self.postMessage({Sucesso:Sucesso});



			}
		}
}


function AcessoChart(Fragmento){
		var xhttp = new XMLHttpRequest();
		
		var Parametros="?DiaAnterior="+Fragmento.DiaAnterior+"&DiaPosterior="+Fragmento.DiaProximo;
		
		xhttp.open("GET", "../Rotas/AcessoChart/"+Parametros, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send();

		xhttp.onreadystatechange = function () {
		    if (this.readyState == 4 && this.status == 200) {
		    	
		    	var Sucesso=this.response;
				   	
				self.postMessage({Sucesso:Sucesso});



			}
		}
}