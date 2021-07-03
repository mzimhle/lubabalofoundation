<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Participant Tickets</title>
{include_php file='administration/includes/css.php'}
{include_php file='administration/includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='administration/includes/header.php'}
	<div id="breadcrumb">
        <ul>
            <li><a href="/administration/" title="Home">Home</a></li>
			<li><a href="/administration/participants/" title="participants">Participants</a></li>
			<li><a href="/administration/participants/participanttickets/" title="participanttickets">Participant Tickets</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Participant Tickets</h2>
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>			
					<th>Pay Date</th>
					<th>Pariticipant</th>
					<th>Event</th>
					<th>Ticket</th>
					<th>Price</th>										
					<th>Reference</th>		
					<th>Payment Proof File</th>	
					<th>Email Sent Date</th>
					<th></th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				{foreach from=$participantticketData item=item}
				<tr>							
					<td>{$item.participantticket_date|date_format}</td>
					<td>{$item.participant_name} {$item.participant_surname}</td>
					<td>{$item.event_name}</td>
					<td>{$item.ticket_name}</td>
					<td>R {$item.ticket_price|number_format:2:".":","}</td>										
					<td>{$item.participantticket_reference}</td>
					<td>{if $item.participantticket_filename neq ''}<a href="{$item.participantticket_filepath}" target="_blank">{$item.participantticket_filename|truncate:30:"..."}</a>{else}N/A{/if}</td>
					<td>{$item.participantticket_notify|default:"Not sent"}</td>
					<td><button onclick="sendticket('{$item.participantticket_code}'); return false;">Send</button></td>	
					<td><button onclick="deleteitem('{$item.participantticket_code}'); return false;">Delete</button></td>
				</tr>
			  {/foreach}     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 {include_php file='administration/includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
function sendticket(id) {					
	if(confirm('Are you sure you want to send this ticket to the participant?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
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
			url: "default.php",
			data: "deleteitem="+code,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					alert('Deleted');
					window.location.href = window.location.href;
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
