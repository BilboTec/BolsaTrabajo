<div ng-controller="controladorDatosAlumno" name="formPerfil" class="contenedor-perfil contenedor">
	<div class="editar-perfil">
		<!--<div ng-include="'/Alumno/DatosPersonales'"></div>-->
		<div bt-perfil-alumnos-datos-personales="datosPersonales" ng-model="alumno"></div>
		<div bt-experiencia ng-model="alumno"></div>
		<div bt-formacion-academica ng-model="alumno"></div>
		<div bt-formacion-complementaria ng-model="alumno"></div>
		<div bt-idiomas ng-model="alumno"></div>
		<div ng-include="'/Alumno/Idiomas'"></div>
		<div ng-include="'/Alumno/OtrosDatos'"></div>
	</div>
</div>