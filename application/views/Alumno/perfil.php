<div ng-controller="controladorDatosAlumno" name="formPerfil" class="contenedor-perfil contenedor">
	<div ng-include="'/Alumno/DatosPersonales'"></div>
	<div bt-experiencia ng-model="alumno"></div>
	<div bt-formacion-academica ng-model="alumno"></div>
	<div bt-formacion-complementaria ng-model="alumno"></div>
	<div bt-idiomas ng-model="alumno"></div>
	<div ng-include="'/Alumno/OtrosDatos'"></div>
</div>