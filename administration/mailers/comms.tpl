<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mailer</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
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
			<li>{$mailerData.mailer_title}</li>
			<li>Mail to participants</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$mailerData.mailer_title}</h2>
    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul >             
            <li><a href="/administration/mailers/details.php?code={$mailerData.mailer_code}" title="Details">Details</a></li>
			<li><a href="/administration/mailers/mail.php?code={$mailerData.mailer_code}" title="Mail">Mail</a></li>
			<li class="active"><a href="#" title="Details">Comms</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	<h4>Mailer Results</h4><br />
	<form id="detailsForm" name="detailsForm" action="/administration/mailers/mail.php?code={$mailerData.mailer_code}" method="post" enctype="multipart/form-data">
		<table id="dataTable" border="0" cellspacing="0" cellpadding="5" width="100%">
			<thead>
			<tr>
			<th>Sent</th>
			<th>Name</th>
			<th>Email</th>
			<th>Cellphone</th>
			<th>Result</th>
			<th>Mailer</th>
			</tr>
		   </thead>
		   <tbody> 
		  {foreach from=$commData item=item}
		  <tr class="{if $item._comms_sent eq '1'}success{else}error{/if}">
			<td align="left">{$item._comms_added|date_format}</td>
			<td align="left">{$item.participant_name} {$item.participant_surname}</td>
			<td align="left">{$item.participant_email}</td>
			<td align="left">{$item.participant_cellphone}</td>
			<td align="left">{$item._comms_output}</td>
			<td align="left"><a href="/mailers/view/{$item._comms_code}" target="_blank">View Mailer</a></td>
		  </tr>
		  {/foreach}     
		  </tbody>
		</table>
	</form>
	</div>
	<div class="clearer"><!-- --></div>	

    </div><!--inner-->
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='administration/includes/footer.php'}
</div>
</body>
</html>
