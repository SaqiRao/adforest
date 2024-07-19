<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_testimonial_modern extends Widget_Base {

    public function get_name() {
        return 'adf_testimonial_modern';
    }

    public function get_title() {
        return __('Testimonials - Modern', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'testimonials-modern', [
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background Color', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            "description" => __("Select background color", 'adforest-elementor'),
            'options' => array(
                '' => __('White', 'adforest-elementor'),
                'bg-gray' => __('Gray', 'adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'section_tagline', [
            'label' => __('Section Tag Line', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Tag Line', 'adforest-elementor'),
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
                'section_desc', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'points', [
            'label' => esc_html__('Testimonials', 'adforest-elementor'),
                ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
                'title', [
            'label' => __('Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title', 'adforest-elementor'),
                ]
        );

        $repeater->add_control(
                'designation', [
            'label' => __('Designation', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Designation', 'adforest-elementor'),
                ]
        );

        $repeater->add_control(
                'desc', [
            'label' => __('Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $repeater->add_control(
                'stars', array(
            'label' => __('Select Stars', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'min' => 1,
            'max' => 5,
                )
        );

        $repeater->add_control(
                'img', array(
            'label' => __('Side Image', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
            'desc' => esc_html__('78 by 78', 'adforest-elementor')
                )
        );

        $this->add_control(
                'points_test', [
            'label' => __('Add testimonial.', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ title }}}',
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
        $params['section_desc'] = isset($atts['section_desc']) ? $atts['section_desc'] : "";
        $params['points_test'] = isset($atts['points_test']) ? $atts['points_test'] : "";    
         
         if(function_exists('adf_testimonial_modern_func')){
        echo adf_testimonial_modern_func($params);
    }
    }

}
