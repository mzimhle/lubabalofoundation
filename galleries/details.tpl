<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Western Province Township Cricket Warriors</title>
<meta name="description" content="Western Province Township Cricket Warriors Galla Dinner, is an event to raise funds for under privilege cricket players. The funds wil help the cricket team tour with other contries in UK...">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="stylesheet" href="/css/normalize.min.css">
<link rel="stylesheet" href="/css/main.css">
<link rel="stylesheet" href="/css/component.css" />
<link rel="stylesheet" href="/css/popup.css" />
<script src="/library/javascript/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
{include_php file='includes/header.php'}
<section>
	<div class="redbox gridbox cf">
    	<div class="wrap">
    		<h1>{$galleryData.gallery_name}</h1>
            <p>{$galleryData.gallery_description}</p>
            <div class="galbox">
                <ul class="og-grid">
				{foreach from=$galleryimageData item=item}
                <li><a href="{$item.galleryimage_path}/big_{$item.galleryimage_code}{$item.galleryimage_ext}" class="popimg"><img src="{$item.galleryimage_path}/gal_{$item.galleryimage_code}{$item.galleryimage_ext}" width="208" height="260" alt="Album Name" /></a></li>
				{/foreach}
                </ul>
            </div>
		</div>
    </div>
</section>
{include_php file='includes/footer.php'}
<script src="/library/javascript/vendor/jquery-1.11.0.min.js"></script>
<!--[if (gte IE 6)&(lte IE 8)]>
  <script src="/library/javascript/selectivizr.min.js"></script>
<![endif]-->
<script defer src="/library/javascript/flexslider.min.js"></script>
<script src="/library/javascript/popup.js"></script>
<script src="/library/javascript/main.js"></script>
{literal}
<script>
$('a.popimg').magnificPopup({
  type: 'image',
  mainClass: 'mfp-fade',
  gallery:{
    enabled:true
  }
});
</script>
{/literal}
</body>
</html>
