<input type="<?php echo $type; ?>" <?php echo (isset($id)?"id='$id'":""); ?> ng-model="valor" ng-required="required"/>
<label <?php echo (isset($id)?"for='$id'":""); ?>>{{ label }}</label>