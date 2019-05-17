
<style type="text/css">
.locontainer {
  position: relative;
  height: 0;
  overflow: hidden;
}
 
/* 16x9 Aspect Ratio */
.locontainer-16x9 {
  padding-bottom: 75%;
}
 
/* 4x3 Aspect Ratio */
.locontainer-4x3 {
  padding-bottom: 75%;
}
 
.locontainer iframe {
  position: absolute;
  top:0;
  left: 0; 
  width: 100%;
  height: 100%;
}  
</style> 
<div class="locontainer locontainer-16x9">
	 <iframe id="sales-automator" src="<?php get_lo_domain(); ?>/track/dashboardremote?user=<?php get_lo_user();?>&pass=<?php get_lo_pass();?>&uid=1" allowfullscreen></iframe>
	<!-- <iframe src="http://ffl.leadoutcometest.com:8080/app/dashboard" allowfullscreen></iframe>
  -->
	</div>
