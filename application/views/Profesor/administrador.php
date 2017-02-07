<div class="contenedor-admin" ng-controller="administradorController">

<ul class="lista_cambios">
	<li class= "btn-cambio" ng-class="seleccionado==0?'activo':''" ng-click= "establecerConfiguracion(configuraciones.conocimientos); seleccionado=0"><?php echo ucfirst($idioma('conocimientos')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==1?'activo':''" ng-click= "establecerConfiguracion(configuraciones.departamentos); seleccionado=1"><?php echo ucfirst($idioma('departamentos')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==2?'activo':''" ng-click= "establecerConfiguracion(configuraciones.tipo_titulacion); seleccionado=2"><?php echo ucfirst($idioma('tipo_titulacion')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==3?'activo':''" ng-click= "establecerConfiguracion(configuraciones.oferta_formativa); seleccionado=3"><?php echo ucfirst($idioma('oferta_formativa')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==4?'activo':''" ng-click= "establecerConfiguracion(configuraciones.pais); seleccionado=4"><?php echo ucfirst($idioma('paises')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==5?'activo':''" ng-click= "establecerConfiguracion(configuraciones.provincias); seleccionado=5"><?php echo ucfirst($idioma('provincias')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==6?'activo':''" ng-click= "establecerConfiguracion(configuraciones.localidades); seleccionado=6"><?php echo ucfirst($idioma('localidades')); ?></li>
	<li class= "btn-cambio" ng-class="seleccionado==7?'activo':''" ng-click= "establecerConfiguracion(configuraciones.profesores); seleccionado=7"><?php echo ucfirst($idioma('profesores')); ?></li>
	<li class="btn-cambio" ng-class="seleccionado==8?'activo':''" ng-click="mostrarFormularioConfiguracion()">Configuracion</li>
	
</ul>

	<div class="contenedor-tabla" >
		<div bt-tabla ng-model="filas" bt-config="configuracion" bt-set-config="establecerConfiguracion" ng-show="seleccionado != 8"></div>
		<fieldset ng-form="ftpForm" ng-show="seleccionado == 8" ng-controller="btControladorConfiguracion">
			<div bt-window="ventana"></div>
			<legend>Copias de seguridad</legend>
			<div class="contenedor-config">
			<div class="grupo">
				<label for="host">Host</label>
				<input type="text" ng-required="true" ng-model="config.sftp_host" id="host" name="host"/>
				<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.host.$touched) && ftpForm.host.$invalid">
					El campo host es obligatorio
				</span>
			</div>
			<div class="grupo">
				<label for="port">Puerto</label>
				<input type="text" ng-required="true" ng-model="config.sftp_port" id="port" name="port"/>
				<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.port.$touched) && ftpForm.port.$invalid">
					El campo puerto es obligatorio
				</span>
			</div>
			<div class="grupo">
				<label for="user">Usuario</label>
				<input type="text" ng-required="true" ng-model="config.sftp_user" id="user" name="user"/>
				<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.user.$touched) && ftpForm.user.$invalid">
					El campo usuario es obligatorio
				</span>
			</div>
			<div class="grupo">
				<label for="pass">Contraseña</label>
				<input type="password" ng-required="true" ng-model="config.sftp_pass" id="pass" name="pass"/>
				<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.pass.$touched) && ftpForm.pass.$invalid">
					El campo contraseña es obligatorio
				</span>
			</div>
			<div class="grupo">
				<label for="freq">Freqeuencia (Días)</label>
				<input type="text" id="freq" ng-required="true" ng-model="config.backup_frequencia" name="freq"/>
				<span class="error_validacion" ng-if="(ftpForm.$submitted  || ftpForm.freq.$touched) && ftpForm.freq.$invalid">
					El campo host es obligatorio
				</span>
			</div>
				<span class="btn btn-tipo" ng-click="guardarFtp()">Guardar</span>
				<span class="btn btn-tipo" ng-click="backup()">Hacer copia de seguridad ahora</span>
			</div>
		</fieldset>
	</div>

</div>