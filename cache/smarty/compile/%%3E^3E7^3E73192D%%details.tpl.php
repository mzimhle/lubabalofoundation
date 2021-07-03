<?php /* Smarty version 2.6.20, created on 2015-07-15 07:18:27
         compiled from galleries/details.tpl */ ?>
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
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<section>
	<div class="redbox gridbox cf">
    	<div class="wrap">
    		<h1><?php echo $this->_tpl_vars['galleryData']['gallery_name']; ?>
</h1>
            <p><?php echo $this->_tpl_vars['galleryData']['gallery_description']; ?>
</p>
            <div class="galbox">
                <ul class="og-grid">
				<?php $_from = $this->_tpl_vars['galleryimageData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                <li><a href="<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/big_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_ext']; ?>
" class="popimg"><img src="<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/gal_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_ext']; ?>
" width="208" height="260" alt="Album Name" /></a></li>
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
<script src="/library/javascript/popup.js"></script>
<script src="/library/javascript/main.js"></script>
<?php echo '
<script>
$(\'a.popimg\').magnificPopup({
  type: \'image\',
  mainClass: \'mfp-fade\',
  gallery:{
    enabled:true
  }
});
</script>
'; ?>

</body>
</html>