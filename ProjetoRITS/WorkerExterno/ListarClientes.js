self.onmessage = event => { 

	var xhttp = new XMLHttpRequest();

	xhttp.open("POST", "/ProjetoRITS/rits/ListarClientes/index.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	var ParametroAcao;
	

	
	ObjetoSistema={}

	
	
	ParametroAcao="ObjetoSistema="+JSON.stringify(ObjetoSistema);

	xhttp.send(ParametroAcao);

	xhttp.onreadystatechange = function () {
	    if (this.readyState == 4 && this.status == 200) {
	    	
			self.postMessage({"RetornoSistema":xhttp.response})				
				
		}
	}
}