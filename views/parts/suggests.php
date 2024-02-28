<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!empty($posts->posts)) { ?>
    <ul>
        <?php foreach($posts->posts as $post) { ?>
            <?php
                $imgId = get_post_thumbnail_id($post);
                ?>
            <li data-link="<?php echo esc_url( get_permalink($post->ID) ); ?>" data-thumbnail-id="<?php echo esc_attr( $imgId ); ?>">
                <?php if(!empty($imgId)) {
                    $img = wp_get_attachment_image_src($imgId, 'medium');
                    ?>
                    <img src="<?php echo esc_url( reset($img) ) ?>" alt="">
                <?php } ?>
                <div class="label-link"><?php echo esc_html( get_the_title($post->ID) ); ?></div>
            </li>
        <?php } ?>
    </ul>
<?php }?>
