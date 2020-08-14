<?php
if ($_SESSION['is_active'] == "1") {
?>
	<div class="row">
		<div class="col-md-12 fixed-top">
			<!-- Inicio Menu Principal -->
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
				<a class="navbar-brand" href="<?php echo $serverUrl . "home"; ?>">
					<img src="<?php echo $serverUrl; ?>resources/images/cash-in-hand.png" width="30" height="30" alt="">
					Menu Principal
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto text-right">
						<li class="nav-item">
							<a class="nav-link" href="#" onclick="terminaSesion(1);">
								<i class="fas fa-sign-out-alt"></i>
								&nbsp;
								Salir
							</a>
						</li>
					</ul>
				</div>
			</nav>
			<!-- Fin Menu Principal -->
		</div>
	</div>
<?php
}
?>