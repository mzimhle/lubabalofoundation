<?php
//requires $smarty and $conn which are usually found in /includes/config.php

/**
 * Smarty {function_javascript_head} function plugin
 *
 * Type:     function
 * Name:     javascript_head
 * Date:     April 11, 2007
 * Purpose:  render JavaScript includes based on parameters
 * @author   Bernhard Ernst <bernhard at clickthinking dot com>
 * @version  1.0
 * @return HTML
 */
function smarty_function_javascript_head($params, &$smarty) {
	global $calendar;
	global $conn, $smarty;
	global $file_uploader;
	global $jqueryjdmenu;
	global $jquery;
	global $jqueryflash;
	global $jquerytabs;
	global $jqueryform;
	global $jquerythickbox;
	global $jscookmenu;
	global $optiontransfer;
	global $pick_media;
	global $qforms;
	global $tiny_mce;
	global $yahoo_library;
	global $yahoo_library_ext;
	global $tinymce;
	global $jquploader;
	extract($params);

	// set some boolean toggle flags
	$calendar = (!isset($calendar) || !$calendar || $calendar == '' || $calendar == '0') ? false : true;
	$file_uploader = (!isset($file_uploader) || !$file_uploader || $file_uploader == '' || $file_uploader == '0') ? false : true;
	$jqueryjdmenu = (!isset($jqueryjdmenu) || !$jqueryjdmenu || $jqueryjdmenu == '' || $jqueryjdmenu == '0') ? false : true;
	$jquery = (!isset($jquery) || !$jquery || $jquery == '' || $jquery == '0') ? false : true;
	$jqueryflash = (!isset($jqueryflash) || !$jqueryflash || $jqueryflash == '' || $jqueryflash == '0') ? false : true;
	$jquerymodal = (!isset($jquerymodal) || !$jquerymodal || $jquerymodal == '' || $jquerymodal == '0') ? false : true;
	$jqueryform = (!isset($jqueryform) || !$jqueryform || $jqueryform == '' || $jqueryform == '0') ? false : true;
	$jquerytabs = (!isset($jquerytabs) || !$jquerytabs || $jquerytabs == '' || $jquerytabs == '0') ? false : true;
	$jscookmenu = (!isset($jscookmenu) || !$jscookmenu || $jscookmenu == '' || $jscookmenu == '0') ? false : true;
	$optiontransfer = (!isset($optiontransfer) || !$optiontransfer || $optiontransfer == '' || $optiontransfer == '0') ? false : true;
	$pick_media = (!isset($pick_media) || !$pick_media || $pick_media == '' || $pick_media == '0') ? false : true;
	$qforms = (!isset($qforms) || !$qforms || $qforms == '' || $qforms == '0') ? false : true;
	$jquerythickbox = (!isset($jquerythickbox) || !$jquerythickbox || $jquerythickbox == '' || $jquerythickbox == '0') ? false : true;
	$tiny_mce = (!isset($tiny_mce) || !$tiny_mce || $tiny_mce == '' || $tiny_mce == '0') ? false : true;
	$tiny_mce = (!isset($tinymce) || !$tinymce || $tinymce == '' || $tinymce == '0') ? false : true;	
	$yahoo_library = (!isset($yahoo_library) || !$yahoo_library || $yahoo_library == '' || $yahoo_library == '0') ? false : true;
	$yahoo_library_ext = (!isset($yahoo_library_ext) || !$yahoo_library_ext || $yahoo_library_ext == '' || $yahoo_library_ext == '0') ? false : true;

	// check for dependencies
	if ($jqueryflash) $jquery = true;
	if ($jquerymodal) $jquery = true;
	if ($jquerytabs) $jquery = true;
	if ($jqueryjdmenu) $jquery = true;
	if ($jqueryform) $jquery = true;
	if ($jquerythickbox) $jquery = true;
	if ($yahoo_library_ext) $yahoo_library = true;

	// get the folder to differentiate between back-end and front-end current location
	$script_name = $_SERVER['SCRIPT_NAME'];
	$script_name_array = explode("/",$script_name);
	$is_backend = ($script_name_array[1] == 'admin') ? true : false;
	$css_name = ($script_name_array[1] == 'admin') ? '_backend' : '';
	unset($script_name_array);
	unset($script_name);

	// compile the HTML
	$html = '';
	if ($jquery) {
		$html .= '
<!--// Start JQuery //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery-1.2.6.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.pngfix/jquery.pngFix.pack.js"></script>
<!--// End JQuery //-->
';
	}

	if ($qforms) {
		$html .= '
<!--// Start Qforms & Mask Library Kudos: PengoWorks [http://www.pengoworks.com/] //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/lib/qforms.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/lib/masks.js"></script>
<script language="JavaScript" type="text/javascript">
// include qforms library
qFormAPI.setLibraryPath("/javascript/lib/");
qFormAPI.include("*");
</script>
<!--// End Qforms & Mask Library //-->
';
	}

	if ($optiontransfer) {
		$html .= '
<!--// Start Matt Kruse Library Kudos: Matt Kruse [http://www.mattkruse.com/] //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/mattkruse/OptionTransfer.js"></script>
<!--// End Matt Kruse Library //-->
';
	}

	if ($yahoo_library) {
		$html .= '
<!--// Start Yahoo Library Kudos Yahoo Dev Team [http://developer.yahoo.com/yui/] //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui/build/yahoo/yahoo-min.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui/build/event/event-min.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui/build/dom/dom-min.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui/build/connection/connection-min.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui/build/tabview/tabview.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui/build/container/container-min.js"></script>
<!--// End Yahoo Library //-->
';
	}

	if ($yahoo_library_ext) {
		$html .= '
<!--// Start Yahoo Ext Library Kudos: Jack Slocum [http://www.jackslocum.com/]  //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui-ext/yui-utilities.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui-ext/ext-yui-adapter.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/yui-ext/ext-all.js"></script>
<!--// End Jack Solcum\'s Yahoo Ext Library //-->
';
	}

if ($jquploader) {
		$html .= '

<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.jqUploader/jquery.flash.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.jqUploader/jquery.jqUploader.js"></script>
';
	}


	if ($tiny_mce) {
		$html .= '
<!--// Start TinyMCE Library Kudos: Moxiecode [http://tinymce.moxiecode.com/] //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/clickthinking/autoembed_tinymce.js" ></script>

<!--<script language="JavaScript" type="text/javascript" src="/library/javascript/tinymce/jscripts/tiny_mce/tiny_mce_popup.js"></script>-->
<!--// End TinyMCE Library //-->
';
	}

	if ($jscookmenu) {
		$html .= '
<!--// Start JSCookMenu //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/jsCookMenu/JSCookMenu.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jsCookMenu/themeOffice/theme.js"></script>
<link rel="stylesheet" type="text/css" href="/javascript/jsCookMenu/themeOffice/theme.css" />
<!--// End JSCookMenu //-->
';
	}

	
	if ($jqueryflash) {
		$html .= '<!--// Start jQueryFlash //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.flash/jquery.flash.js"></script>
<!--// End jQueryFlash //-->
';
	}

	if ($jquerytabs) {
		$html .= '
<!--// Start JQueryTabs //-->
<script language="javascript" type="text/javascript" src="/library/javascript/jquery/jquery.tabs/jquery.tabs.js"></script>';
		if ($is_backend) {
			$html .= '
<link rel="stylesheet" type="text/css" href="/css/jquery.tabs_admin.css" />';
		} else {
			$html .= '
<link rel="stylesheet" type="text/css" href="/javascript/jquery/jquery.tabs/jquery.tabs.css" />';
		}
		$html .= '
<link rel="stylesheet" type="text/css" href="/javascript/jquery/jquery.tabs/jquery.tabs-ie.css" />
<!--// End JQueryTabs //-->
';
	}

	if ($jquerymodal) {
		$html .= '
<!--// Start JQueryModal //-->
<script language="javascript" type="text/javascript" src="/library/javascript/jquery/jquery.jqmodal/jqModal.js"></script>
<link rel="stylesheet" type="text/css" href="';
		if ($is_backend) {
			$html .= '/css/backend/jqModal.custom.css';
		} else {
			//$html .= '/javascript/jquery/jquery.jqmodal/jqModal.css';
			$html .= '/css/jqModal.custom.css';
		}
		$html .= '" />
<!--// End JQueryModal //-->
';
	}

	if ($jquerythickbox) {
		$html .= '
<!--// Start jQueryThickbox //-->
<link rel="stylesheet" type="text/css" media="screen" href="/javascript/jquery/jquery.thickbox/thickbox.css" />
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.thickbox/thickbox-compressed.js"></script>
<!--// End jQueryThickbox //-->
';
	}

	if ($jqueryform) {
		$html .= '
<!--// Start jQueryForm //-->
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.form.js"></script>
<!--// End jQueryForm //-->
';
	}

	if ($jqueryjdmenu) {
/*
		$html .= '
<!--// Start jQueryJDMenu //-->
<link rel="stylesheet" type="text/css" href="';
		if ($is_backend) {
			$html .= '/css/jdMenuBackend.css';
		} else {
			$html .= '/javascript/jquery/jquery.jdmenu/jdMenu.css';
		}
		$html .= '" />

<link rel="stylesheet" type="text/css" href="/javascript/jquery/jquery.jdmenu/jdMenu.custom.css" />
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.bgiframe.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.dimensions.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.jdmenu/jquery.jdMenu.js"></script>
<!--// End jQueryJDMenu //-->
';


*/
		$html .= '
<!--// Start jQueryJDMenu //-->';
		if ($is_backend) {
			$html .= '
<link rel="stylesheet" type="text/css" href="/css/backend/jdMenu.css" />
<link rel="stylesheet" type="text/css" href="/css/backend/jdMenu.custom.css" />';
		} else {
			$html .= '
<link rel="stylesheet" type="text/css" href="/css/jdMenu.css" />
<link rel="stylesheet" type="text/css" href="/css/jdMenu.custom.css" />';
		}
//<!--<link rel="stylesheet" type="text/css" href="/javascript/jquery/jquery.jdmenu/jdMenu.css" />
//<link rel="stylesheet" type="text/css" href="/javascript/jquery/jquery.jdmenu/jdMenu.custom.css" />-->
		$html .= '
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.bgiframe.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.dimensions.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.jdmenu/jquery.jdMenu.js"></script>
<!--// End jQueryJDMenu //--> ';

	}

	if ($calendar) {
	/*
		$html .= '
<!--// Start Calendar //-->
<link rel="stylesheet" type="text/css" href="/javascript/calendar/calendar-blue.css" />
<script language="JavaScript" type="text/javascript" src="/library/javascript/calendar/calendar.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/calendar/calendar-en.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/javascript/calendar/calendar-setup.js"></script>
<!--// End Calendar //-->*/
$html.='<script language="JavaScript" type="text/javascript" src="/library/javascript/jquery/jquery.ui-datepicker/ui.datepicker.js"></script>
<link href="/library/javascript/jquery/jquery.ui-datepicker/ui.datepicker.css" rel="stylesheet" type="text/css" />
<!--// End Calendar //--> ';
	}

	if ($pick_media) {
		$html .= '
<!--// Start media picker function //-->
<script language="JavaScript" type="text/javascript">
function pickMedia(field) {
	var mp = window.open(\'/media/media_picker.php?f=\'+escape(field),\'MediaPicker\',\'width=475, height=250, top=85, left=200, scrollbars=yes\');
}
</script>
<!--// End media picker function //-->
';
	}

	if ($file_uploader) {
		$html .= '
<!--// Start file uploader function //-->
<script language="JavaScript" type="text/javascript">
function popup_file_uploader(field, target_folder) {
	var iu = window.open(\'/includes/uploader/fileuploader.php?f=\'+escape(field)+\'&folder=\'+target_folder,\'fileuploader\',\'width=475, height=250, top=85, left=200, scrollbars=yes\');
}
</script>
<!--// End image uploader function //-->
';
	}

	// clean up
	unset($is_backend);
	unset($calendar);
	unset($file_uploader);
	unset($jdmenu);
	unset($jquery);
	unset($jqueryflash);
	unset($jqueryform);
	unset($jscookmenu);
	unset($optiontransfer);
	unset($pick_media);
	unset($qforms);
	unset($thickbox);
	unset($tiny_mce);
	unset($yahoo_library);
	unset($yahoo_library_ext);

	return($html);
} // end: javascript_head

?>