<div class="container fixed-top" style="margin-top: 50 !important; padding-top: 50 !important;">
	<div class="row" style="padding-top: 15% !important;">
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-6">

			<div class="card shadow mb-3">
				<div class="card-header text-left">
					<h3 class="h5 mb-1 font-weight-normal">Iniciar Sesión</h4>
				</div>
				<div class="row no-gutters">
					<div class="card-body">
						<form class="form-signin">
							<div class="form-group text-left">
								<label for="txt_email">Correo: </label>
								<input type="email" id="txt_email" name="txt_email" class="form-control" value="" placeholder="Correo" maxlength="80" required autofocus>
							</div>

							<div class="form-group text-left">
								<label for="inputPassword" class="">Contraseña</label>
								<input type="password" id="txt_password" name="txt_password" class="form-control" value="" placeholder="Contraseña" maxlength="80" required>
							</div>
							<a id="btn_ingresar" class="btn btn-lg btn-primary btn-block" href="#" onClick='validaLogin();'>Ingresar</a>
						</form>
						<p>
							<a href="#" onclick="recuperarContrasena()" title="Recuprerar Contrasena">Recuprerar Contrasena</a> |
							<a href="#" onclick="RegistroNuevoUsuario()" title="Recuprerar Contrasena">Registrarme</a>
						</p>
					</div>
				</div>
				<div class="card-footer">
					<p class="mt-3 mb-3 text-muted">Desing By &copy; <strong>Dany Pascual Gómez Sánchez</strong></p>
				</div>
			</div>

		</div>
		<div class="col-md-3">&nbsp;</div>
	</div>
</div>