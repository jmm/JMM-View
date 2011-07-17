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
   * Get a content item, or a fallback value.  Possibly appropriate as an abbreviated alternative to get_content_item().
   *
   * @param string $content_id Key identifying the content item.
   *
   * @param mixed $default Fallback value if the content item does not satisfy criteria of get_defaulted_content().
   *
   * @return mixed Content item value, $default, or other.
   */

  public function content( $content_id, $default = NULL ) {

    return $this->get_defaulted_content( $content_id, $default );

  }
  // content


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
   * Unset a content item.
   *
   * @param string $content_id Key identifying the content item.
   *
   * @return void
   */

  public function unset_content_item( $content_id ) {

    unset( $this->content[ $content_id ] );


    return;

  }
  // unset_content_item


  /**
   * Unset content items
   *
   * @param array $content_items Keys identifying content items.
   *
   * @return void
   */

  public function unset_content_items( $content_items ) {

    foreach ( $content_items as $content_id ) {

      $this->unset_content_item( $content_id );

    }
    // foreach


    return;

  }
  // unset_content_items


  /**
   * Tests whether the item exists, for if you need to distinguish between undef and null.
   *
   * @param string $content_id Key identifying the content item.
   *
   * @return bool True if the content item exists, even if null.
   */

  public function has_content_item( $content_id ) {

    return array_key_exists( $content_id, $this->content );

  }
  // has_content_item


  /**
   * Begin capturing a content item.
   *
   * @param string $content_id Optional key identifying the content item.  Must be specified at least here or in end_set_content_item().  If also specified there, they must match.
   *
   * @return void
   */

  public function start_set_content_item( $content_id = NULL ) {

    ob_start();

    array_push( $this->buffers, $content_id );


    return;

  }
  // start_set_content_item


  /**
   * Finish capturing a content item.
   *
   * @param string $content_id Optional key identifying the content item.  If also specified there, they must match.
   *
   * @return void
   */

  public function end_set_content_item( $content_id = NULL ) {

    $buffer_ids = array( 'start' => array_pop( $this->buffers ), 'end' => $content_id );

    $buffer_id = NULL;


    foreach ( $buffer_ids as $current_id ) {

      if ( $buffer_id == $current_id || ! strlen( $buffer_id ) ) {

        $buffer_id = $current_id;

      }
      // if


      elseif ( strlen( $current_id ) ) {

        $buffer_id = NULL;

      }
      // elseif

    }
    // foreach


    $content = ob_get_clean();


    if ( strlen( $buffer_id ) ) {

      $this->set_content_item( $buffer_id, $content );

    }
    // if


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
   * Unset a config item.
   *
   * @param string $config_id Key identifying the config item.
   *
   * @return void
   */

  public function unset_config_item( $config_id ) {

    unset( $this->config[ $config_id ] );


    return;

  }
  // unset_config_item


  /**
   * Unset config items
   *
   * @param array $config_items Keys identifying config items.
   *
   * @return void
   */

  public function unset_config_items( $config_items ) {

    foreach ( $config_items as $config_id ) {

      $this->unset_config_item( $config_id );

    }
    // foreach


    return;

  }
  // unset_config_items


  /**
   * Tests whether the item exists, for if you need to distinguish between undef and null.
   *
   * @param string $config_id Key identifying the config item.
   *
   * @return bool True if the config item exists, even if null.
   */

  public function has_config_item( $config_id ) {

    return array_key_exists( $config_id, $this->config );

  }
  // has_config_item


  /**
   * Determine whether to use default content or not.  Uses $default if content item value is NULL.  Subclass and override for custom logic.
   *
   * @param string $content_id Key identifying the content item.
   *
   * @param mixed $default Default content.
   *
   * @return mixed Content item value or $default.
   */

  protected function get_defaulted_content( $content_id, $default ) {

    $content = $this->get_content_item( $content_id );


    return ( is_null( $content ) ? $default : $content );

  }
  // get_defaulted_content


  /**
   * Execute the specified view script.  Unbuffered output.
   *
   * @param string $view_script, Relative or absolute pathname for the desired ,.  Relative paths will be concatenated with $config[ 'views_path' ].
   *
   * @param array $data Optional data to expose to the view.
   *
   * @return void
   */

  public function echo_render( $view_scripts, $data = array() ) {

    if ( ! ( $view_scripts = $this->find_view( $view_scripts ) ) ) {

      return;

    }
    // if


    $this->config[ '_temp' ] = array();


    $this->config[ '_temp' ][ 'view_script' ] = $view_scripts;

    unset( $view_scripts );


    if ( $this->config[ '_this_alias' ] ) {

      $data[ $this->config[ '_this_alias' ] ] = $this;

    }
    // if


    $this->config[ '_temp' ][ 'unset_data' ] = ! array_key_exists( 'data', $data );


    unset( $data[ 'this' ] );


    extract( $data );


    if ( $this->config[ '_temp' ][ 'unset_data' ] ) {

      unset( $data );

    }
    // if


    include $this->config[ '_temp' ][ 'view_script' ];


    unset( $this->config[ '_temp' ] );


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

  public function get_render( $view_scripts, $data = array() ) {

    ob_start();

    $this->echo_render( $view_scripts, $data );


    return ob_get_clean();

  }
  // get_render


  /**
   * Determine which of possibly several potential views to use.  Use the first one that is a readable file.  Evaluate relative paths in relation to $this->config[ '_views_path' ].
   *
   * @param string|array $view_scripts One or more paths to possibly extant view scripts.
   *
   * @param $start_path Not currently implemented.
   *
   * @param $end_path Not currently implemented.
   *
   * @return string|NULL Pathname to the selected view script, or NULL if none viable.
   */

  public function find_view( $view_scripts, $start_path = NULL, $end_path = NULL ) {

    $view_scripts = (array) $view_scripts;

    $config = $this->config;


    foreach ( $view_scripts as $view_script ) {

      $view_script = (

        ( $view_script[0] == "/" ) ?

        $view_script :

        "{$config[ '_views_path' ]}/{$view_script}"

      );


      if ( count( $view_scripts ) == 1 || is_readable( $view_script ) ) {

        break;

      }
      // if


      unset( $view_script );

    }
    // foreach


    return $view_script;

  }
  // find_view

}
// JMM_View

