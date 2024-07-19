<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ads_cats_tabs_modern extends Widget_Base {

    public function get_name() {
        return 'ads_cats_tabs_short_base';
    }

    public function get_title() {
        return __('ADs Tabs Modern','adforest-elementor');
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
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
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
        $this->end_controls_section();
        $this->start_controls_section(
                'ads_settings', [
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'ad_type', [
            'label' => __('Ads Type','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            "description" => __("Select Ads Type", 'adforest-elementor'),
            'options' => [
                'feature' => __('Featured Ads','adforest-elementor'),
                'regular' => __('Simple Ads','adforest-elementor'),
                'both' => __('Both','adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'ad_order', [
            'label' => __('Order By','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            "description" => __("Select Ads order", 'adforest-elementor'),
            'options' => [
                'asc' => __('Oldest','adforest-elementor'),
                'desc' => __('Latest','adforest-elementor'),
                'rand' => __('Random','adforest-elementor'),
            ],
                ]
        );

        $this->add_control(
                'no_of_ads', [
            'label' => __('Number of Ads for each category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'categories_section_cats', [
            'label' => __('Categories','adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'cats', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
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
        $params['ad_type'] = isset($atts['ad_type']) ? $atts['ad_type'] : "both";
        $params['ad_order'] = isset($atts['ad_order']) ? $atts['ad_order'] : "desc";
        $params['no_of_ads'] = isset($atts['no_of_ads']) ? $atts['no_of_ads'] : 5;
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";

        if(function_exists('ads_cats_tabs_short_base_func')){
        echo ads_cats_tabs_short_base_func($params);
         }
       }                      
}