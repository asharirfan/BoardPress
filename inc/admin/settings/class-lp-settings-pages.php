<?php

/**
 * Class LP_Settings_Pages
 */
class LP_Settings_Pages extends LP_Settings_Base {
	function __construct() {
		$this->id   = 'pages';
		$this->text = __( 'Pages', 'learnpress' );

		parent::__construct();
	}

	function get_sections() {
		$sections = array(
			'profile'          => array(
				'id'    => 'profile',
				'title' => __( 'Profile', 'learnpress' )
			),
			'quiz'          => array(
				'id'    => 'quiz',
				'title' => __( 'Quiz', 'learnpress' )
			),
			'become_a_teacher' => array(
				'id'    => 'become_a_teacher',
				'title' => __( 'Become a teacher', 'learnpress' )
			)
		);
		return $sections = apply_filters( 'learn_press_settings_sections_' . $this->id, $sections );
	}

	function get_settings() {
		return apply_filters(
			'learn_press_page_settings',
			array(
				array( 'section' => 'profile' ),
				array(
					'title'   => __( 'Profile', 'learnpress' ),
					'id'      => $this->get_field_name( 'profile_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				),
				array(
					'title'   => __( 'Add link to admin bar', 'learnpress' ),
					'id'      => $this->get_field_name( 'admin_bar_link' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),
				array(
					'title'       => __( 'Text link', 'learnpress' ),
					'id'          => $this->get_field_name( 'admin_bar_link_text' ),
					'default'     => '',
					'type'        => 'text',
					'placeholder' => __( 'Default: View Course Profile', 'learnpress' ),
					'class'       => 'regular-text'
				),
				array(
					'title'   => __( 'Target link', 'learnpress' ),
					'id'      => $this->get_field_name( 'admin_bar_link_target' ),
					'default' => 'yes',
					'type'    => 'select',
					'options' => array(
						'_self'  => __( 'Self', 'learnpress' ),
						'_blank' => __( 'New window', 'learnpress' )
					)
				),
				/*array(
					'title'   => __( 'Access level', 'learnpress' ),
					'id'      => $this->get_field_name( 'profile_access_level' ),
					'default' => 'private',
					'type'    => 'select',
					'options' => array(
						'private' => __( 'Private (Only account own)', 'learnpress' ),
						'public'  => __( 'Public', 'learnpress' )
					)
				),*/
				array(
					'title' => __( 'Endpoints', 'learnpress' ),
					'type'  => 'title'
				),
				array(
					'title'       => __( 'Tab Courses', 'learnpress' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-courses]' ),
					'default'     => 'courses',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learnpress' ) . sprintf( ' %s <code>[profile/admin/courses]</code>', __( 'Example link is', 'learnpress' ) )
				),
				array(
					'title'       => __( 'Tab Quizzes', 'learnpress' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-quizzes]' ),
					'default'     => 'quizzes',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learnpress' ) . sprintf( ' %s <code>[profile/admin/quizzes]</code>', __( 'Example link is', 'learnpress' ) )
				),
				array(
					'title'       => __( 'Tab Orders', 'learnpress' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-orders]' ),
					'default'     => 'orders',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learnpress' ) . sprintf( ' %s <code>[profile/admin/orders]</code>', __( 'Example link is', 'learnpress' ) )
				),
				array(
					'title'       => __( 'View order', 'learnpress' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-order-details]' ),
					'default'     => 'order-details',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learnpress' ) . sprintf( ' %s <code>[profile/admin/order-details/123]</code>', __( 'Example link is', 'learnpress' ) )
				),
				array( 'section' => 'quiz' ),
				array(
					'title' => __( 'Endpoints', 'learnpress' ),
					'type'  => 'title'
				),
				array(
					'title'       => __( 'Results', 'learnpress' ),
					'id'          => $this->get_field_name( 'quiz_endpoints[results]' ),
					'default'     => 'results',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learnpress' ) . sprintf( ' %s <code>[quizzes/sample-quiz/results]</code>', __( 'Example link is', 'learnpress' ) )
				),
				array( 'section' => 'become_a_teacher' ),
				array(
					'title'   => __( 'Become a teacher', 'learnpress' ),
					'id'      => $this->get_field_name( 'become_a_teacher_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				)
			)
		);
	}

	function _get_settings( $section ) {
		$settings = $this->get_settings();
		$get      = false;
		$return   = array();
		foreach ( $settings as $k => $v ) {
			if ( !empty( $v['section'] ) ) {
				if ( $get ) {
					break;
				}
				if ( $v['section'] == $section ) {
					$get = true;
					continue;
				}
			}
			if ( $get ) {
				$return[] = $v;
			}
		}
		return $return;
	}

	function output_section_profile() {
		$view = learn_press_get_admin_view( 'settings/pages/profile.php' );
		require_once $view;
	}

	function output_section_quiz() {
		$view = learn_press_get_admin_view( 'settings/pages/quiz.php' );
		require_once $view;
	}

	function output_section_become_a_teacher() {
		$view = learn_press_get_admin_view( 'settings/pages/become-a-teacher.php' );
		require_once $view;
	}
}

new LP_Settings_Pages();