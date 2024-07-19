<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_apps_modern extends Widget_Base {

    public function get_name() {
        return 'apps2_short_base';
    }

    public function get_title() {
        return __('Apps - Modern', 'adforest-elementor');
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
                'section_bg', [
            'label' => __('Background Color', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            "description" => __("Select background color", 'adforest-elementor'),
            'options' => [
                '' => __('White', 'adforest-elementor'),
                'bg-gray' => __('Gray', 'adforest-elementor'),
            ],
                ]
        );
       $this->add_control(
                'tag_line', [
            'label' => __('Tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
      
        $this->add_control(
                'section_description', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'android_section', [
            'label' => esc_html__('Android', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'a_link', [
            'label' => __('Download Link', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'android_img', [
            'label' => __('Android image', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("170x56", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'ios_section', [
            'label' => esc_html__('IOS', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'i_link', [
            'label' => __('Download Link', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'ios_img', [
            'label' => __('IOS image', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("170x56", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['tag_line'] = isset($atts['tag_line']) ? $atts['tag_line'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['a_link'] = isset($atts['a_link']) ? $atts['a_link'] : "";
        $params['android_img'] = isset($atts['android_img']) ? $atts['android_img'] : "";
        $params['i_link'] = isset($atts['i_link']) ? $atts['i_link'] : "";
        $params['ios_img'] = isset($atts['ios_img']) ? $atts['ios_img'] : "";
        

        if(function_exists('apps_modern_short_base_func')){
        echo apps_modern_short_base_func($params);
    }
} 
}