<?php
add_action('show_user_profile', 'sb_show_extra_profile_fields');
add_action('edit_user_profile', 'sb_show_extra_profile_fields');
if (!function_exists('adforest_check_if_package_expired')) {

    function adforest_check_if_package_expired($user_id = 0) {
        /* $simple_ads	=	get_user_meta($user_id, '_sb_simple_ads', true); */
        $expiry = get_user_meta($user_id, '_sb_expire_ads', true);
        $is_expired = false;
        if ($expiry != '-1') {
            if ($expiry < date('Y-m-d')) {
                $is_expired = true;
            }
        }
        return $is_expired;
    }

}
if (!function_exists('sb_show_extra_profile_fields')) {

    function sb_show_extra_profile_fields($user) {
        ?>
        <h3><?php echo __('Adforest User Profile', 'redux-framework'); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="_sb_pkg_type"><?php echo __('Package Type', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="_sb_pkg_type" id="_sb_pkg_type" value="<?php echo esc_attr(get_the_author_meta('_sb_pkg_type', $user->ID)); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="_sb_simple_ads"><?php echo __('Free Ads Remaining', 'redux-framework'); ?></label></th>
                <?php
                $simple_ads = get_the_author_meta('_sb_simple_ads', $user->ID);
                if ($simple_ads == "") {
                    $simple_ads = 0;
                }
                ?>
                <td>
                    <input type="text" name="_sb_simple_ads" id="_sb_simple_ads" value="<?php echo esc_attr($simple_ads); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_simple_ads"><?php echo __('Free Ads days', 'redux-framework'); ?></label></th>
                <?php
                $simple_ads_days = get_the_author_meta('package_ad_expiry_days', $user->ID);
                if ($simple_ads_days == "") {
                    $simple_ads_days = 0;
                }
                ?>
                <td>
                    <input type="text" name="package_ad_expiry_days" id="package_ad_expiry_days" value="<?php echo esc_attr($simple_ads_days); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_featured_ads"><?php echo __('Featured Ads Remaining', 'redux-framework'); ?></label></th>
                <?php
                $featured_ads = get_the_author_meta('_sb_featured_ads', $user->ID);
                if ($featured_ads == "") {
                    $featured_ads = 0;
                }
                ?>
                <td>
                    <input type="text" name="_sb_featured_ads" id="_sb_featured_ads" value="<?php echo esc_attr($featured_ads); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="package_adFeatured_expiry_days"><?php echo __('Featured Ads days', 'redux-framework'); ?></label></th>
                <?php
                $featured_ads_days = get_the_author_meta('package_adFeatured_expiry_days', $user->ID);
                if ($featured_ads_days == "") {
                    $featured_ads_days = 0;
                }
                ?>
                <td>
                    <input type="text" name="package_adFeatured_expiry_days" id="package_adFeatured_expiry_days" value="<?php echo esc_attr($featured_ads_days); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_bump_ads"><?php echo __('Bump up Ads Remaining', 'redux-framework'); ?></label></th>
                <?php
                $bump_ads = get_the_author_meta('_sb_bump_ads', $user->ID);
                if ($bump_ads == "") {
                    $bump_ads = 0;
                }
                ?>
                <td>
                    <input type="text" name="_sb_bump_ads" id="_sb_bump_ads" value="<?php echo esc_attr($bump_ads); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?></p>
                </td>
            </tr>
            <!-- new features start -->
            <tr>
                <th><label for="_sb_num_of_images"><?php echo __('Allowed Images Remaining', 'redux-framework'); ?></label></th>
                <?php
                $_sb_num_of_images = get_the_author_meta('_sb_num_of_images', $user->ID);
                if ($_sb_num_of_images == "") {
                    $_sb_num_of_images = 0;
                }
                ?>
                <td>
                    <input type="text" name="_sb_num_of_images" id="_sb_num_of_images" value="<?php echo esc_attr($_sb_num_of_images); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_video_links"><?php echo __('Allowed Video links', 'redux-framework'); ?></label></th>
                <td>
                    <select name="_sb_video_links" id="_sb_video_links">
                        <option value=""><?php echo __('Select an option', 'redux-framework'); ?></option>
                        <option value="yes" <?php if (get_the_author_meta('_sb_video_links', $user->ID) == "yes") echo "selected"; ?>><?php echo __('Yes', 'redux-framework'); ?></option>
                        <option value="no" <?php if (get_the_author_meta('_sb_video_links', $user->ID) == "no") echo "selected"; ?>><?php echo __('No', 'redux-framework'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_allow_tags"><?php echo __('Allowed Tags', 'redux-framework'); ?></label></th>
                <td>
                    <select name="_sb_allow_tags" id="_sb_allow_tags">
                        <option value=""><?php echo __('Select an option', 'redux-framework'); ?></option>
                        <option value="yes" <?php if (get_the_author_meta('_sb_allow_tags', $user->ID) == "yes") echo "selected"; ?>><?php echo __('Yes', 'redux-framework'); ?></option>
                        <option value="no" <?php if (get_the_author_meta('_sb_allow_tags', $user->ID) == "no") echo "selected"; ?>><?php echo __('No', 'redux-framework'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_allow_bidding"><?php echo __('Allowed Bidding', 'redux-framework'); ?></label></th>
                <?php
                $_sb_allow_bidding = get_the_author_meta('_sb_allow_bidding', $user->ID);
                if ($_sb_allow_bidding == "") {
                    $_sb_allow_bidding = 0;
                }
                ?>
                <td>
                    <input type="text" name="_sb_allow_bidding" id="_sb_allow_bidding" value="<?php echo esc_attr($_sb_allow_bidding); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_paid_biddings"><?php echo __('Paid biddings', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="_sb_paid_biddings" id="_sb_paid_biddings" value="<?php echo esc_attr(get_the_author_meta('_sb_paid_biddings', $user->ID)); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means never expired', 'redux-framework'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_expire_ads"><?php echo __('Expiry Date', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="_sb_expire_ads" id="_sb_expire_ads" value="<?php echo esc_attr(get_the_author_meta('_sb_expire_ads', $user->ID)); ?>" class="regular-text" /><br />
                    <p><?php echo __('-1 means never expired or date format will be yyyy-mm-dd.', 'redux-framework'); ?>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_badge_type"><?php echo __('Badge Color', 'redux-framework'); ?></label></th>
                <td>
                    <select name="_sb_badge_type" id="_sb_badge_type">
                        <option value=""><?php echo __('Select Type', 'redux-framework'); ?></option>
                        <option value="label-success" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-success") echo "selected"; ?>><?php echo __('Green', 'redux-framework'); ?></option>
                        <option value="label-warning" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-warning") echo "selected"; ?>><?php echo __('Orange', 'redux-framework'); ?></option>
                        <option value="label-info" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-info") echo "selected"; ?>><?php echo __('Blue', 'redux-framework'); ?></option>
                        <option value="label-danger" <?php if (get_the_author_meta('_sb_badge_type', $user->ID) == "label-danger") echo "selected"; ?>><?php echo __('Red', 'redux-framework'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_badge_text"><?php echo __('Badge Text', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="_sb_badge_text" id="_sb_badge_text" value="<?php echo esc_attr(get_the_author_meta('_sb_badge_text', $user->ID)); ?>" class="regular-text" />
                </td>
            </tr>

        <?php if (class_exists('SbPro')) { ?>
                <tr>
                    <th><lable><?php echo __('Number of events', 'redux-framework'); ?></lable>
                <td>
                    <input type="text" name="number_of_events"  placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework'); ?>" size="30" value="<?php echo esc_attr(get_user_meta($user->ID, "number_of_events", true)); ?>" id="number_of_events" spellcheck="true" autocomplete="off">
                   <p><?php echo __('-1 means unlimited.', 'redux-framework'); ?></p>  
                </td>
               </tr>         
            <?php }
        ?>
            <tr>
                <th><label for="_sb_ph_num_"><?php echo __('Phone Number', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="_sb_ph_num_" id="_sb_ph_num_" value="<?php echo esc_attr(get_the_author_meta('_sb_contact', $user->ID)); ?>" class="regular-text" />
                    <small><?php echo __('+CountrycodeMobilenumber', 'redux-framework'); ?></small>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_ph_verified_"><?php echo __('Phone no. verified', 'redux-framework'); ?></label></th>
                <?php
                $ph_is_verified_ = get_the_author_meta('_sb_is_ph_verified', $user->ID);
                if ($ph_is_verified_ == "") {
                    $ph_is_verified_ = 0;
                }
                ?>
                <td>
                    <select name="_sb_ph_verified_" id="_sb_ph_verified_">
                        <option value=""><?php echo __('Select option', 'redux-framework'); ?></option>
                        <option value="0" <?php if ($ph_is_verified_ == '0') echo "selected"; ?>><?php echo __('Not verified', 'redux-framework'); ?></option>
                        <option value="1" <?php if ($ph_is_verified_ == '1') echo "selected"; ?>><?php echo __('Verified', 'redux-framework'); ?></option>
                    </select>
                </td>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_user_type_"><?php echo __('User Type', 'redux-framework'); ?></label></th>
        <?php
        $user_type = get_user_meta($user->ID, '_sb_user_type', true);
        ?>
                <td>
                    <select name="_sb_user_type_" id="_sb_user_type_">
                        <option value=""><?php echo __('Select option', 'redux-framework'); ?></option>
                        <option value="Indiviual" <?php if ($user_type == 'Indiviual') echo "selected"; ?>><?php echo __('Individual', 'redux-framework'); ?></option>
                        <option value="Dealer" <?php if ($user_type == 'Dealer') echo "selected"; ?>><?php echo __('Dealer', 'redux-framework'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_user_location_"><?php echo __('User Location', 'redux-framework'); ?></label></th>
        <?php
        $user_location_ = get_the_author_meta('_sb_address', $user->ID);
        ?>
                <td>
                    <input type="text" name="_sb_user_location_" id="_sb_user_location_" value="<?php echo esc_attr($user_location_); ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="_sb_user_intro_"><?php echo __('User Introduction', 'redux-framework'); ?></label></th>
        <?php
        $_sb_user_intro_ = get_the_author_meta('_sb_user_intro', $user->ID);
        ?>
                <td>
                    <textarea rows="5" cols="30" name="_sb_user_intro_" id="_sb_user_intro_"><?php echo esc_attr($_sb_user_intro_); ?></textarea>
                </td>
            </tr>
            <?php
            if (function_exists('adforest_social_profiles')) {
                $profiles = adforest_social_profiles();
                foreach ($profiles as $key => $value) {
                    $each_val = get_user_meta($user->ID, '_sb_profile_' . $key, true);
                    $each_val = isset($each_val) && $each_val != '' ? $each_val : '';
                    ?>
                    <tr>
                        <th><label for="<?php echo '_sb_profile_' . $key; ?>"><?php echo ($value); ?></label></th>
                        <td>
                            <input type="text" name="<?php echo '_sb_profile_' . $key; ?>" id="<?php echo '_sb_profile_' . $key; ?>" value="<?php echo ($each_val); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
                <th><label for="_sb_trusted_user"><?php echo __('Trusted User', 'redux-framework'); ?></label></th>
                <?php
                $_sb_trusted_user = get_the_author_meta('_sb_trusted_user', $user->ID);
                $sb_trusted_user_checked = ($_sb_trusted_user == 1 ) ? 'checked="checked"' : '';
                ?>
                <td>
                    <input type="checkbox" name="_sb_trusted_user" class="sb_trusted_user" <?php echo $sb_trusted_user_checked; ?>  value="1">
                    <br />
                    <p><?php esc_html_e("By making the user trusted. User's ads will be approved even (Admin Approval) is turn on in Theme Options. ", "redux-framework") ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_block_individual_messaging"><?php echo __('Block Messaging?', 'redux-framework'); ?></label></th>
                <?php
                $sb_block_individual_messaging = get_the_author_meta('_sb_block_individual_messaging', $user->ID);
                $sb_block_individual_messaging_checked = ($sb_block_individual_messaging == 1 ) ? 'checked="checked"' : '';
                ?>
                <td>
                    <input type="checkbox" name="_sb_block_individual_messaging" class="_sb_block_individual_messaging" <?php echo $sb_block_individual_messaging_checked; ?> value="1">
                    <br />
                    <p><?php esc_html_e("Block this user to send messging against ads", "redux-framework") ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="_sb_block_individual_messaging"><?php echo __('Send User email?', 'redux-framework'); ?></label></th>
        <?php ?>
                <td>
                    <button  class="button-primary" id="send_user_confirmation_email" data-user_id  = "<?php echo esc_attr($user->ID) ?>"> <?php echo esc_html__('Send mail', 'redux-framework'); ?></button>
                    <br />
                    <p><?php esc_html_e("Click on button to send email to user to let him know about his account verification", "redux-framework") ?></p>
                </td>
            </tr>
        </table>
        <div>
            <h2><?php echo __('User Rating', 'redux-framework'); ?></h2>
            <br />
            <table class="wp-list-table widefat fixed striped users">
                <tr>
                    <th width="15%"><strong><?php echo __('Username who rated', 'redux-framework'); ?></strong></th>
                    <th width="10%"><strong><?php echo __('Rating', 'redux-framework'); ?></strong></th>
                    <th width="65%"><strong><?php echo __('Comments', 'redux-framework'); ?></strong></th>
                    <th width="10%"><strong><?php echo __('Action', 'redux-framework'); ?></strong></th>
                </tr>
                <?php
                $author_id = $user->ID;
                $ratings = adforest_get_all_ratings($user->ID);
                if (count($ratings) > 0) {
                    foreach ($ratings as $rating) {
                        $data = explode('_separator_', $rating->meta_value);
                        $rated = $data[0];
                        $comments = $data[1];
                        $date = $data[2];
                        $reply = '';
                        $reply_date = '';
                        if (isset($data[3])) {
                            $reply = $data[3];
                        }
                        if (isset($data[4])) {
                            $reply_date = $data[4];
                        }
                        $_arr = explode('_user_', $rating->meta_key);
                        $rator = $_arr[1];
                        $user = get_user_by('ID', $rator);
                        ?>
                        <tr>
                            <td><?php echo esc_html($user->display_name); ?></td>
                            <td><?php echo esc_html($rated) . ' ' . __('Star', 'redux-framework'); ?></td>
                            <td><?php echo esc_html($comments); ?></td>
                            <td><a href="javascript:void(0);" class="get_user_meta_id" data-mid="<?php echo esc_attr($rating->umeta_id); ?>"><?php echo __('Delete', 'redux-framework'); ?></a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td colspan="4"><?php echo __('There is no rating of this user yet.', 'redux-framework'); ?></td></tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <br />
        <?php
    }

}

add_action('personal_options_update', 'sb_save_extra_profile_fields');
add_action('edit_user_profile_update', 'sb_save_extra_profile_fields');

if (!function_exists('sb_save_extra_profile_fields')) {

    function sb_save_extra_profile_fields($user_id) {
        if (!current_user_can('edit_user', $user_id))
            return false;

        /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */


        update_user_meta(absint($user_id), 'package_ad_expiry_days', wp_kses_post($_POST['package_ad_expiry_days']));
        update_user_meta(absint($user_id), 'package_adFeatured_expiry_days', wp_kses_post($_POST['package_adFeatured_expiry_days']));

        update_user_meta(absint($user_id), '_sb_pkg_type', wp_kses_post($_POST['_sb_pkg_type']));
        update_user_meta(absint($user_id), '_sb_simple_ads', wp_kses_post($_POST['_sb_simple_ads']));
        update_user_meta(absint($user_id), '_sb_featured_ads', wp_kses_post($_POST['_sb_featured_ads']));
        update_user_meta(absint($user_id), '_sb_bump_ads', wp_kses_post($_POST['_sb_bump_ads']));
        update_user_meta(absint($user_id), '_sb_expire_ads', wp_kses_post($_POST['_sb_expire_ads']));
        update_user_meta(absint($user_id), '_sb_badge_type', wp_kses_post($_POST['_sb_badge_type']));
        update_user_meta(absint($user_id), '_sb_badge_text', wp_kses_post($_POST['_sb_badge_text']));
        update_user_meta(absint($user_id), '_sb_is_ph_verified', wp_kses_post($_POST['_sb_ph_verified_']));
        update_user_meta(absint($user_id), '_sb_contact', wp_kses_post($_POST['_sb_ph_num_']));
        update_user_meta(absint($user_id), '_sb_user_type', wp_kses_post($_POST['_sb_user_type_']));
        update_user_meta(absint($user_id), '_sb_address', wp_kses_post($_POST['_sb_user_location_']));
        update_user_meta(absint($user_id), '_sb_user_intro', wp_kses_post($_POST['_sb_user_intro_']));
        update_user_meta(absint($user_id), '_sb_video_links', wp_kses_post($_POST['_sb_video_links']));
        update_user_meta(absint($user_id), '_sb_allow_tags', wp_kses_post($_POST['_sb_allow_tags']));
        update_user_meta(absint($user_id), '_sb_allow_bidding', wp_kses_post($_POST['_sb_allow_bidding']));

        update_user_meta(absint($user_id), '_sb_paid_biddings', wp_kses_post($_POST['_sb_paid_biddings']));

        update_user_meta(absint($user_id), '_sb_num_of_images', wp_kses_post($_POST['_sb_num_of_images']));
        update_user_meta(absint($user_id), '_sb_trusted_user', wp_kses_post($_POST['_sb_trusted_user']));
        
        
        if(isset($_POST['number_of_events']) && $_POST['number_of_events'] != ""){
            update_user_meta(absint($user_id) ,  'number_of_events',$_POST['number_of_events']);
        }

        if (isset($_POST['_sb_block_individual_messaging']) && $_POST['_sb_block_individual_messaging'] == 1) {
            update_user_meta(absint($user_id), '_sb_block_individual_messaging', wp_kses_post($_POST['_sb_block_individual_messaging']));
        } else {
            update_user_meta(absint($user_id), '_sb_block_individual_messaging', 0);
        }
        if (function_exists('adforest_social_profiles')) {
            $profiles = adforest_social_profiles();
            foreach ($profiles as $key => $value) {
                update_user_meta($user_id, '_sb_profile_' . $key, sanitize_textarea_field($_POST['_sb_profile_' . $key]));
            }
        }
    }

}

/* Adding Custom coulumn in user dashboard */
if (!function_exists('new_modify_user_table')) {

    function new_modify_user_table($column) {
        $role = $column['role'];
        $posts = $column['posts'];
        unset($column['name']);
        unset($column['role']);
        unset($column['posts']);
        $column['display_name'] = __('Display Name', 'redux-framework');
        $column['_sb_user_type'] = __('User Type', 'redux-framework');
        $column['_sb_pkg_type'] = __('Package', 'redux-framework');
        $column['role'] = $role;

        $column['posts'] = $posts;
        $column['classified_ads'] = __('Classified ads', 'redux-framework');
        return $column;
    }

}
add_filter('manage_users_columns', 'new_modify_user_table');
if (!function_exists('new_modify_user_table_row')) {

    function new_modify_user_table_row($val, $column_name, $user_id) {
        $is_expired = adforest_check_if_package_expired($user_id);
        if ($is_expired) {
            $is_expired_txt = get_the_author_meta('_sb_pkg_type', $user_id);
            if ($is_expired_txt) {
                $is_expired_txt .= '<br />(' . __("Expired", "redux-framework") . ')';
            }
        } else {
            $is_expired_txt = get_the_author_meta('_sb_pkg_type', $user_id);
        }

        // $args = array(
        //     'author' => $user_id,
        //     'post_type' => 'ad_post',
        //     'post_status' => 'publish',
        // );
        // $author_posts = new WP_Query($args);        
        // $ads_count    =   $author_posts->found_posts;
        // wp_reset_postdata();

        $ads_count = count_user_posts($user_id, 'ad_post');
        $userdata = get_userdata($user_id);

        $display_name = isset($userdata->display_name) ? $userdata->display_name : "";

        $display_name_meta = get_the_author_meta('display_name', $user_id);

        $display_name = $display_name_meta != "" ? $display_name_meta : $display_name;

        switch ($column_name) {
            case '_sb_user_type' :
                if (get_the_author_meta('_sb_user_type', $user_id) == 'Indiviual')
                    return __('Individual', 'redux-framework');
                if (get_the_author_meta('_sb_user_type', $user_id) == 'Dealer')
                    return __('Dealer', 'redux-framework');
                return get_the_author_meta('_sb_user_type', $user_id);
                break;
            case 'display_name' :
                return $display_name;
                break;
            case '_sb_pkg_type' :
                return $is_expired_txt;
                break;
            case 'classified_ads' :
                return $ads_count;
                break;

            default:
        }
        return $val;
    }

}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 99, 3);
if (!function_exists('adforest_get_all_ratings')) {

    function adforest_get_all_ratings($user_id) {
        global $wpdb;
        $ratings = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE user_id = '$user_id' AND  meta_key like  '_user_%' ORDER BY umeta_id DESC", OBJECT);
        return $ratings;
    }

}
/* Add custom column using 'manage_users_columns' filter */
/* <?php esc_html_e("By making the user trusted. User's ads will be approved even (Admin Approval) is turn on in Theme Options. ", "redux-framework")?> */
if (!function_exists('adforest_trusted_users_column')) {

    function adforest_trusted_users_column($columns) {
        global $adforest_theme;
        $sb_trusted_user = isset($adforest_theme['sb_trusted_user']) && $adforest_theme['sb_trusted_user'] ? TRUE : FALSE;
        if ($sb_trusted_user) {
            return array_merge($columns, array('_sb_trusted_user' => __('Trusted?', 'redux-framework')));
        } else {
            return $columns;
        }
    }

}

/* Add the content from usermeta's table by using 'manage_users_custom_column' hook */
if (!function_exists('adforest_trusted_users_column_value')) {

    function adforest_trusted_users_column_value($val, $column_name, $user_id) {
        global $adforest_theme;
        $sb_trusted_user = isset($adforest_theme['sb_trusted_user']) && $adforest_theme['sb_trusted_user'] ? TRUE : FALSE;
        if ($sb_trusted_user) {
            if ('_sb_trusted_user' == $column_name) {
                //Custom value
                $val = get_user_meta($user_id, '_sb_trusted_user', true);
                $is_checked = ( isset($val) && $val == 1 ) ? 'checked="checked"' : '';
                $is_value = ( isset($val) && $val == 1 ) ? 1 : 0;
                $confirmationtext = __("Are you sure you want to do this?", "redux-framework");
                /* //$confirmation_attr = "onclick='return confirm("'$confirmationtext'");'";
                  $confirmation_attr = "return confirm('$confirmationtext');";//onclick="'.$confirmation_attr .'" */
                $val = '<input type="checkbox" name="_sb_trusted_user" class="sb_trusted_user" ' . $is_checked . ' data-user-id="' . $user_id . '"  >';
            }
            return $val;
        }
    }

}
$sb_trusted_user = TRUE;
//if (class_exists('Redux')) {
//    $sb_trusted_user = Redux::getOption('adforest_theme', 'sb_trusted_user');
//    $sb_trusted_user = isset($sb_trusted_user) && $sb_trusted_user ? TRUE : FALSE;
//}

if ($sb_trusted_user) {
    // Hook into filter
    add_filter('manage_users_columns', 'adforest_trusted_users_column');
    add_action('manage_users_custom_column', 'adforest_trusted_users_column_value', 10, 3);
}

/* Ajax handler for add to cart */
add_action('wp_ajax_sb_add_trusted_user', 'adforest_sb_add_trusted_user_func');
if (!function_exists('adforest_sb_add_trusted_user_func')) {

    function adforest_sb_add_trusted_user_func() {
        if (isset($_POST['user_id']) && $_POST['user_id'] != "") {
            update_user_meta($_POST['user_id'], '_sb_trusted_user', $_POST['checkbox_value']);
        }
    }

}

/* Javascript functions to set/update checkbox */
add_action('admin_footer', 'quick_edit_javascript');
if (!function_exists('quick_edit_javascript')) {

    function quick_edit_javascript() {
        global $current_screen;
        $confirmationtext = __("Are you sure you want to do this?", "redux-framework");
        ?>
        <script type="text/javascript">
            jQuery(document).on('click', '.sb_trusted_user', function () {
                if (confirm('<?php echo esc_html($confirmationtext); ?>')) {
                    var user_id = jQuery(this).data('user-id');
                    var checkbox_value = 0;
                    if (jQuery(this).is(":checked")) {
                        var checkbox_value = 1;
                    }
                    if (user_id != "") {
                        var admin_ajax = jQuery("#sb-admin-ajax").val();
                        jQuery.post(admin_ajax, {action: 'sb_add_trusted_user', user_id: user_id, checkbox_value: checkbox_value}).done(function (response) { /* -- */
                        });
                    }
                } else
                {
                    if (jQuery(this).is(":checked")) {
                        jQuery(this).prop("checked", false);
                    } else {
                        jQuery(this).prop("checked", true);
                    }
                }
            });
        </script>
        <?php
    }

}