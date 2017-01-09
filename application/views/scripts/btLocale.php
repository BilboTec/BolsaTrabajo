angular.module("BilboTec.ui")
.filter("btLocale",function(){
	var lang = <?php echo $lang; ?>;
	return function(clave){
		var mensaje = lang[clave];
		return typeof mensaje === "undefined"?clave:mensaje;
	}
});