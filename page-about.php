<?php

/*
	Template Name: About Page
*/

get_header();  ?>


<div class="main">
  <div class="container clearfix">

	<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
		<aside class="sidebar-section clearfix">
			<h1>
			  <a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name', 'display' ); ?>" rel="home">
			    <?php bloginfo( 'name' ); ?>
			  </a>
			</h1>
	    	<?php dynamic_sidebar( 'main-sidebar' ); ?>
	    </aside>
	<?php endif; ?>

	<?php // Start the loop ?>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	  <h2><?php the_title(); ?></h2>
	  <?php the_content(); ?>

	<?php endwhile; // end the loop?>

  </div> <!-- /.container -->
</div> <!-- /.main -->

<?php get_footer(); ?>