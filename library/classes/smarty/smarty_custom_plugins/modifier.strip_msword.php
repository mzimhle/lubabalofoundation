<?php
/*
 * Smarty {strip_msword} modifier plugin
 *
 * Examples:
 * {source|strip_msword}
 *
 * @author     		David Murray <dave@clickthinking.com>
 * @version    		1.0
 * @date 			04 Feb 2009
 * @ src String 	(filename or url)
 * @return string 	stripped text
 */
function smarty_modifier_strip_msword($src)
{
	
   	  //strip tags first
	   $src = strip_tags($src,"<p><br><a><b><strong>");	
	   $src = preg_replace('/<p[^>]+>/i','<p>',$src);  
	   $src = str_ireplace('&nbsp;','',$src);
	   $src = preg_replace("/<[^\/>]*>([\s]?)*<\/[^>]*>/",'',$src); 
	
       $trans_array = array();
       for ($i=127; $i<255; $i++) {
           $trans_array[chr($i)] = "&#" . $i . ";";
       }

      return strtr($src, $trans_array);
}
?>