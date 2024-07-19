<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_ads_listing_services extends Widget_Base {

    public function get_name() {
        return 'adforest_ads_listing_grid';
    }

    public function get_title() {
        return __('ADs Listing - Service','adforest-elementor');
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
                'section_bg',
                [
                    'label' => __('Background Color','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select background color", 'adforest-elementor'),
                    'options' => [
                        '' => __('White','adforest-elementor'),
                        'gray' => __('Gray','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'header_style',
                [
                    'label' => __('Header Style','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'description' => __('Choose Header Style','adforest-elementor'),
                    'options' => [
                        '' => __('No Header','adforest-elementor'),
                        'classic' => __('Classic','adforest-elementor'),
                        'regular' => __('Regular','adforest-elementor')
                    ],
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'header_style',
                                'operator' => 'in',
                                'value' => [
                                    'classic',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'header_style',
                                'operator' => 'in',
                                'value' => [
                                    'classic',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'section_title_regular',
                [
                    'label' => __('Section Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'header_style',
                                'operator' => 'in',
                                'value' => [
                                    'regular',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        
        $this->add_control(
                'button_text',
                [
                    'label' => __('Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,            
                ]
        );
        $this->add_control(
                'more_ads',
                [
                    'label' => __('More ads Button','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
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
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'layout_type',
                [
                    'label' => __('Layout Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Select Layout Type", 'adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_styles', array()),
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
                'categories_section3', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
       

        $this->add_control(
                'cat',
                [
                    'label' => __('Select Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2, 
                    'multiple'=> true,
                    "description" => __("Category", 'adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();

        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        $adforest_render_params['button_text'] = isset($package_settings_fields['button_text']) ? $package_settings_fields['button_text'] : '';     
        $adforest_render_params['more_ads'] = isset($package_settings_fields['more_ads']) ? $package_settings_fields['more_ads'] : '';
        $adforest_render_params['layout_type'] = isset($package_settings_fields['layout_type']) ? $package_settings_fields['layout_type'] : '';
        $adforest_render_params['ad_type'] = isset($package_settings_fields['ad_type']) ? $package_settings_fields['ad_type'] : '';
        $adforest_render_params['ad_order'] = isset($package_settings_fields['ad_order']) ? $package_settings_fields['ad_order'] : '';
        $adforest_render_params['no_of_ads'] = isset($package_settings_fields['no_of_ads']) ? $package_settings_fields['no_of_ads'] : '';
        $adforest_render_params['cats'] = isset($package_settings_fields['cat']) ? $package_settings_fields['cat'] : '';

        echo adforest_ads_listing_grid_callback($adforest_render_params);
    }

}
