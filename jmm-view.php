<?php

/*

View / template engine.

Copyright © 2011 Jesse McCarthy <http://jessemccarthy.net/>

This software may be used under the MIT (aka X11) license or Simplified BSD
(aka FreeBSD) license.  See LICENSE.

*/


class JMM_View {

  /// @property array Configuration data.

  protected $config = array();


  /// @property array Content items.

  protected $content = array();


  /// @property array Buffers currently capturing content for $content.

  protected $buffers = array();


  /**
   * Constructor.
   *
   * @param array $config Config parameters.
   *
   * @return void
   */

  public function __construct( $config = array() ) {

    $this->config = array_merge( $this->config, $config );


    return;

  }
  // __construct



  /**
   * Get a content item.
   *
   * @param string $content_id Key identifying the content item.
   *
   * @return mixed Content value.
   */

  public function get_content_item( $content_id ) {

    return $this->content[ $content_id ];

  }
  // get_content_item


  /**
   * Get content items.
   *
   * @param array $content_items Keys identifying content items.  If unspecified, all content items returned.
   *
   * @return array Requested content items.
   */

  public function get_content_items( $content_items = array() ) {

    $content = array();


    if ( $content_items ) {

      foreach ( $content_items as $content_id ) {

        $content[ $content_id ] = $this->content[ $content_id ];

      }
      // foreach

    }
    // if


    else {

      $content = $this->content;

    }
    // else


    return $content;

  }
  // get_content_items


  /**
   * Set a content item.
   *
   * @param string $content_id Key identifying the content item.
   *
   * @param mixed $content Content value.
   *
   * @return void
   */

  public function set_content_item( $content_id, $content ) {

    $this->content[ $content_id ] = $content;


    return;

  }
  // set_content_item


  /**
   * Set content items.
   *
   * @param array $content_items Associative array of content items.
   *
   * @return void
   */

  public function set_content_items( $content_items ) {

    foreach ( $content_items as $content_id => $content ) {

      $this->set_content_item( $content_id, $content );

    }
    // foreach


    return;

  }
  // set_content_items


  /**
   * Begin capturing a content item.
   *
   * @param string $content_id Key identifying the content item.
   *
   * @return void
   */

  public function start_set_content_item( $content_id ) {

    ob_start();

    array_push( $this->buffers, $content_id );


    return;

  }
  // start_set_content_item


  /**
   * Finish capturing a content item.
   *
   * @param string $content_id Optional argument to document which content item is being captured.  If specified, must match the key passed to the most recent call to start_set_content_item().
   *
   * @return void
   */

  public function end_set_content_item( $content_id = NULL ) {

    $buffer_content_id = array_pop( $this->buffers );

    if ( is_null( $content_id ) || $buffer_content_id == $content_id ) {

      $this->set_content_item( $buffer_content_id, ob_get_clean() );

    }
    // if


    else {

      ob_end_clean();

      for ( $i = ( count( $this->buffers ) - 1 ) ; $i >= 0 ; --$i ) {

        $buffer_content_id = $this->buffers[ $i ];

        unset( $this->buffers[ $i ] );

        if ( $buffer_content_id == $content_id ) {

          break;

        }
        // if

      }
      // for

    }
    // else


    return;

  }
  // end_set_content_item


  /**
   * Get a configuration parameter.
   *
   * @param string $config_id Key identifying the config param.
   *
   * @return mixed
   */

  public function get_config_item( $config_id ) {

    return $this->config[ $config_id ];

  }
  // get_config_item


  /**
   * Get configuration parameters.
   *
   * @param array $config_items Keys identifying the config params.  If unspecified, all config params are returned.
   *
   * @return array Requested config params.
   */

  public function get_config_items( $config_items = array() ) {

    $config = array();


    if ( $config_items ) {

      foreach ( $config_items as $config_id ) {

        $config[ $config_id ] = $this->config[ $config_id ];

      }
      // foreach

    }
    // if


    else {

      $config = $this->config;

    }
    // else


    return $config;

  }
  // get_config_items


  /**
   * Set a configuration parameter.
   *
   * @param string $config_id Key identifying the configuration parameter.
   *
   * @param mixed $config_value Config value.
   *
   * @return void
   */

  public function set_config_item( $config_id, $config_value ) {

    $this->config[ $config_id ] = $config_value;


    return;

  }
  // set_config_item


  /**
   * Set configuration parameters.
   *
   * @param array $config_items Associative array of config params.
   *
   * @return void
   */

  public function set_config_items( $config_items ) {

    foreach ( $config_items as $config_id => $config_value ) {

      $this->set_config_item( $config_id, $config_value );

    }
    // foreach

    return;

  }
  // set_config_items


  /**
   * Execute the specified view script.  Unbuffered output.
   *
   * @param string $view_script, Relative or absolute pathname for the desired ,.  Relative paths will be concatenated with $config[ 'views_path' ].
   *
   * @param array $data Optional data to expose to the view.
   *
   * @return void
   */

  public function echo_render( $view_script, $data = array() ) {

    $config = $this->get_config_items();


    if ( $config[ '_this_alias' ] ) {

      ${$config[ '_this_alias' ]} = $this;

    }
    // if


    unset( $data[ $config[ '_this_alias' ] ], $data[ 'view_script' ] );

    extract( $data );


    $view_script = ( $view_script[0] == "/" ) ? $view_script : "{$config[ '_views_path' ]}/{$view_script}";


    include $view_script;


    return;

  }
  // echo_render


  /**
   * Execute the specified view script.  Buffer the output and return it.
   *
   * @param string $view_script, Relative or absolute pathname for the desired ,.  Relative paths will be concatenated with $config[ 'views_path' ].
   *
   * @param array $data Optional data to expose to the view.
   *
   * @return string View output.
   */

  public function get_render( $view_script, $data = array() ) {

    ob_start();

    $this->echo_render( $view_script, $data );


    return ob_get_clean();

  }
  // get_render

}
// JMM_View

