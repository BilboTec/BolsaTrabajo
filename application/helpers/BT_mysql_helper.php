<?php
if ( ! function_exists('sql_translate'))
{
    function sql_translate($subject,$search,$replace="")
    {
        for($i = 0; $i < strlen($search);$i++){
            $char = $search[$i];
            $rep = (isset($replace[$i])?$replace[$i]:"");
            $subject="REPLACE($subject,'$char','$rep')";
        }
        return $subject;
    }
}
if(!function_exists('sql_string_busqueda')){
    function sql_string_busqueda($string){
        return sql_translate("REPLACE(REPLACE(REPLACE(REPLACE(LOWER($string),'ll','l'),'ch','tx'),'qu','k'),'gu','g')","vmñyjgcáäâàêèéëîìïíôòöóûùüúh","bnnkiiizaaaaeeeeiiiioooouuuu");
    }
}