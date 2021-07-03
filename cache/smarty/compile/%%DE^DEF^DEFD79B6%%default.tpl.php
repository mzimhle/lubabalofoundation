<?php /* Smarty version 2.6.20, created on 2015-07-22 12:43:36
         compiled from profiles/default.tpl */ ?>
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
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

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
					<?php $_from = $this->_tpl_vars['profileData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <li>
                        <a href="" data-largesrc="<?php echo $this->_tpl_vars['item']['profile_image_path']; ?>
big_<?php echo $this->_tpl_vars['item']['profile_image_name']; ?>
<?php echo $this->_tpl_vars['item']['profile_image_ext']; ?>
" data-title="<?php echo $this->_tpl_vars['item']['profile_name']; ?>
 <?php echo $this->_tpl_vars['item']['profile_surname']; ?>
" data-description="<span>Date of Birth:</span> <?php echo $this->_tpl_vars['item']['profile_birthday']; ?>
<br />
                        <span>School Attending:</span> <?php echo $this->_tpl_vars['item']['profile_school']; ?>
<br />
                        <span>Grade:</span> <?php echo $this->_tpl_vars['item']['profile_grade']; ?>
<br />
                        <span>Type of Player:</span> <?php echo $this->_tpl_vars['item']['profile_player']; ?>
">
						<img src="<?php echo $this->_tpl_vars['item']['profile_image_path']; ?>
prof_<?php echo $this->_tpl_vars['item']['profile_image_name']; ?>
<?php echo $this->_tpl_vars['item']['profile_image_ext']; ?>
" alt="<?php echo $this->_tpl_vars['item']['profile_name']; ?>
 <?php echo $this->_tpl_vars['item']['profile_surname']; ?>
" /></a>
					</li>
					<?php endforeach; endif; unset($_from); ?>     
              </ul>
          </div>
    	</div>
    </div>
</section>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script src="/library/javascript/vendor/jquery-1.11.0.min.js"></script>
<!--[if (gte IE 6)&(lte IE 8)]>
  <script src="/library/javascript/selectivizr.min.js"></script>
<![endif]-->
<script defer src="/library/javascript/flexslider.min.js"></script>
<script src="/library/javascript/grid.js"></script>
<script src="/library/javascript/main.js"></script>
<?php echo '
<script>
$(function() {
	Grid.init();
});
</script>
'; ?>

</body>
</html>