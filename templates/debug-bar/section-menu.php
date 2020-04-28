<?php
/**
 * Debug bar event tab listing
 *
 * @since   1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $template ) || ! $template instanceof Plugin_Name_Replace_Me\Core\Utilities\Debug_Bar ) {
	return;
}
$sections = $template->get_param( 'sections', [] );
// Bail early if we dont have any events to display.
if ( empty( $sections ) ) {
	return;
}

?>
<nav id="plugin-name-replace-me-debug-bar-menu">
	<?php foreach ( $sections as $key => $section ): ?>
		<a
			class="debug-menu-item<?= $key === 0 ? ' section-active' : '' ?>"
			href="#"
			data-section="<?= $section->id ?>">
				<?= $section->title ?>
		</a>
	<?php endforeach; ?>
</nav>