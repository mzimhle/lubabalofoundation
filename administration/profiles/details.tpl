<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profiles</title>
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
			<li><a href="/administration/profiles/" title="Jobs">Profiles</a></li>
			<li>{if isset($profileData)}Edit Profile{else}Add a Profile{/if}</li>
        </ul>
	</div><!--breadcrumb-->   
	<div class="inner"> 
      <h2>{if isset($profileData)}Edit Profile{else}Add a Profile{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/profiles/details.php{if isset($profileData)}?code={$profileData.profile_code}{/if}" method="post" enctype="multipart/form-data">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td><h4 class="error">Name:</h4>
				<br /><input type="text" name="profile_name" id="profile_name" value="{$profileData.profile_name}" size="30" />
				{if isset($errorArray.profile_name)}<br /><span class="error">{$errorArray.profile_name}</span>{/if}
			</td>	
			<td><h4 class="error">Surname:</h4><br />
				<input type="text" name="profile_surname" id="profile_surname" value="{$profileData.profile_surname}" size="30" />
				{if isset($errorArray.profile_surname)}<br /><span class="error">{$errorArray.profile_surname}</span>{/if}
			</td>	
			<td>
				<h4 {if isset($errorArray.profile_cellphone)}class="error"{/if}>Cellphone:</h4>
				<input type="text" name="profile_cellphone" id="profile_cellphone" value="{$profileData.profile_cellphone}" size="30" />
				{if isset($errorArray.profile_cellphone)}<br /><span class="error">{$errorArray.profile_cellphone}</span>{/if}
			</td>				
          </tr>
          <tr>
			<td>
				<h4 {if isset($errorArray.profile_email)}class="error"{/if}>Email:</h4><br />
				<input type="text" name="profile_email" id="profile_email" value="{$profileData.profile_email}" size="30" />
				{if isset($errorArray.profile_email)}<br /><span class="error">{$errorArray.profile_email}</span>{/if}
			</td>		  
			<td>
				<h4 class="error">Birthday:</h4><br />
				<input type="text" name="profile_birthday" id="profile_birthday" value="{$profileData.profile_birthday}" size="10" />
				{if isset($errorArray.profile_birthday)}<br /><span class="error">{$errorArray.profile_birthday}</span>{/if}
			</td>	
			<td>
				<h4 {if isset($errorArray.profile_school)}class="error"{/if}>School:</h4><br />
				<input type="text" name="profile_school" id="profile_school" value="{$profileData.profile_school}" size="30" />
				{if isset($errorArray.profile_school)}<br /><span class="error">{$errorArray.profile_school}</span>{/if}
			</td>
          </tr>
          <tr>
			<td><h4 {if isset($errorArray.profile_grade)}class="error"{/if}>Grade:</h4><br />
				<select id="profile_grade" name="profile_grade">
					<option value=""> --- </option>
					<option {if $profileData.profile_grade eq '1'}selected{/if} value="1">Grade 1</option>
					<option {if $profileData.profile_grade eq '2'}selected{/if} value="2">Grade 2</option>
					<option {if $profileData.profile_grade eq '3'}selected{/if} value="3">Grade 3</option>
					<option {if $profileData.profile_grade eq '4'}selected{/if} value="4">Grade 4</option>
					<option {if $profileData.profile_grade eq '5'}selected{/if} value="5">Grade 5</option>
					<option {if $profileData.profile_grade eq '6'}selected{/if} value="6">Grade 6</option>
					<option {if $profileData.profile_grade eq '7'}selected{/if} value="7">Grade 7</option>
					<option {if $profileData.profile_grade eq '8'}selected{/if} value="8">Grade 8</option>
					<option {if $profileData.profile_grade eq '9'}selected{/if} value="9">Grade 9</option>
					<option {if $profileData.profile_grade eq '10'}selected{/if} value="10">Grade 10</option>
					<option {if $profileData.profile_grade eq '11'}selected{/if} value="11">Grade 11</option>
					<option {if $profileData.profile_grade eq '12'}selected{/if} value="12">Grade 12</option>
				</select>
				{if isset($errorArray.profile_grade)}<br /><span class="error">{$errorArray.profile_grade}</span>{/if}
			</td>
			<td><h4 class="error">Player profile:</h4><br />
				<textarea name="profile_player" id="profile_player" rows="3" cols="30">{$profileData.profile_player}</textarea>
				{if isset($errorArray.profile_player)}<br /><span class="error">{$errorArray.profile_player}</span>{/if}
			</td>		
			<td><h4 {if isset($errorArray.profile_address)}class="error"{/if}>Address:</h4><br />
				<textarea name="profile_address" id="profile_address" rows="3" cols="30">{$profileData.profile_address}</textarea>
				{if isset($errorArray.profile_address)}<br /><span class="error">{$errorArray.profile_address}</span>{/if}
			</td>				
          </tr>		
          <tr>
			<td valign="top">
				<h4 {if isset($errorArray.profile_image)}class="error"{/if} >User Image:</h4> Images to upload: gif, png, jpg and jpeg<br /><br />
				<input type="file" id="profile_image" name="profile_image" />
				{if isset($errorArray.profile_image)}<br /><br /><span class="error">{$errorArray.profile_image}</span>{/if}
			</td>
			<td valign="top" colspan="2">
				{if !isset($profileData)} 
					<img src="/media/profile/avatar.jpg" />
				{else}
					{if $profileData.profile_image_path eq ''}
						<img src="/media/profile/avatar.jpg" />
					{else}
						<img src="{$profileData.profile_image_path}tmb_{$profileData.profile_image_name}{$profileData.profile_image_ext}" />
					{/if}
				{/if}
			</td>
          </tr>	
			<tr>
			<td colspan="3"><h4 class="error">Player Bio:</h4><br />
				<textarea name="profile_description" id="profile_description" rows="10" cols="90">{$profileData.profile_description}</textarea>
				{if isset($errorArray.profile_description)}<br /><span class="error">{$errorArray.profile_description}</span>{/if}
			</td>				
			</tr>			
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/profiles/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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
	nicEditors.findEditor('profile_description').saveContent();
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	
	$( "#profile_birthday" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true});
	
	$(document).ready(function() {			
		new nicEditor({
			iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
			buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript'],
			uploadURI : '/library/javascript/nicedit/nicUpload.php',
		}).panelInstance('profile_description');				
	});
});

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
