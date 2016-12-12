<?php

/***************************
* Load Styles and Scripts
****************************/
add_action('admin_head', 'admin_style');

function admin_style() {
  echo '<style>
   .documentation li {
    list-style: initial;
}

.documentation ul {
    margin: 20px;
}
  </style>';
}

function scp_front_styles() {        

		wp_register_style( 'bootstrapcss', get_template_directory_uri() .'/css/bootstrap.min.css');
        wp_enqueue_style( 'bootstrapcss' );
        wp_enqueue_style('font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'); 
        wp_register_style( 'styles', get_stylesheet_uri() );
        wp_enqueue_style( 'styles' );
     
}
add_action( 'wp_enqueue_scripts', 'scp_front_styles' );

function scp_front_scripts() {    
    
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true );      
    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/core.js', array('jquery'), '', true );
}

add_action( 'wp_enqueue_scripts', 'scp_front_scripts' );

function insert_jquery(){
   wp_enqueue_script('jquery');
}
add_filter('wp_head','insert_jquery');


/***************************
* Load Menus
****************************/
register_nav_menus( array(
	'primary' => __( 'Primary' ),
) );


/***************************
* Register Sidebars
****************************/
$args1 = array(
	'name'          => __( 'Blog Sidebar' ),
	'id'            => 'sidebar-blog',
	'description'   => '',
    'class'         => '',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4 class="widgettitle">',
	'after_title'   => '</h4>' 
); 
register_sidebar( $args1 );

/***************************
* Register Sidebars
****************************/
add_theme_support( 'post-thumbnails' ); 


/***************************
* Custom Excerpt
****************************/
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class wp_bootstrap_navwalker extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( $args->has_children )
				$class_names .= ' dropdown';

			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';

			// If item has_children add atts to a.
			if ( $args->has_children && $depth === 0 ) {
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
				$atts['aria-haspopup']	= 'true';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';

				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';

			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container )
				$fb_output .= '</' . $container . '>';

			echo $fb_output;
		}
	}
}

/*************************
Remove those peski emojis
*************************/
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
add_filter( 'emoji_svg_url', '__return_false' );


/*************************************
Add the company logo to the WP Login
*************************************/
add_action( 'login_head', 'ilc_custom_login');
function ilc_custom_login() {
  echo '<style type="text/css">
  h1 a { background-image:url('. get_stylesheet_directory_uri() . '/images/logo.png' . ') !important; margin-bottom: 10px; }
  padding: 20px;}
  </style>
  <script type="text/javascript">window.onload = function(){document.getElementById("login").getElementsByTagName("a")[0].href = "'. home_url() . '";document.getElementById("login").getElementsByTagName("a")[0].title = "Go to site";}</script>';
}

/**********************************************
Remove the default WP Admin Pages not required
***********************************************/
function remove_menus(){
  
  remove_menu_page( 'index.php' ); 
  remove_menu_page( 'edit.php' );                  
  remove_menu_page( 'edit-comments.php' );
  remove_menu_page( 'themes.php' );
  remove_menu_page( 'plugins.php' );
  remove_menu_page( 'tools.php' );
  remove_menu_page( 'options-general.php' );
  remove_menu_page( 'admin.php?page=wpcf7' );
  remove_menu_page( 'edit.php?post_type=acf' );  
}
add_action( 'admin_menu', 'remove_menus' );
//now remove those created by plugins
function wpse_136058_remove_menu_pages() {

    remove_menu_page( 'edit.php?post_type=acf' );
    remove_menu_page( 'wpcf7' );
}
add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );

/**********************************************
Documents CPT
***********************************************/
function document_post_type() {

	$labels = array(
		'name'                  => 'Documents',
		'singular_name'         => 'Document',
		'menu_name'             => 'Documents',
		'name_admin_bar'        => 'Document',
		'archives'              => 'Document Archives',
		'parent_item_colon'     => 'Parent Document:',
		'all_items'             => 'All Document',
		'add_new_item'          => 'Add New Document',
		'add_new'               => 'Add New',
		'new_item'              => 'New Document',
		'edit_item'             => 'Edit Document',
		'update_item'           => 'Update Document',
		'view_item'             => 'View Document',
		'search_items'          => 'Search Document',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Document list',
		'items_list_navigation' => 'Document list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$rewrite = array(
		'slug'                  => 'documents',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => 'Document',
		'description'           => 'Risk Assesment and Health and Safgety Documents',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'            => array( 'document_taxonomy' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 1,
		'menu_icon'             => 'dashicons-format-aside',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'documents', $args );

}
add_action( 'init', 'document_post_type', 0 );

/**********************************************
Documents Category
***********************************************/
function document_taxonomy() {

	$labels = array(
		'name'                       => 'Document Categories',
		'singular_name'              => 'Document Category',
		'menu_name'                  => 'Document Category',
		'all_items'                  => 'All Document Categories',
		'parent_item'                => 'Parent Document Category',
		'parent_item_colon'          => 'Parent Document Category:',
		'new_item_name'              => 'New Document Category Name',
		'add_new_item'               => 'Add New Document Category',
		'edit_item'                  => 'Edit Document Category',
		'update_item'                => 'Update Document Category',
		'view_item'                  => 'View Document Category',
		'separate_items_with_commas' => 'Separate items with commas',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Document Categories',
		'search_items'               => 'Search Document Categories',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No items',
		'items_list'                 => 'Document Categories list',
		'items_list_navigation'      => 'Document Categories list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'document_taxonomy', array( 'documents' ), $args );

}
add_action( 'init', 'document_taxonomy', 0 );

/*************************
Hide that pesky admin bar to all but the admins
*************************/
add_filter('show_admin_bar', '__return_false');



/*************************
Redirect logged in users to the documents archive
*************************/
function add_login_check()
{
    if ( is_user_logged_in() && is_page(2) ) {
    	$documents = get_post_type_archive_link( 'documents' );
		wp_redirect ($documents);        
        exit;
    }
}

add_action('wp', 'add_login_check');

/*************************
Refer failed login atempts 
back to the home page
*************************/
add_action( 'wp_login_failed', 'custom_login_failed' );
function custom_login_failed( $username )
{
    $referrer = wp_get_referer();

    if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') )
    {
        wp_redirect( add_query_arg('login', 'failed', $referrer) );
        exit;
    }
}

/*************************
Add a page for documentation
*************************/
function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Documentation' ),
        'Documentation',
        'manage_options',
        'myplugin/myplugin-admin.php',
        'documentation_callback',
        '',
        100
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

function documentation_callback(){
	echo '
	<div class="documentation">
		<h2>Index</h2>
<ol>
 	<li>Document Management
<ol>
 	<li>Adding a new document</li>
 	<li>Editing a current document</li>
 	<li>Bulk uploads</li>
</ol>
</li>
 	<li>Menus
<ol>
 	<li>WordPress Menu</li>
 	<li>Document Categories Menu</li>
</ol>
</li>
 	<li>Website Footer Content</li>
</ol>
<strong>1. Document Management</strong>

<strong>Adding a new document:</strong> To list all of the existing published and trashed documents, navigate to <strong>Documents &gt; All Documents </strong>from the left hand menu in the WP Admin.
<ul>
 	<li>To add a new Document, click <strong>Add New </strong>near the top of the admin screen.</li>
 	<li>Enter the Document title, select the file to be uploaded and if applicable add a description of the document in the editor provided.</li>
 	<li>You can group / categories the document in the <strong>Document Categories Meta Box </strong>located on the right hand side of the edit screen. Simply start to type the name of the group / category you wish to add to and it will pre populate the input. If you wish to add the document to an already existing group / category click <strong>Choose from the most used</strong> and a list will be displayed for you to select from. You can select single or multiple groups / categories.</li>
 	<li>By default, the document will be displayed on the website with a Document Icon. If however you wish to add a specific image or cover for this document select <strong>Set Featured Image</strong> from the <strong>Featured Image Meta Box </strong>located on the right hand side of the edit screen. From the resulting pop up screen you can select already uploaded images, or upload single / bulk images from your computer.</li>
 	<li>To Save / Publish your document and display on the website, click <strong>Publish </strong>from teh <strong>Publish Meta Box</strong> located on the right hand side of the edit screen.</li>
</ul>
<strong>Editing a current document: </strong>To list all of the existing published and trashed documents, navigate to <strong>Documents &gt; All Documents</strong> from the left hand menu in the WP Admin.
<ul>
 	<li>To edit a current document, hover your mouse over the document you wish to edit and select <strong>Edit. </strong></li>
 	<li>From here you can also select
<ul>
 	<li>Quick Edit: For editing basic document info.</li>
 	<li>Delete: For trashing the document</li>
 	<li>View: To view the document as it appears on the website (note: users on teh website will not be able to view the documents own page, only a list of available documents for download).</li>
</ul>
</li>
</ul>
<strong>Bulk Uploads:</strong> To upload all the media files you will be using for your documents navigate to <strong>Media &gt; Library</strong> from the left hand menu in the WP Admin.
<ul>
 	<li>Select <strong>Add New</strong> located near the top of the screen.</li>
 	<li>From here you can drop multiple files onto the screen or use the browser uploader to upload all of your files. You can also edit the document titles and metas.</li>
</ul>
<strong>2. WordPress Menu</strong>

The website navigation is split into two parts:
<ol>
 	<li>The "Primary" Menu: Links displayed under "Navigation".
<ol>
 	<li>These links can be edited directly from <strong>Appearance &gt; Menus &gt; Primary Menu</strong>.</li>
</ol>
</li>
 	<li>The "Document Types" Menu: Links displayed under "Document Types".
<ol>
 	<li>These links are automatically populated from the list of available Document Categories and displayed in the order they are created.</li>
</ol>
</li>
</ol>
<strong>3. Website Footer Content</strong>

You can edit the websites footer content from the Home Page edit screen. Navigate to <strong>Pages &gt; All Pages &gt; Home</strong> and select <strong>Edit. </strong>
	</div>
	';
}
