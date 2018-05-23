<?php //index.php is the last resort template, if no other templates match ?>
<?php get_header(); ?>

<div class="main">
  <div class="container">

  	<?php // getting the main sidebar ?>
  	<?php get_template_part('partials/main-sidebar'); ?>

    <div class="content">
    		<?php get_template_part( 'loop', 'index' );	?>
    </div> <!--/.content -->

  </div> <!-- /.container -->
</div> <!-- /.main -->

<?php get_footer(); ?>