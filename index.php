<?php
require_once('config.php');
$serverUrl = constant('base_url');
$siteName = constant('nombreEmpresa');
$tiempoSesion = constant('tiempoSesion');
//var_dump($_SESSION);
header("Access-Control-Allow-Origin: " . constant('webUrl'));
?>
<!doctype html>
<html lang="es">

<head>
	<?php include("views/SEO.php"); ?>
	<script>
		const serverURL = '<?php echo $serverUrl . "'"; ?>;
		const siteName = '<?php echo $siteName . "'"; ?>;
		const tiempoSesion = '<?php echo $tiempoSesion . "'"; ?>;
		var paginaJS = "login";
	</script>

	<?php include("resources/css/cssFiles.php"); ?>
	<?php include("resources/js/jsFiles.php"); ?>

</head>

<body class="text-center">

	<div class="container-fluid">

		<?php
		if (!isset($_SESSION['email']) || $_SESSION['email'] == '' && !isset($pag)) {
			$pag = "login";
			echo "<script> paginaJS = 'login'; </script>";
		} else if (isset($view) && isset($_SESSION['email'])) {

			include('views/template/menuPrincipal.php');
			$views = explode("/", $view);

			if (isset($views[0])) {
				$pag = $views[0]; /* Pagina */
			}
			if (isset($views[1])) {
				$opt = $views[1]; /* Opcion */
			}
			if (isset($views[2])) {
				$idRegistro = $views[2]; /* Opcion */
			}
			if (isset($views[3])) {
				$idRegistro2 = $views[3]; /* Opcion */
			}
			echo "<script> paginaJS = '" . $pag . "'; </script>";
		} else {

			include('views/template/menuPrincipal.php');
			$pag = "home";
			echo "<script> paginaJS = 'recaudo'; </script>";
		}
		?>
		<div class="row" class="border">
			<div id="capaContenido" class="col-md-12">
				<?php

				$pag .= ".php";
				//echo $pag;
				if ($pag == 'index.php') {
					include($pag);
				} else {
					include("views/" . $pag);
				}

				?>
			</div>
		</div>
		<?php
		if ($pag != "views/login.php") {
			include('views/template/footer.php');
		}

		?>

	</div>


	<div class="modal inmodal fade font-weight-bold" id="frmModal" tabindex="-1" role="dialog" aria-labelledby="frmModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitulo">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="bodyModal">
					...
				</div>
			</div>
		</div>
	</div>

</body>

</html>