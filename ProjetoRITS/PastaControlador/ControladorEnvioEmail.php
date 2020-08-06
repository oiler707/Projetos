<?php

Class ControladorEnvioEmail
{
	function __construct(){
		
		require("../../ArquivosEmail/src/Exception.php");
		require("../../ArquivosEmail/src/PHPMailer.php");
		require("../../ArquivosEmail/src/SMTP.php");
		
	}

function EnvioEmail($Email,$Usuario,$IdPedido,$Status){

	$mail = new PHPMailer\PHPMailer\PHPMailer();                              // Passing `true` enables exceptions
	try {
	    //Server settings
	    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	    $mail->isSMTP();             
	    $mail->SMTPSecure = 'ssl';                          // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';                  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication

	    $mail->Username = getenv("EMAIL");             // SMTP username
	    $mail->Password = 'pymcshkcrcqtesmu';                           // SMTP password
	                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom('projeto5656@gmail.com', 'Projeto Loja Virtual Rits');          //This is the email your form sends From
	    $mail->addAddress($Email,$Usuario);

	    $mail->isHTML(true);
		$mail->Subject = 'Notificacao pedido Id : '.strval($IdPedido);
	    $mail->Body    = 'Seu pedido Id : '.strval($IdPedido).', está com status : '. $Status.".";


	    $mail->send();
	    echo 'Enviando';

	} catch (Exception $e) {

	    
	    echo 'Erro envio ' . $mail->ErrorInfo;
	}

}
	
function DisparoPedido($IdPedido,$Nome,$cond){


	$mail = new PHPMailer\PHPMailer\PHPMailer();                              // Passing `true` enables exceptions
	try {
	    //Server settings
	    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	    $mail->isSMTP();             
	    $mail->SMTPSecure = 'ssl';                          // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';                  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication

	    $mail->Username = getenv("EMAIL");             // SMTP username
	    $mail->Password = 'pymcshkcrcqtesmu';                           // SMTP password
	                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;     
	    echo("Aqui");                               // TCP port to connect to
	    echo(getenv("EMAIL"));
	    //Recipients
	    $mail->setFrom(getenv("EMAIL"), 'Projeto Loja Virtual Rits');          //This is the email your form sends From
	    $mail->addAddress(getenv("EMAIL"),'Projeto Loja Virtual Rits');

	    $mail->isHTML(true);
		
		if($cond==1){
	    	$mail->Subject = 'Novo pedido Id : '.strval($IdPedido);

	    	$mail->Body    = 'Um novo pedido foi criado Id : '.strval($IdPedido).', para o usuário : '. $Nome.".";
		}
		else if($cond==2){
			$mail->Subject = 'Cancelamento pedido Id : '.strval($IdPedido);

			$mail->Body    = 'O pedido Id : '.strval($IdPedido).', foi cancelado pelo usuário : '. $Nome.".";
		}
	    $mail->send();
	    echo 'Enviando';

	} catch (Exception $e) {

	    
	    echo 'Erro envio ' . $mail->ErrorInfo;
	}

}


}

?>

