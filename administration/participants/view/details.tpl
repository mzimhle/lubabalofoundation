<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Participants</title>
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
			<li><a href="/administration/participants/" title="Jobs">Participants</a></li>
			<li><a href="/administration/participants/view/" title="Jobs">View</a></li>
			<li>{if isset($participantData)}Edit Participant{else}Add a Participant{/if}</li>
        </ul>
	</div><!--breadcrumb-->   
	<div class="inner"> 
      <h2>{if isset($participantData)}Edit Participant{else}Add a Participant{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($participantData)}/administration/participants/view/tickets.php?code={$participantData.participant_code}{else}#{/if}" title="Tickets">Tickets</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/participants/view/details.php{if isset($participantData)}?code={$participantData.participant_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td><h4 class="error">Name:</h4>
				<br /><input type="text" name="participant_name" id="participant_name" value="{$participantData.participant_name}" size="30" />
				{if isset($errorArray.participant_name)}<br /><span class="error">{$errorArray.participant_name}</span>{/if}
			</td>	
			<td><h4 class="error">Surname:</h4><br />
				<input type="text" name="participant_surname" id="participant_surname" value="{$participantData.participant_surname}" size="30" />
				{if isset($errorArray.participant_surname)}<br /><span class="error">{$errorArray.participant_surname}</span>{/if}
			</td>	
			<td>
				<h4>Area:</h4>
				<input type="text" name="area_name" id="area_name" value="{$participantData.area_path}" size="30" />
				<input type="hidden" name="area_code" id="area_code" value="{$participantData.area_code}" />
				{if isset($errorArray.area_code)}<br /><span class="error">{$errorArray.area_code}</span>{/if}
			</td>				
          </tr>
          <tr>
			<td><h4 class="error">Category:</h4><br />
				<select id="participantcategory_code" name="participantcategory_code">
					<option value=""> --- </option>
					{html_options options=$categorypairs selected=$participantData.participantcategory_code}
				</select>
				{if isset($errorArray.participantcategory_code)}<br /><span class="error">{$errorArray.participantcategory_code}</span>{/if}
			</td>
			<td>
				<h4 class="error">Email:</h4><br />
				<input type="text" name="participant_email" id="participant_email" value="{$participantData.participant_email}" size="30" />
				{if isset($errorArray.participant_email)}<br /><span class="error">{$errorArray.participant_email}</span>{/if}
			</td>	
			<td><h4 {if isset($errorArray.participant_gender)}class="error"{/if}>Gender:</h4><br />
				<select id="participant_gender" name="participant_gender">
					<option value=""> --- </option>
					<option {if $participantData.participant_gender eq 'female'}selected{/if} value="female">Female</option>
					<option {if $participantData.participant_gender eq 'male'}selected{/if} value="male">Male</option>
				</select>
				{if isset($errorArray.participant_gender)}<br /><span class="error">{$errorArray.participant_gender}</span>{/if}
			</td>
          </tr>
          <tr>
			<td><h4 {if isset($errorArray.participant_cellphone)}class="error"{/if}>Cell:</h4><br />
				<input type="text" name="participant_cellphone" id="participant_cellphone" value="{$participantData.participant_cellphone}" size="30" />
				{if isset($errorArray.participant_cellphone)}<br /><span class="error">{$errorArray.participant_cellphone}</span>{/if}
			</td>	
			<td><h4 {if isset($errorArray.participant_telephone)}class="error"{/if}>Telephone:</h4><br />
				<input type="text" name="participant_telephone" id="participant_telephone" value="{$participantData.participant_telephone}" size="30" />
				{if isset($errorArray.participant_telephone)}<br /><span class="error">{$errorArray.participant_telephone}</span>{/if}
			</td>	
			<td></td>				
          </tr>		  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/participants/view/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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

function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	
	$( "#participant_dateofbirth" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true});
	
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
