<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
class Widget_ads_with_sidebar extends Widget_Base {
    public function get_name() {
        return 'ads_with_sidebar_short_base';
    }
    public function get_title() {
        return __('ads with sidebar', 'adforest-elementor');
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
                'show_sidebar',
                [
                    'label' => __('Show Sidebar', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'Yes',
                    'options' => [
                        'yes' => __('Yes', 'adforest-elementor'),
                        'no' => __('No', 'adforest-elementor'),
                    ],
                ]
        );

        $this->end_controls_section();   
        $this->start_controls_section(
        'ad_settings', [
             'label' => esc_html__('Ads Settings', 'adforest-elementor'),
                ]
        );
        $ads_rapeater = new \Elementor\Repeater();
        $ads_rapeater->add_control(
                'section_tagline', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $ads_rapeater->add_control(
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $ads_rapeater->add_control(
                'section_desc', [
            'label' => __('Ads Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $ads_rapeater->add_control(
                'ad_type', [
            'label' => __('Ads Type', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'description' => __('Select Ads Type', 'adforest-elementor'),
            'options' => [
                'feature' => __('Featured Ads', 'adforest-elementor'),
                'regular' => __('Simple Ads', 'adforest-elementor'),
                'both' => __('Both', 'adforest-elementor'),
            ],
                ]
        );
        $ads_rapeater->add_control(
                'ad_order', [
            'label' => __('Order By', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'description' => __('Select Ads order', 'adforest-elementor'),
            'options' => [
                'asc' => __('Oldest', 'adforest-elementor'),
                'desc' => __('Latest', 'adforest-elementor'),
                'rand' => __('Random', 'adforest-elementor'),
            ],
                ]
        );

        $ads_rapeater->add_control(
                'no_of_ads', [
            'label' => __('Number fo Ads to display', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
                ]
        );
        $ads_rapeater->add_control(
                'link_title', [
            'label' => __('Link Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Link Title', 'adforest-elementor'),
                ]
        );
        $ads_rapeater->add_control(
                'view_all', [
            'label' => __('View all button link', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => true,
                'nofollow' => true,
            ],
                ]
        );

        $ads_rapeater->add_control(
                'banner', array(
            'label' => __('Banner', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("870x330", 'adforest-elementor'),
           
                )
        );
        
        $ads_rapeater->add_control(
                'cats', [
            'label' => __('Select Category ( Selective )', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', '', 1),
                ]
        );


      $this->add_control(
            'ads_data', [
            'label' => '',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $ads_rapeater->get_controls(),
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
      
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['show_sidebar'] = isset($atts['show_sidebar']) ? $atts['show_sidebar'] : "yes";
        $params['ads_data'] = isset($atts['ads_data']) ? $atts['ads_data'] : "";
       

         if(function_exists('ads_with_sidebar_base_func')){
       echo   ads_with_sidebar_base_func($params);
   }
}
}