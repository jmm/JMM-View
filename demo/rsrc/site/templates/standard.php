<!DOCTYPE html>

<html lang="en-US">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?php echo $view->get_content_item( 'title' ); ?></title>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $view->get_config_item( 'base-url' ); ?>rsrc/site/site.css" />

<?php echo $view->get_content_item( 'head' ); ?>

</head>


<body>

<div id="SITE-primary-layout">

<h1>
Templating Demo Site
</h1>


<nav id="SITE-primary-nav">

<ul class="SITE-nav-items">

<?php

$primary_nav = array(

  'home' => array( 'url' => "/", 'label' => "Home" ),

  'about' => array( 'url' => "/about/about.php", 'label' => "About" )

);
// array


$config = $view->get_config_items();


foreach ( $primary_nav as $nav_id => $nav_item ) {

  $nav_item[ 'html' ] = $nav_item[ 'label' ];

  $nav_item[ 'classes' ] = array( 'SITE-nav-item' );

  if ( $nav_id == $config[ 'site-section' ] ) {

    $nav_item[ 'classes' ][] = 'SITE-current';

  }
  // if


  $nav_item[ 'classes' ] = join( " ", $nav_item[ 'classes' ] );


  if ( strlen( $nav_item[ 'url' ] ) ) {

    $nav_item[ 'url' ] = ltrim( $nav_item[ 'url' ], "/" );

    $nav_item[ 'html' ] = <<<DOCHERE
<a href="{$config[ 'base-url' ]}{$nav_item[ 'url' ]}">{$nav_item[ 'html' ]}</a>
DOCHERE;

  }
  // if


  $primary_nav[ $nav_id ] = <<<DOCHERE
<li class="{$nav_item[ 'classes' ]}">
{$nav_item[ 'html' ]}
</li>
DOCHERE;

}
// foreach


echo join( "\n\n\n", $primary_nav );

?>

</ul>
<!-- .SITE-nav-items -->

</nav>
<!-- #SITE-primary-nav -->


<section id="SITE-primary-content">

<h1>
<?php echo $view->get_content_item( 'primary-content-heading' ); ?>

</h1>


<?php echo $view->get_content_item( 'primary' ); ?>

</section>
<!-- #SITE-primary-content -->


<div id="SITE-footer">

<p>
Copyright So and So | 1 Main St, Anycity, US | 555 555-5555
</p>

</div>
<!-- #SITE-footer -->

</div>
<!-- #SITE-primary-layout -->

</body>

</html>

