<?php
get_header(); 
?>


	<div class="container">
		<section  class="content-body">
			<div class="row">			
				<div class="col-md-12 archive-title">
					<h3><?php post_type_archive_title(); ?> Archive</h3>
					<p>Click any document to view.</p>
				</div>
			</div>
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="row post-entry">				
					<div class="col-sm-2 post-image">
						<div class="row">
							<div class="col-xs-12">
								<?php
								if (has_post_thumbnail()) {
									the_post_thumbnail('medium'); 
								} else {
									echo '<i class="fa fa-fa fa-file-text"></i>';
								}				
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<a class="btn btn-primary" href="<?php the_field('file_url'); ?>" target="_blank">Download</a>
							</div>
						</div>			
					</div>
					<div class="col-sm-10 post-content">
						<p><strong><?php the_title(); ?></strong></p>
						<?php the_content(); ?>
					</div>
				
				</div>
			<?php endwhile; else : echo '<div class="col-md-12"><p> Sorry, no posts matched your criteria. </p></div>';
			endif;
			?>
		</section>
	</div>



<?php
get_footer();
