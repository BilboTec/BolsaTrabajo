<input type="<?php echo $type; ?>" ng-model="value" ng-required="required" ng-change="comprobarValor()"/>
<label ng-class="vacio?'top':''">{{ label }}</label>