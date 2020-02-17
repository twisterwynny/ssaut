<?php
header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

session_start();
include_once("db/conexao.php");

$query = "SELECT * FROM agendamentos"; 
$result_query_agenda = mysqli_query($conn, $query);

while($row_agenda = mysqli_fetch_array($result_query_agenda))
{
	$evento = $row_agenda['evento'];	

	$query = "SELECT title, start FROM eventos WHERE id='$evento'"; 
	$result_query_evento = mysqli_query($conn, $query);
	$row_evento = mysqli_fetch_array($result_query_evento);

	$title = $row_evento['title']; 
	$start = $row_evento['start']; 

	$sqldatetime = explode(" ", $start); 

	list($data, $hora) = $sqldatetime; 
	
	date_default_timezone_set('America/Bahia');
	
	$d1 = strtotime($data); 
	$d2 = strtotime(date('Y/m/d'));
	
	$qtd_dias = ($d2 - $d1) / 86400;
	
	if($qtd_dias < 0)
	$qtd_dias = $qtd_dias * -1; 
	
	if ($qtd_dias == 3)
	{
		$escola = $row_agenda['escola'];
		$turma = $row_agenda['turma'];
		$id_agendamento = $row_agenda['id'];		

		$query = "SELECT nome, email FROM usuarios WHERE id='$escola'";
		$result_query_usuarios = mysqli_query($conn, $query);

		$row_usuarios = mysqli_fetch_array($result_query_usuarios);

		$nome = $row_usuarios['nome'];
		$email = $row_usuarios['email'];		

		$query = "SELECT nivel, serie, nome_turma FROM turmas WHERE id='$turma'";
		$result_query_turmas = mysqli_query($conn, $query);		

		$row_turmas = mysqli_fetch_array($result_query_turmas);

		$nivel_ensino = $row_turmas['nivel'];
		$serie = $row_turmas['serie'];
		$nome_turma = $row_turmas['nome_turma'];

		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8'; 
		$mail->isSMTP();
		$mail->SMTPDebug = 2; 
		$mail->Host = "smtp.gmail.com"; 
		$mail->Port = 587; 
		$mail->SMTPSecure = 'tls'; 
		$mail->SMTPAuth = true;
		$mail->Username = 'antares.uefs@gmail.com'; 
		//antares.uefs@gmail.com	
		//,.;uefs/;.
		$mail->Password = ',.;uefs/;.';
		$mail->setFrom('antares.uefs@gmail.com', 'Etevaldo'); 
		$mail->addAddress($email, $nome); 
		$mail->Subject = 'Antares - Confirmar Visita';

		$mail->msgHTML("Olá! Eu sou o <B><font color='blue'> Etevaldo </font></B>, gestor de visitação do Antares. <BR> Sua vaga será <S> ABDUZIDA </S>  <font color='red'>  cancelada </font></B> e chamaremos a próxima Escola que está em nossa lista de espera, caso você não responda nas proximas 24 horas. <BR><B><font color='HotPink'> A BINA </font></B> disse que você agendou uma visita para o dia $data as $hora horas. Ela precisa da sua confirmação para garantir a sua vaga. <BR> <I><B><font color='gray'>Para vir conosco para nosso planeta </I></B></font> acesse o link : <a href='http://localhost:8080/form-confirma.php?id_agendamento=$id_agendamento&data=$data&hora=$hora&evento=$evento&title=$title&nome=$nome&escola=$escola&turma=$turma&nivel_ensino=$nivel_ensino&serie=$serie&nome_turma=$nome_turma'> ANTARES </a> <BR> <S> O CHEFE </S> nossa equipe está ansiosa para levar você para conhecer alguns mistérios do Universo. Desde já agradecemos seu interesse e compreensão.");
		
		$mail->AltBody = 'HTML messaging not supported'; 
		
		$mail->SMTPOptions = array
							 (
							 	'ssl' => array
							 			 (
							 			 	'verify_peer' => false,
					                        'verify_peer_name' => false,
					                        'allow_self_signed' => true
					                     )
							 );
		if(!$mail->send())
		{
		    echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else
		{
		    echo "Message sent!<BR>";
		    echo "<BR>---------------- DE NOVO ? ---------------- <BR>";
		}
	}
}

?>