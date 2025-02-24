<?php
global $adforest_theme;
$pid = get_the_ID();
$event_id  =   $pid;
if ($adforest_theme['event_share_allow']) {
$flip_it = 'text-left';
if (is_rtl()) {
    $flip_it = 'text-right';
}
?>
<div class="modal fade share-ad share-events" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content <?php echo esc_attr($flip_it); ?>">
        <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only">Close</span></button>
            <div class="modal-title"><?php echo __('Share', 'adforest'); ?></div>
        </div>
        <div class="modal-body <?php echo esc_attr($flip_it); ?>">
            <div class="recent-ads">
                <div class="recent-ads-list">
                    <div class="recent-ads-container">
                        <div class="recent-ads-list-image">
                            <?php
                            $media = sb_pro_fetch_event_gallery($event_id);
                            $img = adforest_get_ad_default_image_url('adforest-ad-related');
                            if (count($media) > 0) {
                                foreach ($media as $m) {
                                    $mid = '';
                                    if (isset($m->ID))
                                        $mid = $m->ID;
                                    else
                                        $mid = $m;

                                    $image = wp_get_attachment_image_src($mid, 'adforest-ad-related');
                                    $img = $image[0];
                                    break;
                                }
                                ?>
                                <a href="<?php echo get_the_permalink(); ?>" class="recent-ads-list-image-inner"><img  src="<?php echo esc_url($img); ?>" alt="<?php echo get_the_title(); ?>"></a>
                                <?php  } ?>
                        </div>
                        <div class="recent-ads-list-content">
                        <h3 class="recent-ads-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                           
                            <p><?php echo adforest_words_count(get_the_excerpt(get_the_ID()), 250); ?></div>
                    </div>
                </div>
            </div>
            <div class="share-link"><?php echo __('Link', 'adforest'); ?></div>
            <p><a href="<?php echo get_the_permalink($pid); ?>"><?php the_permalink($pid); ?></a></p>
        </div>
        <div class="modal-footer">
            <?php echo adforest_social_share(); ?>
        </div>
    </div>
</div>
</div>
<?php } ?>