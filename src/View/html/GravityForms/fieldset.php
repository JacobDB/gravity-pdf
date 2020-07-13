<?php

/**
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2020, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       6.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$width       = isset( $args['width'] ) ? $args['width'] : 'full';
$width_class = 'gform-settings-panel--' . $width;

$collapsible       = ! empty( $args['collapsible'] );
$collapsible_class = $collapsible ? 'gform-settings-panel--collapsible gform-settings-panel--collapsed' : '';
$collapsible_name  = 'gform_settings_section_collapsed_' . $args['id'];

?>

<fieldset id="gfpdf-fieldset-<?= esc_attr( $args['id'] ) ?>" class="gform-settings-panel <?= esc_attr( $width_class ) ?> <?= $collapsible_class ?>">
	<header class="gform-settings-panel__header">
		<?php if ( $collapsible ): ?>
			<legend class="gform-settings-panel__title">
				<label class="gform-settings-panel__title" for="<?= esc_attr( $collapsible_name ) ?>"><?= esc_html( $args['title'] ) ?></label>

				<?php if ( ! empty( $args['tooltip'] ) ): ?>
					<?= $args['tooltip'] ?>
				<?php endif; ?>
			</legend>

			<span class="gform-settings-panel__collapsible-control">
				<input type="checkbox" class="gform-settings-panel__collapsible-toggle-checkbox" name="<?= esc_attr( $collapsible_name ) ?>" id="<?= esc_attr( $collapsible_name ) ?>" value="1" onclick="this.checked ? this.closest( '.gform-settings-panel' ).classList.add( 'gform-settings-panel--collapsed' ) : this.closest( '.gform-settings-panel' ).classList.remove( 'gform-settings-panel--collapsed' )" checked="">
				<label class="gform-settings-panel__collapsible-toggle" for="<?= esc_attr( $collapsible_name ) ?>"><span class="screen-reader-text"><?= sprintf( __( 'Toggle %s Section', 'gravity-forms-pdf-extended' ), esc_html( $args['title'] ) ) ?></span></label>
			</span>
		<?php else: ?>
			<legend class="gform-settings-panel__title">
				<?= esc_html( $args['title'] ) ?>

				<?php if ( ! empty( $args['tooltip'] ) ): ?>
					<?= $args['tooltip'] ?>
				<?php endif; ?>
			</legend>
		<?php endif; ?>
	</header>

	<div class="gform-settings-panel__content <?= isset( $args['content_class'] ) ? esc_attr( $args['content_class'] ) : '' ?>">
		<?php if ( ! empty( $args['desc'] ) ): ?>
			<div class="gform-settings-description gform-settings-panel--full"><?= wp_kses_post( $args['desc'] ) ?></div>
		<?php endif; ?>

		<?= $args['content'] ?>
	</div>
</fieldset>