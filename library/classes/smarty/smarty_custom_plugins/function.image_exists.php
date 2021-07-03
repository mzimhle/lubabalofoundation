<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     image_exists
 * Purpose:  check file exists or return place_holder 
 * -------------------------------------------------------------
 */
function smarty_function_image_exists($params, &$smarty)
{
    /*

    @param  string  path            - path to file

    */
	
	//standard vars
	global $site_root;
	$retval = '/images/sitewide/place_holder.jpg';
         
    /* Import parameters */
    extract($params);

    /* Convert page count if array */
    if (isset($path) && strlen($path) ){
	
		if(file_exists($site_root."/".$path)){
				
				$retval = $path;
		
		}//check we have a file
	
	}//check for non empty path

    return $retval;
}


?>
