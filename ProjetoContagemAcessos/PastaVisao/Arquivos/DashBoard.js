//var Norma='<style>#GraficoPizza svg{ height:200; width:200; } #GraficoPizza .Total{ r:9.99; cx:10; cy:10; fill:#0000ff3d; } #GraficoPizza .Acessos{ r:5; cx:10; cy:10 ; fill:transparent; stroke-width:10; stroke: #01ce61; } #GraficoPizza .Texto{ font-size: 4px; fill: white; font-family: cursive; text-anchor:middle; x:50%; dominant-baseline:middle; } #DeterminadoDia{ padding-top:0px; padding:0px} #DeterminadoDia div{ padding:30px; padding-top:0px} #UsuariosAcessandoSistema{ padding-top:0px; padding:0px} #UsuariosAcessandoSistema div{ padding:30px; padding-top:0px} "</style>';
//var Sucesso='<div id="DeterminadoDia"><div>Quantidade de acessos no período : </div><svg viewBox="0 0 20 20"><circle class="Total" ></circle> <circle class="Acessos" transform="rotate(-90) translate(-20)"></circle><text class="Texto" x="50%" y="50%" >47</text> </svg></div>';

//var PorDia='<div id="UsuariosAcessandoSistema"><div>Quantidade de usuários por dia no período  : </div><svg viewBox="0 0 20 20"><circle class="Total" ></circle> <circle class="Acessos" transform="rotate(-90) translate(-20)"></circle><text class="Texto" x="50%" y="50%" >47</text> </svg></div>'

var ArquivoPizza='<?=$ArquivoPizza?>'+'<?=$CssPizza?>';

function CriarPizza(){

	document.querySelector("#GraficoPizza").innerHTML=ArquivoPizza;

	AtualizarPizza('<?=$Acessos?>','<?=$Total?>',document.querySelector("#GraficoPizza").getElementsByClassName("Acessos")[1]);
	AtualizarValor('<?=$Acessos?>',document.querySelector("#GraficoPizza").getElementsByClassName("Texto")[1]);


	AtualizarPizza('<?=$TotalUsuariosPeriodo?>','<?=$TotalUsuariosDiariamente?>',document.querySelector("#GraficoPizza").getElementsByClassName("Acessos")[0]);
	AtualizarValor('<?=$TotalUsuariosPeriodo?>',document.querySelector("#GraficoPizza").getElementsByClassName("Texto")[0]);

	
}

function AtualizarPizza(Acessos,Total,Elemento){
	Porcentagem = (Acessos/Total)*100;
	Elemento.style.strokeDasharray="calc("+Porcentagem+" * 31.4 / 100) 31.4";
	//document.querySelector("#GraficoPizza").getElementsByClassName("Acessos")[0].style.strokeDasharray="calc("+Porcentagem+" * 31.4 / 100) 31.4";
}
function AtualizarValor(Acessos,Elemento){
	Elemento.innerHTML=Acessos;
	//document.querySelector("#GraficoPizza").getElementsByClassName("Texto")[0].innerHTML=Acessos;
}

CriarPizza();


