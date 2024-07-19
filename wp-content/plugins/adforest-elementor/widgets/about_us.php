<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_about_us extends Widget_Base {

    public function get_name() {
        return 'about_us_short_base';
    }

    public function get_title() {
        return __('About us', 'adforest-elementor');
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
                'section_tagline', [
            'label' => __('Section Tag Line', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title', 'adforest-elementor'),
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
        $this->add_control(
                'img_1', [
            'label' => __('large image', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("524x464", 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'img_2', [
            'label' => __('small image', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("294x280", 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'link', [
            'label' => __('URL or Link', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            "description" => __("Youtube video link", 'adforest-elementor'),
            'default' => '',
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'client_settings', [
            'label' => esc_html__('Client or Partners', 'adforest-elementor'),
                ]
        );
        $adforest_elementor_repetor = new \Elementor\Repeater();
        $adforest_elementor_repetor->add_control(
                'small_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );
        $adforest_elementor_repetor->add_control(
                'small_desc', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );
        $adforest_elementor_repetor->add_control(
                'icon',
                [
                    'label' => __('Icon', 'text-domain'),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'description' => esc_html__('Please use reguler font', 'adforest-elementor'),
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                ]
        );
        $this->add_control(
                'clients', [
            'label' => __('Add Client', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $adforest_elementor_repetor->get_controls(),
            'default' => [],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_tagline'] = isset($atts['section_tagline']) ? $atts['section_tagline'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['img_1'] = isset($atts['img_1']) ? $atts['img_1'] : "";
        $params['img_2'] = isset($atts['img_2']) ? $atts['img_2'] : "";
        $params['link'] = isset($atts['link']) ? $atts['link'] : "";
        $params['clients'] = isset($atts['clients']) ? $atts['clients'] : "";
        $params['adforest_elementor'] = true;

        if(function_exists('about_us_short_base_func')){
        echo about_us_short_base_func($params);
        }

    }
}
