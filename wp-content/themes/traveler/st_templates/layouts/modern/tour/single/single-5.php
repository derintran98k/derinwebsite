<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20-12-2018
 * Time: 1:55 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
while (have_posts()): the_post();
    $post_id = get_the_ID();
    $address = get_post_meta($post_id, 'address', true);
    $review_rate = STReview::get_avg_rate();
    $count_review = STReview::count_review($post_id);
    $lat = get_post_meta($post_id, 'map_lat', true);
    $lng = get_post_meta($post_id, 'map_lng', true);
    $zoom = get_post_meta($post_id, 'map_zoom', true);
    $gallery = get_post_meta($post_id, 'gallery', true);
    $gallery_array = explode(',', $gallery);
    $marker_icon = st()->get_option('st_tours_icon_map_marker', '');
    $tour_external = get_post_meta(get_the_ID(), 'st_tour_external_booking', true);
    $tour_external_link = get_post_meta(get_the_ID(), 'st_tour_external_booking_link', true);
    $booking_type = st_get_booking_option_type();
    $map_iframe = get_post_meta($post_id,'map_iframe',true);
    $is_iframe = get_post_meta(get_the_ID(), 'is_iframe', true);
    ?>
    <div id="st-content-wrapper" class="st-single-tour style-2 st-single-tour-new">
        <div class="hotel-target-book-mobile">
            <div class="price-wrapper">
                <?php echo wp_kses(sprintf(__('from <span class="price">%s</span>', ST_TEXTDOMAIN), STTour::get_price_html(get_the_ID())), ['span' => ['class' => []]]) ?>
            </div>
            <?php
            if ($tour_external == 'off' || empty($tour_external)) {
                ?>
                <a href=""
                   class="btn btn-mpopup btn-green"><?php echo esc_html__('Book Now', ST_TEXTDOMAIN) ?></a>
                <?php
            } else {
                ?>
                <a href="<?php echo esc_url($tour_external_link); ?>"
                   class="btn btn-green"><?php echo esc_html__('Book Now', ST_TEXTDOMAIN) ?></a>
                <?php
            }
            ?>
        </div>
        <div class="st-tour-content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="st-hotel-header">
                            <div class="left">
                                <h2 class="st-heading"><?php the_title(); ?></h2>
                                <div class="sub-heading">
                                    <?php if ($address) {
                                        echo TravelHelper::getNewIcon('ico_maps_add_2', '#5E6D77', '16px', '16px');
                                        echo esc_html($address);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="right">
                                <div class="review-score style-2">
                                    <?php
                                    $avg = STReview::get_avg_rate();
                                    ?>
                                    <div class="review-score-item">
                                        <?php echo st()->load_template('layouts/modern/common/star', '', ['star' => $review_rate, 'style' => 'style-2']); ?>
                                        <span class="per-total"><?php echo esc_attr($avg); ?>/5</span>
                                    </div>
                                    <p class="st-link style-2"><?php comments_number(esc_html__('from 0 review', ST_TEXTDOMAIN), esc_html__('from 1 review', ST_TEXTDOMAIN), esc_html__('from % reviews', ST_TEXTDOMAIN)); ?></p>
                                </div>
                            </div>
                        </div>

                        <!--Tour Info-->
                        <div class="st-tour-feature">
                            <div class="row">
                                <div class="col-xs-6 col-lg-3">
                                    <div class="item">
                                        <div class="icon">
                                            <?php echo TravelHelper::getNewIcon('ico_clock', '#5E6D77', '32px', '32px'); ?>
                                        </div>
                                        <div class="info">
                                            <h4 class="name"><?php echo esc_html__('Duration', ST_TEXTDOMAIN); ?></h4>
                                            <p class="value">
                                                <?php
                                                $duration = get_post_meta(get_the_ID(), 'duration_day', true);
                                                echo esc_html($duration);
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="item">
                                        <div class="icon">
                                            <?php echo TravelHelper::getNewIcon('ico_tour_type', '#5E6D77', '32px', '32px'); ?>
                                        </div>
                                        <div class="info">
                                            <h4 class="name"><?php echo esc_html__('Tour Type', ST_TEXTDOMAIN); ?></h4>
                                            <p class="value">
                                                <?php
                                                $tour_type = get_post_meta(get_the_ID(), 'type_tour', true);
                                                if ($tour_type == 'daily_tour') {
                                                    echo esc_html__('Daily Tour', ST_TEXTDOMAIN);
                                                } else {
                                                    echo esc_html__('Specific Tour', ST_TEXTDOMAIN);
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="item">
                                        <div class="icon">
                                            <?php echo TravelHelper::getNewIcon('ico_adults_blue', '#5E6D77', '32px', '32px'); ?>
                                        </div>
                                        <div class="info">
                                            <h4 class="name"><?php echo esc_html__('Group Size', ST_TEXTDOMAIN); ?></h4>
                                            <p class="value">
                                                <?php
                                                $max_people = get_post_meta(get_the_ID(), 'max_people', true);
                                                if (empty($max_people) or $max_people == 0 or $max_people < 0) {
                                                    echo esc_html__('Unlimited', ST_TEXTDOMAIN);
                                                } else {
                                                    if ($max_people == 1)
                                                        echo sprintf(esc_html__('%s person', ST_TEXTDOMAIN), $max_people);
                                                    else
                                                        echo sprintf(esc_html__('%s people', ST_TEXTDOMAIN), $max_people);
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-lg-3">
                                    <div class="item">
                                        <div class="icon">
                                            <?php echo TravelHelper::getNewIcon('Group', '#5E6D77', '32px', '32px'); ?>
                                        </div>
                                        <div class="info">
                                            <h4 class="name"><?php echo esc_html__('Languages', ST_TEXTDOMAIN); ?></h4>
                                            <p class="value">
                                                <?php
                                                $term_list = wp_get_post_terms(get_the_ID(), 'languages');
                                                $str_term_arr = [];
                                                if (!is_wp_error($term_list) && !empty($term_list)) {
                                                    foreach ($term_list as $k => $v) {
                                                        array_push($str_term_arr, $v->name);
                                                    }

                                                    echo implode(', ', $str_term_arr);
                                                } else {
                                                    echo '___';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Tour info-->
                        <?php
                        if (!empty($gallery_array)) { ?>
                            <div class="st-gallery" data-width="100%"
                                 data-nav="thumbs" data-allowfullscreen="true">
                                <div class="fotorama" data-auto="false">
                                    <?php
                                    foreach ($gallery_array as $value) {
                                        ?>
                                        <img src="<?php echo wp_get_attachment_image_url($value, [870, 555]) ?>">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="shares dropdown">
                                    <?php $video_url = get_post_meta(get_the_ID(), 'video', true);
                                    if (!empty($video_url)) {
                                        ?>
                                        <a href="<?php echo esc_url($video_url); ?>"
                                           class="st-video-popup share-item"><?php echo TravelHelper::getNewIcon('video-player', '#FFFFFF', '20px', '20px') ?></a>
                                    <?php } ?>
                                    <a href="#" class="share-item social-share">
                                        <?php echo TravelHelper::getNewIcon('ico_share', '', '20px', '20px') ?>
                                    </a>
                                    <ul class="share-wrapper">
                                        <li><a class="facebook"
                                               href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                               target="_blank" rel="noopener" original-title="Facebook"><i
                                                        class="fa fa-facebook fa-lg"></i></a></li>
                                        <li><a class="twitter"
                                               href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                               target="_blank" rel="noopener" original-title="Twitter"><i
                                                        class="fa fa-twitter fa-lg"></i></a></li>
                                        <li><a class="google"
                                               href="https://plus.google.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                               target="_blank" rel="noopener" original-title="Google+"><i
                                                        class="fa fa-google-plus fa-lg"></i></a></li>
                                        <li><a class="no-open pinterest"
                                               href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','https://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"
                                               target="_blank" rel="noopener" original-title="Pinterest"><i
                                                        class="fa fa-pinterest fa-lg"></i></a></li>
                                        <li><a class="linkedin"
                                               href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                               target="_blank" rel="noopener" original-title="LinkedIn"><i
                                                        class="fa fa-linkedin fa-lg"></i></a></li>
                                    </ul>
                                    <?php echo st()->load_template('layouts/modern/hotel/loop/wishlist'); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <!--Tour Overview-->
                        <?php
                        global $post;
                        $content = $post->post_content;
                        $count = str_word_count($content);
                        if (!empty($content)) {
                            ?>
                            <div class="st-overview">
                                <h3 class="st-section-title"><?php echo esc_html__('Overview', ST_TEXTDOMAIN); ?></h3>
                                <div class="st-description">
                                    <div class="st-description-more">
                                        <?php
                                        echo wp_trim_words(get_the_content(), 50, '...');
                                        ?>
                                        <span class="stt-more"><?php echo esc_html__('More', ST_TEXTDOMAIN); ?></span>
                                    </div>
                                    <div class="st-description-less">
                                        <?php echo the_content(); ?>
                                        <span class="stt-less"><?php echo esc_html__('Less', ST_TEXTDOMAIN); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--End Tour Overview-->

                        <!--Tour highlight-->

                        <?php
                        $tours_highlight = get_post_meta(get_the_ID(), 'tours_highlight', true);
                        if (!empty($tours_highlight)) {
                            $arr_highlight = explode("\n", trim($tours_highlight));
                            ?>
                            <div class="st-highlight">
                                <h3 class="st-section-title"><?php echo esc_html__('HIGHLIGHTS', ST_TEXTDOMAIN); ?></h3>
                                <ul>
                                    <?php
                                    if (!empty($arr_highlight)) {
                                        foreach ($arr_highlight as $k => $v) {
                                            echo '<li>' . esc_html($v) . '</li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <!--End Tour highlight-->

                        <!--Tour program-->
                        <div class="st-program">
                            <?php
                            $tour_program_style = get_post_meta(get_the_ID(), 'tours_program_style', true);
                            if (empty($tour_program_style))
                                $tour_program_style = 'style1';
                            ?>
                            <div class="st-title-wrapper">
                                <h3 class="st-section-title"><?php echo esc_html__('Itinerary', ST_TEXTDOMAIN); ?></h3>
                            </div>
                            <div class="st-program-list <?php echo esc_attr($tour_program_style); ?>">
                                <?php
                                echo st()->load_template('layouts/modern/tour/single/items/itenirary/' . $tour_program_style);
                                ?>
                            </div>
                        </div>
                        <!--End Tour program-->

                        <!--Tour Include/Exclude-->
                        <div class="st-include">
                            <h3 class="st-section-title">
                                <?php echo esc_html__('Included/Exclude', ST_TEXTDOMAIN); ?>
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="include">
                                        <?php
                                        $include = get_post_meta(get_the_ID(), 'tours_include', true);
                                        if (!empty($include)) {
                                            $in_arr = explode("\n", $include);
                                            if (!empty($in_arr)) {
                                                foreach ($in_arr as $k => $v) {
                                                    echo '<li>' . TravelHelper::getNewIcon('check-1', '#2ECC71', '14px', '14px', false) . $v . '</li>';
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="exclude">
                                        <?php
                                        $exclude = get_post_meta(get_the_ID(), 'tours_exclude', true);
                                        if (!empty($exclude)) {
                                            $ex_arr = explode("\n", $exclude);
                                            if (!empty($ex_arr)) {
                                                foreach ($ex_arr as $k => $v) {
                                                    echo '<li>' . TravelHelper::getNewIcon('remove', '#FA5636', '18px', '18px', false) . $v . '</li>';
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--End Tour Include/Exclude-->

                        <!--Tour Map-->
                        <?php if($is_iframe == 'on'){
                            if(!empty($map_iframe)){ ?>
                                <div class="st-hr large st-height2"></div>
                                <div class="st-map-wrapper">
                                    <div class="st-flex space-between">
                                        <h2 class="st-heading-section mg0"><?php echo __('Tour\'s Location', ST_TEXTDOMAIN) ?></h2>
                                        <?php if ($address) {
                                            ?>
                                            <div class="c-grey"><?php
                                                echo TravelHelper::getNewIcon('Ico_maps', '#5E6D77', '18px', '18px');
                                                echo esc_html($address); ?></div>
                                            <?php
                                        } ?>
                                    </div>
                                    <div class="map_iframe">
                                        <?php echo balanceTags($map_iframe); ?>
                                    </div>

                                </div>
                            <?php } }else{ ?>
                            <div class="st-hr large st-height2"></div>
                            <div class="st-map-wrapper">
                                <?php
                                if (!$zoom) {
                                    $zoom = 13;
                                }
                                ?>
                                <div class="st-flex space-between">
                                    <h2 class="st-heading-section mg0"><?php echo __('Tour\'s Location', ST_TEXTDOMAIN) ?></h2>
                                    <?php if ($address) {
                                        ?>
                                        <div class="c-grey"><?php
                                            echo TravelHelper::getNewIcon('Ico_maps', '#5E6D77', '18px', '18px');
                                            echo esc_html($address); ?></div>
                                        <?php
                                    } ?>
                                </div>
                                <?php $default = array(
                                    'number'      => '12' ,
                                    'range'       => '20' ,
                                    'show_circle' => 'no' ,
                                );
                                extract($default);
                                $hotel = new STTour();
                                $location_center  = '[' . $lat . ',' . $lng . ']';
                                $map_lat_center = $lat;
                                $map_lng_center = $lng;
                                $map_icon = st()->get_option('st_tour_icon_map_marker', '');
                                if (empty($map_icon)){
                                    $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_tours.png';
                                }
                                $data_map = array();
                                $stt  =  1;
                                global $post;
                                $properties = $hotel->properties_near_by(get_the_ID(), $lat, $lng, $range);
                                if( !empty($properties)){
                                    foreach($properties as $key => $val){
                                        $data_map[] = array(
                                            'id' => get_the_ID(),
                                            'name' => $val['name'],
                                            'post_type' => 'st_hotel',
                                            'lat' => (float)$val['lat'],
                                            'lng' => (float)$val['lng'],
                                            'icon_mk' => (empty($val['icon']))? 'http://maps.google.com/mapfiles/marker_black.png': $val['icon'],
                                            'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $val])),

                                        );
                                    }
                                }
                                $map_icon = st()->get_option('st_tours_icon_map_marker', '');
                                if (empty($map_icon)){
                                    $map_icon = get_template_directory_uri() . '/v2/images/markers/ico_mapker_tours.png';
                                }

                                $data_map_origin = array();
                                $data_map_origin = array(
                                    'id' => $post_id,
                                    'post_id' => $post_id,
                                    'name' => get_the_title(),
                                    'description' => "",
                                    'lat' => $lat,
                                    'lng' => $lng,
                                    'icon_mk' => $map_icon,
                                    'featured' => get_the_post_thumbnail_url($post_id),
                                );
                                $data_map[] = array(
                                    'id' => $post_id,
                                    'name' => get_the_title(),
                                    'post_type' => 'st_hotel',
                                    'lat' => $lat,
                                    'lng' => $lng,
                                    'icon_mk' => $map_icon,
                                    'content_html' => preg_replace('/^\s+|\n|\r|\s+$/m', '', st()->load_template('layouts/modern/hotel/elements/property',false,['data' => $data_map_origin])),

                                );

                                $data_map       = json_encode( $data_map , JSON_FORCE_OBJECT );
                                ?>
                                <?php $google_api_key = st()->get_option('st_googlemap_enabled');
                                if ($google_api_key === 'on') { ?>
                                    <div class="st-map mt30">
                                        <div class="google-map gmap3" id="list_map"
                                            data-data_show='<?php echo str_ireplace(array("'"),'\"',$data_map) ;?>'
                                            data-lat="<?php echo trim($lat) ?>"
                                            data-lng="<?php echo trim($lng) ?>"
                                            data-icon="<?php echo esc_url($marker_icon); ?>"
                                            data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                                            data-showcustomcontrol="true"
                                            data-style="normal">
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="st-map-box mt30">
                                        <div class="google-map-mapbox" data-lat="<?php echo trim($lat) ?>"
                                             data-lng="<?php echo trim($lng) ?>"
                                             data-icon="<?php echo esc_url($marker_icon); ?>"
                                             data-zoom="<?php echo (int)$zoom; ?>" data-disablecontrol="true"
                                             data-showcustomcontrol="true"
                                             data-style="normal">
                                            <div id="st-map">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <!--End Tour Map-->

                        <!--Tour FAQ-->
                        <?php
                        $tour_faq = get_post_meta(get_the_ID(), 'tours_faq', true);
                        if (!empty($tour_faq)) {
                            ?>
                            <div class="st-faq">
                                <h3 class="st-section-title">
                                    <?php echo esc_html__('FAQs', ST_TEXTDOMAIN); ?>
                                </h3>
                                <?php $i = 0;
                                foreach ($tour_faq as $k => $v) { ?>
                                    <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
                                        <div class="header">
                                            <?php echo TravelHelper::getNewIcon('question-help-message', '#5E6D77', '18px', '18px'); ?>
                                            <h5><?php echo esc_html($v['title']); ?></h5>
                                            <span class="arrow">
                                                <i class="fa fa-angle-down"></i>
                                            </span>
                                        </div>
                                        <div class="body">
                                            <?php echo balanceTags(nl2br($v['desc'])); ?>
                                        </div>
                                    </div>
                                    <?php $i++;
                                } ?>
                            </div>
                            <?php
                        }
                        ?>
                        <!--End Tour FAQ-->

                        <!--Review Option-->
                        <?php if (comments_open() and st()->get_option('activity_tour_review') == 'on') { ?>
                            <div class="st-hr large st-height2 st-hr-comment"></div>
                            <h2 class="st-heading-section"><?php echo esc_html__('Reviews', ST_TEXTDOMAIN) ?></h2>
                            <div id="reviews" data-toggle-section="st-reviews" class=" stoped-scroll-section">
                                <div class="review-box">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="review-box-score">
                                                <?php
                                                $avg = STReview::get_avg_rate();
                                                ?>
                                                <div class="review-score">
                                                    <?php echo esc_attr($avg); ?><span class="per-total">/5</span>
                                                </div>
                                                <div class="review-score-stars"> <?php echo st()->load_template('layouts/modern/common/star', '', ['star' => $review_rate, 'style' => 'style-2']); ?></div>
                                                <div class="review-score-base">
                                                    <?php echo esc_html__('Based on', ST_TEXTDOMAIN) ?>
                                                    <span><?php comments_number(esc_html__('0 review', ST_TEXTDOMAIN), esc_html__('1 review', ST_TEXTDOMAIN), esc_html__('% reviews', ST_TEXTDOMAIN)); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="review-sumary">
                                                <?php
                                                $stats = STReview::get_review_summary();
                                                if ($stats) {
                                                    foreach ($stats as $stat) {
                                                        ?>
                                                        <div class="item">
                                                            <div class="label">
                                                                <?php echo esc_html($stat['name']); ?>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="percent"
                                                                     style="width: <?php echo esc_attr($stat['percent']); ?>%;"></div>
                                                            </div>

                                                            <div class="number"><?php echo esc_html($stat['summary']) ?>
                                                                /5
                                                            </div>
                                                        </div>
                                                    <?php }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-pagination">
                                    <div class="summary">
                                        <?php
                                        $comments_count = wp_count_comments(get_the_ID());
                                        $total = (int)$comments_count->approved;
                                        $comment_per_page = (int)get_option('comments_per_page', 10);
                                        $paged = (int)STInput::get('comment_page', 1);
                                        $from = $comment_per_page * ($paged - 1) + 1;
                                        $to = ($paged * $comment_per_page < $total) ? ($paged * $comment_per_page) : $total;
                                        ?>
                                    </div>
                                    <div id="reviews" class="review-list">
                                        <?php
                                        $offset = ($paged - 1) * $comment_per_page;
                                        $args = [
                                            'number' => $comment_per_page,
                                            'offset' => $offset,
                                            'post_id' => get_the_ID(),
                                            'status' => ['approve']
                                        ];
                                        $comments_query = new WP_Comment_Query;
                                        $comments = $comments_query->query($args);

                                        if ($comments):
                                            foreach ($comments as $key => $comment):
                                                echo st()->load_template('layouts/modern/common/reviews/review', 'list-2', ['comment' => (object)$comment, 'post_type' => 'st_tours']);
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="review-pag-wrapper">
                                    <div class="review-pag-text">
                                        <?php echo sprintf(esc_html__('Showing %s - %s of %s in total', ST_TEXTDOMAIN), $from, $to, get_comments_number_text('0', '1', '%')) ?>
                                    </div>
                                    <?php TravelHelper::pagination_comment(['total' => $total]) ?>
                                </div>
                                <?php
                                if (comments_open($post_id)) {
                                    ?>
                                    <div id="write-review">
                                        <h4 class="heading">
                                            <a href="" class="toggle-section c-main f16"
                                               data-target="st-review-form"><?php echo esc_html__('Write a review', ST_TEXTDOMAIN) ?>
                                                <i class="fa fa-angle-down ml5"></i></a>
                                        </h4>
                                        <?php
                                        TravelHelper::comment_form();
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <!--End Review Option-->

                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <?php
                        $info_price = STTour::get_info_price();
                        ?>
                        <div class="widgets style2">
                            <div class="fixed-on-mobile" id="booking-request" data-screen="992px">
                                <div class="close-icon hide">
                                    <?php echo TravelHelper::getNewIcon('Ico_close'); ?>
                                </div>

                                <?php
                                if ($booking_type == 'instant_enquire') {
                                    ?>
                                    <div class="form-book-wrapper relative">
                                        <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price_new'] > 0) { ?>
                                            <div class="tour-sale-box">
                                                <?php echo STFeatured::get_sale($info_price['discount']); ?>
                                            </div>
                                        <?php } ?>
                                        <?php echo st()->load_template('layouts/modern/common/loader'); ?>
                                        <div class="form-head">
                                            <div class="price">
                                                <span class="label">
                                                    <?php echo esc_html__("from", ST_TEXTDOMAIN) ?>
                                                </span>
                                                <span class="value">
                                                    <?php
                                                    echo STTour::get_price_html(get_the_ID());
                                                    ?>
                                                </span>
                                                <span class="label person">
                                                            <?php echo esc_html__(" per person", ST_TEXTDOMAIN) ?>
                                                        </span>
                                            </div>
                                        </div>
                                        <nav>
                                            <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
                                                <li class="active"><a id="nav-book-tab" data-toggle="tab"
                                                                      href="#nav-book" role="tab"
                                                                      aria-controls="nav-home"
                                                                      aria-selected="true"><?php echo esc_html__('Book', ST_TEXTDOMAIN) ?></a>
                                                </li>
                                                <li><a id="nav-inquirement-tab" data-toggle="tab"
                                                       href="#nav-inquirement" role="tab" aria-controls="nav-profile"
                                                       aria-selected="false"><?php echo esc_html__('Inquiry', ST_TEXTDOMAIN) ?></a>
                                                </li>
                                            </ul>
                                        </nav>
                                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                            <div class="tab-pane fade in active" id="nav-book" role="tabpanel"
                                                 aria-labelledby="nav-book-tab">
                                                <?php if (empty($tour_external) || $tour_external == 'off') { ?>
                                                    <form id="form-booking-inpage" method="post"
                                                          action="#booking-request"
                                                          class="tour-booking-form form-has-guest-name">
                                                        <input type="hidden" name="action" value="tours_add_to_cart">
                                                        <input type="hidden" name="item_id"
                                                               value="<?php echo get_the_ID(); ?>">
                                                        <input type="hidden" name="type_tour"
                                                               value="<?php echo get_post_meta(get_the_ID(), 'type_tour', true) ?>">
                                                        <?php
                                                        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                                        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                                                        $start = STInput::request('start', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
                                                        $end = STInput::request('end', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
                                                        $date = STInput::request('date', date('d/m/Y h:i a', strtotime($current_calendar)) . '-' . date('d/m/Y h:i a', strtotime($current_calendar)));
                                                        $has_icon = (isset($has_icon)) ? $has_icon : false;
                                                        ?>
                                                        <div class="form-group form-date-field form-date-search clearfix <?php if ($has_icon) echo ' has-icon '; ?>"
                                                             data-format="<?php echo TravelHelper::getDateFormatMoment() ?>"
                                                             data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                            <?php
                                                            if ($has_icon) {
                                                                echo TravelHelper::getNewIcon('ico_calendar_search_box');
                                                            }
                                                            ?>
                                                            <div class="date-wrapper clearfix">
                                                                <div class="check-in-wrapper">
                                                                    <label><?php echo esc_html__('Date', ST_TEXTDOMAIN); ?></label>
                                                                    <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                                                                    <?php
                                                                    $class_hidden_enddate = 'hidden';
                                                                    if ($tour_type != 'daily_tour' && (strtotime($end) - strtotime($start)) > 0) {
                                                                        $class_hidden_enddate = '';
                                                                    }
                                                                    ?>
                                                                    <span class="sts-tour-checkout-label <?php echo esc_attr($class_hidden_enddate); ?>"><span> - </span><div
                                                                                class="render check-out-render"><?php echo esc_html($end); ?></div></span>
                                                                </div>
                                                                <i class="fa fa-angle-down arrow"></i>
                                                            </div>
                                                            <input type="text" class="check-in-input"
                                                                   value="<?php echo esc_attr($start) ?>"
                                                                   name="check_in">
                                                            <input type="hidden" class="check-out-input"
                                                                   value="<?php echo esc_attr($end) ?>"
                                                                   name="check_out">
                                                            <input type="text" class="check-in-out-input"
                                                                   value="<?php echo esc_attr($date) ?>"
                                                                   name="check_in_out"
                                                                   data-action="st_get_availability_tour_frontend"
                                                                   data-tour-id="<?php the_ID(); ?>"
                                                                   data-posttype="st_tours">
                                                        </div>

                                                        <?php
                                                        /*Starttime*/
                                                        $starttime_value = STInput::request('starttime_tour', '');
                                                        ?>

                                                        <div class="form-group form-more-extra st-form-starttime" <?php echo ($starttime_value != '') ? '' : 'style="display: none"' ?>>
                                                            <input type="hidden"
                                                                   data-starttime="<?php echo esc_attr($starttime_value); ?>"
                                                                   data-checkin="<?php echo esc_attr($start); ?>"
                                                                   data-checkout="<?php echo esc_attr($end); ?>"
                                                                   data-tourid="<?php echo get_the_ID(); ?>"
                                                                   id="starttime_hidden_load_form"
                                                                   data-posttype="st_tours"/>
                                                            <div class="" id="starttime_box">
                                                                <label><?php echo __('Start time', ST_TEXTDOMAIN); ?></label>
                                                                <select class="form-control st_tour_starttime"
                                                                        name="starttime_tour"
                                                                        id="starttime_tour"></select>
                                                            </div>
                                                        </div>
                                                        <!--End starttime-->

                                                        <?php echo st()->load_template('layouts/modern/tour/elements/search/single/guest', ''); ?>
                                                        <?php echo st()->load_template('layouts/modern/tour/elements/search/single/package', ''); ?>
                                                        <?php echo st()->load_template('layouts/modern/tour/elements/search/single/extra', ''); ?>
                                                        <div class="submit-group">
                                                            <button class="btn btn-green btn-large btn-full upper btn-book-ajax"
                                                                    type="submit"
                                                                    name="submit">
                                                                <?php echo esc_html__('Book Now', ST_TEXTDOMAIN) ?>
                                                                <i class="fa fa-spinner fa-spin hide"></i>
                                                            </button>
                                                            <input style="display:none;" type="submit"
                                                                   class="btn btn-default btn-send-message"
                                                                   data-id="<?php echo get_the_ID(); ?>"
                                                                   name="st_send_message"
                                                                   value="<?php echo esc_html__('Send message', ST_TEXTDOMAIN); ?>">
                                                        </div>
                                                        <div class="message-wrapper mt30">
                                                            <?php echo STTemplate::message() ?>
                                                        </div>
                                                    </form>
                                                <?php } else { ?>
                                                    <div class="submit-group mb30">
                                                        <a href="<?php echo esc_url($tour_external_link); ?>"
                                                           class="btn btn-green btn-large btn-full upper"><?php echo esc_html__('Book Now', ST_TEXTDOMAIN); ?></a>
                                                        <input style="display:none;" type="submit"
                                                               class="btn btn-default btn-send-message"
                                                               data-id="<?php echo get_the_ID(); ?>"
                                                               name="st_send_message"
                                                               value="<?php echo esc_html__('Send message', ST_TEXTDOMAIN); ?>">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="tab-pane fade " id="nav-inquirement" role="tabpanel"
                                                 aria-labelledby="nav-inquirement-tab">
                                                <?php echo st()->load_template('email/email_single_service'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    if ($booking_type == 'enquire') {
                                        ?>
                                        <div class="form-book-wrapper relative">
                                            <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price_new'] > 0) { ?>
                                                <div class="tour-sale-box">
                                                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                                                </div>
                                            <?php } ?>
                                            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
                                            <div class="form-head">
                                                <div class="price">
                                                            <span class="label">
                                                                <?php echo esc_html__("from", ST_TEXTDOMAIN) ?>
                                                            </span>
                                                    <span class="value">
                                                                <?php
                                                                echo STTour::get_price_html(get_the_ID());
                                                                ?>
                                                            </span>
                                                </div>
                                            </div>
                                            <h4 class="title-enquiry-form"><?php echo esc_html__('Inquiry', ST_TEXTDOMAIN); ?></h4>
                                            <?php echo st()->load_template('email/email_single_service'); ?>
                                            <input style="display:none;" type="submit"
                                                   class="btn btn-default btn-send-message"
                                                   data-id="<?php echo get_the_ID(); ?>" name="st_send_message"
                                                   value="<?php echo esc_html__('Send message', ST_TEXTDOMAIN); ?>">
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="form-book-wrapper relative">
                                            <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price_new'] > 0) { ?>
                                                <div class="tour-sale-box">
                                                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                                                </div>
                                            <?php } ?>
                                            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
                                            <div class="form-head">
                                                <div class="price">
                                                <span class="label">
                                                    <?php echo esc_html__("from", ST_TEXTDOMAIN) ?>
                                                </span>
                                                    <span class="value">
                                                    <?php
                                                    echo STTour::get_price_html(get_the_ID());
                                                    ?>
                                                </span>
                                                    <span class="label person"><?php echo esc_html__(" per person", ST_TEXTDOMAIN) ?></span>
                                                </div>
                                            </div>
                                            <?php if (empty($tour_external) || $tour_external == 'off') { ?>
                                                <form id="form-booking-inpage" method="post" action="#booking-request"
                                                      class="tour-booking-form form-has-guest-name">
                                                    <input type="hidden" name="action" value="tours_add_to_cart">
                                                    <input type="hidden" name="item_id"
                                                           value="<?php echo get_the_ID(); ?>">
                                                    <input type="hidden" name="type_tour"
                                                           value="<?php echo get_post_meta(get_the_ID(), 'type_tour', true) ?>">
                                                    <?php
                                                    $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                                    $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                                                    $start = STInput::request('start', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
                                                    $end = STInput::request('end', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
                                                    $date = STInput::request('date', date('d/m/Y h:i a', strtotime($current_calendar)) . '-' . date('d/m/Y h:i a', strtotime($current_calendar)));
                                                    $has_icon = (isset($has_icon)) ? $has_icon : false;
                                                    ?>
                                                    <div class="form-group form-date-field form-date-search clearfix <?php if ($has_icon) echo ' has-icon '; ?>"
                                                         data-format="<?php echo TravelHelper::getDateFormatMoment() ?>"
                                                         data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                        <?php
                                                        if ($has_icon) {
                                                            echo TravelHelper::getNewIcon('ico_calendar_search_box');
                                                        }
                                                        ?>
                                                        <div class="date-wrapper clearfix">
                                                            <div class="check-in-wrapper">
                                                                <label><?php echo esc_html__('Date', ST_TEXTDOMAIN); ?></label>
                                                                <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                                                                <?php
                                                                $class_hidden_enddate = 'hidden';
                                                                if ($tour_type != 'daily_tour' && (strtotime($end) - strtotime($start)) > 0) {
                                                                    $class_hidden_enddate = '';
                                                                }
                                                                ?>
                                                                <span class="sts-tour-checkout-label <?php echo esc_attr($class_hidden_enddate); ?>"><span> - </span><div
                                                                            class="render check-out-render"><?php echo esc_html($end); ?></div></span>
                                                            </div>
                                                            <i class="fa fa-angle-down arrow"></i>
                                                        </div>
                                                        <input type="text" class="check-in-input"
                                                               value="<?php echo esc_attr($start) ?>" name="check_in">
                                                        <input type="hidden" class="check-out-input"
                                                               value="<?php echo esc_attr($end) ?>" name="check_out">
                                                        <input type="text" class="check-in-out-input"
                                                               value="<?php echo esc_attr($date) ?>" name="check_in_out"
                                                               data-action="st_get_availability_tour_frontend"
                                                               data-tour-id="<?php the_ID(); ?>"
                                                               data-posttype="st_tours">
                                                    </div>

                                                    <?php
                                                    /*Starttime*/
                                                    $starttime_value = STInput::request('starttime_tour', '');
                                                    ?>

                                                    <div class="form-group form-more-extra st-form-starttime" <?php echo ($starttime_value != '') ? '' : 'style="display: none"' ?>>
                                                        <input type="hidden"
                                                               data-starttime="<?php echo esc_attr($starttime_value); ?>"
                                                               data-checkin="<?php echo esc_attr($start); ?>"
                                                               data-checkout="<?php echo esc_attr($end); ?>"
                                                               data-tourid="<?php echo get_the_ID(); ?>"
                                                               id="starttime_hidden_load_form"
                                                               data-posttype="st_tours"/>
                                                        <div class="" id="starttime_box">
                                                            <label><?php echo esc_html__('Start time', ST_TEXTDOMAIN); ?></label>
                                                            <select class="form-control st_tour_starttime"
                                                                    name="starttime_tour"
                                                                    id="starttime_tour"></select>
                                                        </div>
                                                    </div>
                                                    <!--End starttime-->

                                                    <?php echo st()->load_template('layouts/modern/tour/elements/search/single/guest', ''); ?>
                                                    <?php echo st()->load_template('layouts/modern/tour/elements/search/single/package', ''); ?>
                                                    <?php echo st()->load_template('layouts/modern/tour/elements/search/single/extra', ''); ?>
                                                    <div class="submit-group">
                                                        <button class="btn btn-green btn-large btn-full upper btn-book-ajax"
                                                                type="submit"
                                                                name="submit">
                                                            <?php echo esc_html__('Book Now', ST_TEXTDOMAIN) ?>
                                                            <i class="fa fa-spinner fa-spin hide"></i>
                                                        </button>
                                                        <input style="display:none;" type="submit"
                                                               class="btn btn-default btn-send-message"
                                                               data-id="<?php echo get_the_ID(); ?>"
                                                               name="st_send_message"
                                                               value="<?php echo esc_html__('Send message', ST_TEXTDOMAIN); ?>">
                                                    </div>
                                                    <div class="message-wrapper mt30">
                                                        <?php echo STTemplate::message() ?>
                                                    </div>
                                                </form>
                                            <?php } else { ?>
                                                <div class="submit-group mb30">
                                                    <a href="<?php echo esc_url($tour_external_link); ?>"
                                                       class="btn btn-green btn-large btn-full upper"><?php echo esc_html__('Book Now', ST_TEXTDOMAIN); ?></a>
                                                    <input style="display:none;" type="submit"
                                                           class="btn btn-default btn-send-message"
                                                           data-id="<?php echo get_the_ID(); ?>" name="st_send_message"
                                                           value="<?php echo esc_html__('Send message', ST_TEXTDOMAIN); ?>">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $args = [
                    'posts_per_page' => 4,
                    'post_type' => 'st_tours',
                    'post_author' => get_post_field('post_author', get_the_ID()),
                    'post__not_in' => [$post_id]
                ];
                global $post;
                $old_post = $post;
                $query = new WP_Query($args);
                if ($query->have_posts()):
                    ?>
                    <div class="st-hr large"></div>
                    <h2 class="heading text-center f28 mt50"><?php echo esc_html__('You might also like', ST_TEXTDOMAIN) ?></h2>
                    <div class="st-list-tour-related row mt50">
                        <?php
                        while ($query->have_posts()): $query->the_post();
                            ?>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="item has-matchHeight">
                                    <div class="featured">
                                        <a href="<?php the_permalink() ?>">
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), [800, 600]) ?>"
                                                 alt="<?php echo TravelHelper::get_alt_image() ?>"
                                                 class="img-responsive">
                                        </a>
                                        <?php echo st()->load_template('layouts/modern/hotel/loop/wishlist-2'); ?>
                                        <?php echo st_get_avatar_in_list_service(get_the_ID(), 50); ?>
                                    </div>
                                    <div class="body">
                                        <?php
                                        $address = get_post_meta(get_the_ID(), 'address', true);
                                        if ($address) {
                                            echo TravelHelper::getNewIcon('ico_maps_add_2', '#5E6D77', '16px', '16px');
                                            echo '<span class="ml5 f14 address">' . esc_html($address) . '</span>';
                                        }
                                        ?>
                                        <h4 class="title"><a href="<?php the_permalink() ?>"
                                                             class="st-link c-main"><?php the_title(); ?></a></h4>
                                        <?php
                                        $review_rate = STReview::get_avg_rate();
                                        echo st()->load_template('layouts/modern/common/star', '', ['star' => $review_rate, 'style' => 'style-2']);
                                        ?>
                                        <p class="review-text"><?php comments_number(esc_html__('0 review', ST_TEXTDOMAIN), esc_html__('1 review', ST_TEXTDOMAIN), esc_html__('% reviews', ST_TEXTDOMAIN)); ?></p>
                                        <div class="st-flex space-between">
                                            <div class="left st-flex">
                                                <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '16px', '16px'); ?>
                                                <span class="duration"><?php echo get_post_meta(get_the_ID(), 'duration_day', true); ?></span>
                                            </div>
                                            <div class="right st-flex">
                                                <?php echo TravelHelper::getNewIcon('thunder', '#FFAB53', '9px', '16px', false); ?>
                                                <span class="price">
                                                                <?php echo sprintf(esc_html__('from %s', ST_TEXTDOMAIN), STTour::get_price_html(get_the_ID())); ?>
                                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        ?>
                    </div>
                <?php
                endif;
                wp_reset_postdata();
                $post = $old_post;
                ?>
            </div>
        </div>
    </div>
<?php
endwhile;
