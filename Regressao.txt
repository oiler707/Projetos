
function RegressaoExponencial(Vetor,Predicao){

var script = document.createElement('script');
script.onload = function () {

     console.log(Regressao(Vetor,Predicao));
	
};
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.2.1/math.js';

document.head.appendChild(script);

	
};

function Regressao(Y,PosicaoFuturaRequerida){
	X = Array.from({length: Y.length}, (_, i) => i + 1)
	
	LnY = [] 
	LnYX=[]
	const reducer = (accumulator, currentValue) => accumulator + currentValue;
	const reducerPow = (accumulator, currentValue) => accumulator + Math.pow(currentValue,2);

	Y.forEach(function(e,index){LnY.push(Math.log(e)); LnYX.push(Math.log(e)*X[index]) })
	
	//CALCULA EXPONENCIAL E LOGARITMO EXPONENCIAL DA FORMULA

	M = [[X.length,X.reduce(reducer)],
		[X.reduce(reducer),X.reduce(reducerPow)]]

	//MATRIZ PARA CALCULAR INVERSA APARTIR DO LOGARITMO

	b = [LnY.reduce(reducer),LnYX.reduce(reducer) ]

	//VETOR PARA COMPARAR RESULTDO DA REGRESSAO

	MInv = math.inv(M)

	//INVERSA

	Az = MInv[0][0]*b[0]+MInv[0][1]*b[1]
	Bz = MInv[1][0]*b[0]+MInv[1][1]*b[1]
	//VALORES PARA CALCULAR CONSTANTES AUX

	A = Math.exp(Az)
	B = Bz
	//RETORNO A*EXP(B*X) ONDE X É O PROXIMO VALOR DE ENTRADA

	return A*Math.exp(B*PosicaoFuturaRequerida);

}

RegressaoExponencial([1,2,3,4,5],0);
RegressaoExponencial([1,2,3,4,5],1);
RegressaoExponencial([1,2,3,4,5],2);
RegressaoExponencial([1,2,3,4,5],3);
RegressaoExponencial([1,2,3,4,5],4);
RegressaoExponencial([1,2,3,4,5],5);