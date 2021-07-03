<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tickets</title>
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
			<li><a href="/administration/tickets/" title="Jobs">Tickets</a></li>
			<li>{if isset($ticketData)}Edit Ticket{else}Add a Ticket{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($ticketData)}Edit Ticket{else}Add a Ticket{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/administration/tickets/details.php{if isset($ticketData)}?code={$ticketData.ticket_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="ticket_name" id="ticket_name" value="{$ticketData.ticket_name}" size="30" />
				{if isset($errorArray.ticket_name)}<br /><span class="error">{$errorArray.ticket_name}</span>{/if}
			</td>
			<td>
				<h4 class="error">Event:</h4><br />
				<select id="event_code" name="event_code">
					<option value=""> --- </option>
					{html_options options=$eventPairs selected=$ticketData.event_code}
				</select>
				{if isset($errorArray.event_code)}<br /><span class="error">{$errorArray.event_code}</span>{/if}
			</td>					
          </tr>
          <tr>
			<td>
				<h4 class="error">Price:</h4><br />
				<input type="text" name="ticket_price" id="ticket_price" value="{$ticketData.ticket_price}" size="10" />
				{if isset($errorArray.ticket_price)}<br /><span class="error">{$errorArray.ticket_price}</span>{/if}
			</td>	
			<td>
				<h4 class="error">Admission Number:</h4><br />
				<select id="ticket_admit" name="ticket_admit">
					<option value=""> ---- </option>
					<option value="ONE" {if $ticketData.ticket_admit eq 'ONE'} selected{/if}>ONE</option>
					<option value="TWO" {if $ticketData.ticket_admit eq 'TWO'} selected{/if}>TWO</option>
					<option value="THREE" {if $ticketData.ticket_admit eq 'THREE'} selected{/if}>THREE</option>
					<option value="FOUR" {if $ticketData.ticket_admit eq 'FOUR'} selected{/if}>FOUR</option>
					<option value="FIVE" {if $ticketData.ticket_admit eq 'FIVE'} selected{/if}>FIVE</option>
				</select>
				{if isset($errorArray.ticket_admit)}<br /><span class="error">{$errorArray.ticket_admit}</span>{/if}
			</td>			
          </tr>		  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/administration/tickets/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
