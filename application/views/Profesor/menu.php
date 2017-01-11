<nav class="cabecera_usuario">
	<ul>
			<li <?php echo ($activo === "ofertas"? 'class="activo"': ""); ?> ><div></div><a href="/Profesor/Ofertas#!/" <?php echo ($activo === "ofertas"? 'class="activo" >': "> ").ucfirst($idioma('ofertas')); ?> </a></li>
			<li <?php echo ($activo === "alumnos"? 'class="activo"': ""); ?> ><div></div><a href="/Profesor/Alumnos"<?php echo ($activo === "alumnos"? 'class="activo" >': "> ").ucfirst($idioma('alumnos')); ?> </a></li>
			<li <?php echo ($activo === "empresas"? 'class="activo"': ""); ?> ><div></div><a href="/Profesor/Empresas"<?php echo ($activo === "empresas"? 'class="activo" >': "> ").ucfirst($idioma('empresas')); ?> </a></li>
			<li <?php echo ($activo === "perfil"? 'class="activo"': ""); ?> ><div></div><a href="/Profesor/Perfil"<?php echo ($activo === "perfil"? 'class="activo" >': "> ").ucfirst($idioma('perfil')); ?> </a></li>
			<?php 
			if(isset($es_administrador) && $es_administrador){
			 echo "<li ".($activo === "administrador"? 'class="activo"': "")."><div></div><a href='/Profesor/Administrador'" .($activo === "administrador"? 'class="activo" >': "> ").ucfirst($idioma('administrador')) ."</a></li>";
			} 
			?>
	</ul>
</nav>