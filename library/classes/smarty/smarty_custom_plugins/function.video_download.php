<?php
/**
 * Enter a price and a currency id to convert to, it will look up the database and conver the currency where aplicable.
 * This is dependant of the currency class
 *
 * Params:
 *
 * currencyid      the id of the currency
 * usdprice			the price value
 *
 *
 * @author  Johan Steyn 08 May 2008
 * @param array $params
 * @param object $smarty
 * @return string
 */
require_once('library/classes/ccafrica/reserves/reserve.php');
require_once('library/classes/ccafrica/destinations/destination.php');

function smarty_function_video_download($params, &$smarty)
{
	global $site_config;
	extract($params);
	$download = false; //set this to true if download exists
	
	
	
	// if there is a reserve check to see if there is a reserve download
	if(isset($reserveId) && $reserveId != '')
	{
		$reserve = new CCA_Reserve();
		$reserve->load($reserveId);
		
		// create file path to download 
		$filePath =  $_SERVER['DOCUMENT_ROOT'].'/media/flashvideos/reserves/'.$reserve->reserve_permalink.'/video_download.mov';		
		if(file_exists($filePath))
		{
			echo '<a href="/videodownload/download.php?reserveId='.$reserveId.'" class="desktop" title"'.$reserve->reserve_short_name.' Video Download" target="_self">To your desktop</a>';		
		}else
		{
			echo 'currently no download available.';
		}
	}
	
	// if there is a destination check to see if there is a reserve download
	if(isset($destinationId) && $destinationId != '')
	{
		$destination = new CCA_Destination();
		$destination->load($destinationId);
		
		// create file path to download 
		$filePath = $_SERVER['DOCUMENT_ROOT'].'/media/flashvideos/destinations/'.$destination->destination_permalink.'/video_download.mov';	
		
		$fileName = $destination->destination_name;
		if(file_exists($filePath))
		{
			echo '<a href="/videodownload/download.php?rdestinationId='.$destinationId.'" class="desktop" title"'.$destination->destination_name.' Video Download" target="_self">To your desktop</a>';				
		}else
		{
			echo 'currently no download available.';
		}	
	}
	
}

?>