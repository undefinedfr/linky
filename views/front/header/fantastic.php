<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$hide_avatar = true;
$header_title = apply_filters(UNDFND_WP_LINKY_DOMAIN . '_header_title', 'My links');
$header_row_after = '<div class="header__title">' . (($header_title == 'My links') ? __('My links', 'linky') : $header_title) . '</div>';

require_once 'default.php'; ?>
