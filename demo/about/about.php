<?php

/*

This is a page.  It contains only its own unique content.

*/

require_once ( dirname( __FILE__ ) . "/../init.php" );


$view->set_config_item( 'site-section', 'about' );


$view->set_content_item( 'title', "About" );


$content = <<<DOCHERE

<link rel="stylesheet" type="text/css" href="rsrc/about.css" />

DOCHERE;


$view->set_content_item( 'head', $content );


$view->set_content_item( 'primary-content-heading', $view->get_content_item( 'title' ) );


$view->start_set_content_item( 'primary' );

?>

<p>
This is the primary content of the About page.
</p>

<ul>

<li>
One
</li>

<li>
Two
</li>

<li>
Three
</li>

</ul>

<?php

$view->end_set_content_item( 'primary' );


echo $view->get_render( "standard.php" );

