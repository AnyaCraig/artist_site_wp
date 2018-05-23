<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
	<aside class="sidebar-section clearfix">

		<h1>
		  <a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name', 'display' ); ?>" rel="home">
		    <?php bloginfo( 'name' ); ?>
		  </a>
		</h1>
	
    	<?php wp_nav_menu('sidebar-menu'); ?>
    	
    </aside>
<?php endif; ?>