<nav>
	<ul>
			<li><a href="/Profesor/Ofertas" <?php echo ($activo === "ofertas"? 'class="activo" >': "> ").ucfirst($idioma('ofertas')); ?></a></li>
			<li><a href="/Profesor/Alumnos"<?php echo ($activo === "alumnos"? 'class="activo" >': "> ").ucfirst($idioma('alumnos')); ?></a></li>
			<li><a href="/Profesor/Empresas"<?php echo ($activo === "empresas"? 'class="activo" >': "> ").ucfirst($idioma('empresas')); ?></a></li>
			<li<?php echo ($activo === "perfil"? 'class="activo" >': "> ").ucfirst($idioma('perfil')); ?></li>
			<?php 
			if(isset($es_administrador) && $es_administrador){
			 echo "<li><a href='/Profesor/Ofertas'" .($activo === "administrador"? 'class="activo" >': "> ").ucfirst($idioma('administrador')) ."</a></li>";
			} 
			?>
	</ul>
</nav>