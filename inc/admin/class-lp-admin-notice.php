<?php
/**
 * Manage the admin notices and display them in admin
 *
 * @package    LearnPress
 * @author     ThimPress
 * @version    1.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class LP_Admin_Notice
 */
class LP_Admin_Notice {
	/**
	 * Store all notices which added anywhere before show
	 * @var array
	 */
	protected static $_notices = array();

	/**
	 * LP_Admin_Notice construct
	 */
	function __construct() {
		add_action( 'admin_notices', array( __CLASS__, 'show_notices' ), 100000 );
	}

	/**
	 * Add new notice to queue
	 *
	 * @param string $message The message want to display
	 * @param string $type    The class name of WP message type updated|update-nag|error
	 * @param string $id      Custom id for html element's ID
	 * @param        bool
	 */
	static function add( $message, $type = 'updated', $id = '', $redirect = false ) {
		if ( $redirect ) {
			$notices = get_transient( 'learn_press_redirect_notices' );
			if ( empty( $notices ) ) {
				$notices = array();
			}
			$notices[] = array(
				'type'    => $type,
				'message' => $message,
				'id'      => $id
			);
			set_transient( 'learn_press_redirect_notices', $notices );
		} else {
			self::$_notices[] = array(
				'type'    => $type,
				'message' => $message,
				'id'      => $id
			);
		}
	}

	static function add_redirect( $message, $type = 'updated', $id = '' ) {
		self::add( $message, $type, $id, true );
	}

	/**
	 * Show all notices has registered
	 */
	static function show_notices() {
		if ( self::$_notices ) {
			foreach ( self::$_notices as $notice ) {
				if ( empty( $notice ) ) {
					continue;
				}
				learn_press_admin_view( 'admin-notice.php', $notice );
			}
		}
		if ( $notices = get_transient( 'learn_press_redirect_notices' ) ) {
			foreach ( $notices as $notice ) {
				if ( empty( $notice ) ) {
					continue;
				}
				learn_press_admin_view( 'admin-notice.php', $notice );
			}
			delete_transient( 'learn_press_redirect_notices' );
		}
	}
}

new LP_Admin_Notice();