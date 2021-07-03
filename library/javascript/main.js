$(window).load(function() {
	$('.flexslider').flexslider();
	
$('#edate').countdown('2014/07/04', function(event) {
	$(this).html(event.strftime(''
	+ '<div>%w<span>weeks</span></div>'
	+ '<div>%d<span>days</span></div>'
	+ '<div>%H<span>hours</span></div> '
	+ '<div>%M<span>minutes</span></div> '
	/*+ '<div>%S<span>seconds</span></div>'*/));
	});
	$('#logos').tinycarousel();
	
	$('.bwwrap').BlackAndWhite({
        hoverEffect : true, // default true
        // set the path to BnWWorker.js for a superfast implementation
        webworkerPath : false,
        // for the images with a fluid width and height
        responsive:true,
        // this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
        intensity:1,
        speed: { //this property could also be just speed: value for both fadeIn and fadeOut
            fadeIn: 400, // 200ms for fadeIn animations
            fadeOut: 800 // 800ms for fadeOut animations
        }
    });
});