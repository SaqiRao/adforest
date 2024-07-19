<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_main_hero1 extends Widget_Base {

    public function get_name() {
        return 'adforest_main_hero1';
    }

    public function get_title() {
        return __('Main Hero 1', 'adforest-elementor');
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
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_description', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'screen', [
            'label' => esc_html__('Search Settings', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'keyword_label', [
            'label' => __('Search Keyword Label', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'keyword_placeholder', [
            'label' => __('Search Keyword Placeholder', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Search Keyword Placeholder', 'adforest-elementor'),
            'default' => __('What are you looking for.....', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'location_label', [
            'label' => __('Search Location Label', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Search Locaton', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'location_placeholder', [
            'label' => __('Search Location placeholder', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Locaton', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'signature_img', array(
            'label' => __('Signature Image', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
                )
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'clocation', [
            'label' => esc_html__('Custom Locations', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'location_type', array(
            'label' => __('Location type', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Chose header style.', 'adforest-elementor'),
            'options' => array(
                'g_locations' => __('Google', 'adforest-elementor'),
                'custom_locations' => __('Custom Location', 'adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'locations', array(
            'label' => __('Location', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'separator' => 'before',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country', 'yes'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'location_type',
                        'operator' => '=',
                        'value' => 'custom_locations',
                    ],
                ],
            ],
                )
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'categories', [
            'label' => esc_html__('Category slider', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'cat_link_page',
                [
                    'label' => __('Category link Page', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    'options' => [
                        'search' => __('Search Page', 'adforest-elementor'),
                        'category' => __('Category Page', 'adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'cats', array(
            'label' => __('Categories', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'no', false),
                )
        );

        $this->end_controls_section();
    }

    protected function render() {


        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['section_tagline'] = isset($atts['section_tagline']) ? $atts['section_tagline'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['keyword_label'] = isset($atts['keyword_label']) ? $atts['keyword_label'] : "";
        $params['keyword_placeholder'] = isset($atts['keyword_placeholder']) ? $atts['keyword_placeholder'] : "";
        $params['location_label'] = isset($atts['location_label']) ? $atts['location_label'] : "";
        $params['location_placeholder'] = isset($atts['location_placeholder']) ? $atts['location_placeholder'] : "";
        $params['signature_img'] = isset($atts['signature_img']) ? $atts['signature_img'] : "";
        $params['location_type'] = isset($atts['location_type']) ? $atts['location_type'] : "";
        $params['locations'] = isset($atts['locations']) ? $atts['locations'] : "";
        $params['cat_link_page'] = isset($atts['cat_link_page']) ? $atts['cat_link_page'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";

         if(function_exists('search_hero_1_short_base_func')){
          echo search_hero_1_short_base_func($params);
        }
    }

}
