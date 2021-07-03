<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Profiles</title>
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
			<li><a href="/administration/profiles/" title="Jobs">Profiles</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Profiles</h2>
	<a href="/administration/profiles/details.php" title="Click to Add a new Profile" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Profile</span></a>  <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
				<th>Image</th>
				<th>Fullname</th>
				<th>Cellphone</th>
				<th>School</th>
				<th>Grade</th>
				<th>Player profile</th>
				<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$profileData item=item}
			  <tr>
				<td align="left">
					{if $item.profile_image_path eq ''}
						<img src="/media/profile/avatar.jpg" />
					{else}
						<a target="_blank" href="{$item.profile_image_path}big_{$item.profile_image_name}{$item.profile_image_ext}">
							<img src="{$item.profile_image_path}min_{$item.profile_image_name}{$item.profile_image_ext}" />
						</a>
					{/if}				
				</td>
				<td align="left"><a href="/administration/profiles/details.php?code={$item.profile_code}">{$item.profile_name} {$item.profile_surname}</a></td>
				<td align="left">{$item.profile_cellphone}</td>
				<td align="left">{$item.profile_school}</td>
				<td align="left">{if $item.profile_grade neq ''}Grade {$item.profile_grade}{else}N/A{/if}</td>
				<td align="left">{$item.profile_player}</td>
				<td align="right"><button onclick="deleteitem('{$item.profile_code}')">Delete</button></td>
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
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
