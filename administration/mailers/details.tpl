<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mailer</title>
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
			<li><a href="/administration/mailers/" title="Jobs">Mailers</a></li>
			<li>{if isset($mailerData)}Edit Mailer{else}Add a Mailer{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($mailerData)}Edit Mailer{else}Add a Mailer{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($mailerData)}/administration/mailers/mail.php?code={$mailerData.mailer_code}{else}#{/if}" title="Mail">Mail</a></li>
			<li><a href="{if isset($mailerData)}/administration/mailers/comms.php?code={$mailerData.mailer_code}{else}#{/if}" title="Comms">Comms</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/mailers/details.php{if isset($mailerData)}?code={$mailerData.mailer_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Subject:</h4><br />
				<input type="text" name="mailer_title" id="mailer_title" value="{$mailerData.mailer_title}" size="60" />
				{if isset($errorArray.mailer_title)}<br /><span class="error">{$errorArray.mailer_title}</span>{/if}
			</td>					
          </tr>	
          <tr>
			<td>
				<h4>Link:</h4><br />
				<br /><span class="success">{$mailerData.mailer_link}</span>
			</td>
          </tr>	
          <tr>
			<td>
				<h4>Note:</h4><br />
				To add peoples names on the mailer please add the following variables on the mailer: <br /><br />
					<table>					
					<tr><td>[fullname]</td><td>=</td><td>Participant Name and Surname</td></tr>
					<tr><td>[name]</td><td>=</td><td>Participant Name only</td></tr>
					<tr><td>[surname]</td><td>=</td><td>Participant Surname only</td></tr>
					<tr><td>[cellphone]</td><td>=</td><td>Participant cellphone</td></tr>
					<tr><td>[email]</td><td>=</td><td>Participant email</td></tr>
					<tr><td>[area]</td><td>=</td><td>Participant area</td></tr>
					</table>
			</td>
          </tr>			  
          <tr>
			<td colspan="2">
				<h4 class="error">Content:</h4><br />
				<textarea id="mailer_content" name="mailer_content" cols="100" rows="10">{$mailerData.mailer_content}</textarea>
				{if isset($errorArray.mailer_content)}<br /><span class="error">{$errorArray.mailer_content}</span>{/if}
			</td>
          </tr>		  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/mailers/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
	<br /><br />	
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
	}).panelInstance('mailer_content');				
});

function submitForm() {
	nicEditors.findEditor('mailer_content').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
