<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_contact_us extends Widget_Base {

    public function get_name() {
        return 'contact_usshort_base';
    }

    public function get_title() {
        return __('Contact Us', 'adforest-elementor');
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
            'label' => esc_html__('Basic Settings', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                's_title_1', [
            'label' => __('Contact Form Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Contact Form Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                's_title_2', [
            'label' => __('Contact Info Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Contact Info Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'contact_short_code', [
            'label' => __('Contact form 7 shortcode', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'address_settings', [
            'label' => esc_html__('Address', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'address', [
            'label' => __('Address', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'phone_settings', [
            'label' => esc_html__('Phone', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'phone', [
            'label' => __('Phone', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'email_settings', [
            'label' => esc_html__('Email', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'email', [
            'label' => __('Email', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['s_title_1'] = isset($atts['s_title_1']) ? $atts['s_title_1'] : "";
        $params['s_title_2'] = isset($atts['s_title_2']) ? $atts['s_title_2'] : "";
        $params['address'] = isset($atts['address']) ? $atts['address'] : "";
        $params['phone'] = isset($atts['phone']) ? $atts['phone'] : "";
        $params['email'] = isset($atts['email']) ? $atts['email'] : "";
         $params['contact_short_code'] = isset($atts['contact_short_code']) ? $atts['contact_short_code'] : "";

         if(function_exists('contact_usshort_base_func')){
        echo contact_usshort_base_func($params);
    }
}

}
