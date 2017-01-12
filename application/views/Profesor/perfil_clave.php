<fieldset>
	<legend><?php echo strtoupper($idioma("cambiar_clave")); ?></legend>
	<div bt-input-label bt-id="clave" ng-required="true" name="clave" bt-label="'<?php echo ucfirst($idioma("clave_actual")); ?>'" bt-model="usuario.clave" type="password"></div>
	<div  ng-show="(formPerfil.$submitted || formPerfil.clave.$touched) && formPerfil.clave.$invalid"><?php printf($idioma("required"),$idioma("clave_actual")); ?></div>

	<div bt-input-label bt-id="nuevaclave" ng-required="true" name="nuevaclave" bt-label="'<?php echo ucfirst($idioma("clave_nueva")); ?>'" bt-model="usuario.nuevaclave" type="password"></div>

	<div  ng-show="(formPerfil.$submitted || formPerfil.nuevaclave.$touched) && formPerfil.nuevaclave.$invalid"><?php printf($idioma("required"),$idioma("clave_nueva")); ?></div>

	<div bt-input-label bt-id="repetirclave" ng-required="true" name="repetirclave" bt-label="'<?php echo ucfirst($idioma("repetir_clave")); ?>'" bt-model="usuario.repetirclave" type="password"></div>

	<div  ng-show="(formPerfil.$submitted || formPerfil.repetirclave.$touched) && formPerfil.repetirclave.$invalid"><?php printf($idioma("required"),$idioma("repetir_clave")); ?></div>

	<span class="btn btn-tipo" ng-click="cambiarClave()"><?php echo ucfirst($idioma("cambiar")); ?></span>
	<a href="#!/"><?php echo ucfirst($idioma("volver")); ?></a>

	<div bt-window="ventana"></div>

</fieldset>