<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('ABSPATH') || exit;

/* Galery template */
global $adforest_theme;
$event_id = get_the_ID();
$pid = $event_id;
$poster_id = get_post_field('post_author', $pid);
$venue = get_post_meta($event_id, 'sb_pro_event_venue', true);
$sb_pro_event_status = get_post_meta($event_id, 'sb_pro_event_status', true);
$sb_pro_event_contact = get_post_meta($event_id, 'sb_pro_event_contact', true);
$sb_pro_event_email = get_post_meta($event_id, 'sb_pro_event_email', true);
$sb_pro_event_start_date = get_post_meta($event_id, 'sb_pro_event_start_date', true);
$sb_pro_event_end_date = get_post_meta($event_id, 'sb_pro_event_end_date', true);
$sb_pro_event_lat = get_post_meta($event_id, 'sb_pro_event_lat', true);
$sb_pro_event_long = get_post_meta($event_id, 'sb_pro_event_long', true);
$sb_pro_event_listing_id = get_post_meta($event_id, 'sb_pro_event_listing_id', true);
sb_expire_the_event($event_id);    // expire the event if date is expired

$event_questions = get_post_meta($event_id, 'event_question', true);
$event_schedules = get_post_meta($event_id, 'event_schedules', true);
$sb_profile_page = apply_filters('adforest_language_page_id', $adforest_theme['sb_profile_page']);

$user_id = get_current_user_id();
$all_attendees = get_post_meta($event_id, 'attending_users', true);
$going = "yes";

$going_text = esc_html__('Going', 'sb_pro');
if (is_array($all_attendees) && ($key = array_search($user_id, $all_attendees)) !== false) {
    $going = 'no';
    $going_text = esc_html__('Not Going', 'sb_pro');
}
$breadcrumb  =   isset($adforest_theme['event_breadcrumb']['url'])  ?  $adforest_theme['event_breadcrumb']['url']   : "";


?>
<div class="main-event-carousel-section">
    <div class="event-carousel">
<?php 
                if ($breadcrumb != "") {              
                      echo      '<div class="item">
                                <a href ="'.get_the_permalink($event_id).'"  data-caption= "'.get_the_title($event_id).'" data-fancybox="group">
                          <img src="' . $breadcrumb . '" alt="event-image">
                              </a>
                    </div>' ;
                }
        ?>
    </div>
</div>           
<section class="ad-event-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                <div class="main-dtl-box">
                    <h1 class="title"> <?php echo esc_html(get_the_title()) ?></h1>
                    <div class="meta-share-box">
                        <ul class="item-list">       
                        <input type="hidden" name="event_id" id="ad_id" value="<?php echo $event_id;?>">                
                          
                            <li>
                                <i class="fa fa-clock"></i>
                                <span><?php echo date(get_option('date_format') . "  " . get_option('time_format'), strtotime($sb_pro_event_start_date)); ?></span>
                            </li>    
                            <li>
                                <i class="fa fa-clock"></i>
                                <span><?php echo date(get_option('date_format') . "  " . get_option('time_format'), strtotime($sb_pro_event_end_date)); ?></span>
                            </li> 
                            <?php if (get_post_field('post_author', $pid) == get_current_user_id() || is_super_admin(get_current_user_id())) { ?>

                                <li>
                                    <i class="fa fa-edit"></i>
                                    <span> <a href="<?php echo get_the_permalink($sb_profile_page) . '?page_type=events&id=' . get_the_ID() . '' ?>"><?php echo esc_html__('Edit', 'sb_pro'); ?></a>   </span>                           
                                </li>

                            <?php } ?>



                        </ul>
                        <div class="share-links">
                            <ul>
                                <?php $already_favourite = get_user_meta($poster_id, '_sb_fav_event_' . $event_id, true);
                                ?>
                                <li id = "ad-to-fav-event"   title="<?php echo esc_html__('Ad event to favourite', 'sb_pro'); ?>" data-id="<?php echo adforest_returnEcho($event_id) ?>"   class ='<?php echo $already_favourite == $event_id ? 'ad-favourited' : "" ?>' >
                                    <a href="javascript:void(0)"><div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--bi" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" data-icon="bi:heart"><path fill="currentColor" d="m8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385c.92 1.815 2.834 3.989 6.286 6.357c3.452-2.368 5.365-4.542 6.286-6.357c.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"></path></svg>
                                        </div></a>
                                </li>
                                <?php if (isset($adforest_theme['event_share_allow']) && $adforest_theme['event_share_allow']) { ?>
                                    <li  title="<?php echo esc_html__('Share event to social media', 'sb_pro'); ?>"  id = "share-event" data-id="<?php echo adforest_returnEcho($event_id) ?>">
                                        <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target=".share-events"><div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ant-design" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024" data-icon="ant-design:share-alt-outlined"><path fill="currentColor" d="M752 664c-28.5 0-54.8 10-75.4 26.7L469.4 540.8a160.68 160.68 0 0 0 0-57.6l207.2-149.9C697.2 350 723.5 360 752 360c66.2 0 120-53.8 120-120s-53.8-120-120-120s-120 53.8-120 120c0 11.6 1.6 22.7 4.7 33.3L439.9 415.8C410.7 377.1 364.3 352 312 352c-88.4 0-160 71.6-160 160s71.6 160 160 160c52.3 0 98.7-25.1 127.9-63.8l196.8 142.5c-3.1 10.6-4.7 21.8-4.7 33.3c0 66.2 53.8 120 120 120s120-53.8 120-120s-53.8-120-120-120zm0-476c28.7 0 52 23.3 52 52s-23.3 52-52 52s-52-23.3-52-52s23.3-52 52-52zM312 600c-48.5 0-88-39.5-88-88s39.5-88 88-88s88 39.5 88 88s-39.5 88-88 88zm440 236c-28.7 0-52-23.3-52-52s23.3-52 52-52s52 23.3 52 52s-23.3 52-52 52z"></path></svg>
                                            </div></a>
                                    </li>

                                <?php } ?>

                                <?php if ($sb_pro_event_contact != "") { ?>
                                    <li title="<?php echo esc_html__('Whatsapp us', 'sb_pro'); ?>"   id = "whatsapp-event" data-id="<?php echo adforest_returnEcho($event_id) ?>" >
                                        <a href = "https://wa.me/<?php echo esc_attr($sb_pro_event_contact) ?>"><div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--fluent" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20" data-icon="fluent:chat-20-regular"><path fill="currentColor" d="M10 2a8 8 0 1 1-3.613 15.14l-.121-.065l-3.645.91a.5.5 0 0 1-.62-.441v-.082l.014-.083l.91-3.644l-.063-.12a7.95 7.95 0 0 1-.83-2.887l-.025-.382L2 10a8 8 0 0 1 8-8Zm0 1a7 7 0 0 0-6.106 10.425a.5.5 0 0 1 .063.272l-.014.094l-.756 3.021l3.024-.754a.502.502 0 0 1 .188-.01l.091.021l.087.039A7 7 0 1 0 10 3Zm.5 8a.5.5 0 0 1 .09.992L10.5 12h-3a.5.5 0 0 1-.09-.992L7.5 11h3Zm2-3a.5.5 0 0 1 .09.992L12.5 9h-5a.5.5 0 0 1-.09-.992L7.5 8h5Z"></path></svg>
                                            </div></a>
                                    </li>

                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="event-detail-sec">
                    <div class="main-desc-box">

                        <?php
                        if ((get_post_field('post_author', $pid) == $user_id || current_user_can('administrator'))) {
                            ?>
                            <div role="alert" class="alert alert-info alert-dismissible alert-outline">
                                <i class="fa fa-info-circle"></i>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <a data-bs-toggle="modal" data-bs-target=".sortable-images"><?php echo __('Rearrange the event photos.', 'adforest'); ?></a>
                            </div>
                            <?php
                        }


                           if (get_post_field('post_author', $pid) == $user_id && get_post_status($event_id) == 'pending') {
                            ?>
                            <div role="alert" class="alert alert-warning alert-dismissible alert-outline">
                                <i class="fa fa-info-circle"></i>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <a data-bs-toggle="modal" data-bs-target=".sortable-images"><?php echo __('Waiting for admin approval', 'adforest'); ?></a>
                            </div>
                            <?php
                        }

                        wc_get_template2('single-event/event-gallery.php');
                        ?>
                        <h3 class="title"><?php echo esc_html__('Description', 'sb_pro'); ?></h3>     
                        <?php echo get_the_content(" ", " ", $event_id ); ?>       
                        <?php
                        if (is_array($all_attendees) && !empty($all_attendees)) {
                            $attendee_html = "";
                            
                            $count = 1;
                            foreach ($all_attendees as $user) {
                                
                                 $count++; 
                                 
                                 if( $count == 8){
                                     
                                     break;
                                 }

                                $user_info = get_userdata($user);
                                $poster_name = $user_info->display_name;
                                $user_pic = adforest_get_user_dp($poster_id);
                                $user_address = get_user_meta($poster_id, '_sb_address', true);

                                $attendee_html .= '<div class ="col-xl-4 col-xxl-4 col-md-4 col-sm-6 col-6">
                                        <div class="attendee-container">
                                            <div class="attendee_avatr">
                                                <img src="' . $user_pic . '">
                                            </div>
                                            <div class="attendee_avatr">
                                                <a href=' . adforest_set_url_param(get_author_posts_url($poster_id), 'type', 'ads') . '>' . $poster_name . '</a>                                       
                                            </div>
                                      </div>
                             </div>';
                            }
                            echo '<div class="my-attendess">
                              <h3 class="title">' . esc_html__("Attendees", "sb_pro") . '</h3> 
                            <div class="row">
                              ' . $attendee_html . ' 
                            </div>
                        </div>';
                        }
                        ?>
                        <?php 
                         if(isset($adforest_theme['event_review_allowed'])  && $adforest_theme['event_review_allowed']  ) {
                        wc_get_template2('single-event/event-review.php');
                       }
                         ?>
                    
                    </div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                        <?php      if ($event_questions && !empty($event_questions)) {?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo esc_html__('FAQ', 'sb_pro'); ?></button>
                        </li>

                    <?php } ?>

                    <?php    if ($event_schedules && !empty($event_schedules)) {  ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo esc_html__('Schedule', 'sb_pro'); ?></button>
                        </li>

                    <?php }  
                        $contact_tab  =  "";
                     if($event_schedules == "" &&  $event_questions  ==  ""){
                            $contact_tab  =  "active show";
                     }

                      if (isset($adforest_theme['user_contact_form_event']) && $adforest_theme['user_contact_form_event']) {

                    ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php  echo $contact_tab; ?>" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><?php echo esc_html__('Contact', 'sb_pro'); ?></button>
                        </li>

                    <?php }  ?>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="accordion" id="accordionExample">
                                <?php
                                if ($event_questions && !empty($event_questions)) {
                                    $count = 0;
                                    foreach ($event_questions as $que) {
                                        $count++;
                                        ?>             
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqs_<?php echo esc_attr($count); ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <?php echo esc_html__($que['question']) ?>
                                                </button>
                                            </h2>
                                            <div id="faqs_<?php echo esc_attr($count); ?>" class="accordion-collapse collapse <?php  echo  $count ==  1 ?  'show' : "";?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <?php echo esc_html__($que['answer']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="accordion" id="accordionExample2">
                                <?php
                                if ($event_schedules && !empty($event_schedules)) {
                                    $count = 0;
                                    foreach ($event_schedules as $que) {
                                        $count++;
                                        ?>             
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#schedule_<?php echo esc_attr($count); ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <?php echo esc_html__($que['day']) ?>
                                                </button>
                                            </h2>
                                            <div id="schedule_<?php echo esc_attr($count); ?>" class="accordion-collapse collapse <?php  echo  $count ==  1 ?  'show' : "";?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <?php echo ($que['day_val']) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane <?php echo $contact_tab; ?>" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                            <?php
                            if (isset($adforest_theme['user_contact_form_event']) && $adforest_theme['user_contact_form_event']) {

                                $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';
                                $site_key = isset($adforest_theme['google_api_key']) && !empty($adforest_theme['google_api_key']) ? $adforest_theme['google_api_key'] : '';
                                $contact_form_recaptcha = isset($adforest_theme['contact_form_recaptcha_event']) && !empty($adforest_theme['contact_form_recaptcha_event']) ? $adforest_theme['contact_form_recaptcha_event'] : '';
                                ?>
                                <div class="ad-bottom-sidebar event-seller-form">
                                    <form class="send-message-to-author">
                                        <div class="seller-form-group">
                                            <div class="row">
                                                <div class="col-xxl-6 col-xl-6 col-12">    
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="userName" aria-describedby="nameHelp" placeholder="<?php echo __('Name', 'sb_pro'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'sb_pro'); ?>">
                                                    <small id="nameHelp" class="form-text text-muted"></small> </div>
                                                </div>
                                                 <div class="col-xxl-6 col-xl-6 col-12">  
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="emailAddress" aria-describedby="emailHelp" placeholder="<?php echo __('Email', 'sb_pro'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'sb_pro'); ?>">
                                                    <small id="emailHelp" class="form-text text-muted"></small> </div>
                                                 </div>
                                                <div class="col-xxl-12 col-xl-12 col-12">   
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="phoneNumber" aria-describedby="phonelHelp" placeholder="<?php echo __('Phone Number', 'sb_pro'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('Format should be +CountrycodePhonenumber.', 'sb_pro'); ?>" data-parsley-pattern="/\+[0-9]+$/">
                                                    <small id="phonelHelp" class="form-text text-muted"></small> </div>
                                                </div>
                                                <div class="col-xxl-12 col-xl-12 col-12">   
                                            <div class="form-group">
                                                <textarea class="form-control" name="message" rows="4" placeholder="<?php echo __('Message', 'sb_pro'); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'sb_pro'); ?>"></textarea>
                                            </div>
                                                </div>
                                            <?php
                                            $captcha = '<input type="hidden" value="no" name="is_captcha" />';

                                            if (isset($contact_form_recaptcha) && $contact_form_recaptcha) {
                                                if ($captcha_type == 'v2') {
                                                    if ($site_key != "") {
                                                        $captcha = '<div class="form-group"><div class="g-recaptcha" data-sitekey="' . $site_key . '"></div></div><input type="hidden" value="yes" name="is_captcha" />';
                                                    }
                                                } else {
                                                    $captcha = '<input type="hidden" value="yes" name="is_captcha" />';
                                                }
                                            }
                                            echo adforest_returnEcho($captcha);
                                            ?>
                                        </div>
                                        <div class="sellers-button-group">
                                            <button class="btn btn-theme"><?php echo __('Send Message', 'sb_pro'); ?></button>
                                        </div>
                                        <input type="hidden" name="ad_id" value="<?php echo $event_id; ?>">
                                        </div>
                                    </form>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="ad-main-sidebar">
                    <div class="author-main-box">
                        <?php
                        ?>
                       

                        <?php
                        $timer_html = '';
                        if ($sb_pro_event_start_date != "" && date('Y-m-d H:i:s') < $sb_pro_event_start_date) {
                            echo $timer_html .= '<div class="counter-box">' . event_timer_html($sb_pro_event_start_date, true, 1) . '</div>';
                        }
                        ?>
                         <div class="going-btn">
                          <a href="javascript:void()" class= "btn btn-theme btn-block" data-status = "<?php echo esc_attr($going) ?>"  id="going_to_event" data-id ="<?php echo $event_id ?>"  data-going ="<?php echo esc_html__('Going', 'sb_pro'); ?>"  data-going ="<?php echo esc_html__('Not Going', 'sb_pro'); ?>"  ><?php echo esc_html($going_text); ?></a>   </span>                           
                        </div>
                        <?php wc_get_template2('single-event/event-author.php') ?>
                        <div class="btn-box">
                            <ul class="event-contact-info">
                                <?php
                                if ($sb_pro_event_contact) {
                                    echo '<li>
                                        <a class="btn event-contact event-phone" href="tel:' . $sb_pro_event_contact . '"><i class="fa fa-phone" aria-hidden="true"></i>' . esc_html__("Call now", "sb_pro") . '</a>
                                        </li>';
                                }
                                ?>
                                <?php ?>
                                <?php
                                if ($sb_pro_event_email) {
                                    echo '<li>
                                       <a class ="btn event-contact event-email" href="mailto:' . $sb_pro_event_email . '"><i class="fa fa-envelope-o" aria-hidden="true"></i>' . esc_html__('Email', 'sb_pro') . '</a>
                                    </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php wc_get_template2('single-event/event-map.php'); ?>
                    <?php wc_get_template2('single-event/event-related.php'); ?>
                    <div class="add-to-map">
                        <a href="javascript:void(0)" data-bs-target=".share-events-map" data-bs-toggle="modal" class="btn btn-theme btn-block">
                            <?php echo esc_html__('Add to Calendar', 'sb_pro'); ?>    
                        </a>
                    </div>
                    <?php
                    dynamic_sidebar('sb_event_sidebar');
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>
<?php
if (isset($adforest_theme['event_share_allow']) && $adforest_theme['event_share_allow']) {
    wc_get_template2('single-event/share-event.php');
}
/* review reply form modal box */
$flip_it = 'text-left';
if (is_rtl()) {
    $flip_it = 'text-right';
}
?>


<div class="modal fade event_reply_rating" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form id="event_rating_reply_form">
            <div class="modal-content <?php echo esc_attr($flip_it); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only"></span></button>
                    <div class="modal-title"><?php echo __('Reply to', 'sb_pro'); ?> <span id="reply_to_rating"></span></div>
                </div>
                <div class="modal-body <?php echo esc_attr($flip_it); ?>">
                    <div class="form-group  col-md-12 col-sm-12">
                        <label></label>
                        <textarea placeholder="<?php echo __('Write your reply...', 'sb_pro'); ?>" rows="3" class="form-control" name="reply_comments" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field is required.', 'sb_pro'); ?>"></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 margin-bottom-20 margin-top-20">
                        <input type="hidden" id="sb-review-reply-token" value="<?php echo wp_create_nonce('sb_review_reply_secure'); ?>" />
                        <input type="hidden" id="parent_comment_id" value="0" name="parent_comment_id" />
                        <input type="hidden" value="<?php echo adforest_returnEcho($pid); ?>" name="ad_id" />
                        <input type="hidden" value="<?php echo adforest_returnEcho($poster_id); ?>" name="ad_owner" />
                        <input type="submit" class="btn btn-theme btn-block" value="<?php echo __('Submit', 'sb_pro'); ?>" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<?php wc_get_template2('single-event/share-map.php'); ?>

<?php wc_get_template2('single-event/rearrange-notification.php'); ?>
