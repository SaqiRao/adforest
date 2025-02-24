<?php
global $adforest_theme;
$pid = get_the_ID();
$poster_id = get_post_field('post_author', $pid);
$section_title = __('Write a Review', 'sb_pro');

wp_enqueue_style('star-rating', trailingslashit(get_template_directory_uri()) . 'assests/css/star-rating.css');


?>
<div class="write-review" id="ad-rating">
    <?php
    /* $page = (get_query_var('page')) ? get_query_var('page') : 1; */

    // grab the current page number and set to 1 if no page number is set
    if (function_exists('adforest_comments_pagination2')) {
        $page = ( isset($_GET['page-number'])) ? $_GET['page-number'] : 1;
    } else {
        $page = (get_query_var('page')) ? get_query_var('page') : 1;
    }

    $limit = $adforest_theme['sb_rating_max'];
    $offset = ($page * $limit) - $limit;
    $args = array(
        'type__in' => array('event_post_rating'),
        'number' => $limit,
        'offset' => $offset,
        'parent' => 0, // parent only
        'post_id' => $pid, // use post_id, not post_ID
    );
    $comments = get_comments($args);
    ?>
    <div class="review-reply">
        <?php
        if (count($comments) > 0) {
            ?>
            <div class="review-product">
                <h4 class="main-title text-left">
                    <?php echo adforest_returnEcho($adforest_theme['sb_ad_rating_title']); ?>  
                    <span class="ratings">
                        <?php
                        $get_percentage = adforest_fetch_reviews_average($pid);
                        if (isset($get_percentage) && count($get_percentage['ratings']) > 0) {
                            echo adforest_returnEcho($get_percentage['total_stars']) . ' <span class="avg_stars">(' . $get_percentage['average'] . ')</span>';
                            ;
                        }
                        ?>
                    </span>
                </h4>
            </div>
            <?php
        }
        ?>
        <?php
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $commenter = get_userdata($comment->user_id);
                if ($commenter) {
                    ?>
                    <div class="review-content">
                        <div class="review-img">
                            <a href="<?php echo adforest_set_url_param(get_author_posts_url($comment->user_id), 'type', 'ads'); ?>">
                                <img src="<?php echo adforest_get_user_dp($comment->user_id, 'adforest-single-small'); ?>" alt="<?php echo esc_attr($commenter->display_name); ?>">
                            </a>
                        </div>

                        <div class="review-content-item">
                            <?php if (get_current_user_id() == $poster_id) {
                                ?>   
                                <div class ="review-reply">
                                    <a class="reply-btn reply_event_rating" href="javascript:void(0);" data-comment_id="<?php echo adforest_returnEcho($comment->comment_ID); ?>" data-commenter-name="<?php echo esc_attr($commenter->display_name); ?>" data-bs-toggle="modal" data-bs-target=".event_reply_rating">
                                        <i class="fa fa-comments"></i><?php echo __('Reply', 'sb_pro'); ?>
                                    </a>
                                </div>
                                <?php }
                            ?>
                            <div class="review-head">
                                <h5 class="author-name">
                                    <a href="<?php echo adforest_set_url_param(get_author_posts_url($comment->user_id), 'type', 'ads'); ?>"><?php echo esc_html($commenter->display_name); ?></a>
                                </h5>
                            </div>
                            <ul class="review-list">
                                
                                <li>
                                    <span class="ratings"><?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= get_comment_meta($comment->comment_ID, 'review_stars', true))
                                                echo '<i class="fa fa-star color" aria-hidden="true"></i>';
                                            else
                                                echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                        }
                                        ?></span> 
                                </li>
                                <li><span class="list-posted-date"><?php echo get_comment_date(get_option('date_format'), $comment->comment_ID); ?></span></li>
                            </ul>
                            <p><?php echo esc_html($comment->comment_content); ?></p>


                            <?php
                            if (isset($adforest_theme['adforest_listing_review_enable_emoji']) && $adforest_theme['adforest_listing_review_enable_emoji']) {
                                $got_likes = '';
                                $got_love = '';
                                $got_wow = '';
                                $got_angry = '';
                                if (get_comment_meta($comment->comment_ID, 'review_like', true) != "") {
                                    $got_likes = get_comment_meta($comment->comment_ID, 'review_like', true);
                                }
                                if (get_comment_meta($comment->comment_ID, 'review_love', true) != "") {
                                    $got_love = get_comment_meta($comment->comment_ID, 'review_love', true);
                                }
                                if (get_comment_meta($comment->comment_ID, 'review_wow', true) != "") {
                                    $got_wow = get_comment_meta($comment->comment_ID, 'review_wow', true);
                                }
                                if (get_comment_meta($comment->comment_ID, 'review_angry', true) != "") {
                                    $got_angry = get_comment_meta($comment->comment_ID, 'review_angry', true);
                                }
                                ?>
                                <div class="review-helpful"> <span><?php echo esc_html__('Your reaction about this review', 'sb_pro'); ?></span>
                                    <div class="Like">
                                        <div class="Emojis">
                                            <div class="Emoji  Emoji-like"  data-reaction="1" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                                <div class="emoji-name"> <?php echo esc_html__('Like', 'sb_pro'); ?></div>
                                                <div class="icon icon-like"></div>
                                                <div class="emoji-count likes-<?php echo esc_attr($comment->comment_ID); ?>"><?php echo esc_attr($got_likes); ?></div>
                                            </div>
                                            <div class="Emoji Emoji-love" data-reaction="2" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                                <div class="emoji-name"> <?php echo esc_html__('Love', 'sb_pro'); ?></div>
                                                <div class="icon icon-heartt" ></div>
                                                <div class="emoji-count loves-<?php echo esc_attr($comment->comment_ID); ?>"> <?php echo esc_attr($got_love); ?> </div>
                                            </div>

                                            <div class="Emoji Emoji-wow" data-reaction="3" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                                <div class="emoji-name"> <?php echo esc_html__('Wow', 'sb_pro'); ?></div>
                                                <div class="icon icon-wow" ></div>
                                                <div class="emoji-count wows-<?php echo esc_attr($comment->comment_ID); ?>"> <?php echo esc_attr($got_wow); ?> </div>
                                            </div>

                                            <div class="Emoji Emoji-angry" data-reaction="4" data-cid="<?php echo esc_attr($comment->comment_ID); ?>">
                                                <div class="emoji-name"> <?php echo esc_html__('Angry', 'sb_pro'); ?></div>
                                                <div class="icon icon-angry"></div>
                                                <div class="emoji-count angrys-<?php echo esc_attr($comment->comment_ID); ?>"> <?php echo esc_attr($got_angry); ?> </div>
                                            </div>
                                            <img id="reaction-loader-<?php echo esc_attr($comment->comment_ID); ?>" class="none" src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'images/adforest_loader.gif'); ?>" alt="<?php echo esc_html__('not found', 'sb_pro'); ?>">
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            $args_reply = array(
                                'type__in' => array('event_post_rating'),
                                'number' => 1,
                                'parent' => $comment->comment_ID, // parent only
                                'post_id' => $pid, // use post_id, not post_ID
                            );
                            $replies = get_comments($args_reply);
                            if (count($replies) > 0) {
                                foreach ($replies as $reply) {
                                    $ad_author = get_userdata($poster_id);
                                    if ($ad_author) {
                                        ?>
                                        <div class="comment-view">
                                            
                                            <div class="review-comment">
                                               
                                                <div class="comment-heading">
                                                <ul class="list-comment">

                                                    <li>   <?php echo get_comment_date(get_option('date_format'), $reply->comment_ID); ?>
                                                        <a href="<?php echo adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads'); ?>">
                                                            <?php echo esc_html($ad_author->display_name); ?>
                                                        </a> 
                                                        <?php echo __('says', 'sb_pro'); ?> : </li>

                                                    <li>   <p>
                                                        <?php echo esc_html($reply->comment_content); ?>   </p></li>
                                                </ul>
                                                </div>
                                             
                                            </div>

                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
            $args_c = array(
                'type__in' => array('event_post_rating'),
                'parent' => 0,
                'post_id' => $pid,
            );
            $total_comments = get_comments($args_c);
            $pages = ( ceil(count($total_comments)) / $limit );

            if (function_exists('adforest_comments_pagination2')) {
                echo adforest_comments_pagination2($pages, $page);
            } else {
                echo adforest_comments_pagination($pages, $page);
            }
        }
        ?>
    </div>
    
  <h5><?php echo esc_html__('Write a Review','sb_pro'); ?>    </h5>          
        <form method="post" id="event_rating_form">
            <div class="col-md-12 col-sm-12 no-padding">
                <div class="form-group">
                    <div dir="ltr">
                        <input id="input-21b" name="rating" value="1" type="text"  data-show-clear="false" <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>class="rating" data-min="0" data-max="5" data-step="1" data-size="xs" required title="required">
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-12 no-padding">
                <div class="form-group">
                    <label><?php echo __('Comments', 'sb_pro'); ?>: <span class="required">*</span></label>
                    <textarea cols="6" name="rating_comments" rows="6" placeholder="<?php echo __('Your comments...', 'sb_pro'); ?>" class="form-control re-mdg" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'sb_pro'); ?>"></textarea>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 no-padding">
                <input type="hidden" id="sb-review-token" value="<?php echo wp_create_nonce('sb_review_secure'); ?>" />
                <input class="btn btn-theme btn btn-sub" value="<?php echo __('Submit Review', 'sb_pro'); ?>" type="submit">
                <input type="hidden" value="<?php echo adforest_returnEcho($pid); ?>" name="ad_id" />
                <input type="hidden" value="<?php echo adforest_returnEcho($poster_id); ?>" name="ad_owner" />
            </div>
        </form>

</div>
  