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
<script src="/library/javascript/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
{include_php file='includes/header.php'}
<section>
	<div class="redbox boxes cf">
    	<div class="wrap">
    		<h1>Western Province Township Cricket Warriors</h1>
            <p>Below is the profiles of the Township Cricket Warriors' players. These are the young cricket players that will be going on the UK/Paris tour. They love the game of cricket and cannot wait to go on tour and compete against other countries. See the official UK/Paris tour invitation letter below.</p>
            <a href="/docs/WPA_Tour_Invite.pdf" target="_blank" class="button">Official UK Tour Invite</a>
    	</div>
    </div>
    <div class="greybox gridbox">
    	<div class="wrap">
    		<h2 style="margin-bottom: 20px">The Team</h2>
            <div class="profbox">
                <ul id="og-grid" class="og-grid">
					{foreach from=$profileData item=item}
                    <li>
                        <a href="" data-largesrc="{$item.profile_image_path}big_{$item.profile_image_name}{$item.profile_image_ext}" data-title="{$item.profile_name} {$item.profile_surname}" data-description="<span>Date of Birth:</span> {$item.profile_birthday}<br />
                        <span>School Attending:</span> {$item.profile_school}<br />
                        <span>Grade:</span> {$item.profile_grade}<br />
                        <span>Type of Player:</span> {$item.profile_player}">
						<img src="{$item.profile_image_path}prof_{$item.profile_image_name}{$item.profile_image_ext}" alt="{$item.profile_name} {$item.profile_surname}" /></a>
					</li>
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
<script src="/library/javascript/grid.js"></script>
<script src="/library/javascript/main.js"></script>
{literal}
<script>
$(function() {
	Grid.init();
});
</script>
{/literal}
</body>
</html>