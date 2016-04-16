<?php
/*
$exclude_quiz   = array();
$exclude_lesson = array();
$current_user   = get_current_user_id();
global $wpdb;
$q         = $wpdb->prepare(
	"SELECT         pm.meta_value
					FROM            $wpdb->posts        AS p
					INNER JOIN      $wpdb->postmeta     AS pm  ON p.ID = pm.post_id
						WHERE           p.post_type = %s
						AND 			p.post_author = %d
						AND             pm.meta_key = %s",
	LP()->course_post_type,
	$current_user,
	'_lpr_course_lesson_quiz'
);
$used_item = $wpdb->get_col(
	$q
);

for ( $i = 0; $i < count( $used_item ); $i ++ ) {
	$lesson_quiz_array = unserialize( $used_item[$i] );
	for ( $j = 0; $j < count( $lesson_quiz_array ); $j ++ ) {
		if ( isset( $lesson_quiz_array[$j]['lesson_quiz'] ) ) {
			foreach ( $lesson_quiz_array[$j]['lesson_quiz'] as $key => $value ) {
				array_push( $exclude_lesson, $value );
				array_push( $exclude_quiz, $value );
			}
		}
	}
}*/
global $post;
$course_sections = $course->get_curriculum();

$hidden_sections = (array) get_post_meta( $post->ID, '_admin_hidden_sections', true );
?>
<div id="lp-course-curriculum" class="lp-course-curriculum">
	<h3 class="curriculum-heading">
		<?php _e( 'Course Curriculum', 'learnpress' ); ?>
		<span class="description"><?php _e( 'Outline your course and add content with sections, lessons and quizzes.', 'learnpress' ); ?></span>

		<p align="right" class="items-toggle">
			<a href="" data-action="expand" class="dashicons dashicons-arrow-down<?php echo !sizeof( $hidden_sections ) ? ' hide-if-js' : ''; ?>" title="<?php _e( 'Expand All', 'learnpress' ); ?>"></a>
			<a href="" data-action="collapse" class="dashicons dashicons-arrow-up<?php echo sizeof( $hidden_sections ) ? ' hide-if-js' : ''; ?>" title="<?php _e( 'Collapse All', 'learnpress' ); ?>"></a>
		</p>
	</h3>
	<!---->
	<ul class="curriculum-sections">
		<?php
		if ( $course_sections ):
			foreach ( $course_sections as $k => $section ):

				$content_items = '';

				if ( $section->items ):
					foreach ( $section->items as $item ):
						//if ( LP()->quiz_post_type == $item->post_type ) $exclude_quiz[] = $item->ID;
						//if ( LP()->lesson_post_type == $item->post_type ) $exclude_lesson[] = $item->ID;
						$loop_item_view = learn_press_get_admin_view( 'meta-boxes/course/loop-item.php' );
						ob_start();
						include $loop_item_view;
						$content_items .= "\n" . ob_get_clean();
					endforeach;
				endif;

				include learn_press_get_admin_view( 'meta-boxes/course/loop-section.php' );
			endforeach;
			unset( $content_items );
		endif;
		if ( !empty( $section ) ) foreach ( get_object_vars( $section ) as $k => $v ) {
			$section->{$k} = null;
		}
		include learn_press_get_admin_view( 'meta-boxes/course/loop-section.php' );
		?>
	</ul>
</div>