<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_product_bg extends Widget_Base {

    public function get_name() {
        return 'select_product_short_base';
    }

    public function get_title() {
        return __('Product with Bg','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic_seetting', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_tag_line', [
            'label' => __('Section Tagline','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Tagline','adforest-elementor'),
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
                'link_title', [
            'label' => __('Button Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Button Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'link', [
            'label' => __('Button Link','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => '',
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => true,
                'nofollow' => true,
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'main_all_products', [
            'label' => esc_html__('Products','adforest-elementor'),
                ]
        );

        $this->add_control(
                'one_product', array(
            'label' => __('Select Product (max 2)','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => 'all',
            'placeholder' => 'Select Options',
           'options' => apply_filters('adforest_elementor_get_packages', array()),
                )
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'key_points_settings', [
            'label' => esc_html__('Key Points','adforest-elementor'),
                ]
        );



        $adforest_elementor_repetor = new \Elementor\Repeater();

        $adforest_elementor_repetor->add_control(
                'title', [
            'label' => __('Point','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );

        $this->add_control(
                'points', [
            'label' => __('Add Point','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $adforest_elementor_repetor->get_controls(),
            'default' => [],
            'title_field' => '{{{title}}}',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_tag_line'] = isset($atts['section_tag_line']) ? $atts['section_tag_line'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['link_title'] = isset($atts['link_title']) ? $atts['link_title'] : "";
        $params['link'] = isset($atts['link']) ? $atts['link'] : ""; 
        $params['points'] = isset($atts['points']) ? $atts['points'] : "";
        $params['one_product'] = isset($atts['one_product']) ? $atts['one_product'] : "";
        
        
        
        echo select_product_short_base_func($params);
    }}
