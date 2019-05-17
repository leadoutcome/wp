<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
/* Add your CSS code here.
                     
For example:
.example {
    color: red;
}

For brushing up on your CSS knowledge, check out http://www.w3schools.com/css/css_syntax.asp

End of comment */ 

/* Add your JavaScript code here.
                     
If you are using the jQuery library, then don't forget to wrap your code inside jQuery.ready() as follows:

jQuery(document).ready(function( $ ){
    // Your code in here 
});

End of comment */ 


jQuery(document).ready(function( $ ){
     swfobject.embedSWF("//www.youtube.com/e/detw7LrYON0?enablejsapi=1&playerapiid=ytplayer &version=3",
    "ytapiplayer", // where the embedded player ends up
    "425", // width    
    "356", // height    
    "8", // swf version    
    null,
    null, {
        allowScriptAccess: "always"
    }, {
        id: "myytplayer" // here is where the id of the element is set
    });
     
});</script>
<!-- end Simple Custom CSS and JS -->
