
<?php if(!$socials->isEmpty()): ?>
    <nav class="header__social-bar <?php echo $page->get('social_display') == 'yes' ? 'social-hide' : ''; ?>">
        <?php foreach ($socials->getAll() as $social => $value): ?>
            <?php if(!empty($value)): ?>
                <a href="<?php echo $value; ?>" target="_blank" class="<?php echo sanitize_title($social); ?>" title="<?php echo ucfirst($social); ?>" style="fill: <?php echo $textColor ?>">
                    <?php require UNDFND_WP_LINKY_PLUGIN_DIR . '/assets/images/icons/' . sanitize_title($social) . '.svg' ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>
