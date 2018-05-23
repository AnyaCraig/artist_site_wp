<section class="gallery-listing">

	<div class="filter-options">
    	<input type="checkbox" id="forSaleCheckbox" name="forSale" value="forSale">
    	<label for="forSaleCheckbox">Show only works currently for sale?</label>
  	</div>
	<div class="masonry">

		<?php

		$galleryArtworks = new WP_Query(
		    array(
		        'posts_per_page' => -1,
		        'post_type' => 'artwork',
		        'order' => 'ASC'
		        )
		); 

		if ( $galleryArtworks->have_posts() ) :

		while ($galleryArtworks->have_posts()) : 

		$galleryArtworks->the_post();


			// ARTWORK VARIABLES

			// artwork title
			$title = get_the_title();

			// artwork image
			$image = get_field('artwork_images');
			$imageUrl = $image[0]['sizes']['medium_large'];

			// year made
			$yearMade = get_field('artwork_date');

			// artist's statement
			$statement = get_field('artists_statement');

			// FOR SALE AND PRICE

			$forSale = get_field('for_sale');
			$priceOnRequest = get_field('price_on_request');
			$price = get_field('artwork_price');
			
			$forSaleText = "";
			$forSalePrice = "";

			if ($forSale) {
				$forSaleText = "FOR SALE";
				
				// don't list a dollar price if the price is on request only
				if ($priceOnRequest) {
					
					$forSalePrice = " <span class='pipe-padding'>|</span> Price on request";

				} else {

					$forSalePrice = " <span class='pipe-padding'>|</span> $" . $price;
				}

			} else {

				$forSaleText = "NOT FOR SALE";
			}

			// ARTWORK SIZE

			// width
			$width = get_field('artwork_width');

			// height
			$height = get_field('artwork_height');

			$sizeText = $width . '" by ' . $height . '"';

			// size
			$size = get_field('artwork_size');

			// artwork link
			$artworkLink = get_post_permalink( $post->ID );

			$extraClasses = "";

			if( $forSale ) {
				$extraClasses = $extraClasses . " forSale";
			} else {
				$extraClasses = $extraClasses . " notForSale";
			}				

			$extraClasses = $extraClasses . " " . $size;

			?>

			<div class="artwork-preview-container<?php echo $extraClasses; ?>">
				<div class="artwork-preview-inner">
					<div class="artwork-image">
						<img src="<?php echo $imageUrl; ?>" />
					</div>

					<div class="artwork-info">
						
						<h3><?php echo $title; ?></h3>
						<p><?php echo $yearMade; ?></p>
						<p><?php echo $forSaleText; echo $forSalePrice; ?></p>
						<p><?php echo $sizeText; ?></p>
						<?php
							echo $statement ? $statement : '';
						?>
						
					</div>
				</div>

			</div>

		<?php 
		endwhile;  
		wp_reset_postdata(); ?>

		<?php else:  ?>
		    <div class="no-artworks">There are no works to display</div>
		<?php endif; ?>


	</div><!-- /.masonry -->


</section><!-- /.gallery-listing -->

<div class="gallery-slider-wrapper">
	<div id="close-gallery-slider">
		<i class="fa fa-times" aria-hidden="true"></i>
	</div>
	<div class="slider"></div>
</div>