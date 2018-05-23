<?php

$slider = new WP_Query(array(
	'post_type' => 'slider', // "slider" is our custom post type name that we created with CPT UI
	'post' => $id, // this $id variable came from our functions.php file, which in turn came from the shortcode

	));
?>

<?php if ($slider->have_posts()) while ($slider -> have_posts()) : $slider -> the_post(); ?>

	<?php 

	$works_to_display = get_field('works_to_display'); 

	?>

	<div class="slider">

		<h2>Here is our slider!</h2>

		<?php
		
		// for each work to be displayed...
		foreach($works_to_display as $artwork):

			// set up the post data
			setup_postdata( $artwork );

			// get the ID of the post object
			$artworkID = $artwork[artwork_to_display];

			// get the images associated with the artwork
			$artworkImages = get_field('artwork_images', $artworkID);

			// get the large image URL
			$imageUrl = $artworkImages[0]['sizes']['large'];
			
		?>

		<span>SLIDER ITEM</span>
		<div><?php dump($imageUrl); ?></div>

		<?php endforeach; ?>
		
		<?php wp_reset_postdata(); ?>
		
	</div>

<?php endwhile; wp_reset_postdata(); ?>