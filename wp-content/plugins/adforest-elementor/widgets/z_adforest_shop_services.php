<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_shop_services extends Widget_Base {

    public function get_name() {
        return 'adforest_shop_services';
    }

    public function get_title() {
        return __('Shop Layout - Services','adforest-elementor');
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
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Chose header style.','adforest-elementor'),
            'options' => array(
                '' => __('No Header','adforest-elementor'),
                'classic' => __('Classic','adforest-elementor'),
                'regular' => __('Regular','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
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
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_description', [
            'label' => __('Section Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
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
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
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
                'screen', [
            'label' => esc_html__('Product Settings','adforest-elementor'),
                ]
        );

        $this->add_control(
                'max_limit', [
            'label' => __('Select Number of Product','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 100,
            'step' => 1,
            'default' => 1,
                ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'products', [
            'label' => esc_html__('Product Settings','adforest-elementor'),
                ]
        );

        $this->add_control(
                'all_products', array(
            'label' => __('Select Products','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Option','adforest-elementor'),
                'all' => __('All Categories','adforest-elementor'),
                'selective' => __('Selective Categories','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'woo_products', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'description' => __('Chose header style.','adforest-elementor'),
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'product_cat'),
            'multiple' => true,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'all_products',
                        'operator' => 'in',
                        'value' => [
                            'selective',
                        ],
                    ],
                ],
            ],
                )
        );


        $this->end_controls_section();
    }

    protected function render() {


        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        $adforest_render_params['max_limit'] = isset($package_settings_fields['max_limit']) ? $package_settings_fields['max_limit'] : '';
        $adforest_render_params['all_products'] = isset($package_settings_fields['all_products']) ? $package_settings_fields['all_products'] : '';
        $adforest_render_params['woo_products'] = isset($package_settings_fields['woo_products']) ? $package_settings_fields['woo_products'] : '';

        echo adforest_shop_services_callback($adforest_render_params);
    }

}
