<?php
/*
Date: 21 Jul 2007
Author: Bernhard K. Ernst
Requires: PHP (http://www.php.net/) and Smarty (http://smarty.php.net/)
Description: This smarty plugin generates the phpThumb image statement. It makes use of maximum amounts.
*/

/*
Date Modified: 23 October 2007
Editor: Johan Steyn
added function to return empty gif at height
*/
include_once 'modifier.file_exists.php';
function smarty_function_php_thumb($params, &$smarty) {
	extract($params);
	//check we have a source file name

	$html = '<img src="';

	// this is for alternative src switching, this is for if you dont want a blank/no image to show by a placeholder image
	if(isset($altsrc) && $altsrc != '' )
	{
		if(isset($src) && $src != '' && !smarty_modifier_file_exists($src))
		{
			$src = $altsrc;
		}
	}



	if (isset($src) && $src != '' && smarty_modifier_file_exists($src)){
		$html .= '/library/classes/phpthumb/phpthumb.php?src='.$src;
		if ($width != '') $html .= '&w='.$width;
		if ($widths != '') $html .= '&wp='.$widths.'&wl='.$widths.'&ws='.$widths; // used for square thumbnails
		if ($height != '') $html .= '&h='.$height;
		if ($heights != '') $html .= '&hp='.$heights.'&hl='.$heights.'&hs='.$heights; // used for square thumbnails
		if ((string)$zc != '') $html .= '&zc='.$zc;
		if ((string)$far != '') $html .= '&far='.$far;
		//if ((string)$fltr != '') $html .= '&fltr[]='.$fltr;
		if ($bg != '') $html .= '&bg='.$bg;
		if ($quality != '') $html .= '&q='.$quality;
	} else {
		$html .= '/images/global/emptyimg.gif"';
	}

	$html .= '"';
//	if ($width != '') $html .= ' width="'.$width.'"';
//	if ($height != '') $html .= ' height="'.$height.'"';
	$html .= ' border="0" alt="';
	if ($alt != '') $html .= $alt;
	$html .= '"';
	if ($align != '') $html .= ' align="'.$align.'"';
	if ($width != '') $html .= ' width="'.$width.'"';
	if ($height != '') $html .= ' height="'.$height.'"';
	if ($class != '') $html .= ' class="'.$class.'"';
	if ($style != '') $html .= ' style="'.$style.'"';
	if ($onclick != '') $html .= ' onclick="'.$onclick.'"';
	if ($onmouseout != '') $html .= ' onmouseout="'.$onmouseout.'"';
	if ($onmouseover != '') $html .= ' onmouseover="'.$onmouseover.'"';
	if ($name != '' && $id=='') $html .= ' name="'.$name.'" id="'.$name.'"';
	if ($id != ''  && $name=='') $html .= ' name="'.$id.'" id="'.$id.'"';
	if ($id != ''  && $name!='') $html .= ' name="'.$name.'" id="'.$id.'"';
	$html .= ' />';
	return $html;
}
?>