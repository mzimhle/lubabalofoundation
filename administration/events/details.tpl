<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Events</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'}
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/events/" title="Jobs">Events</a></li>
			<li>{if isset($eventData)}Edit Event{else}Add a Event{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($eventData)}Edit Event{else}Add a Event{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/events/details.php{if isset($eventData)}?code={$eventData.event_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="event_name" id="event_name" value="{$eventData.event_name}" size="60" />
				{if isset($errorArray.event_name)}<br /><span class="error">{$errorArray.event_name}</span>{/if}
			</td>
			<td>
				<h4 class="error">Date of Event:</h4><br />
				<input type="text" name="event_date" id="event_date" value="{$eventData.event_date}" size="20" readonly />
				{if isset($errorArray.event_date)}<br /><span class="error">{$errorArray.event_date}</span>{/if}
			</td>					
          </tr>
          <tr>
			<td>
				<h4 class="error">Address:</h4><br />
				<input type="text" name="event_address" id="event_address" value="{$eventData.event_address}" size="60" />
				{if isset($errorArray.event_address)}<br /><span class="error">{$errorArray.event_address}</span>{/if}
			</td>	
			<td>
				<h4 class="error">Area:</h4><br />
				<input type="text" name="area_name" id="area_name" value="{$eventData.area_path}" size="60" />
				<input type="hidden" name="area_code" id="area_code" value="{$eventData.area_code}" />
				{if isset($errorArray.area_code)}<br /><span class="error">{$errorArray.area_code}</span>{/if}
			</td>			
          </tr>		   
          <tr>
			<td colspan="2">
				<h4 class="error">Description:</h4><br />
				<textarea id="event_description" name="event_description" cols="100" rows="10">{$eventData.event_description}</textarea>
				{if isset($errorArray.event_description)}<br /><span class="error">{$errorArray.event_description}</span>{/if}
			</td>
          </tr>		  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/events/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function() {			
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript', 'upload'],
		uploadURI : '/library/javascript/nicedit/nicUpload.php',
	}).panelInstance('event_description');				
});

function submitForm() {
	nicEditors.findEditor('event_description').saveContent();
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	
	$("#event_date").datetimepicker({
		dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true
	});	
	
	$( "#area_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == '') {
				$('#area_name').html('');
				$('#area_code').val('');					
			} else {
				$('#area_name').html('<b>' + ui.item.value + '</b>');
				$('#area_code').val(ui.item.id);	
			}
			$('#area_name').val('');										
		}
	});
	
});

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
