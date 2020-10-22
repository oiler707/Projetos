<?php 


class ModeloPrevisao{


	public function BuscarTodos(){
		$conn = new mysqli('localhost', 'root', '', 'previsaofutebol');
		//$sql = "INSERT INTO programadores(nome,local) VALUES ('Gustavo','Bianco')";
		header("Content-Type: text/html; charset=ISO-8859-1", true);
		$sql="SELECT * FROM previsaogoogle";
		$data=[];
		if ($resultSet = $conn->query($sql))
			{
			$i = 0;
			while ($aux = $resultSet->fetch_assoc())
				{
				$data[$i] = $aux;
				$i++;
				};
			}

		return $data;

	}

	public function SalvarPrevisao($ObjetoSistema){
		$conn = new mysqli('localhost', 'root', '', 'previsaofutebol');
		
		$TempObjeto=json_decode($ObjetoSistema,true);

		$Temp1 = $TempObjeto['[%G]/[V.Alg.]'];
	
		$Temp2 = $TempObjeto['Exp([%G]/[V.Alg.])'];
		$Temp3 = $TempObjeto['([%G] [V.Alg.])/([%G]-[V.Alg.])'];
		$Temp4 = $TempObjeto['1/([%G] [V.Alg.])'];
		$Temp5 = $TempObjeto['[%G]/[V.Alg.] : 2'];
		$Temp6 = $TempObjeto['Exp([%G]/[V.Alg.]) : 2'];
		$Temp7 = $TempObjeto['([%G] [V.Alg.])/([%G]-[V.Alg.]) : 2'];
		$Temp8 = $TempObjeto['1/([%G] [V.Alg.]) : 2'];

		$Temp9 = $TempObjeto['Time 1 [%G]'];
		$Temp10 = $TempObjeto['Time 1 [V.Alg]'];
		$Temp11 = $TempObjeto['Time 2 [%G]'];
		$Temp12 = $TempObjeto['Time 2 [V.Alg]'];


		$Temp13 = $TempObjeto['Ref. 1'];
		$Temp14 = $TempObjeto['Ref. 2'];
		$Temp15 = $TempObjeto['Ref. 3'];
		$Temp16 = $TempObjeto['Ref. 4'];

		$Temp17 = $TempObjeto['Tempo'];

		if($Temp1!="NaN" && $Temp2 !="NaN" && $Temp3 !="NaN"&& $Temp4 !="NaN"&& $Temp5 !="NaN"&& $Temp6 !="NaN"&& $Temp7 !="NaN"&& $Temp8 !="NaN" && $Temp17!=""){
		
			$sql = "INSERT INTO `previsaogoogle`(`[%G]/[V.Alg.]`, `Exp([%G]/[V.Alg.])`, `([%G]+[V.Alg.])/([%G]-[V.Alg.])`, `1/([%G]+[V.Alg.])`,`[%G]/[V.Alg.] : 2`,`Exp([%G]/[V.Alg.]) : 2`,`([%G]+[V.Alg.])/([%G]-[V.Alg.]) : 2`, `1/([%G]+[V.Alg.]) : 2`, `Time 1 [%G]`, `Time 1 [V.Alg]`, `Time 2 [%G]`, `Time 2 [V.Alg]`, `Ref. 1`, `Ref. 2`, `Ref. 3`, `Ref. 4`, `Tempo`) VALUES ($Temp1,$Temp2,$Temp3,$Temp4,$Temp5,$Temp6,$Temp7,$Temp8,$Temp9,$Temp10,$Temp11,$Temp12,$Temp13,$Temp14,$Temp15,$Temp16,$Temp17)";
			
			header("Content-Type: text/html; charset=ISO-8859-1", true);

			echo $conn->query($sql);
			
		}
		else{
			echo false;

		}
	}


}

?>