<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!$socials->isEmpty()): ?>
    <nav class="header__social-bar <?php echo esc_attr( $page->get('social_display') == 'yes' ? 'social-hide' : '' ); ?>">
        <?php foreach ($socials->getAll() as $social => $value): ?>
            <?php if(!empty($value)): ?>
                <a href="<?php echo esc_attr( (($social == 'email' && strpos($value, '@') !== false && strpos($value, 'mailto:') === false) ? 'mailto:' : '') . $value ); ?>" target="_blank" class="<?php echo esc_attr( sanitize_title($social) ); ?>" title="<?php echo esc_attr( ucfirst($social) ); ?>" style="fill: <?php echo esc_attr( $textColor ) ?>">
                    <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/' . sanitize_title($social) . '.svg' ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>
