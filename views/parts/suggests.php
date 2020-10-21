<?php if(!empty($posts->posts)) { ?>
    <ul>
        <?php foreach($posts->posts as $post) { ?>
            <?php
                $imgId = get_post_thumbnail_id($post);
                ?>
            <li data-link="<?php echo get_permalink($post->ID); ?>" data-thumbnail-id="<?php echo $imgId; ?>">
                <?php if(!empty($imgId)) {
                    $img = wp_get_attachment_image_src($imgId, 'medium');
                    ?>
                    <img src="<?php echo reset($img) ?>" alt="">
                <?php } ?>
                <div class="label-link"><?php echo get_the_title($post->ID); ?></div>
            </li>
        <?php } ?>
    </ul>
<?php }?>
