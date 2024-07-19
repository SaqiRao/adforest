<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_video_hero extends Widget_Base {

    public function get_name() {
        return 'search_hero_short_base';
    }

    public function get_title() {
        return __('Search - with bg-video', 'adforest-elementor');
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
            'video_url',
            [
                'label' => __( 'YouTube Video URL', 'text-domain' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter YouTube video URL', 'text-domain' ),
                'description' => __( 'Enter the YouTube video URL.', 'text-domain' ),
            ]
        );

        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => "%count% " . __("for total ads", 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_tag_line',
                [
                    'label' => __('Section Tagline', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        global $adforest_theme;  
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_tag_line'] = isset($atts['section_tag_line']) ? $atts['section_tag_line'] : ""; 
        $params['section_video'] = isset($atts['video_url']) ? $atts['video_url'] : "";    
        echo search_hero_short_base_func($params);
}
}