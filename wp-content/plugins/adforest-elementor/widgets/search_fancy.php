<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_search_fancy extends Widget_Base {

    public function get_name() {
        return 'search_fancy_short_base';
    }

    public function get_title() {
        return __('Search - Fancy','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic_setting', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_tag_line', [
            'label' => __('Section Tagline','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Tagline','adforest-elementor'),
            "description" => '%count% ' . __("for total ads", 'adforest-elementor'),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'slider_setting', [
            'label' => esc_html__('Slider','adforest-elementor'),
                ]
        );


        $adforest_slide_repetor = new \Elementor\Repeater();

        $adforest_slide_repetor->add_control(
                'img', array(
            'label' => __('Slider Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("1280x600", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );

        $this->add_control(
                'slides', [
            'label' => __('Add Slider Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $adforest_slide_repetor->get_controls(),
            'default' => [],
            'title_field' => '{{{img}}}',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'cat_setting', [
            'label' => esc_html__('Category','adforest-elementor'),
                ]
        );

        $this->add_control(
                'cat_frontend_switch', array(
            'label' => __('Category ( ajax based )','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Default','adforest-elementor'),
                'ajax_based' => __('Ajax Based ( Load All )','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'cat', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => true,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'cat_frontend_switch',
                        'operator' => 'in',
                        'value' => [
                            '',
                        ],
                    ],
                ],
            ],
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats','yes')
                )
        );

        $this->end_controls_section();
    }

    protected function render() {

        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_title'] = isset($search_settings_fields['section_title']) ? $search_settings_fields['section_title']:'';
        $adforest_render_params['section_tag_line'] = isset($search_settings_fields['section_tag_line']) ? $search_settings_fields['section_tag_line']:'';
        $adforest_render_params['cat_frontend_switch'] = isset($search_settings_fields['cat_frontend_switch']) ? $search_settings_fields['cat_frontend_switch'] :'';
        $adforest_render_params['cats'] = isset($search_settings_fields['cat']) ? $search_settings_fields['cat']:'';
        $adforest_render_params['slides'] = $search_settings_fields['slides'];
        
        echo search_fancy_short_base_func($adforest_render_params);
    }

}
