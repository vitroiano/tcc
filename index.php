<?php

require('dbconnect_system.php');

?>

<?php
	session_start();
	if(!isset($_SESSION["email"]) || !isset($_SESSION["senha"])){
		header("Location: login.php");
		exit;
	}
?>

<?php

$email = $_SESSION["email"];

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ferramenta de Analise de Desempenho de Rede</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	
	<!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>
<body>

<div id="wrapper">

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<!-- Top Navigation: Left Menu -->
		<ul class="nav navbar-nav navbar-left navbar-top-links">
			<li><a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a></li>
		</ul>
		
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Ferramenta de Análise de Desempenho de Rede</a>
		</div>

		<!-- Top Navigation: Right Menu -->
		<ul class="nav navbar-right navbar-top-links">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-user fa-fw"></i> <?php echo $email; ?><b class="caret"></b>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
			</li>
		</ul>

		<!-- Sidebar -->
		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">

				<ul class="nav" id="side-menu">
					
					<?php include 'menu_navbar.php' ?>
				
				</ul>

			</div>
		</div>
	</nav>

	<!-- Page Content -->
		<div id="page-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Bem Vindo</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Quantidade de Dispositivos vinculados a essa conta em relação ao seus Status
							</div>                            
							<div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>PVID</th>
                                                <th>USER</th>
                                                <th>SENHA</th>
                                                <th>NOME</th>
												<th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										require_once('dbconnect.php');

										$query = "SELECT pvid, user, senha, nome, conectado, servicos FROM dispositivos WHERE user = '$email' ORDER BY pvid";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$pvid = $row["pvid"];
											$user = $row["user"];
											$senha = $row["senha"];
											$nome = $row["nome"];
											$conectado = $row["conectado"];
											if($conectado == 0){
												$conectado = "OFFLINE";
												$color = "red";
											}else{
												$conectado = "ONLINE";
												$color = "green";
											}
											$servicos = $row["servicos"];
											if($servicos == 0){
												$servicos = "SEM SERVIÇO";
											}else{
												$servicos = "COM SERVIÇO";
											}
											
											echo "<tr><td>".$pvid."</td><td>".$user."</td><td>".$senha."</td><td>".$nome."</td><td style='background:".$color.";color: #fff;'>".$conectado."</td></tr>";
										}?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
							<div class="panel-footer">
								Observações: A cada 60 segundos é atualizado automaticamente a página.
							</div>
						</div>
					</div>
					<!-- /.col-lg-1 -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Visão Geral dos Dispositivos em Relação aos seus Serviços e Scripts
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive" style="overflow: auto; width: auto; height: 350px">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>DISPOSITIVO</th>
                                                <th>SERVICO</th>
												<th>DOWNLOAD</th>
												<th>PERFIL</th>
												<th>SCRIPT</th>
												<th>PARAMETRO</th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										require_once('dbconnect.php');

										$query = "SELECT dispositivo, nome_servico, download, nome_perfil, nome_script, nome_parametro FROM perfil_script_parametro INNER JOIN servicos ON perfil_script_parametro.nome_perfil = servicos.perfil INNER JOIN dispositivos ON servicos.dispositivo = dispositivos.pvid WHERE user = '$email' ORDER BY idservicos";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$dispositivo = $row["dispositivo"];
											$nome_servico = $row["nome_servico"];
											$download = $row["download"];
											$download = $row["download"];
											if($download == 'N'){
												$download = "NÃO REALIZADO";
											}else{
												$download = "REALIZADO";
											}
											$nome_perfil = $row["nome_perfil"];
											$nome_script = $row["nome_script"];
											$nome_parametro = $row["nome_parametro"];
											
											echo "<tr><td>".$dispositivo."</td><td>".$nome_servico."</td><td>".$download."</td><td>".$nome_perfil."</td><td>".$nome_script."</td><td>".$nome_parametro."</td></tr>";
										}?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-2 -->
				</div>
			</div>
		</div>

</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

</body>
</html>
<?php

require_once('dbconnect.php');

$query = "SELECT pvid FROM dispositivos WHERE conectado = 1";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()){
	$data[] = $row;
	$pvid = $row["pvid"];
	
	$query1 = "UPDATE dispositivos SET conectado = 0 WHERE pvid = $pvid";
    $result1 = $mysqli->query($query1);
}

// $query1 = "UPDATE dispositivos SET conectado = 0 WHERE pvid = $pvid";
// $result1 = $mysqli->query($query1);

echo "<meta HTTP-EQUIV='refresh' CONTENT='60;URL=index.php'>";
?>




