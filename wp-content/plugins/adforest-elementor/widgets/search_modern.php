<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_search_modern extends Widget_Base {

    public function get_name() {
        return 'search_modern_short_base';
    }

    public function get_title() {
        return __('Search - Modern', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic_settings', [
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_tag_line', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Tagline', 'adforest-elementor'),
            "description" => '%count% ' . __("for total ads", 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'm_search_placeholder', [
            'label' => __('Search Place holder', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Search Place holder', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'm_location_placeholder', [
            'label' => __('Location Place holder', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Location Place holder', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'is_display_tags', array(
            'label' => __('Display tags ?', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '1' => __('Yes', 'adforest-elementor'),
                '0' => __('No', 'adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'max_tags_limit', array(
            'label' => __('Max number of tags', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 5,
            'min' => 1,
            'max' => 500,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'is_display_tags',
                        'operator' => 'in',
                        'value' => [
                            '1',
                        ],
                    ],
                ],
            ],
                )
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'cat_setting', [
            'label' => esc_html__('Category', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'cat_frontend_switch', array(
            'label' => __('Category ( ajax based )', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Default', 'adforest-elementor'),
                'ajax_based' => __('Ajax Based ( Load All )', 'adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'cats', array(
            'label' => __('Select Category', 'adforest-elementor'),
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
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes')
                )
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'loc_settings', [
            'label' => esc_html__('Custom Loctions', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'location_type', array(
            'label' => __('Location type', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'g_locations' => __('Google', 'adforest-elementor'),
                'custom_locations' => __('Custom Location', 'adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'locations', array(
            'label' => __('Locations', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'multiple' => true,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'location_type',
                        'operator' => 'in',
                        'value' => [
                            'custom_locations',
                        ],
                    ],
                ],
            ],
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country', 'yes')
                )
        );
        $this->end_controls_section();
    }

    protected function render() {

        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['m_search_placeholder'] = isset($atts['m_search_placeholder']) ? $atts['m_search_placeholder'] : "";
        $params['section_tag_line'] = isset($atts['section_tag_line']) ? $atts['section_tag_line'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['m_location_placeholder'] = isset($atts['m_location_placeholder']) ? $atts['m_location_placeholder'] : "";
        $params['is_display_tags'] = isset($atts['is_display_tags']) ? $atts['is_display_tags'] : "";
        $params['max_tags_limit'] = isset($atts['max_tags_limit']) ? $atts['max_tags_limit'] : "";
        $params['locations'] = isset($atts['locations']) ? $atts['locations'] : "";
        $params['location_type'] = isset($atts['location_type']) ? $atts['location_type'] : "";
        $params['cat_frontend_switch'] = isset($atts['cat_frontend_switch']) ? $atts['cat_frontend_switch'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";
        $params['locations'] = isset($atts['locations']) ? $atts['locations'] : "";
        echo search_modern_short_base_func($params);
    }

}
