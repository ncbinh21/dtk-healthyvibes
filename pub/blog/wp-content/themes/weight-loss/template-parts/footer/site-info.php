<?php
/**
 * Displays footer site info
 *
 * @subpackage Weight Loss
 * @since 1.0
 * @version 1.4
 */

?>
<div class="site-info">
<a href="<?php echo esc_html(get_theme_mod('weight_loss_footer_link',__('https://www.luzuk.com/themes/free-wordpress-weight-loss-theme/','weight-loss'))); ?>" target="_blank">
	<p><?php weight_loss_credit(); ?> <?php echo esc_html(get_theme_mod('weight_loss_footer_copy',__('By Luzuk','weight-loss'))); ?></p>
</a>
</div>