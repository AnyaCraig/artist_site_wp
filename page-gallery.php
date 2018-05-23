<?php

/*
	Template Name: Gallery Listing Page
*/

get_header();  ?>


<div class="main">
  <div class="container clearfix">

  	<?php // getting the main sidebar ?>
  	<?php get_template_part('partials/main-sidebar'); ?>

  	<?php // getting the gallery listing ?>
  	<?php get_template_part('partials/artwork-listing'); ?>

  </div> <!-- /.container -->
</div> <!-- /.main -->

<?php get_footer(); ?>