self.onmessage = event => { 

	var xhttp = new XMLHttpRequest();

	xhttp.open("POST", "/ProjetoRITS/rits/EditarPedido/index.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	var ParametroAcao;

	
	
	ObjetoSistema={"Produtos":event.data.ProdutoEditarHistorico,
					"Total":event.data.Total,
					"IdPedido":event.data.IdPedido,
					}

	
	
	ParametroAcao="ObjetoSistema="+JSON.stringify(ObjetoSistema);

	xhttp.send(ParametroAcao);

	xhttp.onreadystatechange = function () {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(xhttp.response)
			self.postMessage({"RetornoSistema":xhttp.response})				
				
		}
	}
}