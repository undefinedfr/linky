<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="notice notice-info">
    <p><strong><?php esc_html_e( "Welcome to Linky's plugin", 'linky' ); ?></strong></p>
    <ul>
        <li><?php echo esc_html( sprintf(__( "To start, you can <a href='%s'>choose a theme</a>", 'linky' ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_themesMenuSlug))) ); ?></li>
        <li><?php echo esc_html( sprintf(__( "Then configure the appearance of your page : the header banner, the default colors of your links or the background color of your page from the tab <a href='%s'>Appearance</a>", 'linky' ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_appareanceMenuSlug))) ); ?></li>
        <li><?php echo esc_html( sprintf(__( "Choose the <a href='%s'>links of your social profiles</a> so that they appear on your page", 'linky' ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_socialMenuSlug))) ); ?></li>
        <li><?php echo esc_html( sprintf(__( "Finally, <a href='%s'>configure your links</a> and view the result!", 'linky' ), admin_url('admin.php?page=' . $this->_getMenuSlug($this->_socialMenuSlug))) ); ?></li>
    </ul>
    <p><a href="<?php echo esc_url( admin_url('admin.php?page=' . sanitize_text_field($_GET['page']) . '&admin_notice_dismissed') ); ?>" class="button button-primary button-large"><?php esc_html_e('Got it', 'linky' ); ?></a></p>
</div>
