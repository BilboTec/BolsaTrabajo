<?php

function data_result($data,$total){
	$respuesta = new stdClass();
	$respuesta->total = $total;
	$respuesta->data = $data;
	return json_encode($respuesta);
}
function include_localization($archivos=false){
		$url = "/api/Localize/".($archivos?"Get/".implode( "#",$archivos):"");
		return "<script src='$url'></script>";
}
