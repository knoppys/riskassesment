<?php
//get the header
get_header(); 
//start the page loop
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="container">
	<section class="content-body">
		<div class="row">
			<div class="col-sm-9">
			<header>
				<article>
					<h1><?php the_title(); ?></h1>
				</article>
			</header>
			<main>
				<?php the_content(); ?>
			</main>
		</div>
		<div class="col-sm-3">
			<aside>
				<?php dynamic_sidebar('blog-sidebar'); ?>
			</aside>			
		</div>
	</section>
</div>

<?php endwhile; else : 
//if there isnt any content, show this.	
echo '<p> Sorry, no posts matched your criteria. </p>';
//end the loop
endif;
//get the footer
get_footer();