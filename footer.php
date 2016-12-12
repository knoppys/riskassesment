	</div>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php if (!is_page(2)) {
							 echo get_field('footer', 2);
						} ?>
					</div>
				</div>
			</div>
		</footer>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>