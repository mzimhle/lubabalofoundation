<?php
//build filter
global $smarty; // needed for the template
global $filter; // used later for SQL query, starts empty
global $filter_fields; // this is used specifically for listing entries
global $filter_search_fields; // this is used for searching multiple fields
global $table_name;

// get the search text which is nota field in the database
$search_text = (isset($_REQUEST['search_text~t']) && $_REQUEST['search_text~t'] != '') ? trim($_REQUEST['search_text~t']) : '';
if (!is_null($table_name) || is_bool($table_name)) $table_name = '';

// -------------------------------------------------------------------------------------
// remember filters:
// Notes: This script loops through filters and sets sets the session accordingly.
// The input is a CSV based string. Example:
// $filter_fields = "traveller_first_name~t,traveller_surname~t,traveller_email~t,fk_user_id~n";
if (isset($filter_fields) && !empty($filter_fields) && strlen($filter_fields) > 0) {
	$filter_fields = explode(',',$filter_fields);
	foreach ($filter_fields as $key => $value) {
		$temp_array = explode('~',$value);
		$fieldname_full = $value;
		$fieldname_name = $temp_array[0];
		$fieldname_type = $temp_array[1];
		$session_name = $fieldname_name;
		if ($fieldname_type == 'ed' || $fieldname_type == 'sd') $session_name .= $fieldname_type; // start and end date
		$field_value = '';
		if (isset($_SESSION[$session_name]) && ($_SESSION[$session_name] != '')) $field_value = $_SESSION[$session_name]; //set to session value first
		if (isset($_REQUEST[$fieldname_name.'~'.$fieldname_type])) $field_value = $_REQUEST[$fieldname_name.'~'.$fieldname_type]; //override with new value
		$_SESSION[$session_name] = $field_value; //re-assign session value
		if (isset($smarty) && $smarty) {
			$smarty->assign($session_name,$field_value); //assign to Smarty template
		} else {
			echo '<pre><small>Error: Smarty was not available for filter</small></pre>';
		}
		if ($fieldname_name != '') $_REQUEST[$fieldname_name.'~'.$fieldname_type] = $field_value; //add to $_REQUEST for filter
	}
}

// Loop through the form REQUEST
foreach ($_REQUEST as $key => $value) {
	$fld = split('~',$key);
	if (strlen($value) > 0 && is_array($fld) && count($fld) > 1) {
		//N.B use '|' for aliased tables as the REQUEST array replaces '.' with '_' .. resulting in e.g. a_area not a.area
		$fld[0] = str_replace('|','.',trim($fld[0]));

		//N.B Must be after replace of | for . or smarty will try to use modifier. Re-assign search filter vars
		$smarty->assign($fld[0],$value);
		//echo 'assigning:'.$fld[0].' - '.$value.'<br />';
		$qry = '';
		if ($fld[0] != 'search_text') { // skip the multiple field search, see below ths code block
			switch (substr($fld[1], 0, 2)) {
				case 't': //text
							$qry = $table_name.$fld[0]." like '%".str_replace("'","\'",trim($value))."%' ";
							break;

				case 'n': //number
							$qry = $table_name.$fld[0]." = ".str_replace("'","\'",trim($value))." ";
							break;

				case 'd': //date
							$qry = "day($table_name$fld[0]) = day('".str_replace("'","\'",trim($value))."') and month($table_name$fld[0]) = month('".str_replace("'","\'",trim($value))."') and year($table_name$fld[0]) = year('".str_replace("'","\'",trim($value))."') ";
							break;

				case 'sd': //date
							$qry = $table_name.$fld[0]." >= '".str_replace("'","\'",trim($value))." 00:00:00' ";
							$smarty->assign("$fld[0]"."sd",$value);
							break;

				case 'ed': //date
							$qry = $table_name.$fld[0]." <= '".str_replace("'","\'",trim($value))." 23:59:59' ";
							$smarty->assign("$fld[0]"."ed",$value);
							break;

			}
			if ($fld[1] != 'i' && $fld[1] != 'd1' && $fld[1] != 'd2' && is_array($fld) && count($fld) > 1) {
				$filter .= ((strlen($filter) > 0) ? ' AND ' : ' WHERE ').$qry;
			}
		}
	} //end check for 2 values
	unset($fld);
} //end post for-each loop


// -------------------------------------------------------------------------------------
// search filter for multiple fields is a CSV (Comma Seperated Values) list
// Please note, that unlike the filter above, OR instead of AND has to be used and this
// is text specific search.
// The output gets attached to the above generated $filter string which is used in an SQL query.
if ($search_text != '') {
	if (isset($filter_search_fields) && !empty($filter_search_fields) && strlen($filter_search_fields) > 0) {

		// remove the appended types
		$filter_search_fields = str_replace('~t','',$filter_search_fields);
		$filter_search_fields = str_replace('~n','',$filter_search_fields);
		$filter_search_fields = str_replace('~i','',$filter_search_fields);
		$filter_search_fields = str_replace('~sd','',$filter_search_fields);
		$filter_search_fields = str_replace('~ed','',$filter_search_fields);

		// convert to an array and loop through it
		$filter_search_fields_array = explode(',',$filter_search_fields);
		$filter_temp = '';

		// get the search text and remove quotes
		$search_text_cleaned = trim($search_text."");
		$search_text_cleaned = str_replace("'","",$search_text_cleaned);
		$search_text_cleaned = str_replace('"',"",$search_text_cleaned);
		if (count($filter_search_fields_array) > 0) {

			//use the below for standard simple matching.
			for ($i = 0; $i < count($filter_search_fields_array); $i++) {
				if ($filter_temp != '') $filter_temp .= ' OR ';
				$filter_temp .= $filter_search_fields_array[$i]." LIKE '%".$search_text_cleaned."%'";
			}
			/**/

			//use the below for enhanced freetext matching.
			//N.B  fields must be added to fulltext index to work. e.g. ALTER TABLE product ADD FULLTEXT(product_name, product_code);
			$select_score = ''; //", MATCH(".implode(",",$filter_search_fields_array).") AGAINST ('".$search_text_cleaned."')  AS score ";
			//$filter_temp .=	" MATCH(".implode(",",$filter_search_fields_array).") AGAINST ('".$search_text_cleaned."') ";
			//$filter_temp .=	" HAVING ".implode(",",$filter_search_fields_array)." like LIKE '%".$search_text_cleaned."%' ";
			//boolean mode messing with category names like k-way - is interpreted.
			//$filter_temp .=	" MATCH(".implode(",",$filter_search_fields_array).") AGAINST ('".$search_text_cleaned."' IN BOOLEAN MODE ) ";
			$order_score = ''; //" score DESC, ";

		}
		// attach the result to the $filter string
		if ($filter != '') {
			$filter .= ' AND ('.$filter_temp.')';
		} else {
			$filter .= ' WHERE ('.$filter_temp.')';
		}
		unset($filter_temp);
	}
}

//echo $filter;

?>