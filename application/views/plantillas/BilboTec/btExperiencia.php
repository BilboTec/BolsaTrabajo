<h1><?php echo $idioma("experiencia"); ?></h1><button ng-click="insertar()">Añadir Experiencia</button>
<div ng-init="nuevo=true" ng-show="insertando" ng-include="editar"></div>
<div ng-model="experiencia" ng-repeat="experiencia in alumno.experiencias track by $index" ng-include="indiceEdicion == $index?editar:vista"></div>
