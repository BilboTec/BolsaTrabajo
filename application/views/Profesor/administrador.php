<div class="contenedor-admin" ng-controller="administradorController">
<ul class="lista_cambios">
	<li class= "btn btn-cambio" ng-class="seleccionado==0?'activo':''" ng-click= "establecerConfiguracion(configuraciones.conocimientos); seleccionado=0"><?php echo ucfirst($idioma('conocimientos')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==1?'activo':''" ng-click= "establecerConfiguracion(configuraciones.departamentos); seleccionado=1"><?php echo ucfirst($idioma('departamentos')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==2?'activo':''" ng-click= "establecerConfiguracion(configuraciones.tipo_titulacion); seleccionado=2"><?php echo ucfirst($idioma('tipo_titulacion')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==3?'activo':''" ng-click= "establecerConfiguracion(configuraciones.oferta_formativa); seleccionado=3"><?php echo ucfirst($idioma('oferta_formativa')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==4?'activo':''" ng-click= "establecerConfiguracion(configuraciones.pais); seleccionado=4"><?php echo ucfirst($idioma('paises')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==5?'activo':''" ng-click= "establecerConfiguracion(configuraciones.provincias); seleccionado=5"><?php echo ucfirst($idioma('provincias')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==6?'activo':''" ng-click= "establecerConfiguracion(configuraciones.localidades); seleccionado=6"><?php echo ucfirst($idioma('localidades')); ?></li>
	<li class= "btn btn-cambio" ng-class="seleccionado==7?'activo':''" ng-click= "establecerConfiguracion(configuraciones.profesores); seleccionado=7"><?php echo ucfirst($idioma('profesores')); ?></li>
	<li class="btn btn-cambio" ng-class="seleccionado==8?'activo':''" ng-click="mostrarConfiguracion()"><?php echo mb_ucfirst($idioma("configuracion")); ?></li>
	
</ul>
	<p ng-show="seleccionado == -1">Seleccione la opción que deséa modificar</p>
	<div class="contenedor-tabla" >
		<div bt-tabla ng-model="filas" bt-config="configuracion.conocimientos" bt-set-config="establecerConfiguracion" ng-show="seleccionado >= 0 && seleccionado != 8"></div>
		<div class="config-wrapper">
			<fieldset ng-form="ftpForm" ng-show="seleccionado == 8" ng-controller="btControladorConfiguracion">
				<div bt-window="ventana"></div>
				<legend><?php echo mb_strtoupper($idioma("copia_seguridad")); ?></legend>
				<div class="contenedor-config">
				<div class="grupo">
					<label for="host">Host</label>
					<input type="text" ng-required="true" ng-model="config.sftp_host" id="host" name="host"/>
					<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.host.$touched) && ftpForm.host.$invalid">
						El campo host es obligatorio
					</span>
				</div>
				<div class="grupo">
					<label for="port"><?php echo mb_ucfirst($idioma("puerto")); ?></label>
					<input type="text" ng-required="true" ng-model="config.sftp_port" id="port" name="port"/>
					<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.port.$touched) && ftpForm.port.$invalid">
						El campo puerto es obligatorio
					</span>
				</div>
				<div class="grupo">
					<label for="user"><?php echo mb_ucfirst($idioma("usuario")); ?></label>
					<input type="text" ng-required="true" ng-model="config.sftp_user" id="user" name="user"/>
					<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.user.$touched) && ftpForm.user.$invalid">
						El campo usuario es obligatorio
					</span>
				</div>
				<div class="grupo">
					<label for="pass"><?php echo mb_ucfirst($idioma("clave")); ?></label>
					<input type="password" ng-required="true" ng-model="config.sftp_pass" id="pass" name="pass"/>
					<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.pass.$touched) && ftpForm.pass.$invalid">
						El campo contraseña es obligatorio
					</span>
				</div>
				<div class="grupo">
					<label for="freq"><?php echo mb_ucfirst($idioma("frecuencia")); ?></label>
					<input type="text" id="freq" ng-required="true" ng-model="config.backup_frequencia" name="freq"/>
					<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.freq.$touched) && ftpForm.freq.$invalid">
						El campo host es obligatorio
					</span>
				</div>
					<span class="btn btn-tipo centro" ng-click="guardarFtp()"><?php echo mb_ucfirst($idioma("guardar")); ?></span>
					<span class="btn btn-tipo centro" ng-click="backup()"><?php echo mb_ucfirst($idioma("hacer_copia")); ?></span>
				</div>
			</fieldset>
			<fieldset ng-form="emailForm" ng-controller="btEmailConfigController" ng-show="seleccionado == 8">
				<legend><?php echo mb_ucfirst($idioma("config_email")); ?></legend>
				<div bt-window="ventana"></div>
				<div class="contenedor-config">
					<div class="grupo">
						<label for="protocol"><?php echo mb_ucfirst($idioma("protocol")); ?></label>
						<select id="protocol" ng-model="email.email_protocol">
							<option value="smtp">Smtp</option>
							<option value="mail">Mail</option>
							<option value="sendmail">SendMail</option>
						</select>
					</div>
				<?php
					$campos_email = ["email_user","email_host","email_port","email_pass"];
					foreach($campos_email as $campo){ ?>
						<div class="grupo">
							<label for="<?php echo $campo; ?>"><?php echo mb_ucfirst($idioma($campo)); ?></label>
							<input ng-required="true" type="text" ng-required="true" name="email_host" id="email_host" ng-model="email.<?php echo $campo; ?>"/>
							<span class="error_validacion"
								ng-if="(emailForm.$submitted || emailForm.<?php echo $campo; ?>.$touched) && emailForm.<?php echo $campo; ?>.$invalid">
								<?php
								printf(mb_ucfirst($idioma("required")),mb_ucfirst($idioma($campo)));
								?>
							</span>
						</div>
				<?php	} ?>
					<div class="grupo">
						<label for="crypto"><?php echo mb_ucfirst($idioma("crypto")); ?></label>
						<select id="crypto" ng-model="email.email_crypto">
							<option value="ssl">SSL</option>
							<option value="tsl">TSL</option>
						</select>
					</div>
				<span class="btn btn-tipo centro" ng-click="guardarEmailConfig()"><?php echo mb_ucfirst($idioma("guardar")); ?></span>
				</div>
			</fieldset>
		</div>
	</div>

</div>