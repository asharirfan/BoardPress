<?php
/**
 * Admin view for settings page display in admin under menu Settings -> LearnPress
 *
 * @author  ThimPress
 * @package Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setting page
 */
function learn_press_settings_page() {
	LP_Assets::enqueue_style( 'learn-press-admin' );
	LP_Assets::enqueue_script( 'learn-press-admin-settings', LP()->plugin_url( 'assets/js/admin/settings.js' ) );


	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

	$tabs = learn_press_settings_tabs_array();

	if ( !$current_tab && $tabs ) {
		$keys        = array_keys( $tabs );
		$current_tab = reset( $keys );
	}

	// ensure all settings relevant to rewrite rules effect immediately
	flush_rewrite_rules();

	if ( !empty( $_GET['settings-updated'] ) ) : ?>
		<div id="message" class="updated notice is-dismissible">
			<p><?php _e( 'LearnPress settings updated.', 'learnpress' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="wrap">
		<form method="<?php echo esc_attr( apply_filters( 'learn_press_settings_form_method_tab_' . $current_tab, 'post' ) ); ?>" id="mainform" action="" enctype="multipart/form-data">
			<div id="icon-themes" class="icon32"><br></div>
			<h2 class="nav-tab-wrapper">
				<?php if ( $tabs ) foreach ( $tabs as $tab => $name ) { ?>
					<?php $class = ( $tab == $current_tab ) ? ' nav-tab-active' : ''; ?>
					<a class="nav-tab <?php echo $class; ?>" href="?page=learn_press_settings&tab=<?php echo $tab; ?>"><?php echo $name; ?></a>
				<?php } ?>
				<?php do_action( 'learn_press_settings_tabs' ); ?>
			</h2>
			<?php
			do_action( 'learn_press_sections_' . $current_tab );
			do_action( 'learn_press_settings_' . $current_tab );
			?>
			<p>
				<button class="button button-primary"><?php _e( 'Save settings', 'learnpress' ); ?></button>
			</p>
			<?php wp_nonce_field( 'learn_press_settings', 'learn_press_settings_nonce' ); ?>
		</form>
	</div>
	<?php
}

function learn_press_admin_update_settings() {

	$tabs        = learn_press_settings_tabs_array();
	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

	if ( !$current_tab && $tabs ) {
		$keys        = array_keys( $tabs );
		$current_tab = reset( $keys );
	}

	$class_name = apply_filters( 'learn_press_settings_class_' . $current_tab, 'LP_Settings_' . $tabs[$current_tab] );
	if ( !class_exists( $class_name ) ) {
		$class_file = apply_filters( 'learn_press_settings_file_' . $current_tab, LP()->plugin_path( 'inc/admin/settings/class-lp-settings-' . $current_tab . '.php' ) );
		if ( !file_exists( $class_file ) ) {
			return false;
		}

		include_once $class_file;
		if ( !class_exists( $class_name ) ) {

		}
	}

	if ( !empty( $_POST ) ) {
		//	 Check if our nonce is set.
		if ( !isset( $_POST['learn_press_settings_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( !wp_verify_nonce( $_POST['learn_press_settings_nonce'], 'learn_press_settings' ) ) {
			return;
		}

		do_action( 'learn_press_settings_save_' . $current_tab );

		$section = !empty( $_REQUEST['section'] ) ? '&section=' . $_REQUEST['section'] : '';
		LP_Admin_Notice::add( '<p><strong>' . __( 'Settings saved', 'learnpress' ) . '</strong></p>' );

		wp_redirect( admin_url( 'options-general.php?page=learn_press_settings&tab=' . $current_tab . $section . '&settings-updated=true' ) );
		exit();
	}
}