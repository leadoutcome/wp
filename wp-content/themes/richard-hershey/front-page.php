<?php
/*
 WARNING: This file is part of the core Genesis framework. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * Template Name: Home Page
 * This file handles blog post listings within a page.
 *
 * This file is a core Genesis file and should not be edited.
 *
 * The blog page loop logic is located in lib/structure/loops.php
 *
 * @category Genesis
 * @package  Templates
 * @author   StudioPress
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.studiopress.com/themes/genesis
 */

// Homepage CUSTOM LOOP
remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_loop', 'my_custom_loop' );

function my_custom_loop () {
?>

<div class="frontslider">
	            	
	<?php
        echo '<div class="flexslider">';
        echo '<ul class="slides">';
                $args = array( 'post_type' => 'slider', 'posts_per_page' => -1 );
                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();
                    echo '<li>';
                    $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                    ?>
                 
                      <img src="<?php echo CHILD_URL; ?>/timthumb.php?src=<?php
            if ($url) {
                echo $url;
            }
                ?>&h=725&w=1600&zc=0" alt="<?php the_title(); ?>" />
                    <?php
                    echo '</li>';
                    
                endwhile;
            echo '</ul>';
            echo '</div>';
            
       ?>
       <div class="clear"></div>

</div>


<div class="contentarea">
	
    <div class="left">
    	
        <?php while ( have_posts() ) : the_post(); ?>
			
           <h1> <?php the_title(); ?></h1>
             
            <?php the_content(); ?>       
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widgets2') ) : ?> <?php endif; ?>
        <?php endwhile; ?>
        
    </div>
    
    <div class="right">
    
    	<?php dynamic_sidebar ('home-sidebar'); ?>   

      	
        <?php dynamic_sidebar ('tweet-sidebar'); ?>   
        
 
    </div>
    

    
    <section class="left">

            
        </section>
        
    
      
       <div class="clear"></div>
   
</div>




<?php } ?>
<?php genesis(); ?>
