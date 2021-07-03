<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tickets</title>
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
			<li><a href="/administration/tickets/" title="Jobs">Ticket</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Ticket</h2>
	<a href="/administration/tickets/details.php" title="Click to Add a new Ticket" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Ticket</span></a>  <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
				<th>Added</th>
				<th>Name</th>
				<th>Event</th>
				<th>Price</th>
				<th>Admission</th>
				<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$ticketData item=item}
			  <tr>
				<td>{$item.ticket_added|date_format}</td>
				<td align="left"><a href="/administration/tickets/details.php?code={$item.ticket_code}">{$item.ticket_name}</a></td>
				<td align="left">{$item.event_name}</td>
				<td align="left">R {$item.ticket_price|string_format:"%.2f"}</td>
				<td align="left">{$item.ticket_admit}</td>
				<td align="right"><button onclick="deleteitem('{$item.ticket_code}')">Delete</button></td>
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
function deleteitem(id) {					
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+id,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item deleted!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
	
}
function sendcompemail(id) {					
	if(confirm('Are you sure you want to send this competition entry mail?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "code="+id+"&competition=1",
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
function resendregmail(id) {					
	if(confirm('Are you sure about this ?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "code="+id+"&resend=1",
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
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
