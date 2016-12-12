<?php

/***************************
* Load Styles and Scripts
****************************/
add_action('admin_head', 'admin_style');

function admin_style() {
  echo '<style>
  	#wp-admin-bar-comments, #wp-admin-bar-new-content, #wp-admin-bar-updates {
	    display: none;
	}
	.documentation li {
		list-style: initial;
	}
	.documentation ul {
	    margin: 20px;
	}
	li.wp-not-current-submenu.wp-menu-separator {
	    display: none;
	}
	div#contextual-help-link-wrap {
	    display: none;
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
		remove_menu_page( 'widgets.php' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
		remove_menu_page( 'admin.php?page=wpcf7' );
		remove_menu_page( 'edit.php?post_type=acf' ); 

	  //Whilst were in the admin_menu, 

		//remove some of the roles so as not to confuse things
		global $wp_roles; 
		$roles_to_remove = array('contributor', 'author', 'editor');

		foreach ($roles_to_remove as $role) {
			if (isset($wp_roles->roles[$role])) {
			    $wp_roles->remove_role($role);
			}
		}

		//rename the subscriber role to Employee
		if ( ! isset( $wp_roles ) )
	        $wp_roles = new WP_Roles();    
	    	$wp_roles->roles['subscriber']['name'] = 'Employee';


	}
	add_action( 'admin_menu', 'remove_menus' );

	//now remove those created by plugins
	function wpse_136058_remove_menu_pages() {

	    remove_menu_page( 'edit.php?post_type=acf' );
	    remove_menu_page( 'wpcf7' );
	}
	add_action( 'admin_init', 'wpse_136058_remove_menu_pages' );

	function custom_menu_order($menu_ord) {
	    if (!$menu_ord) return true;
	     
	    return array(     
	        
	        'edit.php?post_type=documents', // Posts
	        'users.php', // Users	        
	        'edit.php?post_type=page', // Posts
	        'upload.php', // Media
	        'separator2', // First separator
	        'separator1', // First separator
	        'separator3', // First separator
	        
	    );
	}
	add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
	add_filter('menu_order', 'custom_menu_order');


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
Refer failed login atempts back to the home page
*************************/

function custom_login_failed( $username ){

    $referrer = wp_get_referer();
    if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') )    {
        wp_redirect( add_query_arg('login', 'failed', $referrer) );
        exit;
    }
}
add_action( 'wp_login_failed', 'custom_login_failed' );


/*************************
Redirect Non-logged in users to the home page for authentication
*************************/
function global_auth(){
	if( ( !is_page(2) ) ) {
        if ( !is_user_logged_in() ) {
            wp_redirect( site_url() );
            exit();
        }
    }
}

add_action( 'template_redirect', 'global_auth');


/*************************
Send employees over to the documents archive if they try to login to the dashboard
*************************/
function blockusers_init() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( get_post_type_archive_link('documents') );
	exit;
	}
}
add_action( 'init', 'blockusers_init' );

/*************************
Add a page for documentation
*************************/
function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Documentation' ),
        'Documentation',
        'manage_options',
        'documentation.php',
        'documentation_callback',
        'dashicons-welcome-learn-more',
        100
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

function documentation_callback(){
	echo '
	&nbsp;
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
 	<li>Employee Management
<ol>
 	<li>Adding new employee</li>
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
<strong>2. Employee Management: </strong>

<strong>Adding a new employee:</strong> To list all registered employees navigate to <strong>Users &gt; All Users</strong> from the left hand menu in the WP Admin.
<ul>
 	<li>To add a new employee click <strong>Add New </strong>near the top of the admin screen.</li>
 	<li>Fill out the user fields such as Username, Email, First and Last names.</li>
 	<li>Click <strong>Show Password</strong> to view or change the users password.</li>
 	<li>Select the checkbox to email your new user with the details about their account.</li>
 	<li>You can then choose to register your new user as a new Employee or Site Administrator.</li>
</ul>
<strong>Change an employee or administrator password.</strong>
<ul>
 	<li>To update a users details navigate to <strong>Users &gt; All Users</strong> from the left hand menu in the WP Admin.</li>
 	<li>Hover the username you wish to edit and click <strong>Edit</strong>.</li>
 	<li>From here you can edit all this users profile fields.</li>
 	<li>To revoke a users access you will need to delete the user manaually from the <strong>User List screen</strong>.</li>
</ul>
<strong>3. WordPress Menu</strong>

The website navigation is split into two parts:
<ol>
 	<li>The "Primary" Menu: Links displayed under "Navigation".
<ol>
 	<li>As you add pages to the site, they will appear under the <strong>Navigation</strong> title in the main menu.</li>
</ol>
</li>
 	<li>The "Document Types" Menu: Links displayed under "Document Types".
<ol>
 	<li>These links are automatically populated from the list of available Document Categories and displayed in the order they are created.</li>
</ol>
</li>
</ol>
<strong>4. Website Footer Content</strong>

You can edit the websites footer content from the Home Page edit screen. Navigate to <strong>Pages &gt; All Pages &gt; Home</strong> and select <strong>Edit. </strong>

</div>';
}

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
function my_custom_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_users_link', 'Welcome', 'custom_dashboard_help');
}

function custom_dashboard_help() {
echo '<h3>Welcome to your Dashboard</h3>';
echo '<p>For help and support with your website and its content or users, you can find documentation <a href="admin.php?page=myplugin%2Fmyplugin-admin.php" target="_blank">Here</a>.</p>
	<p>If you require additional support, please do not hesitate to contact one of our team at Ellison Marketing.</p>
	<h3>Tel: 01978 265807<br>
		Email: lucy@ellosonmarketing.co.uk<br>
		</h3>';
}