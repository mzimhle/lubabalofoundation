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
include_once 'library/classes/clickthinking/standard/currencies/currency.php';

function smarty_function_priceconversion($params, &$smarty)
{
	global $conn, $site_config;
	extract($params);
	try{
		if($currencyid=='' || !isset($currencyid))
		{
			throw new Exception('please specify a currency id');
		}
		if($usdprice=='' || !isset($usdprice) || $usdprice==0)
		{
			return false;
		}

		$currency= new Currency();
		$currency->load($currencyid);
		if(! $currency->fetchData() )
		{
			throw new Exception('currency id not found');
		}

	}catch(Exception $e)
	{
		echo $e->getMessage();
		return false;
	}
	$newValue = $usdprice * $currency->currency_relative_to_USD;	
	$formatedValue = number_format(round($newValue),0,',',',');
	
	if($nowrap == 1)
	{
		$price = $currency->currency_symbol.' '.$formatedValue;
		
	}else
	{
		$price = '<span id="'.$newValue.'">'.$currency->currency_symbol.' '.$formatedValue.'</span>';
	}
	echo $price;
}

?>