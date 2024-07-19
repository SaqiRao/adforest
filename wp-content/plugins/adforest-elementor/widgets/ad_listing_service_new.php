<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ad_listing_service_new extends Widget_Base {

    public function get_name() {
        return 'adforest_ads_listing_grid_new';
    }

    public function get_title() {
        return __('ADs Listing 2 with sidebar - Service','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_bg',
                [
                    'label' => __('Background Color','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select background color", 'adforest-elementor'),
                    'options' => [
                        '' => __('White','adforest-elementor'),
                        'gray' => __('Gray','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'header_style',
                [
                    'label' => __('Header Style','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'description' => __('Choose Header Style','adforest-elementor'),
                    'options' => [
                        '' => __('No Header','adforest-elementor'),
                        'classic' => __('Classic','adforest-elementor'),
                        'regular' => __('Regular','adforest-elementor')
                    ],
                ]
        );
        // $this->add_control(
        //         'section_title',
        //         [
        //             'label' => __('Section Title','adforest-elementor'),
        //             'type' => \Elementor\Controls_Manager::TEXT,
        //             "description" => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
        //             'conditions' => [
        //                 'terms' => [
        //                     [
        //                         'name' => 'header_style',
        //                         'operator' => 'in',
        //                         'value' => [
        //                             'classic',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ]
        // );
        // $this->add_control(
        //         'section_description',
        //         [
        //             'label' => __('Section Description','adforest-elementor'),
        //             'type' => \Elementor\Controls_Manager::TEXTAREA,
        //             'conditions' => [
        //                 'terms' => [
        //                     [
        //                         'name' => 'header_style',
        //                         'operator' => 'in',
        //                         'value' => [
        //                             'classic',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ]
        // );
        // $this->add_control(
        //         'section_title_regular',
        //         [
        //             'label' => __('Section Title','adforest-elementor'),
        //             'type' => \Elementor\Controls_Manager::TEXT,
        //             'conditions' => [
        //                 'terms' => [
        //                     [
        //                         'name' => 'header_style',
        //                         'operator' => 'in',
        //                         'value' => [
        //                             'regular',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ]
        // );
        
        $this->add_control(
                'button_text',
                [
                    'label' => __('Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,            
                ]
        );
        $this->add_control(
                'more_ads',
                [
                    'label' => __('More ads Button','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'ads_settings', [
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'layout_type',
                [
                    'label' => __('Layout Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select Layout Type", 'adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_styles', array()),
                ]
        );
        $this->add_control(
                'ad_type',
                [
                    'label' => __('Ads Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select Ads Type", 'adforest-elementor'),
                    'options' => [
                        'feature' => __('Featured Ads','adforest-elementor'),
                        'regular' => __('Simple Ads','adforest-elementor'),
                        'both' => __('Both','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'ad_order',
                [
                    'label' => __('Order By','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select Ads order", 'adforest-elementor'),
                    'options' => [
                        'asc' => __('Oldest','adforest-elementor'),
                        'desc' => __('Latest','adforest-elementor'),
                        'rand' => __('Random','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('Number of Ads for each category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 500,
                    'step' => 1,
                    'default' => 1,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'categories_section3', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
       

        $this->add_control(
                'cat',
                [
                    'label' => __('Select Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2, 
                    'multiple'=> true,
                    "description" => __("Category", 'adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();

        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        $adforest_render_params['button_text'] = isset($package_settings_fields['button_text']) ? $package_settings_fields['button_text'] : '';     
        $adforest_render_params['more_ads'] = isset($package_settings_fields['more_ads']) ? $package_settings_fields['more_ads'] : '';
        $adforest_render_params['layout_type'] = isset($package_settings_fields['layout_type']) ? $package_settings_fields['layout_type'] : '';
        $adforest_render_params['ad_type'] = isset($package_settings_fields['ad_type']) ? $package_settings_fields['ad_type'] : '';
        $adforest_render_params['ad_order'] = isset($package_settings_fields['ad_order']) ? $package_settings_fields['ad_order'] : '';
        $adforest_render_params['no_of_ads'] = isset($package_settings_fields['no_of_ads']) ? $package_settings_fields['no_of_ads'] : '';
        $adforest_render_params['cats'] = isset($package_settings_fields['cat']) ? $package_settings_fields['cat'] : '';

        echo adforest_ads_listing_grid_callback_new($adforest_render_params);
    }

}

if (!function_exists('adforest_ads_listing_grid_callback_new')) {

    function adforest_ads_listing_grid_callback_new($atts, $content = '') {
        global $adforest_theme;
        $no_title = 'yes';

        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'ad_order' => '',
            'no_of_ads' => '',
            'more_ads' => '',
            'element_title' => '',
            'layout_type' => 'grid_15',
                        ), $atts));
        extract($atts);
        
        $layout_type = isset($layout_type) && $layout_type != '' ? $layout_type : 'grid_8';
        
        wp_enqueue_script('carousel');
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";


        if (isset($adforest_elementor) && $adforest_elementor) {
            
            $rows = ($atts['cats']);
        } else {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $rows = apply_filters('adforest_validate_term_type', $rows);
        }



        $cats = array();
        if (isset($rows) && !empty($rows) && is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {

                if (isset($adforest_elementor) && $adforest_elementor) {
                    $cat_idd = $row;
                } else {
                    $cat_idd = $row['cat'];
                }

                if (isset($cat_idd)) {
                    if ($cat_idd != 'all') {
                        if (!in_array($cat_idd, $cats)) {
                            $cats[] = $cat_idd;
                        }
                    }
                }
            }
        }

        $category = '';
        if (isset($cats) && !empty($cats) && count($cats) > 0) {
            $category = array(
                'taxonomy' => 'ad_cats',
                'field' => 'term_id',
                'terms' => $cats,
            );
        }

        $ads_html = '';
        $ads = new ads();
        $ordering = 'DESC';
        $order_by = 'date';
        if ($ad_order == 'asc') {
            $ordering = 'ASC';
        } else if ($ad_order == 'desc') {
            $ordering = 'DESC';
        } else if ($ad_order == 'rand') {
            $order_by = 'rand';
        }
        $countries_location = '';
        $countries_location = apply_filters('adforest_site_location_ads', $countries_location, 'search');
        $args = array(
            'post_type' => 'ad_post',
            'post_status' => 'publish',
            'posts_per_page' => $no_of_ads,
            'meta_query' => array(
                array(
                    'key' => '_adforest_ad_status_',
                    'value' => 'active',
                    'compare' => '=',
                ),
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );

        if ($category != '') {
            $args['tax_query'][] = $category;
        }
        if ($countries_location != '') {
            $args['tax_query'][] = $countries_location;
        }

        if ($ad_type == 'feature') {
            $args['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            
        } else {
            $args['meta_query'][] = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }

        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $function = "adforest_search_layout_$layout_type";
                $ads_html .= $ads->$function(get_the_ID(), 4);
            }
        }
        wp_reset_postdata();
        $html = '';

        $btn_html = '';
        if (isset($adforest_elementor) && $adforest_elementor) {
            $btn_args = array(
                'btn_key' => $more_ads,
                'adforest_elementor' => $adforest_elementor,
                'btn_class' => 'btn btn-theme',
                'iconBefore' => '',
                'iconAfter' => '',
                'titleText' => $button_text,
            );

            $btn_html = apply_filters('adforest_elementor_url_field', $btn_html, $btn_args);
        } else {
            $btn_html = adforest_ThemeBtn($more_ads, 'btn btn-theme');
        }
        
        ob_start(); 
        dynamic_sidebar('adforest_home_sidebar');
        $sidebar_content = ob_get_clean();
        $html .= '<section class="ad-section-divider-1"></section>
        <section class="ad-section-divider-2"></section>
        <section class="ad-category-listing-wrapper ' . $bg_color . ' no-extra">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 col-xl-3 col-xxl-2">
                 '. $sidebar_content.'
               </div>
                 <div class="col-12 col-md-8 col-lg-9 col-xl-9 col-xxl-10">
                 <div class="row">
                ' . ($ads_html) . '
                  </div>   
                </div>
            </div>
            <div class="srvs-featured-ads-2">
               ' . $btn_html . '
            </div>
        </div>
    </section>';

    ob_get_clean();

        return $html;
    }

}
