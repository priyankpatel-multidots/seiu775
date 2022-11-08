<?php

/**
 * Messages Trait
 *
 * Allows modules to set global messages
 * This can include notices, errors, and success messages
 */

trait Messages {

	//
	// Singleton state
	//
	static $messages = array();

	//
	// Messaging helper
	//
	function message( $type, $message_code, $args = array() ) {
		if ( isset( static::$message_text[ $type ][ $message_code ] ) ) {
			if ( ! self::has_messages( $type ) ) {
				Messages::$messages[ $type ] = array();
			}
			$message                       = vsprintf( static::$message_text[ $type ][ $message_code ], $args );
			$message                       = __( $message, 'seiu' );
			Messages::$messages[ $type ][] = $message;
		}
	}

	function messageString( $message ) {
		if ( isset( $message ) ) {
			$message              = __( $message, 'seiu' );
			Messages::$messages[] = $message;
		}
	}

	function has_messages( $type ) {
		return isset( Messages::$messages[ $type ] )
			&& is_array( Messages::$messages[ $type ] );
	}
}


