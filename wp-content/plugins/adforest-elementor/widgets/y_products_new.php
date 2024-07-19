<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_products_new extends Widget_Base {

    public function get_name() {
        return 'price_modern2_short_base';
    }

    public function get_title() {
        return __('Products - Modern 2','adforest-elementor');
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
                'section_bg', [
            'label' => __('Select Background Color','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            "description" => __("Select background color", 'adforest-elementor'),
            'options' => [
                '' => __('White','adforest-elementor'),
                'gray' => __('Gray','adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'header_style', [
            'label' => __('Header Style','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'options' => [
                __('No Header','adforest-elementor'),
                'classic' => __('Classic','adforest-elementor'),
                'regular' => __('Regular','adforest-elementor'),
            ],
                ]
        );


        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" => __("For color {color}warp text within this tag{/color}", 'adforest-elementor'),
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
                'section_description', [
            'label' => __('Section Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'placeholder' => __('Type your description here','adforest-elementor'),
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
                'section_title_regular', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" => __("For color {color}warp text within this tag{/color}", 'adforest-elementor'),
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

        $this->end_controls_section();

        $this->start_controls_section(
                'products_section', [
            'label' => esc_html__('Products','adforest-elementor'),
                ]
        );

        $this->add_control(
                'woo_products', [
            'label' => __('Select Product','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            "description" => __("Select Product", 'adforest-elementor'),
            'options' => apply_filters('adforest_elementor_get_packages', array()),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;

        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        $adforest_render_params['woo_products'] = isset($package_settings_fields['woo_products']) ? $package_settings_fields['woo_products']:'';


        echo price_modern3_short_base_func($adforest_render_params);
    }

}
