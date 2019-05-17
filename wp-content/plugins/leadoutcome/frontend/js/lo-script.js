
;(function ($) {
	$(document).ready(function() {
		console.log("lo-script ready called ...");
	});
});

function resizeIFrameToFitContent( iFrame ) {

    iFrame.width  = iFrame.contentWindow.document.body.scrollWidth;
    iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
    console.log("resizing iframe");
}

window.addEventListener('DOMContentReady', function(e) {

    var iFrame = document.getElementById( 'sales-automator' );
    resizeIFrameToFitContent( iFrame );

    // or, to resize all iframes:
    var iframes = document.querySelectorAll("iframe");
    for( var i = 0; i < iframes.length; i++) {
        resizeIFrameToFitContent( iframes[i] );
    }
} );


