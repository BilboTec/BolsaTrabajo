angular.module("BilboTec.ui")
.filter("btLocale",function(){
	var lang = <?php echo $lang; ?>;
	return function(clave){		
		return lang[clave];
	}
});