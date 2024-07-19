<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_hero_realestate extends Widget_Base {

    public function get_name() {
        return 'adforest_hero_realestate_base';
    }

    public function get_title() {
        return __('Adforest Hero - Realestate','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

       $this->start_controls_section(
                'ads_settings', [
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'ads_title',
                [
                    'label' => __('Ads Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __("Add the title of ads that dispaly at the top of the sidebar ads listings", 'adforest-elementor'),
                ]
        );
        
        $this->add_control(
                'ad_type',
                [
                    'label' => __('Ads Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select Ads Type", 'adforest-elementor'),
                    'options' => [
                        'feature' => __('Featured Ads','adforest-elementor'),
                        'regular' => __('Simple Ads','adforest-elementor'),
                        'both' => __('Both','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'ad_order',
                [
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
                'no_of_ads',
                [
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
                'banner_settings', [
            'label' => esc_html__('Banner Setting','adforest-elementor'),
                ]
        );
        $this->add_control(
                'sec_bg_img',
                [
                    'label' => __('Section Background Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __("2020x899", 'adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
                'sec_img',
                [
                    'label' => __('Section Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __('536x703','adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
                'sec_heading',
                [
                    'label' => __('Heading','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'sec_subheading',
                [
                    'label' => __('Sub Heading','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'dropdown_cats', [
            'label' => esc_html__('Dropdown Categories','adforest-elementor'),
                ]
        );
        $this->add_control(
                'cats_load',
                [
                    'label' => __('Categories Load on frontend','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'default' => __('Default','adforest-elementor'),
                        'ajax_based' => __('Ajax Based(Load All)','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'cats_d',
                [
                    'label' => __('Select Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes'),
                    'conditions' => [
                    'terms' => [
                        [
                            'name' => 'cats_load',
                            'operator' => 'in',
                            'value' => [
                                'default',
                            ],
                        ],
                    ],
                ],
                ]
        );
        $this->end_controls_section();
        
         $this->start_controls_section(
                'categoriesr', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
         
         $this->add_control(
                'cats',
                [
                    'label' => __('Select Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes'),
                ]
        );
         
        
         $this->end_controls_section();
        
        
        
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['ads_title'] = isset($package_settings_fields['ads_title']) ? $package_settings_fields['ads_title']:'';
        $adforest_render_params['ad_type'] = isset($package_settings_fields['ad_type']) ? $package_settings_fields['ad_type']:'';
        $adforest_render_params['ad_order'] = isset($package_settings_fields['ad_order']) ? $package_settings_fields['ad_order']:'';
        $adforest_render_params['no_of_ads'] = $package_settings_fields['no_of_ads'];
        $adforest_render_params['sec_bg_img'] = isset($package_settings_fields['sec_bg_img']['id']) ? $package_settings_fields['sec_bg_img']['id'] : '';
        $adforest_render_params['sec_img'] = isset($package_settings_fields['sec_img']['id']) ? $package_settings_fields['sec_img']['id'] : '';
        $adforest_render_params['sec_heading'] = isset($package_settings_fields['sec_heading']) ? $package_settings_fields['sec_heading']:'';
        $adforest_render_params['sec_subheading'] = isset($package_settings_fields['sec_subheading']) ? $package_settings_fields['sec_subheading']:'';
        $adforest_render_params['cats_d'] = isset($package_settings_fields['cats_d']) ? $package_settings_fields['cats_d']:'';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats']:'';//cat_frontend_switch
        $adforest_render_params['cat_frontend_switch'] = isset($package_settings_fields['cats_load']) ? $package_settings_fields['cats_load']:'';//

        echo adforest_hero_realestate_base_func($adforest_render_params);
    }

}
