!function(t){function o(t,o,e){t.velocity({opacity:0,marginTop:0,marginLeft:0},{duration:225,queue:!1,delay:225}),o.velocity({opacity:0,scale:1},{duration:225,delay:275,queue:!1,complete:function(){o.css("display","none"),t.css("display","none"),e.call()}})}function e(t,o,e,i){o.css({display:"block",left:"0px",top:"0px"}),o.children("span").text(t.attr("data-tooltip"));var n,d,r,l=t.outerWidth(),p=t.outerHeight(),s=t.attr("data-position"),u=o.outerHeight(),f=o.outerWidth(),c="0px",v=8,h="0px";"top"===s?(n=t.offset().top-u-i,d=t.offset().left+l/2-f/2,r=a(d,n,f,u),c="-5px",e.css({borderRadius:"14px 14px 0 0",transformOrigin:"50% 90%",marginTop:u,marginLeft:f/2-e.width()/2})):"left"===s?(n=t.offset().top+p/2-u/2,d=t.offset().left-f-i,r=a(d,n,f,u),h="-10px",e.css({width:"14px",height:"14px",borderRadius:"14px 0 0 14px",transformOrigin:"95% 50%",marginTop:u/2,marginLeft:f})):"right"===s?(n=t.offset().top+p/2-u/2,d=t.offset().left+l+i,r=a(d,n,f,u),h="+10px",e.css({width:"14px",height:"14px",borderRadius:"0 14px 14px 0",transformOrigin:"5% 50%",marginTop:u/2,marginLeft:"0px"})):(n=t.offset().top+t.outerHeight()+i,d=t.offset().left+l/2-f/2,r=a(d,n,f,u),c="+10px",e.css({marginLeft:f/2-e.width()/2})),o.css({top:r.y,left:r.x}),v=f/8,8>v&&(v=8),("right"===s||"left"===s)&&(v=f/10,6>v&&(v=6)),o.velocity({marginTop:c,marginLeft:h},{duration:350,queue:!1}).velocity({opacity:1},{duration:300,delay:50,queue:!1}),e.css({display:"block"}).velocity({opacity:1},{duration:55,delay:0,queue:!1}).velocity({scale:v},{duration:300,delay:0,queue:!1,easing:"easeInOutQuad"})}t.fn.live_tooltip=function(a){var i=null,n=!1,d=null,r=5,l={delay:100};return"remove"===a?(this.each(function(){t("#"+t(this).attr("data-tooltip-id")).remove()}),!1):(a=t.extend(l,a),this.each(function(){function l(o){if(o.attr("data-tooltip-id"))return o;var e=Materialize.guid();o.attr("data-tooltip-id",e);var a=t("<span></span>").text(o.attr("data-tooltip")),i=t("<div></div>");i.addClass("tvd-material-tooltip").append(a).appendTo(t("body")).attr("id",e),o.data("tvd-new-tooltip",i);var n=t("<div></div>").addClass("tvd-backdrop");return n.appendTo(i),n.css({top:0,left:0}),o.data("tvd-backdrop",n),o}var p=t(this);p.off("mouseenter.tooltip mouseleave.tooltip"),p.on("mouseenter.tooltip",".tvd-tooltipped",function(o){var p=l(t(this)),s=p.data("tvd-new-tooltip"),u=p.data("tvd-backdrop"),f=p.data("delay");f=void 0===f||""===f?a.delay:f,i=0,l(p),d=setInterval(function(){i+=10,i>=f&&n===!1&&(n=!0,e(p,s,u,r))},10)}),p.on("mouseleave.tooltip",".tvd-tooltipped",function(){var e=t(this),a=e.data("tvd-new-tooltip"),r=e.data("tvd-backdrop");clearInterval(d),i=0,o(a,r,function(){n=!1})})}))},t.fn.tooltip=function(a){var i=null,n=!1,d=null,r=5,l={delay:100};return"remove"===a?(this.each(function(){t("#"+t(this).attr("data-tooltip-id")).remove()}),!1):(a=t.extend(l,a),this.each(function(){var l=Materialize.guid(),p=t(this);p.attr("data-tooltip-id",l);var s=t("<span></span>").text(p.attr("data-tooltip")),u=t("<div></div>");u.addClass("tvd-material-tooltip").append(s).appendTo(t("body")).attr("id",l);var f=t("<div></div>").addClass("tvd-backdrop");f.appendTo(u),f.css({top:0,left:0}),p.off("mouseenter.tvd-tooltip mouseleave.tvd-tooltip"),p.on({"mouseenter.tooltip":function(t){var o=p.data("delay");o=void 0===o||""===o?a.delay:o,i=0,d=setInterval(function(){i+=10,i>=o&&n===!1&&(n=!0,e(p,u,f,r))},10)},"mouseleave.tooltip":function(){clearInterval(d),i=0,o(u,f,function(){n=!1})}})}))};var a=function(o,e,a,i){var n=o,d=e;return 0>n?n=4:n+a>window.innerWidth&&(n-=n+a-window.innerWidth),0>d?d=4:d+i>window.innerHeight+t(window).scrollTop&&(d-=d+i-window.innerHeight),{x:n,y:d}};t(document).ready(function(){t("body").live_tooltip()})}(jQuery);