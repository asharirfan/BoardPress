<?php
/**
 * Template for displaying the content of single quiz
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'learn_press_before_single_quiz' ); ?>

	<div itemscope id="quiz-<?php the_ID(); ?>" <?php learn_press_quiz_class(); ?>>

		<?php do_action( 'learn_press_before_single_quiz_summary' ); ?>

		<div class="quiz-summary">

			<?php do_action( 'learn_press_single_quiz_summary' ); ?>

		</div>

		<?php do_action( 'learn_press_after_single_quiz_summary' ); ?>

	</div>

<?php do_action( 'learn_press_after_single_quiz' ); ?>