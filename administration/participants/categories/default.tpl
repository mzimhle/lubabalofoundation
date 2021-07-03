<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Participant Categories</title>
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
			<li><a href="/administration/participants/" title="Jobs">Participants</a></li>
			<li><a href="/administration/participants/categories/" title="Jobs">Categories</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Participants</h2>
	<a href="/administration/participants/categories/details.php" title="Click to Add a new Category" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Category</span></a> <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
					<th>Added</th>
					<th>Code</th>
					<th>Name</th>
					<th>Status</th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$participantcategoryData item=item}
			  <tr>
				<td>{$item.participantcategory_added|date_format}</td>
				<td align="left">{$item.participantcategory_code}</td>
				<td align="left"><a href="/administration/participants/categories/details.php?code={$item.participantcategory_code}">{$item.participantcategory_name}</a></td>
				<td align="left">{if $item.participantcategory_active eq '1'}<span style="color: green;">Active</span>{else}<span style="color: red;">Not Active</span>{/if}</td>
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
<!-- End Main Container -->
</body>
</html>
