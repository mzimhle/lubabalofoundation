<?php
/* Get Blocked modification
-------------------------------
Modifed By: Johan Steyn
Date: 16 October 2007

Parameters
-------------------------------

type: 		Document / document
			Image / image
			Content (default) /content
id:			primary key from block table
width:  	width of image
height:		height of image
align:		align image or align document icon to text
style:		add a style to image
name:		name image
iconwidth:	document icon image width
iconheight:	document icon image height
zc:			zoom crop images (boolean)
icononly:	return icon only for documents (boolean)
textonly:	returns text link only (boolean)
customicon:	link to a custom icon image
disablelink:disables anylinks (boolean)
tagline:	alt text uses tagline instead of title (boolean)
class:		addes a class to an image
onclick:	sets onclick event
onmouseout:	sets onmouseout event
onmouseover:	sets onmouseover event
placeholder: shows a place holder instead of no image at all (boolean)  function to see layout with no image Default:1
showcaption: returns caption text rather for documents (boolean)

eg:

{get_block type=content id=1}
{get_block type=document id=3 iconwidth=20}
{get_block type=image id=2 width=250 height=250 alt='this is an image'}


Dependancies:
-------------------------------

function.php_thumb.php  = spits out php thumb of an image
modifier.file_exists.php = checks if file exists


*/
//dependent on $siteConfig array, usually /includes/config.php

include_once 'function.php_thumb.php';
include_once 'modifier.file_exists.php';
include_once 'library/classes/dehoop/contents/contents.php';

function smarty_function_get_block($params, &$smarty)
{
    global $conn, $siteConfig;
	$block = new Content();
	
   
	extract($params);
	$type = (isset($type) && $type != '') ? $type : 'content';

	if (isset($id) && is_numeric($id)) {
		$block->load($id);
	}
	if (isset($pageId) && is_numeric($pageId) && isset($position) && is_numeric($position)) 
	{
		$block->loadByPosition($pageId ,$position);	
		if($block->fk_block_type_id !='')
		{	
			switch ($block->fk_block_type_id) 
			{
				case 2:	$type = 'image';
						break;
				case 3:	$type = 'document';
						break;
				default:$type = 'content';
						break;
			}
		}
		$id = $block->pk_block_id;
	}	
	
	
	if($id !='' )
	{	
	
		if($block->block_deleted!=1 && $block->block_active==1){
			switch (strtolower($type)) {
				case 'content' : return $block->block_text;
				break;
				case 'image': $filename = $block->block_filename;
							if($filename!='') {
								if(!preg_match('/http:/',$filename)) $filename = '/media/image/blocks/'.$id.'/'.$filename; // checks if image is url						
								if(smarty_modifier_file_exists($siteConfig['root'].$filename)) {
								
									if ($width != '' || $height != '') {	 // create php_thumb image with link to fullview
										$imageinfo =@getimagesize ($siteConfig['root'].$filename);  //[0] = width , [1] = height

										if ($tagline == 1) {
											$alt = $block->block_tags;
										}else{
											$alt = $block->block_title;
										}

										$param = array('src' => $filename,'width'=>$width,'height'=>$height,'zc'=>$zc,'far'=>$far,'bg'=>$bg,'alt'=>$alt,'align'=>$align,'style'=>$style,'class'=>$class,'onclick'=>$onclick,'onmouseout'=>$onmouseout,'onmouseover'=>$onmouseover,'name'=>$name,'fltr'=>$fltr);
										$html = @smarty_function_php_thumb($param);								
										
									
										
										
									}else{
										$html = '<img src="'.$filename.'"';
										$html .= ' border="0" alt="'.$block->block_title.'"';

										if ($width != '') $html .= ' width="'.$width.'"';
										if ($height != '') $html .= ' height="'.$height.'"';
										if ($align != '') $html .= ' align="'.$align.'"';
										if ($class != '') $html .= ' class="'.$class.'"';
										if ($style != '') $html .= ' style="'.$style.'"';
										if ($onclick != '') $html .= ' onclick="'.$onclick.'"';
										if ($onmouseout != '') $html .= ' onmouseout="'.$onmouseout.'"';
										if ($onmouseover != '') $html .= ' onmouseover="'.$onmouseover.'"';
										if ($name != '') $html .= ' name="'.$name.'" id="'.$name.'"';
										$html .= ' />';
									}

								 }elseif($placeholder) {
									 $html = '<div';

										if ($width != '') $Addstyles[]= ' width:'.$width.'px';
										if ($height != '') $Addstyles[]= 'height:'.$height.'px';
										if ($align != '') $Addstyles[]= 'vertical-align:'.$align;
										if ($style != '' || ($Addstyles !='' && is_array($Addstyles)) ) $html .= ' style="'.$style.implode(";",$Addstyles).'"';
										if ($class != '') $html .= ' class="'.$class.'"';
										if ($onclick != '') $html .= ' onclick="'.$onclick.'"';
										if ($onmouseout != '') $html .= ' onmouseout="'.$onmouseout.'"';
										if ($onmouseover != '') $html .= ' onmouseover="'.$onmouseover.'"';
										if ($name != '') $html .= ' name="'.$name.'" id="'.$name.'"';
										$html .= ' >[IMAGE: '.$block->block_title.' ]<br /><br>'.$block->block_text.'</div>';
								}
								return $html;
							}elseif($placeholder){							
								$html = '<img src=""';
								$html .= ' border="0" ';
								if ($name != '') $html .= ' name="'.$name.'" id="'.$name.'"';
								$html .= ' />';
								
								return $html;
							}
							return false;
				break;

				case'document':	$filename = $block->block_filename;						

							if( !empty($filename) ) {

								if(!preg_match('/http:/',$filename)) {// checks if document is url
									$document = '/media/document/blocks/'.$id.'/'.$filename;
									
									$doc_size =	round(@filesize($siteConfig['root'].$document) /1024);
								}else{
									$document = $filename;
									$headers = @get_headers($document, 1);
									$doc_size = round($headers["content-length"] /1024);
									unset($headers);
								}
								if($doc_size >= 1024) {		// convert 1024 kb to 1 mb and adds MB / KB
									$doc_size =round($doc_size /1024,2)." MB";
								}else{
									$doc_size .= " KB";
								}

								if(!smarty_modifier_file_exists($document)) return;
								if($showcaption!=1) {
									$doc_title = $block->block_title." (".$doc_size.")";
								}else{
									$doc_title = $block->block_text;
								}
								if ($tagline==1) {
										$alt = $block->block_tags;
									}else{
										if($alt=='') {
											$alt = "Download ".$doc_title;
										}
								}
								if($disablelink!=1)	$html = '<a href="/includes/downloader/download.php?f='.$block->pk_block_id.'" title="'.$alt.'">';
								if($textonly!=1) {
									if($customicon!='') {
										$icon_image = $customicon;
									}else{
										$doc_ext   =  substr($document,strrpos($document,'.')+1);
										$icon_image = "/images/icons/icon_".$doc_ext.".gif";
										if(!smarty_modifier_file_exists($icon_image))  $icon_image = "/images/icons/default.gif";
									}
									if ($name != '') {
										$html .= '<img hspace="2" src="'.$icon_image.'" id="'.$name.'" name="'.$name.'" border="0" ';
									}else{
										$html .= '<img src="'.$icon_image.'" id="'.$doc_title.'" name="'.$doc_title.'" border="0" ';
									}

									if ($iconwidth != '') $html .= ' width="'.$iconwidth.'"';
									if ($iconheight != '') $html .= ' height="'.$iconheight.'"';
									if ($align != '') $html .= ' align="'.$align.'"';
									if($alt != '')	$html .= ' alt="'.$alt.'"';
									$html.='/>';
								}



								if($icononly!=1)	$html.= $doc_title;
								if($disablelink!=1)	$html.="</a>";

								return $html;
							}
				break;

			}
		}	
	}else{
			//return "get_block: ID is not numeric or is blank";
	}
}
?>