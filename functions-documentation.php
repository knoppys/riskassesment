<?php
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