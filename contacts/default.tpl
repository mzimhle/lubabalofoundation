<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Lubabalo Foundation | Galla Dinner Event</title>
<meta name="description" content="Western Province Township Cricket Warriors Galla Dinner, is an event to raise funds for under privilege cricket players. The funds wil help the cricket team tour with other contries in UK...">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="stylesheet" href="/css/normalize.min.css">
<link rel="stylesheet" href="/css/main.css">
<link rel="stylesheet" href="/css/tinycarousel.css">
<script src="/library/javascript/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
{include_php file='includes/header.php'}
<section>
	<div class="redbox boxes cutbox cf">
    	<div class="wrap">
        	<div class="bookbox">
            	<h1>Booking Details</h1>
                <p>To book your tickets, use the banking details below to make a payment. Email your proof of payment to info@lubabalofoundation.co.za.<br />Once payment is confirmed you will recieve your ticket details online.</p>
                <ul  class="contlist">
                    <li class="bank">
                    	<span>Bank Name:</span> FNB<br />
                    	<span>Account Type:</span> Business Account<br />
						<span>Account Name:</span> Lubabalo J Skweyiya Foundation<br />
                        <span>Account Number:</span> 62473801019
                    </li>
                    <li class="mon">R350 single ticket or R3 500 per table</li>
                </ul>
            </div>
        	<div class="contbox">
                <h1>Contact Details</h1>
                <p>The details below are for Lubabalo J Skweyiya Foundation.<br />Feel free to contact us using our contact details or you can use the contact form below.</p>
                <ul  class="contlist">
                    <li class="loc">Lubabalo J Skweyiya Foundation<br />20 Leipoldt Way<br />Mandalay<br />7785</li>
                    <li class="mail">info@lubabalofoundation.co.za</li>
                    <li class="tel">Tel: 021 387 4878<br />Cell: 078 903 9877</li>
                </ul>
            </div>
    	</div>
    </div>
    <div class="whitebox boxes cf">
    	<div class="wrap">
    		<h2 style="margin-bottom: 20px">Contact Form</h2>
            <p>Complete the form below to send us an enquiry.</p>
			{if isset($success)}<span style="color: #7F0023;font-size: 15px;">Your enquiry has been successfully submitted, we will get back to you as soon as possible.</span><br /><br />{/if}
            <form id="detailsForm" name="detailsForm" method="post" target="" action="/contacts/">
            <div class="formbox">
                <label>Name{if isset($errorArray.enquiry_name)}<span style="color: #7F0023;font-size: 14px;"> - {$errorArray.enquiry_name}</span>{/if}</label><br /><input type="text" name="enquiry_name" id="enquiry_name" value="" class="shad" />
                <label>Email Address{if isset($errorArray.enquiry_email)}<span style="color: #7F0023;font-size: 14px;"> - {$errorArray.enquiry_email}</span>{/if}</label><br /><input type="text" name="enquiry_email" id="enquiry_email" value="" class="shad" />                				
            </div>
            <div class="formbox2">
                <label>Surname{if isset($errorArray.enquiry_surname)}<span style="color: #7F0023;font-size: 14px;"> - {$errorArray.enquiry_surname}</span>{/if}</label><br /><input type="text" name="enquiry_surname" id="enquiry_surname" value="" class="shad" />
                <label>Phone Number<span style="color: #7F0023;font-size: 14px;"> - {$errorArray.enquiry_cellphone|default:"e.g. 0812596541"}</span></label><br /><input type="text" name="enquiry_cellphone" id="enquiry_cellphone" value="" class="shad" />
            </div>
            <label>Enquiry Message{if isset($errorArray.enquiry_message)}<span style="color: #7F0023;font-size: 14px;"> - {$errorArray.enquiry_message}</span>{/if}</label><br />
            <textarea name="enquiry_message" id="enquiry_message" rows="5" class="shad"></textarea>
            <input type="submit" name="submit" value="Send Enquiry" class="shad" />
            </form>
    	</div>
    </div>
    <div class="mapbox">
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3307.178999446101!2d18.627713!3d-34.01361599999999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1dcc4f5d6837bc03%3A0x55d244ba6fa1823b!2sLeipoldt+Way!5e0!3m2!1sen!2sza!4v1400784329722" width="100%" height="500" frameborder="0" style="border:0"></iframe>
	</div>
</section>
{include_php file='includes/footer.php'}
<script src="/library/javascript/vendor/jquery-1.11.0.min.js"></script>
<script src="/library/javascript/countdown.min.js"></script>
<script defer src="/library/javascript/flexslider.min.js"></script>
<script defer src="/library/javascript/tinycarousel.min.js"></script>
<script src="/library/javascript/black.js"></script>
<script src="/library/javascript/main.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function() {	
    $(this).keydown(function(e) {
        if (e.keyCode == '13') {
            $("#detailsForm").submit();
        }
    });
});
</script>
{/literal}
</body>
</html>