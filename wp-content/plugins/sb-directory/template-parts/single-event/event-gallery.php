<?php
 wp_enqueue_style('adforest-fancybox', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery.fancybox.min.css');

$event_id = get_the_id();
$media = sb_pro_fetch_event_gallery($event_id);
 ?>
<!-- Place somewhere in the <body> of your page -->
 <?php wp_enqueue_script('adforest-fancybox'); 
      global $adforest_theme;
      wp_enqueue_style('adforest-fancybox', trailingslashit(get_template_directory_uri()) . 'assests/css/jquery.fancybox.min.css');
  
     $layout_style  =  isset($adforest_theme['ad_layout_style'])  ?  $adforest_theme['ad_layout_style'] : '1';    
     $image_thumbnail_size    =    'adforest-single-post';
    
 ?>
<div id="slider" class="flexslider">
  <ul class="slides">
   <?php
        global $adforest_theme;
        $ad_id = get_the_ID();
        
        $disable_optimize_img = isset($adforest_theme['sb_optimize_img_switch']) && $adforest_theme['sb_optimize_img_switch'] ? TRUE : FALSE;
        $title = get_the_title();
        if (count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID))
                    $mid = $m->ID;
                else
                    $mid = $m;

                $img = wp_get_attachment_image_src($mid, $image_thumbnail_size);
                $full_img = wp_get_attachment_image_src($mid, 'full');
                if (isset($img[0]) && $img[0] == '') {
                    continue;
                }
                $slider_img = isset($img[0])  ?  $img[0]  : "";
                if ($disable_optimize_img) {
                    $slider_img = $full_img[0];
                }
                if(isset($full_img[0])){
                ?><li class=""><div><a href="<?php echo esc_url($full_img[0]);?>" data-caption="<?php echo esc_attr($title);?>" data-fancybox="group"><img class="event-gallery" alt="<?php echo esc_attr($title);?>" src="<?php echo esc_url($slider_img);?>"></a></div></li>
                <?php
            }}
        }
        else{
            if(isset($adforest_theme['sb_default_detail_img'])  && $adforest_theme['sb_default_detail_img']) {
            $img = adforest_get_ad_default_image_url($image_thumbnail_size); ?>
            <li class=""><div><a href="<?php echo esc_url($img);?>" data-caption="<?php echo esc_attr($title);?>" data-fancybox="group"><img alt="<?php echo esc_attr($title);?>" src="<?php echo esc_url($img);?>"  class="event-gallery"></a></div></li>
        <?php  }
      }
    if (isset($adforest_theme['sb_allow_upload_video']) && $adforest_theme['sb_allow_upload_video'] == true) {
        $video_url = $video_attachment_id_arr = '';
        /* get attachment id by post ID */
        $video_attachment_id = get_post_meta($ad_id, 'adforest_video_uploaded_attachment_', true); 
       
        if ($video_attachment_id != '') {
            $video_attachment_id_arr = explode(",", $video_attachment_id);
        }
        if (is_array($video_attachment_id_arr) && !empty($video_attachment_id_arr) && count($video_attachment_id_arr) > 0 && $video_attachment_id_arr != '') {
            for ($i = 0; $i < count($video_attachment_id_arr); $i++) {
                $video_url = wp_get_attachment_url($video_attachment_id_arr[$i]);
                $media_type = wp_get_attachment_metadata(($video_attachment_id_arr[$i]));
                ?>
            <li>
                        <video width="540" height="400" controls>
                            <source src="<?php echo $video_url; ?>" type="<?php echo $media_type['mime_type']; ?>">
                        </video>
                    </li>
                <?php
            }
        }
    }
        ?>  
  </ul>
</div>




<div id="carousel" class="flexslider">
  <ul class="slides">
   <?php
        if (count($media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID))
                    $mid = $m->ID;
                else
                    $mid = $m;

               
               $img = wp_get_attachment_image_src($mid,'');
                $full_img = wp_get_attachment_image_src($mid, 'full');
                if (isset($img[0]) && $img[0] == '') {
                    continue;
                }
               
                ?><li><img alt="<?php echo esc_attr($title);?>" draggable="false" src="<?php echo esc_attr($img[0]);?>"></li><?php
            }
        }
        
          if (isset($adforest_theme['sb_allow_upload_video']) && $adforest_theme['sb_allow_upload_video'] == true) {
        $video_url = $video_attachment_id_arr = '';
        /* get attachment id by post ID */
        $video_attachment_id = get_post_meta($ad_id, 'adforest_video_uploaded_attachment_', true); 
       
        if ($video_attachment_id != '') {
            $video_attachment_id_arr = explode(",", $video_attachment_id);
        }
        if (is_array($video_attachment_id_arr) && !empty($video_attachment_id_arr) && count($video_attachment_id_arr) > 0 && $video_attachment_id_arr != '') {
            for ($i = 0; $i < count($video_attachment_id_arr); $i++) {
                $video_url = wp_get_attachment_url($video_attachment_id_arr[$i]);
                $media_type = wp_get_attachment_metadata(($video_attachment_id_arr[$i]));
                ?>
            <li class=""> 
                        <video width="130" height="80">
                            <source src="<?php echo $video_url; ?>" type="<?php echo $media_type['mime_type']; ?>">
                        </video>
                    
            </li>
                <?php
            }
        }
    }
        ?>  
  </ul>
</div>












<!-- main-event-carousel end -->