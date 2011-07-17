<?php

require_once ( dirname( __FILE__ ) . "/jmm-view.php" );


$view = new JMM_View( array(

  '_views_path' => ( dirname( __FILE__ ) . "/rsrc/site/templates" ),

  '_this_alias' => 'view'

) );


$view->set_config_item( 'base-url', "/demo/" );

