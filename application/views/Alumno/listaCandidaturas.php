<?php
foreach ($candidaturas as $candidatura) { ?>
		<li> <a href="#!/<?php echo $candidatura->id_oferta; ?>"><?php echo $candidatura->titulo ." (" .$candidatura->fecha .")" ; ?> </a></li>

<?php } 