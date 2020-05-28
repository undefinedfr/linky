<div class="notice notice-info">
    <p><strong><?php echo __( "Welcome to Linky's plugin", UNDFND_WP_LINKY_DOMAIN ); ?></strong></p>
    <ul>
        <li><?php echo sprintf(__( "To start, you can <a href='%s'>choose a theme</a>", UNDFND_WP_LINKY_DOMAIN ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_themesMenuSlug))); ?></li>
        <li><?php echo sprintf(__( "Then configure the appearance of your page : the header banner, the default colors of your links or the background color of your page from the tab <a href='%s'>Apparence</a>", UNDFND_WP_LINKY_DOMAIN ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_appareanceMenuSlug))); ?></li>
        <li><?php echo sprintf(__( "Choose the <a href='%s'>links of your social profiles</a> so that they appear on your page", UNDFND_WP_LINKY_DOMAIN ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_socialMenuSlug))); ?></li>
        <li><?php echo sprintf(__( "Finally, <a href='%s'>configure your links</a> and view the result!", UNDFND_WP_LINKY_DOMAIN ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_socialMenuSlug))); ?></li>
    </ul>
    <p><a href="<?php echo admin_url('admin.php?page=' . $_GET['page'] . '&admin_notice_dismissed'); ?>" class="button button-primary button-large"><?php echo __('Got it', UNDFND_WP_LINKY_DOMAIN ); ?></a></p>
</div>