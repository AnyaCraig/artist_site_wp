// GALLERY LISTING FUNCTIONALITY

// VARIABLES

var gallerySliderWrapper = $('.gallery-slider-wrapper');
var gallerySlider = $('.gallery-slider-wrapper .slider');

// FUNCTIONS

function filterForSale() {
  
	// filter gallery items
	if ( $("#forSaleCheckbox").is(':checked') ) {
    	$(".notForSale").hide();
	} else {
    	$(".notForSale").show();
	}
}

function makeSliderFromVisibleArtworks(startFrom) {
	// Grab our slider container
	
	gallerySliderWrapper.addClass("active");
	$("body").addClass("no-scroll");


	// first select the visible arworks and copy them
	var artworks = $('.artwork-preview-container:visible').clone();
	// dump the artworks into the slider
	gallerySlider.html(artworks);
	// make it a flickity
	gallerySlider.flickity({
		initialIndex: startFrom,
		accessibility: true,
		wrapAround: true,
		pageDots: false,
		adaptiveHeight: true,
	});
}

function closeSlider() {

	gallerySlider.flickity('destroy')
	gallerySliderWrapper.removeClass("active");
	gallerySlider.html("");
	$("body").removeClass("no-scroll");

}

function getIndexOfClickedArtwork(clickedWork) {
	console.log(clickedWork);

	var visibleWorks = $(".artwork-preview-container:visible");

	console.log(visibleWorks);

	
	var clickedIndex = visibleWorks.index(clickedWork);

	console.log(clickedIndex);

	makeSliderFromVisibleArtworks(clickedIndex);

}

// 1 listne for click
// 2 get how many visibil artworks are on the page
// 3. Figure out what this is the index (indexOf)



// DOCUMENT READY

$(function(){

// EVENT LISTENERS

	$("#forSaleCheckbox").on("change", function() {
		filterForSale();
    });

    $(".artwork-preview-container:visible").on("click", function(event) {
		var clickedWork = $(this);
    	getIndexOfClickedArtwork(clickedWork);
    });

    $("#close-gallery-slider").on("click", function(){
		closeSlider();
    });

});

