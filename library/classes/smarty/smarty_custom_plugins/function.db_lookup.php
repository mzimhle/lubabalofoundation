<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
/**
 * Smarty {db_lookup} function plugin
 *
 * File:       function.db_lookup.php<br>
 * Type:       function<br>
 * Name:       db_lookup<br>
 * Date:       15.Aug.2004<br>
 * Purpose:    does a single field lookup, used for foreign key resolution<br>
 * Input:<br>
 *           - table      		(required) - string
 *           - id field   		(required) - string
 *           - id value   		(required) - string
 *           - lookup field 	(required) - string
 * Examples:
 * <pre>
 * {db_lookup table="users" id="userId" value=1 findField="userName"}
 * </pre>
 *      (Smarty online manual)
 * @author     David Murray <dave@clickthinking.com>
 * @version    1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_db_lookup($params, &$smarty)
{
	//NB add error checking!!
	global $conn;
	$table = $params['table']; 
	$id = $params['id']; 
	$value = $params['value']; 
	$findField = $params['findField']; 
	

	$sql = "Select ".$findField." from ".$table." where ".$id." in (".$value.")";
	//echo $sql;
	$rs = $conn->getCol($sql);	
	//var_dump($rs);
	$rs = (is_array($rs))? implode(",",$rs) : $rs;
	return $rs;
}
?>
