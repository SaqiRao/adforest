<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_process_cycle extends Widget_Base {

    public function get_name() {
        return 'process_cycle_short_base';
    }

    public function get_title() {
        return __('Process Cycle', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        // basic

        $this->start_controls_section(
                'basic', [
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White', 'adforest-elementor'),
                'bg-gray' => __('Gray', 'adforest-elementor'),
            ),
                )
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
                'step_1_settings', [
            'label' => esc_html__('Step 1', 'adforest-elementor'),
                ]
        );
        
        $this->add_control(
                's1_title', [
            'label' => __('Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                's1_description', [
            'label' => __('Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 5,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'step_2_settings', [
            'label' => esc_html__('Step 2', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                's2_title', [
            'label' => __('Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                's2_description', [
            'label' => __('Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 5,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'step_3_settings', [
            'label' => esc_html__('Step 3', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                's3_title', [
            'label' => __('Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                's3_description', [
            'label' => __('Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 5,
            'placeholder' => '',
                ]
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
        $params['s1_title'] = isset($atts['s3_title']) ? $atts['s3_title'] : "";
        // $params['s1_icon'] = isset($atts['s1_icon']) ? $atts['s1_icon'] : "";
        $params['s1_description'] = isset($atts['s1_description']) ? $atts['s1_description'] : "";
        $params['s2_title'] = isset($atts['s2_title']) ? $atts['s2_title'] : "";
        // $params['s2_icon'] = isset($atts['s2_icon']) ? $atts['s2_icon'] : "";
        $params['s2_description'] = isset($atts['s2_description']) ? $atts['s2_description'] : "";
        // $params['s3_icon'] = isset($atts['s3_icon']) ? $atts['s3_icon'] : "";
        $params['s3_title'] = isset($atts['s3_title']) ? $atts['s3_title'] : "";
        $params['s3_description'] = isset($atts['s3_description']) ? $atts['s3_description'] : "";
        echo process_cycle_short_base_func($params);
    }

}
