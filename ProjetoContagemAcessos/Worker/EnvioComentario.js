self.onmessage = event => { 

	var xhttp = new XMLHttpRequest();

	xhttp.open("POST", "/ProjetoEleicaoBrusque/Rotas/ComenteAqui/EnviarComentario.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	var ParametroAcao;

	TempNumber= "0"+event.data.ObjetoEnvioComentario.Whatsapp;
	


	const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    

	if(/^[a-zA-Z ]+$/.test( event.data.ObjetoEnvioComentario.Nome)==false){
		self.postMessage({"RetornoSistema":"Nome em formato inválido."});
	}
	
    
	else if(re.test(String(event.data.ObjetoEnvioComentario.Email).toLowerCase())==false&&event.data.ObjetoEnvioComentario.Email!=""){
		self.postMessage({"RetornoSistema":"Email inválido"});
	}

	else if( ( (TempNumber.match(/\d/g).length>12)||(TempNumber.match(/\d/g).length<9) )  &&TempNumber	!="0"){
		self.postMessage({"RetornoSistema":"Telefone inválido"});
	}
	else{
	ParametroAcao="ObjetoSistema="+JSON.stringify(event.data.ObjetoEnvioComentario);
	
	xhttp.send(ParametroAcao);

	xhttp.onreadystatechange = function () {
	    if (this.readyState == 4 && this.status == 200) {
	    	
				self.postMessage({"RetornoSistema":xhttp.response})				
				
		}
	}
	}
}