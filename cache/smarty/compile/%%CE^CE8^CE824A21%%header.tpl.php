<?php /* Smarty version 2.6.20, created on 2015-07-24 21:24:27
         compiled from includes/header.tpl */ ?>
<header>
	<div class="topbar cf">
    	<div class="wrap">
        	<div class="logobox">
				<a href="/">
					<img src="/images/main_logo.png" width="282" height="52" alt="Lubabalo Foundation Logo" title="Lubabalo Foundation Logo" />
				</a>
			</div>
            <nav class="navbar">
            	<a href="/" <?php if ($this->_tpl_vars['currentPage'] == ''): ?>class="actbtn" <?php endif; ?>><img src="/images/event_btn.png" width="117" height="114" alt="The Event" /></a>
                <a href="/profiles/" <?php if ($this->_tpl_vars['currentPage'] == 'profiles'): ?>class="actbtn" <?php endif; ?>><img src="/images/who_btn.png" width="117" height="114" alt="Who it's for" /></a>
                <a href="/galleries/" <?php if ($this->_tpl_vars['currentPage'] == 'galleries'): ?>class="actbtn" <?php endif; ?>><img src="/images/pic_btn.png" width="117" height="114" alt="Our pictures" /></a>
                <a href="/contacts/" <?php if ($this->_tpl_vars['currentPage'] == 'contacts'): ?>class="actbtn" <?php endif; ?>><img src="/images/cont_btn.png" width="117" height="114" alt="Get in touch" /></a>
            </nav>
        </div>
    </div>
    <div class="wrap">
		<div class="slidetxt">
			<p>Western Province</p><br />
            <p class="stxt1">Township Cricket Warriors</p><br />
            <p class="stxt2">Fundraising Galla</p>
		</div>
	</div>
	<div class="flexslider">
    	<div id="pattern"></div>
		<ul class="slides">
			<li><img src="/images/slide_img.jpg" alt="" /></li>
            <li><img src="/images/slide_img_03.jpg" alt="" /></li>
            <li><img src="/images/slide_img_02.jpg" alt="" /></li>
		</ul>
	</div>
</header>