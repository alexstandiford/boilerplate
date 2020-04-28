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

$section = $template->get_param( 'section' );

if ( ! $section instanceof \Plugin_Name_Replace_Me\Core\Factories\Debug_Bar_Section ) {
	return;
}

$class = $template->get_param( 'active' ) ? " active" : "";
?>
<div class="debug-bar-section<?= $class ?>" id="<?= $section->id; ?>">
	<h2><?= $section->title ?></h2>
	<p><?= $section->subtitle ?></p>

	<?php if ( empty( $section->items ) ): ?>
		<em>Well, that's boring (or perhaps exciting!). Nothing was logged.</em>
	<?php endif; ?>

	<?= $template->get_template( 'tabs', [ 'items' => array_keys( $section->items ) ] ) ?>

	<div class="section-listing">
		<?php foreach ( $section->items as $item_type => $item ): ?>
			<?= $template->get_template( 'console', [ 'item_type' => $item_type, 'items' => $item ] ); ?>
		<?php endforeach; ?>
	</div>
</div>