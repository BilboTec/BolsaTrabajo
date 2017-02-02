<nav class="cabecera_usuario">
	<ul>
			<li <?php echo ($activo === "ofertas"? 'class="activo"': ""); ?> ><div></div><a href="/Empresa/#!/" <?php echo ($activo === "ofertas"? 'class="activo" >': "> ").ucfirst($idioma('ofertas')); ?> </a></li>
			<li <?php echo ($activo === "perfil"? 'class="activo"': ""); ?> ><div></div><a href="/Empresa/Perfil"<?php echo ($activo === "perfil"? 'class="activo" >': "> ").ucfirst($idioma('perfil')); ?> </a></li>
			
	</ul>
</nav>