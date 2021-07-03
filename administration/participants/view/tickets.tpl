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
			<li><a href="/administration/participants/" title="">Participants</a></li>
			<li><a href="/administration/participants/view/" title="">View</a></li>
			<li><a href="/administration/participants/view/details.php?code={$participantData.participant_code}" title="">{$participantData.participant_name} {$participantData.participant_surname}</a></li>
			<li>Tickets</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$participantData.participant_name} {$participantData.participant_surname} Tickets</h2>

    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul >             
			<li><a href="/administration/participants/view/details.php?code={$participantData.participant_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Tickets">Tickets</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	<h4>Tickets:</h4><br />
	<form id="ticketaddForm" name="ticketaddForm" action="/administration/participants/view/tickets.php?code={$participantData.participant_code}" method="post" enctype="multipart/form-data">
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>			
			<th>Reference</th>
			<th>Ticket</th>
			<th>Payment Date</th>
			<th>Upload File</th>
			<th>Sent Date</th>
			<th></th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$participantticketData item=item}
		<tr>							
			<td>{$item.participantticket_reference}</td>
			<td>{$item.ticket_name} (R {$item.ticket_price})</td>
			<td>{$item.participantticket_date}</td>
			<td>{if $item.participantticket_filename neq ''}<a href="{$item.participantticket_filepath}" target="_blank">{$item.participantticket_filename|truncate:30:"..."}</a>{else}N/A{/if}</td>
			<td>{$item.participantticket_notify|default:"Ticket not sent"}</td>
			<td><button onclick="sendticket('{$item.participantticket_code}'); return false;">Send</button></td>	
			<td><button onclick="deleteitem('{$item.participantticket_code}'); return false;">Delete</button></td>
		</tr>
		{/foreach}		
		<input type="hidden" name="participanticketadd" id="participanticketadd" value="1" />
		<tr>
			<td>
				<input type="text" id="participantticket_reference" name="participantticket_reference" value="" size="10" />
				{if isset($errorArray.participantticket_reference)}<br /><span class="error">{$errorArray.participantticket_reference}</span>{/if}
			</td>							
			<td>
				<select id="ticket_code" name="ticket_code">
					<option value=""> --- </option>
					{html_options options=$ticketPairs selected=$participantData.ticket_code}
				</select>
				{if isset($errorArray.ticket_code)}<br /><span class="error">{$errorArray.ticket_code}</span>{/if}
			</td>
			<td>
				<input type="text" id="participantticket_date" name="participantticket_date" value="" size="10" />
				{if isset($errorArray.participantticket_date)}<br /><span class="error">{$errorArray.participantticket_date}</span>{/if}
			</td>
			<td>
				<input type="file" id="participantticket_file" name="participantticket_file" />
				{if isset($errorArray.participantticket_file)}<br /><span class="error">{$errorArray.participantticket_file}</span>{/if}
			</td>
			<td colspan="3"><button onclick="additem();">Add Item</button></td>
		</tr>								
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
{literal}
<script type="text/javascript">
$( document ).ready(function() {
	$( "#participantticket_date" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true});	
});	

function additem() {
	document.forms.ticketaddForm.submit();					 
}

function sendticket(id) {					
	if(confirm('Are you sure you want to send this ticket to the participant?')) {
		$.ajax({ 
				type: "GET",
				url: "tickets.php?code={/literal}{$participantData.participant_code}{literal}",
				data: "sendticket="+id,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Email sent!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}	
	return false;	
}

function deleteitem(code) {
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({
			type: "GET",
			url: "tickets.php?code={/literal}{$participantData.participant_code}{literal}",
			data: "deleteitem="+code,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					alert('Deleted');
					window.location.href = '/administration/participants/view/tickets.php?code={/literal}{$participantData.participant_code}{literal}';
				} else {
					alert(data.message);
				}
			}
		});		
	}
	return false;			

}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
