<?php

/*
	Template Name: Contact Page
*/

get_header();  ?>

<div class="main">
  <div class="container">

  		<?php // getting the main sidebar ?>
  		<?php get_template_part('partials/main-sidebar'); ?>

  		<div class="content">


		    <?php // Start the loop ?>
		    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		      <h2><?php the_title(); ?></h2>
		      <?php the_content(); ?>

		    <?php endwhile; // end the loop?>

			<?php // getting the contact form ?>
		    <?php get_template_part('partials/contact-form'); ?>
		    
		</div>
	    
  </div> <!-- /.container -->
</div> <!-- /.main -->

<?php get_footer(); ?>
