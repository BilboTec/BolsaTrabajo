<select>
	<?php
		foreach($elementos as $elemento){
			echo "<option value='".$elemento[$valor]."'>".$elemento[$texto]."</option>";
		}
	 ?>
</select>