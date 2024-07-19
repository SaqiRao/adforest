<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ads_grid extends Widget_Base {

    public function get_name() {
        return 'ads_grid_short_base';
    }

    public function get_title() {
        return __('ADs Grid', 'adforest-elementor');
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
                'section_tagline', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
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
                'section_description', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->add_control(
                'link_title', [
            'label' => __('Link Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Link Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'main_link', [
            'label' => __('Read More Link', 'adforest-elementor'),
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
                'ads_settings', [
            'label' => esc_html__('Ads Settings', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'ad_type', array(
            'label' => __('Ads Type', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads Type', 'adforest-elementor'),
                'feature' => __('Featured Ads', 'adforest-elementor'),
                'regular' => __('Simple Ads', 'adforest-elementor'),
                'both' => __('Both', 'adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'ad_order', array(
            'label' => __('Order By', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads order', 'adforest-elementor'),
                'asc' => __('Oldest', 'adforest-elementor'),
                'desc' => __('Latest', 'adforest-elementor'),
                'rand' => __('Random', 'adforest-elementor'),
            ),
                )
        );
        $this->add_control(
                'no_of_ads', array(
            'label' => __('Number fo Ads', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 10,
            'min' => 1,
            'max' => 500,
                )
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'ad_categories', [
            'label' => esc_html__('Categories', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'cats', array(
            'label' => __('Select Category', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes')
                )
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
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['ad_type'] = isset($atts['ad_type']) ? $atts['ad_type'] : "";    
        $params['link_title'] = isset($atts['link_title']) ? $atts['link_title'] : "";
        $params['main_link'] = isset($atts['main_link']) ? $atts['main_link'] : "";
        $params['ad_order'] = isset($atts['ad_order']) ? $atts['ad_order'] : "";
        $params['no_of_ads'] = isset($atts['no_of_ads']) ? $atts['no_of_ads'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";

         if(function_exists('ads_gridshort_base_func')){
        echo ads_gridshort_base_func($params);

    }
         
            }
    }


