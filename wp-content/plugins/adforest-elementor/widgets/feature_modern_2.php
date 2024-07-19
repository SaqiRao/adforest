<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_feature_modern_2 extends Widget_Base {

    public function get_name() {
        return 'feature_modern_2_type_short_base';
    }

    public function get_title() {
        return __('Feature - Modern 2', 'adforest-elementor');
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
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );
            $this->add_control(
                'section_bg', array(
            'label' => __('Background','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White','adforest-elementor'),
                'bg-gray' => __('Gray','adforest-elementor'),              
            ),
                )
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'section_desc', [
            'label' => __('Ads Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'ad_settings', [
            'label' => esc_html__('Ads Settings', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'ad_type', [
            'label' => __('Ads Type', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'description' => __('Select Ads Type', 'adforest-elementor'),
            'options' => [
                'feature' => __('Featured Ads', 'adforest-elementor'),
                'regular' => __('Simple Ads', 'adforest-elementor'),
                'both' => __('Both', 'adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'ad_order', [
            'label' => __('Order By', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'description' => __('Select Ads order', 'adforest-elementor'),
            'options' => [
                'asc' => __('Oldest', 'adforest-elementor'),
                'desc' => __('Latest', 'adforest-elementor'),
                'rand' => __('Random', 'adforest-elementor'),
            ],
                ]
        );

        $this->add_control(
                'no_of_ads', [
            'label' => __('Number fo Ads to display', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
                ]
        );
        $this->add_control(
                'link_title', [
            'label' => __('Link Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Link Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'view_all', [
            'label' => __('View all button link', 'adforest-elementor'),
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
                'ad_category', [
            'label' => esc_html__('Categories for ads', 'adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'cats', [
            'label' => __('Select Category ( Selective )', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes', 1),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $atts = $this->get_settings_for_display();

        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = TRUE;
        $adforest_render_params['cat_link_page'] = isset($atts['cat_link_page']) ? $atts['cat_link_page'] : '';
        $section_title = isset($atts['section_title']) ? $atts['section_title'] : '';
        $section_desc = isset($atts['section_desc']) ? $atts['section_desc'] : '';
        $ad_type = isset($atts['ad_type']) ? $atts['ad_type'] : '';
        $ad_order = isset($atts['ad_order']) ? $atts['ad_order'] : '';
        $no_of_ads = isset($atts['no_of_ads']) ? $atts['no_of_ads'] : '';
        $view_all = isset($atts['view_all']) ? $atts['view_all'] : '';
        $link_title = isset($atts['link_title']) ? $atts['link_title'] : '';
        $cats_arr = isset($atts['cats']) ? $atts['cats'] : array();
        $section_bg   =  isset($atts['section_bg']) ? $atts['section_bg'] : "";
        
        
        

        $cats_array = array();
        if (count((array) $cats_arr) > 0) {
            foreach ($cats_arr as $cta_idd) {
                if (isset($cta_idd)) {
                    if ($cta_idd != 'all') {
                        $cats_array[] = $cta_idd;
                    }
                }
            }
        }

      
        $category = '';
        if (count($cats_array) > 0) {
            $category = array(
                array(
                    'taxonomy' => 'ad_cats',
                    'field' => 'term_id',
                    'terms' => $cats_array,
                ),
            );
        }
        $is_feature = '';

        if ($ad_type == 'feature') {
            $is_feature = array(
                'key' => '_adforest_is_feature',
                'value' => 1,
                'compare' => '=',
            );
        } else if ($ad_type == 'both') {
            $is_feature = '';
        } else {
            $is_feature = array(
                'key' => '_adforest_is_feature',
                'value' => 0,
                'compare' => '=',
            );
        }
        $is_active = array(
            'key' => '_adforest_ad_status_',
            'value' => 'active',
            'compare' => '=',
        );
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
                $is_feature,
                $is_active,
            ),
            'tax_query' => array(
                $category,
                $countries_location,
            ),
            'orderby' => $order_by,
            'order' => $ordering,
        );
        $ads_html = "";
        $args = apply_filters('adforest_wpml_show_all_posts', $args);
        $results = new \WP_Query($args);
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $function = "";

                $ads_html .= adforest_search_layout_list_3(get_the_ID(), false);
            }
        }
        wp_reset_postdata();

        echo '<section class="our-feature custom-padding '.$section_bg.'">
<div class="container">
  <div class="sb-short-head center">
    <h2>'.$section_title.'</h2>
    <p>'.$section_desc.'</p>
  </div>
  <div class="row">
      '.$ads_html.'
   </div>
  </div>
</section>';
        }
}

