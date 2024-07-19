<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_search_hero3 extends Widget_Base {

    public function get_name() {
        return 'search_hero3_short_base';
    }

    public function get_title() {
        return __('Search - Hero 3','adforest-elementor');
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
                'bg_img', [
            'label' => __('Background Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("1280x800", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" =>"%count% " . __( "for total ads", 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'sub_title', [
            'label' => __('Main Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'btn_text', [
            'label' => __('Button Text','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'block_text', [
            'label' => __('Search Block Text','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_description', [
            'label' => __('Section Tagline','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'location_type_section', [
            'label' => esc_html__('Location Type','adforest-elementor'),
                ]
        );
        $this->add_control(
                'location_type', [
            'label' => __('Location type','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'g_locations',
            'options' => [
                'g_locations' => __('Google','adforest-elementor'),
                'custom_locations' => __('Custom Location','adforest-elementor'),
            ],
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'cats_section', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
        $this->add_control(
                'cat_frontend_switch', [
            'label' => __('Categories Load on frontend )','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            "description" => __("Please choose categories load type on frontend for this element", 'adforest-elementor'),
            'default' => 'default',
            'options' => [
                'default' => __('Default','adforest-elementor'),
                'ajax_based' => __('Ajax Based(Load All)','adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'cats', [
            'label' => __('Select Category ( All or Selective )','adforest-elementor'),
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
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'locationsetting', [
            'label' => esc_html__('Custom Location','adforest-elementor'),
                ]
        );

        $this->add_control(
                'location', [
            'label' => __('Location','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country','yes'),
                ]
        );
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;

        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['sub_title'] = isset($package_settings_fields['sub_title']) ? $package_settings_fields['sub_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['btn_text'] = isset($package_settings_fields['btn_text']) ? $package_settings_fields['btn_text']:'';
        $adforest_render_params['block_text'] = isset($package_settings_fields['block_text']) ? $package_settings_fields['block_text']:'';
        $adforest_render_params['location_type'] = isset($package_settings_fields['location_type']) ? $package_settings_fields['location_type']:'';
        $adforest_render_params['cat_frontend_switch'] = isset($package_settings_fields['cat_frontend_switch']) ? $package_settings_fields['cat_frontend_switch']:'';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats']:'';
        $adforest_render_params['locations'] = isset($package_settings_fields['location']) ? $package_settings_fields['location']:'';

        echo search_hero3_short_base_func($adforest_render_params);
    }

}