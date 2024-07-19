<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_apps_classic extends Widget_Base {

    public function get_name() {
        return 'app_classic_short_base';
    }

    public function get_title() {
        return __('Apps - Classic', 'adforest-elementor');
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
                'app_img', array(
            'label' => __('Main Image', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("400x500", 'adforest-elementor'),
                )
        );

        $this->add_control(
                'section_tag_line', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
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

        $this->end_controls_section();

        $this->start_controls_section(
                'keypoints', [
            'label' => esc_html__('Key Points', 'adforest-elementor'),
                ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
                'title', [
            'label' => __('Point', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('List Title', 'adforest-elementor'),
            'label_block' => true,
                ]
        );

        $this->add_control(
                'points', [
            'label' => __('Add Points', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ title }}}',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'andriod', [
            'label' => esc_html__('Andriod', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'a_tag_line', [
            'label' => __('Tag Line', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Tag Line', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'a_title', [
            'label' => __('Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'a_link', [
            'label' => __('Download Link', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Download Link', 'adforest-elementor'),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'ios', [
            'label' => esc_html__('IOS', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'i_tag_line', [
            'label' => __('Tag Line', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Tag Line', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'i_title', [
            'label' => __('Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'i_link', [
            'label' => __('Download Link', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Download Link', 'adforest-elementor'),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['app_img'] = isset($atts['app_img']) ? $atts['app_img'] : "";
        $params['section_tag_line'] = isset($atts['section_tag_line']) ? $atts['section_tag_line'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['points'] = isset($atts['points']) ? $atts['points'] : "";

         $params['i_link'] = isset($atts['i_link']) ? $atts['i_link'] : "";

          $params['i_title'] = isset($atts['i_title']) ? $atts['i_title'] : "";

           $params['i_tag_line'] = isset($atts['i_tag_line']) ? $atts['i_tag_line'] : "";



         $params['a_link'] = isset($atts['a_link']) ? $atts['a_link'] : "";

          $params['a_title'] = isset($atts['a_title']) ? $atts['a_title'] : "";

           $params['a_tag_line'] = isset($atts['a_tag_line']) ? $atts['a_tag_line'] : "";

         if(function_exists('app_classic_short_base_func')){
            echo app_classic_short_base_func($params);
          }
   
    }
}
