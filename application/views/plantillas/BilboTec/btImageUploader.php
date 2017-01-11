<canvas id="canvas">
</canvas height="200" width="160">
<label for="offsetX"><?php echo ucfirst($idioma("correc_x")); ?></label>
<input id="offsetX" type="number" ng-model="offset.x" ng-change="imagenSeleccionada()"/>
<label for="offsetY"><?php echo ucfirst($idioma("correc_y")); ?></label>
<input id="offsetY" type="number" ng-model="offset.y" ng-change="imagenSeleccionada()"/>
<label for="scale"><?php echo ucfirst($idioma("escala")); ?></label>
<input id="scale" type="number" ng-model="scale" ng-change="imagenSeleccionada()"/>
<p ng-show="size"><?php echo ucfirst($idioma("tamano")); ?>: {{ size }}</p>
<input type="hidden"  value="{{ imagen }}"/>
<input type="file" accept="image/*"/>