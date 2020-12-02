self.onmessage = event => { 


	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "../Rotas/TotalAcessos/", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send();

	xhttp.onreadystatechange = function () {
	if (this.readyState == 4 && this.status == 200) {
	    	//console.log(this.response);
			
			
			self.postMessage('document.getElementById("TotalAcessos").innerHTML='+this.response);
		}
	}

	//self.postMessage({"RetornoSistema":"Retornado"})		
}