<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gallery</title>
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
			<li><a href="/administration/gallerys/" title="">Gallery</a></li>
			<li><a href="/administration/gallery/details.php?code={$galleryData.gallery_code}" title="">{$galleryData.gallery_name}</a></li>
			<li>Gallery</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{$galleryData.gallery_name}</h2>

    <div class="clearer"><!-- --></div>	
    <div id="sidetabs">
        <ul >             
			<li><a href="/administration/gallery/details.php?code={$galleryData.gallery_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Images">Images</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	<h4>Gallery:</h4><br />
	<form id="addForm" name="addForm" action="/administration/gallery/image.php?code={$galleryData.gallery_code}" method="post" enctype="multipart/form-data">
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
		<thead>
		  <tr>
			<th width="12%">Image</th>
			<th width="40%">Name</th>					
			<th width="10%">Primary</th>
			<th width="*" class="rgt"></th>
			<th width="*" class="rgt"></th>
		   </tr>
	   </thead>
	   <tbody>
	  {foreach from=$galleryimageData item=item}
	  <tr>
		<td><a target="_blank" href="{$item.galleryimage_path}/big_{$item.galleryimage_code}{$item.galleryimage_extension}"><img src="{$item.galleryimage_path}/tny_{$item.galleryimage_code}{$item.galleryimage_extension}" /></a></td>											
		<td><input type="text" name="galleryimage_description_{$item.galleryimage_code}" id="galleryimage_description_{$item.galleryimage_code}" value="{$item.galleryimage_description}" size="70" /></td>									
		<td>
			<input type="radio" name="galleryimage_primary" id="galleryimage_primary_{$item.galleryimage_code}" value="{$item.galleryimage_code}" {if $item.galleryimage_primary eq 1} checked="checked"{/if} />
		</td>			
		<td>	
			<button onclick="javascript:updateForm('{$item.galleryimage_code}'); return false;" >Update</button>
		</td>	
		<td>
			{if $item.galleryimage_primary eq '0'}
			<button onclick="javascript:deleteForm('{$item.galleryimage_code}'); return false;" >Delete</button>
			{else}
			N/A
			{/if}		
		</td>		
	  </tr>
	  {foreachelse}
		<tr>
			<td colspan="5" class="error">There are no current items in the system.</td>
		</tr>
	  {/foreach}  
		  <tr>
			<th colspan="3">Description</th>
			<th>Upload</th>
			<th></th>
		   </tr>
		<tr>
			<td colspan="3">
				<input type="text" id="galleryimage_description" name="galleryimage_description" value="" size="80" />
				{if isset($errorArray.galleryimage_description)}<br /><span class="error">{$errorArray.galleryimage_description}</span>{/if}
			</td>
			<td>
				<input type="file" id="imagefile" name="imagefile" />
				{if isset($errorArray.imagefile)}<br /><span class="error">{$errorArray.imagefile}</span>{/if}
			</td>
			<td><button onclick="addItemForm(); return false;">Add Item</button></td>
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
function addItemForm() {
	document.forms.addForm.submit();				 
}			
	
function updateForm(id) {
	if(confirm('Are you sure you want to update this file ?')) {
		var primary = '';
		if($('#galleryimage_primary_'+id).is(':checked')) {
			primary = id;
		}			
		
		$.ajax({ 
				type: "GET",
				url: "image.php",
				data: "code={/literal}{$galleryData.gallery_code}{literal}&galleryimage_code_update="+id+"&galleryimage_primary="+primary + "&galleryimage_description="+$('#galleryimage_description_'+id).val(),
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Updated');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	
	return false;
}	
	
function deleteForm(id) {	
	if(confirm('Are you sure you want to delete this file?')) {
			$.ajax({ 
					type: "GET",
					url: "image.php",
					data: "code={/literal}{$galleryData.gallery_code}{literal}&galleryimage_code_delete="+id,
					dataType: "json",
					success: function(data){
							if(data.result == 1) {
								alert('Deleted');
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
