<?php

/*
	Template Name: Home Page
*/

get_header();  ?>


<div class="main">
  <div class="container clearfix">

  	<?php // getting the main sidebar ?>
  	<?php get_template_part('partials/main-sidebar'); ?>

  	<div class="content">

  		<div class="home-slider">
  			<?php echo do_shortcode('[slider id="37"]');?>
  		</div>
  	</div>

  </div> <!-- /.container -->
</div> <!-- /.main -->

<?php get_footer(); ?>