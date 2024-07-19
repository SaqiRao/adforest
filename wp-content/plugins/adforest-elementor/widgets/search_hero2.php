<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_search_hero2 extends Widget_Base {

    public function get_name() {
        return 'search_hero2_short_base';
    }

    public function get_title() {
        return __('Search - Hero', 'adforest-elementor');
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
                'bg_img', [
            'label' => __('Background Image', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("1280x800", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" => "%count% " . __("for total ads", 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_description', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'sub_title', [
            'label' => __('Section title', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'block_text', [
            'label' => __('Search Block Title', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'btn_text', [
            'label' => __('Button Text', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'btn_link', [
            'label' => __('Button Link', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'location_type_section', [
            'label' => esc_html__('Location Type', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'location_type', [
            'label' => __('Location type', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'g_locations',
            'options' => [
                'g_locations' => __('Google', 'adforest-elementor'),
                'custom_locations' => __('Custom Location', 'adforest-elementor'),
            ],
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'cats_section', [
            'label' => esc_html__('Categories', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'cat_frontend_switch', [
            'label' => __('Categories Load on frontend )', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            "description" => __("Please choose categories load type on frontend for this element", 'adforest-elementor'),
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'adforest-elementor'),
                'ajax_based' => __('Ajax Based(Load All)', 'adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'cats', [
            'label' => __('Select Category ( All or Selective )', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'cat_frontend_switch',
                        'operator' => 'in',
                        'value' => [
                            'default',
                        ],
                    ],
                ],
            ],
                // 'default' => [ 'title', 'description' ],
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'custom_locations', [
            'label' => esc_html__('Custom Location', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'locations', [
            'label' => __('Locations', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country', 'yes'),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['bg_img'] = isset($atts['bg_img']) ? $atts['bg_img'] : "";
        $params['sub_title'] = isset($atts['sub_title']) ? $atts['sub_title'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['block_text'] = isset($atts['block_text']) ? $atts['block_text'] : "";
        $params['btn_text'] = isset($atts['btn_text']) ? $atts['btn_text'] : "";
        $params['btn_link'] = isset($atts['btn_link']) ? $atts['btn_link'] : "";
        $params['location_type'] = isset($atts['location_type']) ? $atts['location_type'] : "";
        $params['cat_frontend_switch'] = isset($atts['cat_frontend_switch']) ? $atts['cat_frontend_switch'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";
        $params['locations'] = isset($atts['locations']) ? $atts['locations'] : "";
        echo search_hero2_short_base_func($params);
    }

}
