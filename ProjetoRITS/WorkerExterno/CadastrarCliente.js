self.onmessage = event => { 

	var xhttp = new XMLHttpRequest();

	xhttp.open("POST", "/ProjetoRITS/rits/ValidarCadastro/index.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	var ParametroAcao;


	
	ObjetoSistema={"Usuario":event.data.Usuario,
				   "Senha":event.data.Senha,
				   "Nome":event.data.Nome,
				   "Telefone":event.data.Telefone,
				   "Endereco":event.data.Endereco,
				   "Email":event.data.Email,
				}

	
	
	ParametroAcao="ObjetoSistema="+JSON.stringify(ObjetoSistema);

	xhttp.send(ParametroAcao);

	xhttp.onreadystatechange = function () {
	    if (this.readyState == 4 && this.status == 200) {
	    	
			self.postMessage({"RetornoSistema":xhttp.response})				
				
		}
	}
}