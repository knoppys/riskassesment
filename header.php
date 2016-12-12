<!DOCTYPE html>
<html>
<head>
<title></title>
<link href="https://fonts.googleapis.com/css?family=Oswald|Raleway" rel="stylesheet">
<meta name="viewport" content="initial-scale=1">
<meta name="author" content="Knoppys.co.uk" >
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="expires" content="0">
<?php wp_head(); ?>
</head>
<body>
<?php
if (!is_page('home')) { ?>
	
<header class="home-naviagtion" id="sticky">

	    <div class="container">
	    	<div class="row">
	    		<div class="col-xs-6 logo">
			    	<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png">
			    </div>
			    <div class="col-xs-6">
			    	<div class="dropdown">
					  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    Menu  <i class="fa fa-bars"></i>
					  </button>
					  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					  	<a class="dropdown-item drop-down-header"><i class="fa fa-bars"></i>Navigation</a>
					    <?php //The page links from the Primary menu if there are any	
					    wp_nav_menu('primary');
					    ?>    
					    <div class="dropdown-divider"></div>
					    <a class="dropdown-item drop-down-header"><i class="fa fa-file-text"></i>Document Types</a>
					    <?php
					    //The list of document categories and links to their archive.
					    $terms = get_terms( 'document_taxonomy' );
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){   
							    foreach ( $terms as $term ) {
							    	$term_link = get_term_link( $term );
							        echo '<a class="dropdown-item" href="'.esc_url( $term_link ).'">' . $term->name . '</a>';
							        
							    }   
							}
							//var_dump($terms);
					    ?>
						<div class="dropdown-divider"></div>
					    <a class="dropdown-item logout" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out"></i>Logout</a>
					  </div>
					</div>
			    </div>
	    	</div>
	    </div>

</header>
<?php } else {}
