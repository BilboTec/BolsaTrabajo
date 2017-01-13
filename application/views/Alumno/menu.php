<nav class="cabecera_usuario">
	<ul>
			<li <?php echo ($activo === "ofertas"? 'class="activo"': ""); ?> ><div></div><a href="/Alumno/Ofertas#!/" <?php echo ($activo === "ofertas"? 'class="activo" >': "> ").ucfirst($idioma('ofertas')); ?> </a></li>
			<li <?php echo ($activo === "candidaturas"? 'class="activo"': ""); ?> ><div></div><a href="/Alumno/Candidaturas"<?php echo ($activo === "candidaturas"? 'class="activo" >': "> ").ucfirst($idioma('candidaturas')); ?> </a></li>
			<li <?php echo ($activo === "perfil"? 'class="activo"': ""); ?> ><div></div><a href="/Alumno/Perfil"<?php echo ($activo === "perfil"? 'class="activo" >': "> ").ucfirst($idioma('perfil')); ?> </a></li>
			
	</ul>
</nav>