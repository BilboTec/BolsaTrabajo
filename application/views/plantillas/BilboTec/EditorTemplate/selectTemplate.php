<select ng-model="edit[columna]">
	<?php
		foreach($elementos as $elemento){
			echo "<option value='".$elemento->$clave."'>".$elemento->$texto."</option>";
		}
	 ?>
</select>