<?php
om_custom_sidebar_setup(false);
get_header(); ?>

	<?php om_tpl_page_title(false, __('Search', 'om_theme')) ?>
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">

				<?php 
					/*
					// set page to load all returned results
					global $query_string;
					query_posts( $query_string . '&posts_per_page=-1' );
					*/
					if( have_posts() ) {
						?>
						<p class="search-results-note"><?php printf( __('Search Results for: &ldquo;%s&rdquo;', 'om_theme'), get_search_query()); ?></p>
						<ol class="search-results-list">
							<?php
	
							// All Posts in one List
							while( have_posts() ) {
								the_post(); 
	            	$thumbnail=get_the_post_thumbnail();
	            	if($thumbnail) {
	            		$thumbnail='<div class="search-results-thumbnail"><a href="%1$s">'.$thumbnail.'</a></div>';
	            	}
			          echo sprintf('<li>'.$thumbnail.'<h4><a href="%1$s">%2$s</a></h4><p>%3$s</p><div class="clear"></div></li>', get_permalink(), get_the_title(), get_the_excerpt()); 
					    }
					  ?>
						</ol>
				    <?php
					  
					  echo '<p>&nbsp;</p>';
					  echo om_wrap_paginate_links ( paginate_links( om_paginate_links_args() ) );
	         
	  			} else {
						?>
						<p><?php printf( __('Your search for <em>"%s"</em> did not match any entries','om_theme'), get_search_query() ); ?></p>
	
	  				<?php get_search_form(); ?>
	  				<p><?php _e('Suggestions:','om_theme') ?></p>
	  				<ul>
	  					<li><?php _e('Make sure all words are spelled correctly.', 'om_theme') ?></li>
	  					<li><?php _e('Try different keywords.', 'om_theme') ?></li>
	  					<li><?php _e('Try more general keywords.', 'om_theme') ?></li>
	  				</ul>
						<?php
					}
				?>
		      							
				</div>
									
				<?php // $post=false; get_sidebar(); ?>
					
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
<?php get_footer(); ?>