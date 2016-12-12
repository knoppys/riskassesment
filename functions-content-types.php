<?php
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