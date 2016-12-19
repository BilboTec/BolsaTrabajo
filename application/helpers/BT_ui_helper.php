<?php

function data_result($data,$total){
	$respuesta = new stdClass();
	$respuesta->total = $total;
	$respuesta->data = $data;
	return json_encode($respuesta);
}
