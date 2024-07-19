<?php
if (!function_exists('adforest_add_code')) {
    function adforest_add_code($id, $func) {
        add_shortcode($id, $func);
    }
}
if (!function_exists('adforest_decode')) {
    function adforest_decode($html) {
        return base64_decode($html);
    }
}
/* Ajax handler for add to cart */
add_action('wp_ajax_sb_mailchimp_subcribe', 'adforest_mailchimp_subcribe');
add_action('wp_ajax_nopriv_sb_mailchimp_subcribe', 'adforest_mailchimp_subcribe');
/* Addind Subcriber into Mailchimp */
if (!function_exists('adforest_mailchimp_subcribe')) {
    function adforest_mailchimp_subcribe() {
        global $adforest_theme;
        $sb_action = $_POST['sb_action'];
        $apiKey = $adforest_theme['mailchimp_api_key'];

        
        if ($sb_action == 'coming_soon') {
            $listid = $adforest_theme['mailchimp_notify_list_id'];
        }
        if ($sb_action == 'footer_action') {
            $listid = $adforest_theme['mailchimp_footer_list_id'];
        }
        if ($apiKey == "" || $listid == "") {
            echo 0;
            die();
        }
        $email = $_POST['sb_email'];
        $fname = '';
        $lname = '';
        /* MailChimp API URL */
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . $memberID;
        /* member information */
        $json = json_encode(array(
            'email_address' => $email,
            'status' => 'subscribed',
            'merge_fields' => array(
                'FNAME' => $fname,
                'LNAME' => $lname
            )
        ));

        /* send a HTTP POST request with curl */
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        /* store the status message based on response code */

        $mcdata = json_decode($result);
        if (!empty($mcdata->error)) {
            echo 0;
        } else {
            echo 1;
        }
        die();
    }

}
/* Report Ad */
add_action('wp_ajax_sb_report_ad', 'adforest_sb_report_ad');
add_action('wp_ajax_nopriv_sb_report_ad', 'adforest_sb_report_ad');

if (!function_exists('adforest_sb_report_ad')) {

    function adforest_sb_report_ad() {
        adforest_authenticate_check();

        //option
        global $adforest_theme;
        $ad_id = $_POST['ad_id'];
        $option = $_POST['option'];
        $comments = sanitize_text_field($_POST['comments']);

        if (!isset($_POST['option']) || $_POST['option'] == '') {
            echo '0|' . __("Please select one of the ad report options.", 'redux-framework');
            wp_die();
        }

        if (!isset($_POST['comments']) || $_POST['comments'] == '') {
            echo '0|' . __("Please write your comments();
 about the ad.", 'redux-framework');
                    }

        if (get_post_meta($ad_id, '_sb_user_id_' . get_current_user_id(), true) == get_current_user_id()) {
            echo '0|' . __("You have reported already.", 'redux-framework');
            wp_die();
        } else {
            update_post_meta($ad_id, '_sb_user_id_' . get_current_user_id(), get_current_user_id());
            update_post_meta($ad_id, '_sb_report_option_' . get_current_user_id(), $option);
            update_post_meta($ad_id, '_sb_report_comments_' . get_current_user_id(), $comments);

            $count =  (int) get_post_meta($ad_id, '_sb_count_report', true);
            $count = $count + 1;
            update_post_meta($ad_id, '_sb_count_report', $count);
            if ($count <= (int)$adforest_theme['report_limit']) {
                if ($adforest_theme['report_action'] == '1') {
                    $my_post = array(
                        'ID' => $ad_id,
                        'post_status' => 'pending',
                        'post_type' => 'ad_post',
                    );
                    wp_update_post($my_post);
                } else {
                    // Sending email
                    $to = $adforest_theme['report_email'];
                    $subject = __('Ad Reported', 'redux-framework');
                    $body = '<html><body><p>' . __('Users reported this ad, please check it. ', 'redux-framework The user reported  as , '.$comments.'') . '<a href="' . get_the_permalink($ad_id) . '">' . get_the_title($ad_id) . '</a></p></body></html>';
                    $from = get_bloginfo('name');
                    if (isset($adforest_theme['sb_report_ad_from']) && $adforest_theme['sb_report_ad_from'] != "") {
                        $from = $adforest_theme['sb_report_ad_from'];
                    }
                    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                    if (isset($adforest_theme['sb_report_ad_message']) && $adforest_theme['sb_report_ad_message'] != "") {
                        $subject_keywords = array('%site_name%', '%ad_title%');
                        $subject_replaces = array(get_bloginfo('name'), get_the_title($ad_id));
                        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_report_ad_subject']);
                        $author_id = get_post_field('post_author', $ad_id);
                        $user_info = get_userdata($author_id);
                        $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%ad_owner%', '%ad_report_option%');
                        $msg_replaces = array(get_bloginfo('name'), get_the_title($ad_id), get_the_permalink($ad_id), $user_info->display_name, $option);
                        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_report_ad_message']);
                    }
                    wp_mail($to, $subject, $body, $headers);
                    update_post_meta($ad_id, '_sb_count_report', 0); // recount the report limit.
                }
            }

            echo '1|' . __("Reported successfully.", 'redux-framework');
            wp_die();
        }
    }

}
/* reject ad mail template */
add_action('wp_ajax_adforest_ad_rejection', 'adforest_ad_rejection_callback');

if (!function_exists('adforest_ad_rejection_callback')) {

    function adforest_ad_rejection_callback() {
        global $adforest_theme;
        $rej_ad_id = isset($_POST['post_id']) && !empty($_POST['post_id']) ? $_POST['post_id'] : 0;
        $ad_reject_reason = isset($_POST['ad_reject_reason']) && !empty($_POST['ad_reject_reason']) ? $_POST['ad_reject_reason'] : '';
        $status = array();
        $author_id = get_post_field('post_author', $rej_ad_id);
        $user_info = get_userdata($author_id);
        $to = $user_info->user_email;
        $subject = __('New Messages', 'redux-framework');
        $body = '<html><body><p>' . __('Got new message on ads', 'redux-framework') . ' ' . get_the_title($rej_ad_id) . '</p><p>' . $ad_reject_reason . '</p></body></html>';
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_ad_rejection_from']) && $adforest_theme['sb_ad_rejection_from'] != "") {
            $from = $adforest_theme['sb_ad_rejection_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $subject_keywords = array('%site_name%', '%ad_title%');
        $subject_replaces = array(get_bloginfo('name'), get_the_title($rej_ad_id));
        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_ad_rejection_subject']);
        $msg_keywords = array('%ad_author%', '%site_name%', '%ad_title%', '%ad_link%', '%reject_reason%');
        $msg_replaces = array($user_info->display_name, get_bloginfo('name'), get_the_title($rej_ad_id), get_the_permalink($rej_ad_id), $ad_reject_reason);
        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_ad_rejection_msg']);
        $body = stripcslashes($body);

        if (wp_mail($to, $subject, $body, $headers)) {
            $status['status'] = true;
            $status['message'] = __('Email sent to the ad author successfully', 'redux-framework');
            /* wp_trash_post($rej_ad_id); */
            wp_update_post(array(
                'ID' => $rej_ad_id,
                'post_status' => 'rejected',
                'post_type' => 'ad_post',
            ));
            /* update_post_meta($rej_ad_id, '_adforest_ad_status_', 'rejected'); */
        } else {
            $status['status'] = false;
            $status['message'] = __('Oops! Something went wrong.Please Check your Mailing details.', 'redux-framework');
        }
        echo json_encode($status);
        wp_die();
    }

}
/* package Expiry Notification */
add_action('adforest_package_expiry_notification', 'adforest_package_expiry_notification_callback', 10, 2);
if (!function_exists('adforest_package_expiry_notification_callback')) {

    function adforest_package_expiry_notification_callback($before_days = 0, $user_id = 0) {
        $adforest_theme = get_option('adforest_theme');
        $sb_pkg_name = get_user_meta($user_id, '_sb_pkg_type', true);
        $user_info = get_userdata($user_id);
        $to = $user_info->user_email;
        $subject = __('New Messages', 'redux-framework');
        $body = '<html><body><p>' . __('Got new message on ads', 'redux-framework') . ' ' . get_the_title($rej_ad_id) . '</p><p>' . $ad_reject_reason . '</p></body></html>';
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_package_expiry_from']) && $adforest_theme['sb_package_expiry_from'] != "") {
            $from = $adforest_theme['sb_package_expiry_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $subject_keywords = array('%site_name%');
        $subject_replaces = array(get_bloginfo('name'));
        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_package_expiray_subject']);
        $msg_keywords = array('%package_subcriber%', '%site_name%', '%package_name%', '%no_of_days%');
        $msg_replaces = array($user_info->display_name, get_bloginfo('name'), $sb_pkg_name, $before_days);
        $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_package_expiry_msg']);
        $body = stripcslashes($body);
        wp_mail($to, $subject, $body, $headers);
    }

}


/*Ad expiry email*/

//add_action('adforest_ad_before_expiry_notification', 'adforest_ad_before_expiry_notification_callback', 10, 2);


if (!function_exists('adforest_ad_before_expiry_notification_callback')) {
    function adforest_ad_before_expiry_notification_callback($ad_id = 0 ,$before_days = 0 ,$type = '') {
      $adforest_theme = get_option('adforest_theme');
        $post_author_id = get_post_field( 'post_author', $ad_id );
        $ad_title  =   get_the_title($ad_id);
        $user_info = get_userdata($post_author_id);
        $to = $user_info->user_email;
        $subject = __('New Messages', 'redux-framework');
        $body =  "";
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_ad_expiry_from']) && $adforest_theme['sb_ad_expiry_from'] != "") {
            $from = $adforest_theme['sb_ad_expiry_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $subject_keywords = array('%site_name%');
        $subject_replaces = array(get_bloginfo('name'));
        $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_ad_expiray_subject']);
       
         if($type ==  'after'){
             $msg_keywords = array('%ad_author%', '%site_name%', '%ad_title%');
             $msg_replaces = array($user_info->display_name, get_bloginfo('name'), $ad_title);

             $body_html  =  isset($adforest_theme['sb_ad_after_expiry_msg'])  ?  $adforest_theme['sb_ad_after_expiry_msg']  : "";
             $body = str_replace($msg_keywords, $msg_replaces, $body_html);
         }
         else {
             $msg_keywords = array('%ad_author%', '%site_name%', '%ad_title%', '%no_of_days%');
             $msg_replaces = array($user_info->display_name, get_bloginfo('name'), $ad_title, $before_days);
             $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_ad_expiry_msg']);
         }

        $body = stripcslashes($body);
        wp_mail($to, $subject, $body, $headers);
    }
}
/* Send message to ad owner */
add_action('wp_ajax_sb_send_message', 'adforest_send_message');
if (!function_exists('adforest_send_message')) {
    function adforest_send_message() {       
        global $adforest_theme;
        check_ajax_referer('sb_msg_secure', 'security');
        adforest_authenticate_check();
      $is_demo = ( isset($adforest_theme['is_demo']) ) ? $adforest_theme['is_demo'] : false;
          if($is_demo){
            echo '0|' . __("Not allowed in demo mode", 'adforest');
                die();
        }
        if (function_exists('adforest_check_if_phoneVerified')) {
            $verifed_phone_number = adforest_check_if_phoneVerified();
            if ($verifed_phone_number) {
                echo '0|' . __("Please go to profile and verify your phone number to send message.", 'redux-framework');
                die();
            }
        }
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $current_userID = get_current_user_id();
        $max_allow_time_seconds = isset($adforest_theme['sb_message_delay_time']) ? (int) $adforest_theme['sb_message_delay_time'] : 15;
        $max_allow_messages = 5;
        $message = isset($params['message']) ? $params['message'] : "";
        if (adforest_check_spam($message)) {
            echo '0|' . __("Scripts and tags are not allowed", 'redux-framework');
            die();
        }
        $current_ad_post_id = $params['ad_post_id'];
        $send_post_ids = get_user_meta($current_userID, '_sb_ad_message_send_ids', true);
        $send_post_msg_time = (int) get_user_meta($current_userID, '_sb_ad_message_send_time', true);
        $last_message = get_post_meta($current_ad_post_id, 'ad_last_message', true);
        if ($send_post_ids != "") {
            $time_info = time();
            $max_time_limit = $time_info + $max_allow_time_seconds;
            $time_info_diff = $send_post_msg_time - $time_info;

            if ($send_post_ids != $current_ad_post_id) {
                if ($send_post_msg_time > $time_info) {
                    $time_info = $time_info_diff . "  " . esc_html('Seconds', 'redux-framework');
                    echo '0|' . __("Can not send message for next", 'redux-framework') . $time_info;
                    die();
                } else {
                    update_user_meta($current_userID, '_sb_ad_message_send_time', $time_info);
                }
            }
            if ($last_message == $message) {
                echo '0|' . __("Duplicate messaging not allowed", 'redux-framework');
                die();
            }
        }       
        $sb_block_individual_messaging = get_user_meta($current_userID, '_sb_block_individual_messaging', true);
        if ($sb_block_individual_messaging == 1) {
            echo '0|' . __("Website admin block you to send message.", 'redux-framework');
            die();
        }
        if (function_exists('adforest_set_date_timezone')) {
            adforest_set_date_timezone();
        }
        $time = current_time('mysql', 1);
        /* $time = date('Y-m-d H:i:s'); */
        $blocked_user_array1 = get_user_meta($params['msg_receiver_id'], 'adforest_blocked_users', true);
        if (isset($blocked_user_array1) && !empty($blocked_user_array1) && is_array($blocked_user_array1) && in_array(get_current_user_id(), $blocked_user_array1)) {
            echo '0|' . __("You can't send message to this user.", 'redux-framework');
            die();
        }
        $blocked_user_array2 = get_user_meta(get_current_user_id(), 'adforest_blocked_users', true);   
        if (isset($blocked_user_array2) && !empty($blocked_user_array2) && is_array($blocked_user_array2) && in_array($params['msg_receiver_id'], $blocked_user_array2)) {
            echo '0|' . __("Unblock this user to send message.", 'redux-framework');
            die();
        }
        if (isset($params['msg_receiver_id']) && $params['msg_receiver_id'] == get_current_user_id()) {
            echo '0|' . __("Ad Author cannot message himself.", 'redux-framework');
            die();
        }
        $words = explode(',', $adforest_theme['bad_words_filter']);
        $replace = $adforest_theme['bad_words_replace'];
        $message = adforest_badwords_filter($words, sanitize_text_field($params['message']), $replace);           
        $attachment_ids    =   array();
        $attachments_files  =   array();     
          if (isset($_FILES["message_file"])  && !empty($_FILES["message_file"])) {        
           $attachments_files   =   array();
             require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            $files = $_FILES["message_file"];
            $attachment_ids = array();
            $attachment_idss = '';
            $ul_con = '';
            $file = array();
            $condition_img = isset($adforest_theme['sb_media_attachment_limit']) ? $adforest_theme['sb_media_attachment_limit'] : 2;
            if (count($_FILES['message_file']['name']) > $condition_img) {

                $msg = sprintf("can not upload more than %u files", $condition_img);
                echo '0|' . __($msg, 'redux-framework');
                die();
            }
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $_FILES = array("message_file" => $file);
                    // Allow certain file formats
                    $imageFileType = strtolower(end(explode('.', $file['name'])));

                    $allowed_formats = isset($adforest_theme['sb_message_attach_formats']) ? $adforest_theme['sb_message_attach_formats'] : array('pdf', 'doc');
                    $formats_provided = "";
                    foreach ($allowed_formats as $format) {
                        $formats_provided .= "." . $format . ",";
                    }

                    if (!in_array($imageFileType, $allowed_formats)) {
                     //   echo '0|' . esc_html__("Allowed format are $formats_provided", 'nokri');
                       // die();
                    }
                    $size_arr = explode('-', $adforest_theme['sb_media_image_size']);
                    $display_size = isset($size_arr[1]) ? $size_arr[1] : "800kb";
                    $actual_size = isset($size_arr[0]) ? $size_arr[0] : 819200;
                    // Check file size                

                    if ($file['size'] > $actual_size) {
                        $mess = "Max allowed image size is" . " " . $display_size;
                        echo '0|' . esc_html__($mess, 'nokri');
                        die();
                    }
                    
                    foreach ($_FILES as $file => $array) {
                        $attach_id = media_handle_upload($file, "");
                        
                        if(!is_wp_error($attach_id)){
                        $attachment_ids[] = $attach_id;
                        $image_link = wp_get_attachment_image_src($attach_id, 'nokri-user-profile');
                        $attachments_files[]  = get_attached_file($attach_id); 
                        }                       
                        else{                        
                            echo '0|' . $attach_id->get_error_message();
                            die();
                            
                        }
                       }
                    }
                 }
 
        }               
        /* do_action('adforest_switch_language_code_from_id', $params['ad_post_id']); */
        $data = array(
            'comment_post_ID' => $params['ad_post_id'],
            'comment_author' => $params['name'],
            'comment_author_email' => $params['email'],
            'comment_author_url' => '',
            'comment_content' => $message,
            'comment_type' => 'ad_post',
            'comment_parent' => $params['usr_id'],
            'user_id' => get_current_user_id(),
            'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
            'comment_date' => $time,
            'comment_approved' => 1,
        );
        global $adforest_theme;
        if ($adforest_theme['sb_send_email_on_message']) {
            $author_obj = get_user_by('id', $params['msg_receiver_id']);
            $to = $author_obj->user_email;
            $subject = __('New Message', 'redux-framework');
            $body = '<html><body><p>' . __('Got new message on ad', 'redux-framework') . ' ' . get_the_title($params['ad_post_id']) . '</p><p>' . $params['message'] . '</p></body></html>';
            $from = get_bloginfo('name');
            if (isset($adforest_theme['sb_message_from_on_new_ad']) && $adforest_theme['sb_message_from_on_new_ad'] != "") {
                $from = $adforest_theme['sb_message_from_on_new_ad'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($adforest_theme['sb_message_on_new_ad']) && $adforest_theme['sb_message_on_new_ad'] != "") {
                $subject_keywords = array('%site_name%', '%ad_title%');
                $subject_replaces = array(get_bloginfo('name'), get_the_title($params['ad_post_id']));
                $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_message_subject_on_new_ad']);
                $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%message%', '%sender_name%', '%sender_email%');
                $msg_replaces = array(get_bloginfo('name'), get_the_title($params['ad_post_id']), get_the_permalink($params['ad_post_id']), $params['message'], $params['name'], $params['email']);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_message_on_new_ad']);
                $body = stripcslashes($body);
            }
            wp_mail($to, $subject, $body, $headers,$attachments_files);
        }
        $comment_id = wp_insert_comment($data);
        if ($comment_id) {
            if (function_exists('adforestAPI_messages_sent_func')) {
                $strip_message = stripcslashes($params['message']);
                adforestAPI_messages_sent_func('sent', $params['msg_receiver_id'], get_current_user_id(), $params['usr_id'], $comment_id, $params['ad_post_id'], sanitize_text_field($strip_message), $time);
            }         
           update_comment_meta($params['msg_receiver_id'], $params['ad_post_id'] . "_" . get_current_user_id(), 0);  
            update_user_meta($current_userID, '_sb_ad_message_send_ids', $current_ad_post_id);
            update_user_meta($current_userID, '_sb_ad_message_send_time', $max_time_limit);
            update_post_meta($current_ad_post_id, 'ad_last_message', $message);         
              if(!empty($attachment_ids)){                  
                      update_comment_meta($comment_id, 'comment_file_meta', serialize($attachment_ids));
                 }    
            
            echo '1|' . __("Message sent successfully.", 'redux-framework');
        } else {
            echo '0|' . __("Message not sent, please try again later.", 'redux-framework');
        }
        die();
    }
}
/* Ajax handler for Forgot Password */
add_action('wp_ajax_sb_forgot_password', 'adforest_forgot_password');
add_action('wp_ajax_nopriv_sb_forgot_password', 'adforest_forgot_password');
/* Forgot Password */
if (!function_exists('adforest_forgot_password')) {

    function adforest_forgot_password() {
        global $adforest_theme;
        /* Getting values */
        $params = array();
        parse_str($_POST['sb_data'], $params);
        check_ajax_referer('sb_forgot_pass_secure', 'security', false);
        $email = $params['sb_forgot_email'];
        if (email_exists($email) == true) {
            $from = get_bloginfo('name');
            if (isset($adforest_theme['sb_forgot_password_from']) && $adforest_theme['sb_forgot_password_from'] != "") {
                $from = $adforest_theme['sb_forgot_password_from'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($adforest_theme['sb_forgot_password_message']) && $adforest_theme['sb_forgot_password_message'] != "") {
                $subject_keywords = array('%site_name%');
                $subject_replaces = array(get_bloginfo('name'));
                $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_forgot_password_subject']);
                $token = adforest_randomString(50);
                $user = get_user_by('email', $email);
                $msg_keywords = array('%site_name%', '%user%', '%reset_link%');               
                $home_url    =  get_home_url(); 
                $reset_link = trailingslashit($home_url) . '?token=' . $token . '-sb-uid-' . $user->ID;            
                $url_arr        =   parse_url(get_home_url()); 
                $check_query    =   isset($url_arr['query'])   ?  $url_arr['query']   : "";
                                                                        
                if($check_query != ""){  
                     $query = "&token=$token";
                     $host      =   isset($url_arr['host'])   ?  $url_arr['host']   : "";
                    $reset_link      =        $home_url .$query. '-sb-uid-' . $user->ID;                   
                }               
                $msg_replaces = array(get_bloginfo('name'), $user->display_name, $reset_link);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_forgot_password_message']);
                $to = $email;
                $mail = wp_mail($to, $subject, $body, $headers);
                if ($mail) {
                    update_user_meta($user->ID, 'sb_password_forget_token', $token);
                    echo "1";
                } else {
                    echo __('Email server not responding', 'redux-framework');
                }
            }
        } else {
            echo __('Email is not registered with us.', 'redux-framework');
        }
        die();
    }
}
if (!function_exists('adforest_get_notify_on_ad_post')) {
    function adforest_get_notify_on_ad_post($pid , $is_update = false) {
        global $adforest_theme;
        if (isset($adforest_theme['sb_send_email_on_ad_post']) && $adforest_theme['sb_send_email_on_ad_post']) {
            $to = $adforest_theme['ad_post_email_value'];
            $subject = __('New Ad', 'redux-framework') . '-' . get_bloginfo('name');
            $body = '<html><body><p>' . __('Got new ad', 'redux-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
            $from = get_bloginfo('name');
            if (isset($adforest_theme['sb_msg_from_on_new_ad']) && $adforest_theme['sb_msg_from_on_new_ad'] != "") {
                $from = $adforest_theme['sb_msg_from_on_new_ad'];
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            if (isset($adforest_theme['sb_msg_on_new_ad']) && $adforest_theme['sb_msg_on_new_ad'] != "" && !$is_update) {
                $author_id = get_post_field('post_author', $pid);
                $user_info = get_userdata($author_id);
                $subject_keywords = array('%site_name%', '%ad_owner%', '%ad_title%');
                $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));
                $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_msg_subject_on_new_ad']);
                $msg_keywords = array('%site_name%', '%ad_owner%', '%ad_title%', '%ad_link%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_msg_on_new_ad']);
            }
            wp_mail($to, $subject, $body, $headers);
        }
    }
}
if (!function_exists('adforest_send_email_new_rating')) {
    function adforest_send_email_new_rating($sender_id, $receiver_id, $rating = '', $comments = '') {
        global $adforest_theme;
        $receiver_info = get_userdata($receiver_id);
        $to = $receiver_info->user_email;
        $subject = __('New Rating', 'redux-framework') . '-' . get_bloginfo('name');

        $body = '<html><body><p>' . __('Got new Rating', 'redux-framework') . ' <a href="' . get_author_posts_url($receiver_id) . '?type=1">' . get_author_posts_url($receiver_id) . '</a></p></body></html>';
        $from = get_bloginfo('name');

        if (isset($adforest_theme['sb_new_rating_from']) && $adforest_theme['sb_new_rating_from'] != "") {
            $from = $adforest_theme['sb_new_rating_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['sb_new_rating_message']) && $adforest_theme['sb_new_rating_message'] != "") {
            $subject_keywords = array('%site_name%');
            $subject_replaces = array(get_bloginfo('name'));
            $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_new_rating_subject']);
            /* Rator info */
            $sender_info = get_userdata($sender_id);
            $msg_keywords = array('%site_name%', '%receiver%', '%rator%', '%rating%', '%comments%', '%rating_link%');
            $msg_replaces = array(get_bloginfo('name'), $receiver_info->display_name, $sender_info->display_name, $rating, $comments, get_author_posts_url($receiver_id) . '?type=1');

            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_rating_message']);
        }
        wp_mail($to, $subject, $body, $headers);
    }

}

add_action('adforest_send_email_bid_winner', 'adforest_send_email_bid_winner_callback', 10, 1);

if (!function_exists('adforest_send_email_bid_winner_callback')) {

    function adforest_send_email_bid_winner_callback($ad_id = 0) {
        global $adforest_theme;

        if ($ad_id == 0)
            return;

        $adforest_bid_flag = get_post_meta($ad_id, 'adforest_bid_winner_mail_flg', true);
        $adforest_bid_flag = $adforest_bid_flag == '' ? '1' : $adforest_bid_flag;

        if ($adforest_bid_flag == '0')
            return;

        $bids_res = adforest_get_all_biddings_array($ad_id);
        $total_bids = count($bids_res);
        $max = 0;
        if ($total_bids > 0) {
            $max = max($bids_res);
        }
        $count = 1;
        if ($total_bids > 0) {

            if (isset($bids_res) && $bids_res != '' && is_array($bids_res) && sizeof($bids_res) > 0) {
                foreach ($bids_res as $key => $val) {
                    $bid_winner_neme = 'demo';
                    if ($val == $max) {
                        $data = explode('_', $key);
                        $bid_winner_id = $data[0];
                        $user_info = get_userdata($bid_winner_id);
                        $bid_winner_neme = $user_info->display_name;
                        $to = $user_info->user_email;
                        $from = '';
                        if (isset($adforest_theme['sb_new_bid_winner_from']) && $adforest_theme['sb_new_bid_winner_from'] != "") {
                            $from = $adforest_theme['sb_new_bid_winner_from'];
                        }
                        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                        if (isset($adforest_theme['sb_email_to_bid_winner']) && $adforest_theme['sb_email_to_bid_winner']) {
                            if (isset($adforest_theme['sb_new_bid_winner_message']) && $adforest_theme['sb_new_bid_winner_message'] != "") {
                                $subject_keywords = array('%site_name%');
                                $subject_replaces = array(get_bloginfo('name'));
                                $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_new_bid_winner_subject']);
                                $msg_keywords = array('%site_name%', '%bid_winner_name%', '%bid_link%');
                                $msg_replaces = array(get_bloginfo('name'), $bid_winner_neme, get_the_permalink($ad_id) . '#tab2default');
                                 $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_bid_winner_message']);
                                wp_mail($to, $subject, $body, $headers);
                                update_post_meta($ad_id, 'adforest_bid_winner_mail_flg', '0');
                            }
                        }
                    }
                    break;
                }
            }
        }
    }

}

if (!function_exists('adforest_send_email_new_bid')) {

    function adforest_send_email_new_bid($sender_id = "", $receiver_id = "", $bid = '', $comments = '', $aid = "") {
        global $adforest_theme;
        $receiver_info = get_userdata($receiver_id);
        $to = $receiver_info->user_email;
        $from = '';
        if (isset($adforest_theme['sb_new_bid_from']) && $adforest_theme['sb_new_bid_from'] != "") {
            $from = $adforest_theme['sb_new_bid_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['sb_new_bid_message']) && $adforest_theme['sb_new_bid_message'] != "") {
            $subject_keywords = array('%site_name%');
            $subject_replaces = array(get_bloginfo('name'));
            $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_new_bid_subject']);
            /* Bidder info */
            $sender_info = get_userdata($sender_id);
            $msg_keywords = array('%site_name%', '%receiver%', '%bidder%', '%bid%', '%comments%', '%bid_link%');
            $msg_replaces = array(get_bloginfo('name'), $receiver_info->display_name, $sender_info->display_name, $bid, $comments, get_the_permalink($aid) . '#tab2default');
            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_bid_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

}
/* Resend Email */
add_action('wp_ajax_sb_resend_email', 'adforest_resend_email');
add_action('wp_ajax_nopriv_sb_resend_email', 'adforest_resend_email');

if (!function_exists('adforest_resend_email')) {

    function adforest_resend_email() {
        $email = $_POST['usr_email'];
        $user = get_user_by('email', $email);
        if (get_user_meta($user->ID, 'sb_resent_email', true) != 'yes') {
            adforest_email_on_new_user($user->ID, '');
            update_user_meta($user->ID, 'sb_resent_email', 'yes');
        }
        die();
    }

}


/* Resend Email */
add_action('wp_ajax_sb_send_user_account_confirmation_mail', 'sb_send_user_account_confirmation_mail_callback');

if (!function_exists('sb_send_user_account_confirmation_mail_callback')) {
    function sb_send_user_account_confirmation_mail_callback() {       
                $user_id = isset($_POST['user_id'])  ?  $_POST['user_id']  : "";
                $subject = $adforest_theme['sb_new_user_account_confirmation_subject'];
                $from = $adforest_theme['sb_new_user_account_message_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $user_info = get_userdata($user_id);
                $msg_keywords = array('%site_name%', '%display_name%', '%email%');

                $user_email  =  isset($user_info->user_email)  ?  $user_info->user_email  : "";

                if($user_email  ==  "" ){

                    $user_email  ==  get_user_meta($user_id , '_sb_contact',true);   
                }

                 $msg_replaces = array(get_bloginfo('name'), $user_info->display_name,$user_email);
                
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_account_confirmation_message']);                 
                   if($user_email  != ""){
                   wp_mail($user_email, $subject, $body, $headers);  
                   
                   echo esc_html__("Email has been sent ssuccesfully",'redux-framework');
                   die();
                   
                  }                
}
}
/* Email on new User */

if (!function_exists('adforest_email_on_new_user')) {

    function adforest_email_on_new_user($user_id, $social = '', $admin_email = true) {
      global  $adforest_theme ;
        
        if (isset($adforest_theme['sb_new_user_email_to_admin']) && $adforest_theme['sb_new_user_email_to_admin'] && $admin_email) {
            if (isset($adforest_theme['sb_new_user_admin_message']) && $adforest_theme['sb_new_user_admin_message'] != "" && isset($adforest_theme['sb_new_user_admin_message_from']) && $adforest_theme['sb_new_user_admin_message_from'] != "") {
                $to = get_option('admin_email');
           
                $subject = $adforest_theme['sb_new_user_admin_message_subject'];
                $from = $adforest_theme['sb_new_user_admin_message_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $user_info = get_userdata($user_id);
                $msg_keywords = array('%site_name%', '%display_name%', '%email%');
               

                $user_email  =  isset($user_info->user_email)  ?  $user_info->user_email  : "";
                if($user_email  ==  "" ){
                    $user_email  ==  get_user_meta($user_id , '_sb_contact',true);   
                }
                 $msg_replaces = array(get_bloginfo('name'), $user_info->display_name,$user_email);
                
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_admin_message']);
                  
                   if($user_email  != ""){
                   wp_mail($to, $subject, $body, $headers);
                   }
            }
        }

        if (isset($adforest_theme['sb_new_user_email_to_user']) && $adforest_theme['sb_new_user_email_to_user']) {
            if (isset($adforest_theme['sb_new_user_message']) && $adforest_theme['sb_new_user_message'] != "" && isset($adforest_theme['sb_new_user_message_from']) && $adforest_theme['sb_new_user_message_from'] != "") {
                // User info
                $user_info = get_userdata($user_id);

                $to = $user_info->user_email;
                $subject = $adforest_theme['sb_new_user_message_subject'];
                $from = $adforest_theme['sb_new_user_message_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $user_name = $user_info->user_email;

                if($user_name ==  ""){
                    return ;
                }
                if ($social != '')
                    $user_name .= "(Password: $social )";
                $verification_link = '';
                $sb_sign_in_page = isset($adforest_theme['sb_sign_in_page']) && $adforest_theme['sb_sign_in_page'] != '' ? $adforest_theme['sb_sign_in_page'] : '';
                if (isset($adforest_theme['sb_new_user_email_verification']) && $adforest_theme['sb_new_user_email_verification'] && $social == "" && $sb_sign_in_page != '') {
                    $token = get_user_meta($user_id, 'sb_email_verification_token', true);
                    if ($token == "") {
                        $token = adforest_randomString(50);
                    }                    
                    $verification_link = trailingslashit(get_the_permalink($adforest_theme['sb_sign_in_page'])) . '?verification_key=' . $token . '-sb-uid-' . $user_id;
                    update_user_meta($user_id, 'sb_email_verification_token', $token);
                }
                $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%verification_link%');
                $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $verification_link);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_message']);
                wp_mail($to, $subject, $body, $headers);
            }
        }
    }
}
/* Email on new social login user */

if (!function_exists('adforest_email_on_new_social_user')) {

    function adforest_email_on_new_social_user($user_id, $social = '', $admin_email = true) {
        global $adforest_theme;

        if (isset($adforest_theme['sb_new_user_email_to_admin']) && $adforest_theme['sb_new_user_email_to_admin'] && $admin_email) {
            if (isset($adforest_theme['sb_new_user_admin_message']) && $adforest_theme['sb_new_user_admin_message'] != "" && isset($adforest_theme['sb_new_user_admin_message_from']) && $adforest_theme['sb_new_user_admin_message_from'] != "") {
                $to = get_option('admin_email');
                $subject = $adforest_theme['sb_new_user_admin_message_subject'];
                $from = $adforest_theme['sb_new_user_admin_message_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $user_info = get_userdata($user_id);
                $msg_keywords = array('%site_name%', '%display_name%', '%email%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_new_user_admin_message']);
                wp_mail($to, $subject, $body, $headers);
            }
        }

        if (isset($adforest_theme['sb_new_user_email_to_user']) && $adforest_theme['sb_new_user_email_to_user']) {
            if (isset($adforest_theme['sb_welcome_social_message']) && $adforest_theme['sb_welcome_social_message'] != "" && isset($adforest_theme['sb_welcome_social_message_from']) && $adforest_theme['sb_welcome_social_message_from'] != "") {
                $user_info = get_userdata($user_id);
                $to = $user_info->user_email;
                $subject = $adforest_theme['sb_welcome_social_message_subject'];
                $from = $adforest_theme['sb_welcome_social_message_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $login_details = '';
                $login_details .= ' Username : ' . $user_info->user_email;

                if ($social != '') {
                    $login_details .= "(Password: $social )";
                }
                $msg_keywords = array('%site_name%', '%email%', '%display_name%', '%details%');
                $msg_replaces = array(get_bloginfo('name'), $user_info->user_email, $user_info->display_name, $login_details);

                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_welcome_social_message']);
                wp_mail($to, $subject, $body, $headers);
            }
        }
    }

}

/* Email on Ad approval */

if (!function_exists('adforest_get_notify_on_ad_approval')) {

    function adforest_get_notify_on_ad_approval($pid) {
        global $adforest_theme;
        //$sent_mail = apply_filters('adforest_wpml_mail_duplicator', $pid, true);
        $sent_mail = TRUE;
        $from = get_bloginfo('name');
        if (isset($adforest_theme['sb_active_ad_email_from']) && $adforest_theme['sb_active_ad_email_from'] != "") {
            $from = $adforest_theme['sb_active_ad_email_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['sb_active_ad_email_message']) && $adforest_theme['sb_active_ad_email_message'] != "") {

            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);

            $subject = $adforest_theme['sb_active_ad_email_subject'];

            $msg_keywords = array('%site_name%', '%user_name%', '%ad_title%', '%ad_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), urldecode(get_the_permalink($pid)));

            $to = $user_info->user_email;
            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_active_ad_email_message']);

            if ($sent_mail) {
                wp_mail($to, $subject, $body, $headers);
            }
        }
    }

}

/* Email on Ad rating */

if (!function_exists('adforest_email_ad_rating')) {

    function adforest_email_ad_rating($pid, $sender_id, $rating, $comments) {
        global $adforest_theme;
        $from = get_bloginfo('name');
        if (isset($adforest_theme['ad_rating_email_from']) && $adforest_theme['ad_rating_email_from'] != "") {
            $from = $adforest_theme['ad_rating_email_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['ad_rating_email_message']) && $adforest_theme['ad_rating_email_message'] != "") {
            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);
            $subject = $adforest_theme['ad_rating_email_subject'];
            $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%rating%', '%rating_comments%', '%author_name%');
            $msg_replaces = array(get_bloginfo('name'), get_the_title($pid), get_the_permalink($pid) . '#ad-rating', $rating, $comments, $user_info->display_name);
            $to = $user_info->user_email;
            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['ad_rating_email_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

}

/* Email on Ad rating reply */

if (!function_exists('adforest_email_ad_rating_reply')) {

    function adforest_email_ad_rating_reply($pid, $receiver_id, $reply, $rating, $rating_comments) {
        global $adforest_theme;
        $from = get_bloginfo('name');
        if (isset($adforest_theme['ad_rating_reply_email_from']) && $adforest_theme['ad_rating_reply_email_from'] != "") {
            $from = $adforest_theme['ad_rating_reply_email_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($adforest_theme['ad_rating_reply_email_message']) && $adforest_theme['ad_rating_reply_email_message'] != "") {

            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);

            $subject = $adforest_theme['ad_rating_reply_email_subject'];

            $msg_keywords = array('%site_name%', '%ad_title%', '%ad_link%', '%rating%', '%rating_comments%', '%author_name%', '%author_reply%');
            $msg_replaces = array(get_bloginfo('name'), get_the_title($pid), get_the_permalink($pid) . '#ad-rating', $rating, $rating_comments, $user_info->display_name, $reply);

            $receiver_info = get_userdata($receiver_id);
            $to = $receiver_info->user_email;
            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['ad_rating_reply_email_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }

}

/* Ajax handler for add to cart */
add_action('wp_ajax_demo_data_start', 'adforest_before_install_demo_data');

/* Addind Subcriber into Mailchimp */
if (!function_exists('adforest_before_install_demo_data')) {

    function adforest_before_install_demo_data() {
        if (get_option('adforest_fresh_installation') != 'no') {
            update_option('adforest_fresh_installation', $_POST['is_fresh']);
        }
        die();
    }

}

/* Importing data */

if (!function_exists('adforest_importing_data')) {

    function adforest_importing_data($demo_type) {
        global $wpdb;
        $sql_file_OR_content;
        if ($demo_type == 'Adforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/data.sql';
        } 
       else if ($demo_type == 'PetForest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/petforest-data.sql';
        } else if ($demo_type == 'MatchForest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/matchforest-data.sql';
        } else if ($demo_type == 'TechForest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/techforest-data.sql';
        } else if ($demo_type == 'Landing-Page') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/landing-data.sql';
        } else if ($demo_type == 'bookforest') {                              // new sql files
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/bookforest-data.sql';
        } else if ($demo_type == 'decorforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/decorforest-data.sql';
        } else if ($demo_type == 'estateforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/estateforest-data.sql';
        } else if ($demo_type == 'mobileforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/mobileforest-data.sql';
        } else if ($demo_type == 'serviceforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/serviceforest-data.sql';
        } else if ($demo_type == 'sportforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/sportforest-data.sql';
        } else if ($demo_type == 'toyforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/toyforest-data.sql';
        } else if ($demo_type == 'Elementor-LTR-Adforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/ele-ltr-data.sql';
        } else if ($demo_type == 'Elementor-RTL-Adforest') {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/ele-rtl-data.sql';
        } 
         else if($demo_type == 'directory'){
         $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/directory.sql';

         }
          else if($demo_type == 'events'){
         $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/events.sql';
         }

        else {
            $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/data-rtl.sql';
        }//
        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content) );
        $allLines = explode("\n", $SQL_CONTENT);
        $zzzzzz = $wpdb->query('SET foreign_key_checks = 0');
        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
        foreach ($target_tables[2] as $table) {
            $wpdb->query('DROP TABLE IF EXISTS ' . $table);
        }
        $zzzzzz = $wpdb->query('SET foreign_key_checks = 1');
        //$wpdb->query("SET NAMES 'utf8'");	
        $templine = ''; // Temporary variable, used to store current query
        foreach ($allLines as $line) {           // Loop through each line
            if (substr($line, 0, 2) != '--' && $line != '') {
                $templine .= $line;  // (if it is not a comment..) Add this line to the current segment
                if (substr(trim($line), -1, 1) == ';') {  // If it has a semicolon at the end, it's the end of the query
                    if ($wpdb->prefix != 'wp_') {
                        $templine = str_replace("`wp_", "`$wpdb->prefix", $templine);
                    }
                    if (!$wpdb->query($templine)) {
                        //print('Error performing query \'<strong>' . $templine . '\': ' . $wpdb->error . '<br /><br />');
                    }
                    $templine = ''; // set variable to empty, to start picking up the lines after ";"
                }
            }
        }
        //return 'Importing finished. Now, Delete the import file.';
    }

}

/* define the admin_comment_types_dropdown callback */
if (!function_exists('sb_filter_admin_comment_types_dropdown')) {

    function sb_filter_admin_comment_types_dropdown($comment_type_array) {
        // make filter magic happen here... 
        $comment_type_array['ad_post_rating'] = __('Ad Rating', 'redux-framework');
        return $comment_type_array;
    }

}

/* add the filter */
add_filter('admin_comment_types_dropdown', 'sb_filter_admin_comment_types_dropdown', 10, 1);
add_action('wp_ajax_sb_delete_user_rating', 'adforest_delete_user_rating');
/* Delete user rating */
if (!function_exists('adforest_delete_user_rating')) {

    function adforest_delete_user_rating() {
        global $wpdb;
        $meta_id = $_POST['meta_id'];
        $table_name = $wpdb->prefix . "usermeta";
        $wpdb->query("DELETE FROM $table_name WHERE umeta_id = '$meta_id' ");
        echo "1";
        die();
    }

}

add_action('wp_ajax_sb_delete_user_bid', 'adforest_delete_user_bid_admin');

/* Delete user rating */
if (!function_exists('adforest_delete_user_bid_admin')) {

    function adforest_delete_user_bid_admin() {
        global $wpdb;
        $meta_id = $_POST['meta_id'];
        $table_name = $wpdb->prefix . "postmeta";
        $wpdb->query("DELETE FROM $table_name WHERE meta_id = '$meta_id' ");
        echo "1";
        die();
    }

}

/* Email on new User */
add_action('wp_ajax_sb_user_contact_form', 'adforest_user_contact_form');
add_action('wp_ajax_nopriv_sb_user_contact_form', 'adforest_user_contact_form');

if (!function_exists('adforest_user_contact_form')) {

    function adforest_user_contact_form() {
        global $adforest_theme;
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $name = $params['name'];
        $email = $params['email'];
        $sender_subject = $params['subject'];
        $message = $params['message'];
        $user_id = $_POST['receiver_id'];

        $google_captcha_auth = false;
        $google_captcha_auth = adforest_recaptcha_verify($adforest_theme['google_api_secret'], @$params['g-recaptcha-response'], @$_SERVER['REMOTE_ADDR'], @$params['is_captcha']);
        $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';

        if ($google_captcha_auth) {
            if (isset($adforest_theme['user_contact_form']) && $adforest_theme['user_contact_form']) {
                if (isset($adforest_theme['sb_profile_contact_message']) && $adforest_theme['sb_profile_contact_message'] != "" && isset($adforest_theme['sb_profile_contact_from']) && $adforest_theme['sb_profile_contact_from'] != "") {
                    $user_info = get_userdata($user_id);
                    $to = $user_info->user_email;
                    $user_info->display_name;
                    $subject = $adforest_theme['sb_profile_contact_subject'];
                    $from = $adforest_theme['sb_profile_contact_from'];
                    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                    $headers[] = 'Reply-To: $name <$email>';
                    $msg_keywords = array('%receiver_name%', '%sender_name%', '%sender_email%', '%sender_subject%', '%sender_message%');
                    $msg_replaces = array($user_info->display_name, $name, $email, $sender_subject, $message);
                    $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_profile_contact_message']);
                    $res = wp_mail($to, $subject, $body, $headers);
                    if ($res) {
                        echo '1|' . __("Message has been sent.", "redux-framework");
                    } else {
                        echo '0|' . __("Message not sent, please try later.", "redux-framework");
                    }
                    die();
                }
            }
        } else {
            if ($captcha_type == 'v3') {
                echo '0|' . __("You are spammer ! Get out..", "redux-framework");
            } else {
                echo '0|' . __("please verify captcha code.", "redux-framework");
            }
        }
    }
}
/* Email on new User */
add_action('wp_ajax_sb_send_message_to_author', 'adforest_sb_send_message_to_author_func');
add_action('wp_ajax_nopriv_sb_send_message_to_author', 'adforest_sb_send_message_to_author_func');
if (!function_exists('adforest_sb_send_message_to_author_func')) {
    function adforest_sb_send_message_to_author_func() {
        global $adforest_theme;
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $name = $params['userName'];
        $email = $params['emailAddress'];
        $sender_phone = $params['phoneNumber'];
        $message = $params['message'];
        $ad_id = $_POST['ad_id'];

       

        
        if ('ad_post' != get_post_type($ad_id) && 'events' != get_post_type($ad_id)) {
                
                 echo '0|' . __("You can use this widget on ad details page only", "redux-framework");
                 die();               
        }
        //$from         = $email;
        $ad_author_id = get_post_field('post_author', $ad_id);
        /* $to           = get_the_author_meta('user_email', $ad_author_id);
          $to_name      = get_the_author_meta('display_name', $ad_author_id); */
        $google_captcha_auth = false;
        $google_captcha_auth = adforest_recaptcha_verify($adforest_theme['google_api_secret'], $params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $params['is_captcha']);
        $captcha_type = isset($adforest_theme['google-recaptcha-type']) && !empty($adforest_theme['google-recaptcha-type']) ? $adforest_theme['google-recaptcha-type'] : 'v2';

        if ($google_captcha_auth) {
            //if (isset($adforest_theme['user_contact_form']) && $adforest_theme['user_contact_form']) {
            if (isset($adforest_theme['sb_email_template_seller_widget_desc']) && $adforest_theme['sb_email_template_seller_widget_desc'] != "" && isset($adforest_theme['sb_email_template_seller_widget_from']) && $adforest_theme['sb_email_template_seller_widget_from'] != "") {

                $ad_title = get_the_title($ad_id);
                $ad_permalink = get_the_permalink($ad_id);
                $ad_owner = get_post_meta($ad_id, '_adforest_poster_name', true);
                $user_info = get_userdata($ad_author_id);
                $to = $user_info->user_email;
                $user_info->display_name;
                /* $subject = $adforest_theme['sb_email_template_seller_widget_subject']; */
                $from = $adforest_theme['sb_email_template_seller_widget_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from", "Reply-To: <$email>");
                $msg_keywords = array('%receiver_name%', '%sender_name%', '%sender_email%', '%sender_phone%', '%sender_message%', '%ad_title%', '%ad_link%', '%ad_owner%');
                $msg_replaces = array($user_info->display_name, $name, $email, $sender_phone, $message, $ad_title, $ad_permalink, $ad_owner);
                $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_email_template_seller_widget_desc']);

                $subject_keywords = array('%site_name%', '%ad_title%', '%ad_owner%');
                $subject_replaces = array(get_bloginfo('name'), get_the_title($ad_id), $user_info->display_name);

                $subject = str_replace($subject_keywords, $subject_replaces, $adforest_theme['sb_email_template_seller_widget_subject']);
                $res = wp_mail($to, $subject, $body, $headers);
                if ($res) {
                    echo '1|' . __("Message has been sent.", "redux-framework");
                } else {
                    echo '0|' . __("Message not sent, please try later.", "redux-framework");
                }
                die();
            }
            //}
        } else {


            if ($captcha_type == 'v3') {
                echo '0|' . __("You are spammer ! Get out..", "redux-framework");
            } else {
                echo '0|' . __("please verify captcha code.", "redux-framework");
            }
        }
    }

}

class Adforest_Demo_OCDI {

    function __construct() {
        add_filter('pt-ocdi/import_files', array($this, 'adforest_ocdi_import_files'));
        add_action('pt-ocdi/after_import', array($this, 'adforest_ocdi_after_import'));
        add_filter('pt-ocdi/plugin_intro_text', array($this, 'adforest_ocdi_plugin_intro_text'));
        //add_filter('pt-ocdi/plugin_intro_text', array($this, 'adforest_framework_importer_description_config'));
        add_filter('pt-ocdi/disable_pt_branding', array($this, '__return_true'));
        //add_action('pt-ocdi/enable_wp_customize_save_hooks', '__return_true');
    }

    function adforest_ocdi_before_content_import($a) {
        $msg = '';
        $fresh_installation = (array) get_option('_adforest_ocdi_demos');
        if (in_array("$a", $fresh_installation)) {
            $msg = __('Note: This demo data is already imported.', 'redux-framework');
            $msg = "<strong style='color:red;'>" . $msg . "</strong><br />";
        }
        return $msg;
    }

    function adforest_ocdi_options($demo_type = array()) {
        if (isset($demo_type)) {
            $fresh_installation = (array) get_option('_adforest_ocdi_demos');
            $result = array_merge($fresh_installation, $demo_type);
            $result = array_unique($result);
            update_option('_adforest_ocdi_demos', $result);
            
             
        }
        $fresh_installation = (array) get_option('_adforest_ocdi_demos');

        $my_keyname = array("_", "s", "b", "_", "p", "u", "r", "c", "h", "a", "s", "e", "_", "c", "o", "d", "e");
        $kyname = implode($my_keyname);
        $my_keynamelink = array("h", "t", "t", "p", "s", ":", "/", "/", "a", "u", "t", "h", "e", "n", "t", "i", "c", "a", "t", "e", ".", "s", "c", "r", "i", "p", "t", "s", "b", "u", "n", "d", "l", "e", ".", "c", "o", "m", "/", "a", "d", "f", "o", "r", "e", "s", "t", "/", "v", "e", "r", "i", "f", "y", "_", "p", "c", "o", "d", "e", ".", "p", "h", "p");
        $my_keynameUrl = implode($my_keynamelink);
        $sb_theme_pcode = get_option($kyname);
        if ($sb_theme_pcode != "") {
            $theme_name = "Adforest";
            $data = "?purchase_code=" . $sb_theme_pcode . "&id=" . get_option('admin_email') . '&url=' . get_option('siteurl') . '&theme_name=' . $theme_name;
            $url = esc_url($my_keynameUrl) . $data;
            $response = @wp_remote_get($url);
            if (is_array($response) && !is_wp_error($response)) {
                update_option('_sb_purchase_code_verification', 'done');
            } else {
                update_option('_sb_purchase_code_verification', '');
            }
        }
    }

function adforest_ocdi_import_files() {
        /* LTR Demo Options */
        $text = " - " . __('Imported', 'redux-framework') . "";
        // $text = "";
        $notice = $this->adforest_ocdi_before_content_import('Adforest');
               
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Adforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Adforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Adforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Adforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Adforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Adforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/demo-bakery/',
        );
       
        if(class_exists('SbPro')){      

        $notice = $this->adforest_ocdi_before_content_import('Adforest Events');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Adforest Events' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Events/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Events/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Events/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Events/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Events/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest-directory.scriptsbundle.com/event_listing',
        );
        
        $notice = $this->adforest_ocdi_before_content_import('Adforest Directory Listing');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Adforest Directory Listing' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Directory/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Directory/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Directory/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Directory/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Directory/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforest-directory.scriptsbundle.com/',
        );
            
            
        }
        
        /* RTL Demo Options */
        $notice = $this->adforest_ocdi_before_content_import('Adforest RTL');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Adforest RTL' . $notice2,
            'categories' => array('RTL Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Adforest-RTL/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Adforest-RTL/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/bakery-rtl/',
        );

         $notice = $this->adforest_ocdi_before_content_import('Elementor-LTR-Adforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Elementor LTR Adforest' . $notice2,
            'categories' => array('Elementor Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Elementor-LTR-Adforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Elementor-LTR-Adforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Elementor-LTR-Adforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Elementor-LTR-Adforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Elementor-LTR-Adforest/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'http://adforestpro.scriptsbundle.com/',
        );
        /* Elementor-Demos  Elementor-RTL-Adforest */
        $notice = $this->adforest_ocdi_before_content_import('Elementor-RTL-Adforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Elementor RTL Adforest' . $notice2,
            'categories' => array('Elementor Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Elementor-RTL-Adforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Elementor-RTL-Adforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Elementor-RTL-Adforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Elementor-RTL-Adforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Elementor-RTL-Adforest/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/rtl/',
        );
        /* Multi vendor  Multi vendor*/
        $notice = $this->adforest_ocdi_before_content_import('multivendor');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Multi Vendor' . $notice2,
            'categories' => array('Multi Vendor'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/multivendor/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/multivendor/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/multivendor/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/multivendor/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/multivendor/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://vendors-adforest.scriptsbundle.com/',
        );                
        /* Multi vendor  Multi vendor*/
        $notice = $this->adforest_ocdi_before_content_import('multivendor-rtl');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Multi Vendor rtl' . $notice2,
            'categories' => array('Multi Vendor'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/multivendor-rtl/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/multivendor-rtl/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/multivendor-rtl/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/multivendor-rtl/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/multivendor-rtl/screen-image.jpg',
            'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://vendors-adforest.scriptsbundle.com/rtl',
        );
        $notice = $this->adforest_ocdi_before_content_import('PetForest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'PetForest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/PetForest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/PetForest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/PetForest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/PetForest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/PetForest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/petforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('MatchForest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'MatchForest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/MatchForest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/MatchForest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/MatchForest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/MatchForest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/MatchForest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/matchforest',
        );
        $notice = $this->adforest_ocdi_before_content_import('TechForest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'TechForest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/TechForest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/TechForest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/TechForest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/TechForest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/TechForest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/techforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Landing Page');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Landing Page' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/Landing-Page/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/Landing-Page/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/landing/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Bookforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Bookforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/bookforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/bookforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/bookforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/bookforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/bookforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/bookforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Decorforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Decorforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/decorforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/decorforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/decorforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/decorforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/decorforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/decorforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Estateforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Estateforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/estateforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/estateforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/estateforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/estateforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/estateforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/realforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Mobileforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Mobileforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/mobileforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/mobileforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/mobileforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/mobileforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/mobileforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/mobileforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Serviceforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Serviceforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/serviceforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/serviceforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/serviceforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/serviceforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/serviceforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/serviceforest',
        );
        $notice = $this->adforest_ocdi_before_content_import('Sportforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Sportforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/sportforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/sportforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/sportforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/sportforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/sportforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/sportforest/',
        );
        $notice = $this->adforest_ocdi_before_content_import('Toyforest');
        $notice2 = ($notice != "" ) ? $text : "";
        $allDemos[] = array(
            'import_file_name' => 'Toyforest' . $notice2,
            'categories' => array('LTR Demo'),
            'local_import_file' => SB_PLUGIN_PATH . 'demo-data/toyforest/content.xml',
            'local_import_widget_file' => SB_PLUGIN_PATH . 'demo-data/toyforest/widgets.json',
            'local_import_customizer_file' => SB_PLUGIN_PATH . 'demo-data/toyforest/customizer.dat',
            'local_import_redux' => array(
                array('file_path' => SB_PLUGIN_PATH . 'demo-data/toyforest/theme-options.json', 'option_name' => 'adforest_theme',),),
            'import_preview_image_url' => SB_PLUGIN_URL . 'demo-data/toyforest/screen-image.jpg',
            'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
            'preview_url' => 'https://adforestpro.scriptsbundle.com/toyforest/',
        );

        return $allDemos;
    }

    function adforest_ocdi_after_import($selected_import) {
        //echo "This will be displayed on all after imports!";
        $fresh_installation = get_option('adforest_fresh_installation');
        if ('Multi Vendor' === $selected_import['import_file_name']   || 'Multi Vendor rtl' === $selected_import['import_file_name'] ) {
        }
        else{
             if ( $fresh_installation != 'no') {
                global $wpdb;
               $wpdb->query("TRUNCATE TABLE $wpdb->term_relationships");
                $wpdb->query("TRUNCATE TABLE $wpdb->term_taxonomy");
               $wpdb->query("TRUNCATE TABLE $wpdb->termmeta");
                $wpdb->query("TRUNCATE TABLE $wpdb->terms");    
            }           
        }
        if ('Adforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('sassy classified');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Adforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest'));
        
        } elseif ('Adforest RTL' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('sassy classified');
            $blog_page_id = get_page_by_title('مدون');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Adforest RTL');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest RTL'));
        } elseif ('Elementor LTR Adforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('sassy classified');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Elementor-LTR-Adforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Elementor LTR Adforest'));
        } 

        elseif ('Adforest Directory Listing' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('home page 2');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('directory');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest Directory Listing'));
        } 

         elseif ('Adforest Events' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('event home');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('events');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest Events'));
        } 





        elseif ('Multi Vendor' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title("Vendor's Shop");
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('multivendor');
            }
            update_option('is_multivendor_imported', "yes");
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Multi Vendor'));
        }
          elseif ('Multi Vendor rtl' === $selected_import['import_file_name']) {
            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title("Vendor's Shop");
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('multivendor');
            }
            update_option('is_multivendor_imported', "yes");
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Adforest RTL'));
        }
        elseif ('PetForest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('petforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('PetForest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('PetForest'));
        } elseif ('MatchForest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('matchforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
               adforest_importing_data('MatchForest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('MatchForest'));
        } elseif ('TechForest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('techforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('TechForest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('TechForest'));
        } elseif ('Landing Page' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('landing page');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('Landing-Page');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Landing Page'));
        } elseif ('Bookforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('boookforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('bookforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Bookforest'));
        } elseif ('Decorforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('decorforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('decorforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Decorforest'));
        } elseif ('Estateforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('realforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('estateforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Estateforest'));
        } elseif ('Mobileforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('mobileforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('mobileforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Mobileforest'));
        } elseif ('Serviceforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('serviceforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('serviceforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Serviceforest'));
        } elseif ('Sportforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('sportforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('sportforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Sportforest'));
        } elseif ('Toyforest' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            /* Assign front page and posts page (blog page). */
            $front_page_id = get_page_by_title('toyforest');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                adforest_importing_data('toyforest');
            }
            update_option('adforest_fresh_installation', 'no');
            $this->adforest_ocdi_options(array('Toyforest'));
        } 
           
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
    }

    function adforest_ocdi_plugin_intro_text($default_text) {
        $default_text .= '<div class="ocdi__intro-text"><h4 id="before">Before Importing Demo</h4>
            	<p><strong>Before importing one of the demos available it is advisable to check the following list</strong>. <br />All these queues are important and will ensure that the import of a demo ends successfully. In the event that something should go wrong with your import, open a ticket and <a href="https://scriptsbundle.ticksy.com/" target="_blank">contact our Technical Support</a>.</p>
            	<ul>
            	<li><strong>Theme Activation</strong> – Please make sure to activate the theme to be able to access the demo import section</li>
            	<li><strong>Required Plugins</strong> – Install and activate all required plugins</li>
            	<li><strong>Other Plugins</strong> – Is recommended to <strong>disable all other plugins that are not required</strong>. Such as plugins to create coming soon pages, plugins to manage the cache, plugin to manage SEO, etc &#8230; You will reactivate your personal plugins later as soon as the import process is finished</li>
            	</ul>
            	<h4>Requirements for demo importing</h4>
            	<p>To correctly import a demo please make sure that your hosting is running the following features:</p>
            	<p><strong>WordPress Requirements</strong></p>
            	<ul>
            	<li>WordPress 4.6+</li>
            	<li>PHP 5.6+</li>
            	<li>MySQL 5.6+</li>
            	</ul>
            	<p><strong>Recommended PHP configuration limits</strong></p>
            	<p>*If the import stalls and fails to respond after a few minutes it because your hosting is suffering from PHP configuration limits. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:</p>
            	<ul>
            	<li>max_execution_time 3000</li>
            	<li>memory_limit 512M</li>
            	<li>post_max_size 100M</li>
            	<li>upload_max_filesize 81M</li>
            	</ul></div>
            	<p><strong>*Please note that you can import 1 demo data select it carefully.</strong></p>
            	<hr />';

        return $default_text;
    }

    /* if ( !function_exists( 'adforest_framework_importer_description_config' ) ) { */

    function adforest_framework_importer_description_config($default_text) {
        //get ser detials
        $server_memory_limit = $server_max_execution_time = $server_upload_max_size = '';
        $server_memory_limit = ini_get('memory_limit');
        $server_max_execution_time = ini_get('max_execution_time');
        $server_upload_max_size = ini_get('upload_max_filesize');
        //minimum req
        $php_version = 7.1;
        $min_memory_end = 512;
        $min_execution_time = 3000; // 300 seconds = 5 minutes
        $min_filesize = 81;
        //get php version
        if (phpversion() >= $php_version) {
            $active_clr = 'ok-req';
            $icon = 'yes';
            $msg = '';
        }
        if (phpversion() < $php_version) {
            $active_clr = 'bad-req';
            $icon = 'no';
            $msg = 'You have outdated PHP version installed on your server. PHP version 7.1 or higher is required to make sure Propertya Theme and all required plugins work correctly. <a href="https://www.php.net/supported-versions.php"> Click here to read more details </a>';
        }
        if ($server_max_execution_time >= $min_execution_time) {
            $ok_clr = 'ok-req';
            $e_icon = 'yes';
            $e_msg = '';
        }
        if ($server_max_execution_time < $min_execution_time) {
            $ok_clr = 'bad-req';
            $e_icon = 'no';
            $e_msg = 'Your server has limited max_execution_time. We recommend you to increase it to 360 (seconds) or more to make sure demo import will have enough time to load all demo content & images';
        }
        if ($server_upload_max_size >= $min_filesize) {
            $f_ok_clr = 'ok-req';
            $f_icon = 'yes';
            $f_msg = '';
        }
        if ($server_upload_max_size < $min_filesize) {
            $f_ok_clr = 'bad-req';
            $f_icon = 'no';
            $f_msg = 'Your server has limited upload_max_filesize. We recommend to increase it to 32M or more to make sure demo import will have enough time to load all demo content & images';
        }
        if ($server_memory_limit >= $min_memory_end) {
            $ok_mem = 'ok-req';
            $mem_icon = 'yes';
            $mem_msg = '';
        }
        if ($server_memory_limit < $min_memory_end && $server_memory_limit != 0) {
            $ok_mem = 'bad-req';
            $mem_icon = 'no';
            $mem_msg = 'Your server has very limited memory_limit. Please increase it to 256M or more to make sure DWT Listing Theme and all required plugins work correctly.';
        }

        $message = '<p>' . esc_html__('Best if used on new WordPress install & this theme requires PHP version 7.1+', 'propertya-framework') . '</p>';
        $message .= '<p>' . esc_html__('Images are for demo purpose only.', 'propertya-framework') . '</p>';
        $message .= '
        <h3>Server Requirements</h3>
        <div class="theme-server-detials">            
        <div class="requirnment-row ' . $active_clr . '">
            <div class="req-title"><strong>PHP version</strong> ' . $msg . ' | ' . esc_html(phpversion()) . ' | <span class="dashicons dashicons-' . $icon . '"></span></div>
        </div>
        <div class="requirnment-row ' . $ok_mem . '">
            <div class="req-title"><strong>Memory Limit</strong> ' . $mem_msg . ' | ' . esc_html($server_memory_limit) . ' | <span class="dashicons dashicons-' . $mem_icon . '"></span></div>
        </div>
        <div class="requirnment-row ' . $ok_clr . '">
            
            <div class="req-title"><strong>Max Execution Time</strong> ' . $e_msg . ' | ' . esc_html($server_max_execution_time) . ' | <span class="dashicons dashicons-' . $e_icon . '"></span></div>
        </div>
        <div class="requirnment-row ' . $f_ok_clr . '">
            
            <div class="req-title"><strong>Upload max filesize</strong> ' . $f_msg . ' | ' . esc_html($server_upload_max_size) . ' | <span class="dashicons dashicons-' . $f_icon . '"></span></div>

        </div>
    </div>< hr />';

        $message = $default_text . $message;
        return $message;
    }

    /* add_filter( 'wbc_importer_description', 'adforest_framework_importer_description_config', 10 ); */
    //}    
}

$adforest_demo_ocdi = new Adforest_Demo_OCDI();
add_action('adforest_wpml_terms_filters', 'adforest_wpml_terms_filters_callback');
if (!function_exists('adforest_wpml_terms_filters_callback')) {

    function adforest_wpml_terms_filters_callback() {
        global $sitepress;
        remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'), 10);
        remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
        remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
    }

}

if (!function_exists('adforest_register_custom_widgets')) {

    function adforest_register_custom_widgets($widget_name = '') {
        if ($widget_name != "") {
            register_widget($widget_name);
        }
    }

}

//check spam string

if (!function_exists('adforest_check_spam')) {

    function adforest_check_spam($str) {
        $res = false;
        $spam = preg_match("/<[^<]+>/", $str, $m);
        if ($spam > 0) {
            $res = true;
        }
        return $res;
    }

}

 
//ad og:image meta for single ad view page
add_action('wp_head', 'sb_add_image_meta');
if(!function_exists('sb_add_image_meta')){
function sb_add_image_meta(){
    if( is_single() ) {
        echo '<meta property="og:image" content="'. get_the_post_thumbnail_url(get_the_ID(),'full')   .'" />';
    }
}
}



/* Email job alert */
if (!function_exists('sb_send_email_job_alerts')) {

    function sb_send_email_job_alerts($pid, $user_email) {
       $adforest_theme = get_option('adforest_theme');
        if (isset($adforest_theme['sb_email_job_alerts_subj']) && $adforest_theme['sb_email_job_alerts_subj'] != '') {
            // Job  info                         
            $job_id = $pid;
            $job_title = get_the_title($pid);
            $job_link = get_the_permalink($pid);
            $subject = $adforest_theme['sb_email_job_alerts_subj'];
            $from = $adforest_theme['sb_email_job_alerts_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $msg_keywords = array('%site_name%', '%job_title%', '%job_link%');
            $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link);
            $body = str_replace($msg_keywords, $msg_replaces, $adforest_theme['sb_email_job_alerts_body']);
            wp_mail($user_email, $subject, $body, $headers);
        }
    }

}
    add_filter('cron_schedules', 'sb_send_job_alerts_email');
    function sb_send_job_alerts_email($schedules) {
        $schedules['every_seven_hours'] = array(
            'interval' => 25200,
            'display' => __('Every 7 Hours', 'adforest')
        );
        return $schedules;
    }

// Schedule an action if it's not already scheduled
    if (!wp_next_scheduled('sb_send_job_alerts_email')) {

        wp_schedule_event(time(), 'every_seven_hours', 'sb_send_job_alerts_email');
    }
// Hook into that action that'll fire every three minutes
    add_action('sb_send_job_alerts_email', 'sb_job_alerts_function');
    
    /* ============================== */
    /* Validating job alert taxonomies */
    /* =============================== */
    if (!function_exists('nokri_validating_alert_taxonomy')) {

        function nokri_validating_alert_taxonomy($cand_tax = '', $job_tax = '') {
            $validate = false;
            if (!empty($cand_tax) && !empty($job_tax) && is_array($cand_tax) && is_array($job_tax)) {
                $final_array = array_intersect($cand_tax, $job_tax);
                if (count($final_array) > 0) {
                    $validate = true;
                }
            }
            return $validate;
        }

    }
    
    
        /* ====================================== */
    /* Getting candidates alerts categories */
    /* ====================================== */
    if (!function_exists('nokri_get_alerts_category_subscription')) {

        function nokri_get_alerts_category_subscription($user_id = '', $alert_type = array()) {
            $job_alert = sb_get_ad_alerts($user_id);
            if (isset($job_alert) && !empty($job_alert)) {
                $terms = array();
                foreach ($job_alert as $key => $val) {
                    $value = (isset($val[$alert_type]) && $val[$alert_type] != '' ) ? $val[$alert_type] : '';
                    $terms[] = $value;
                }
            }
            return $terms;
        }

    }

    
     /* ============================== */
    /* Query sending job alerts */
    /* =============================== */
    if (!function_exists('sb_send_alerts_jobs')) {

        function sb_send_alerts_jobs($user_id = '', $cand_category = '') {

            $today = getdate();
            $current_id = $user_id;

            $query = array(
                'post_type' => 'ad_post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'date_query' => array(
                    array(
                        'year' => $today['year'],
                        'month' => $today['mon'],
                        'day' => $today['mday'],
                    ),
                ),
            );
            $loop = new WP_Query($query);
            $notification = '';
            $valid = false;
            while ($loop->have_posts()) {
                $loop->the_post();
                $job_id = get_the_ID();
                $valid = true;
                $post_author_id = get_post_field('post_author', $job_id);
                $company_name = get_the_author_meta('display_name', $post_author_id);
                /* Getting cand informations */
              //  $cand_category = nokri_get_alerts_category_subscription($current_id, 'alert_category');
               
                /* Getting Job informations */
                $job_category = wp_get_post_terms($job_id, 'ad_cats', array("fields" => "ids"));
           
                /* Validating taxonmies */
               
                if (!empty($cand_category)) {

                    $valid = nokri_validating_alert_taxonomy($cand_category, $job_category);
                }
            }
            wp_reset_postdata();
            if ($valid) {
                $notification = $job_id;
            }
            return $notification;
        }
    }


add_action('wp_footer', 'sb_job_alerts_function');
    
     function sb_job_alerts_function() {
        global $adforest_theme;    
        $is_alert   =       isset($adforest_theme['sb_ad_alerts'])   ? $adforest_theme['sb_ad_alerts']   :  false;
        if(!$is_alert){
        //    return ;
        }
            $args = array(
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => '_cand_alerts_en',
                        'value' => '',
                        'compare' => '!='
                    ),
                ),
            );              
            $user_query = new WP_User_Query($args);
            $candidates = $user_query->get_results();
            $required_user_html = $job_id = '';
            if (!empty($candidates)) {
                foreach ($candidates as $candidate) {
                    $user_id = $candidate->ID;
                    $job_alert = sb_get_ad_alerts($user_id);
                  //  $job_id = sb_send_alerts_jobs($user_id);
                    if (isset($job_alert) && !empty($job_alert)) {
                        foreach ($job_alert as $key => $val) {

                           $cat_arr  =   array();
                           $cat_arr[]  =  $val['alert_category'];

                          $job_id = sb_send_alerts_jobs($user_id,$cat_arr);
                            $alert_name = $val['alert_name'];
                            $alert_category = $val['alert_category'];
                            $alert_email = $val['alert_email'];
                            $alert_start = $val['alert_start'];
                            $today = date('Y/m/d');
                                $date_to_sent = $today;
                            if ($date_to_sent == $today && $job_id != '') {
                                $val['alert_start'] = $date_to_sent;
                                $my_alert = json_encode($val);
                               sb_send_email_job_alerts($job_id, $alert_email);
                                update_user_meta($user_id, $key, ($my_alert));
                            }
                        }
                    }
                }
            }   
    }
//   cronjob for sending emailto user after and before ad expiry
 $adforest_themee = get_option('adforest_theme');
 $ad_expiry_notification = isset($adforest_themee['ad_expiry_notification']) ? $adforest_themee['ad_expiry_notification'] : false;
if (isset($ad_expiry_notification ) && ($ad_expiry_notification )) {
    if (!wp_next_scheduled('adforest_ad_expiray_notification')) {
        wp_schedule_event(time(), 'daily', 'adforest_ad_expiray_notification');
    }
} 
add_action('adforest_ad_expiray_notification', 'adforest_ad_expiray_notification_callback');
if(!function_exists('adforest_ad_expiray_notification_callback')){
function adforest_ad_expiray_notification_callback(){ 
   global $adforest_theme ;
   $day_before_expiry     = isset($adforest_theme['ad_expire_notify_before'])   ?  $adforest_theme['ad_expire_notify_before']   : 1; 
      $args = array(
            'posts_per_page' => -1,
            'post_type' => 'ad_post',
            'post_status' => 'publish',
           );
        $results = new WP_Query($args);
         if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $aid = get_the_ID();
                $expiry_days = '-1';
        $package_ad_expiry_days = get_post_meta($aid, 'package_ad_expiry_days', true);

        if (isset($package_ad_expiry_days) && $package_ad_expiry_days != '')
        {
            $expiry_days = $package_ad_expiry_days;
        }
        else if (isset($adforest_theme['simple_ad_removal']) && $adforest_theme['simple_ad_removal'] != '')
        {
            $expiry_days = $adforest_theme['simple_ad_removal'];
        }
     if($expiry_days != '-1'){
            $now = time(); // or your date as well
            $simple_date = strtotime(get_the_date('Y-m-d'));
            $simple_days_diff = adforest_days_diff($now, $simple_date); 
            $remaining_days    =    $expiry_days     -  $simple_days_diff ;
            if((int)$day_before_expiry == (int)$remaining_days  ){
            adforest_ad_before_expiry_notification_callback($aid  , $day_before_expiry );
            }
            else if((int)$simple_days_diff   ==  (int)$expiry_days ){
                 adforest_ad_before_expiry_notification_callback($aid  , 0 ,'after' );
            }
         }        
          }
            wp_reset_postdata();
        }
}
}

add_action('wp_ajax_sb_set_imported_ad_images', 'sb_set_imported_ad_images_callback');

if(!function_exists('sb_set_imported_ad_images_callback')){
   function sb_set_imported_ad_images_callback(){
     
     $args = array(  
        'post_type' => 'ad_post',
        'post_status' => 'publish',
        'posts_per_page' => -1, 
        'orderby' => 'title', 
        'order' => 'ASC', 
    );

    $loop = new WP_Query( $args );  
    if($loop->have_posts()){       
    while ( $loop->have_posts() ) { 
           $loop->the_post(); 
           $ad_id  =  get_the_ID();
           $imgaes = get_post_meta($ad_id, '_sb_photo_arrangement_', true);

        if ($imgaes == ""  ||  $imgaes  ==  0) {
           $media  =  get_attached_media('image', $ad_id);
           $imges_ids  = "";
           $count = 0;
          if(!empty($media)){
             foreach($media  as $med){
                $attachment_id  = $med->ID;
                if($count == 0){
                    $imges_ids  .=  $attachment_id;  
                }
                else {
                     $imges_ids = $imges_ids . ',' . $attachment_id; 
                }
                 $count++;
           }
         }
          update_post_meta($ad_id, '_sb_photo_arrangement_', $imges_ids);
    }
}
    wp_reset_postdata(); 
  }
 }
}


add_action('wp_ajax_sb_set_all_ads_activated', 'sb_set_all_ads_activated_callback'); 
function sb_set_all_ads_activated_callback(){
if (!is_super_admin(get_current_user_id())) {
    wp_send_json_error(array('message' => 'You do not have permission.'));
}
 $args = array(
        'post_type' => 'ad_post',
        'posts_per_page' => -1, 
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_adforest_ad_status_',
                'value' => 'active',
                'compare' => '!=',
            ),
            array(
                'key' => '_adforest_ad_status_',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );
    $ads = new WP_Query( $args );
    if ( $ads->have_posts() ) {
        while ( $ads->have_posts() ) {
            $ads->the_post();
            $ad_id = get_the_ID();
            update_post_meta( $ad_id, '_adforest_ad_status_', 'active' );
             update_post_meta($ad_id, 'package_ad_expiry_days', $adforest_theme['make-ads-active-days']);
            wp_update_post(
                array(
                    'ID' => $ad_id, // ID of the post to update
                    'post_date' => current_time('mysql'),
                    'post_type' => 'ad_post',
                    'post_status' => 'publish',
                    'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                )
            );
        }
        wp_reset_postdata();
        $total_posts = $ads->found_posts;
         wp_send_json_success(array('message' => $total_posts . " ads have been activated"));
    }
    wp_send_json_success(array('message' => "you have no inactive ad"));   
}


?>

                                  