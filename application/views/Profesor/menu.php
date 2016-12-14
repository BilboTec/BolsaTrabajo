<nav>
	<ul>
			<li <?php echo ($activo === "ofertas"? 'class="activo" >': "> ").ucfirst($idioma('ofertas')); ?></li>
			<li<?php echo ($activo === "alumnos"? 'class="activo" >': "> ").ucfirst($idioma('alumnos')); ?></li>
			<li<?php echo ($activo === "empresas"? 'class="activo" >': "> ").ucfirst($idioma('empresas')); ?></li>
			<li<?php echo ($activo === "perfil"? 'class="activo" >': "> ").ucfirst($idioma('perfil')); ?></li>
			<?php 
			if(isset($es_administrador) && $es_administrador){
			 echo "<li" .($activo === "administrador"? 'class="activo" >': "> ").ucfirst($idioma('administrador')) ."</li>";
			} 
			?>
	</ul>
</nav>