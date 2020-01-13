<?php
/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * Review list
 *
 * Created by ShineTheme
 *
 */
$args['avatar_size'] = 50;
if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) :
else :
    $comment_class = empty($args['has_children']) ? '' : $comment_class .= 'parent';
    if (!$comment->comment_approved) {
        return;
    }

    $comment_id = $comment->comment_ID;
    $user_id = get_comment($comment_id)->user_id;
    $user_email = get_comment($comment_id)->comment_author_email;
    $current_user = wp_get_current_user();
    ?>
    <div class="comment-item">
        <div class="comment-item-head">
            <div class="media">
                <div class="media-left">
                    <?php echo st_get_profile_avatar($user_id, 50) ?>
                </div>
                <div class="media-body">
                    <?php
                    if (!empty($user_id)) {
                        ?>
                        <h4 class="media-heading"><?php echo TravelHelper::get_username($user_id); ?></h4>
                        <?php
                    } else {
                        ?>
                        <h4 class="media-heading"><?php echo esc_html($comment->comment_author); ?></h4>
                        <?php
                    }
                    ?>
                    <div class="date"><?php echo get_comment_date('F d, Y', $comment_id) ?></div>
                </div>
            </div>
            <div class="like">
                <?php
                $count_like = (int)get_comment_meta($comment_id, '_comment_like_count', true);
                echo '<span>' . $count_like . '</span>' . _n(' like this', ' likes this', $count_like, ST_TEXTDOMAIN);
                ?>
                <?php $review_obj = new STReview();
                if ($review_obj->check_like($comment_id)):
                    ?>
                    <a data-id="<?php echo esc_attr($comment_id); ?>" href="#"
                       class="btn-like st-like-review ">
                        <i class="fa fa-thumbs-o-down"></i>
                    </a>
                <?php else: ?>
                    <a data-id="<?php echo esc_attr($comment_id); ?>" href="#"
                       class="btn-like st-like-review ">
                        <i class="fa fa-thumbs-o-up"></i>
                    </a>
                <?php
                endif;
                ?>
            </div>
        </div>
        <div class="comment-item-body">
            <?php
            $stats = STReview::get_review_stats(get_the_ID());
            $comment_rate = (float)get_comment_meta($comment_id, 'comment_rate', true);
            ?>
            <?php if (isset($post_type) and in_array($post_type, ['st_tours', 'st_activity'])) { ?>
                <?php if ($comment_title = get_comment_meta($comment_id, 'comment_title', true)): ?>
                    <h4 class="title st_tours" <?php if (!$stats) echo 'style="padding-left: 0;"'; ?>>
                        <?php echo esc_html(balanceTags($comment_title)) ?>
                    </h4>
                    <?php
                    if ($stats) {
                        echo '<ul class="review-star">';
                        echo TravelHelper::rate_to_string($comment_rate);
                        echo '</ul>';
                    }
                    ?>
                <?php else:
                    if ($stats) {
                        echo '<ul class="review-star">';
                        echo TravelHelper::rate_to_string($comment_rate);
                        echo '</ul>';
                    }
                endif; ?>
            <?php } else {
                ?>
                <?php if ($comment_title = get_comment_meta($comment_id, 'comment_title', true)): ?>
                    <h4 class="title" <?php if (!$stats) echo 'style="padding-left: 0;"'; ?>>
                        <?php
                        if ($stats) {
                            echo '<span class="comment-rate">' . number_format($comment_rate, 1, '.', ',') . '</span>';
                        }
                        ?>
                        "<?php echo esc_html(balanceTags($comment_title)) ?>"
                    </h4>
                <?php else:
                    if ($stats) {
                        echo '<span class="comment-rate">' . number_format($comment_rate, 1, '.', ',') . '</span>';
                    }
                endif; ?>
                <?php
            } ?>
            <?php
            if (!$stats && $comment_rate) {
                ?>
                <div class="st-stars style-2">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $comment_rate) {
                            echo '<i class="fa fa-star"></i>';
                        } else {
                            echo '<i class="fa fa-star grey"></i>';
                        }
                    }
                    ?>
                </div>
            <?php }
            ?>
            <div class="detail">
                <?php
                $content = get_comment_text($comment_id);

                ?>
                <div class="st-description">
                    <div class="st-comment-more">
                        <?php
                        if (str_word_count($content) > 25) {
                            echo wp_trim_words(esc_html($content), 25, '...');
                            ?>
                            <span class="stt-more"><?php echo esc_html__('Read more', ST_TEXTDOMAIN); ?></span>
                        <?php }else {
                             echo esc_html($content);
                        } ?>
                    </div>
                    <div class="st-comment-less">
                        <?php
                        if (str_word_count($content) > 25) {
                            echo esc_html($content); ?>
                            <span class="stt-less"><?php echo esc_html__('Less', ST_TEXTDOMAIN); ?></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endif;

?>
