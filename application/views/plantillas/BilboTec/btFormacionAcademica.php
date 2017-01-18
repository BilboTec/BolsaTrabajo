<h1><?php echo $idioma("formacion_academica"); ?></h1><button ng-click="insertar()">Añadir Formación</button>
<div ng-init="nuevo=true" ng-show="insertando" ng-include="editar"></div>
<div ng-model="formacion" ng-repeat="formacion in alumno.formaciones track by $index" ng-include="indiceEdicion == $index?editar:vista"></div>
