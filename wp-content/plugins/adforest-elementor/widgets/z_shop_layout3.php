<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_shop_layout3 extends Widget_Base {

    public function get_name() {
        return 'shop_layout_modern_short3_base';
    }

    public function get_title() {
        return __('Shop Layout - Modern 3','adforest-elementor');
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
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White','adforest-elementor'),
                'gray' => __('Gray','adforest-elementor'),
                'img' => __('Image','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'bg_img', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'section_bg',
                        'operator' => 'in',
                        'value' => [
                            'img',
                        ],
                    ],
                ],
            ],
                )
        );

        $this->add_control(
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
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
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
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
        $this->end_controls_section();



        $this->start_controls_section(
                'pro-setting', [
            'label' => esc_html__('Products Setting','adforest-elementor'),
                ]
        );


        $this->add_control(
                'max_limit', [
            'label' => __('Select Number of Product','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 100,
            'step' => 1,
            'default' => 5, //"value" => range(1, 100),
                ]
        );

        $this->add_control(
                'p_cols', [
            'label' => __('Column','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '4',
            'placeholder' => 'Select Options',
            'options' => [
                '4' => __('3 Col','adforest-elementor'),
                '3' => __('4 Col','adforest-elementor'),
                '2' => __('6 Col','adforest-elementor'),
            ],
                ]
        );

        $this->add_control(
                'link_title', [
            'label' => __('Link Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Link Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'main_link', [
            'label' => __('View All Link','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => __('https://your-link.com','adforest-elementor'),
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
                'all_products', [
            'label' => __('Select Product Categories','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'all',
            'options' => [
                'all' => __('All Categories','adforest-elementor'),
                'selective' => __('Selective Categories','adforest-elementor'),
            ],
                ]
        );


        $this->add_control(
                'woo_products', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => 'all',
            'placeholder' => 'Select Options',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'product_cat'),
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

        $product_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($product_settings_fields['section_bg']) ? $product_settings_fields['section_bg'] : '';
        $adforest_render_params['bg_img'] = isset($product_settings_fields['bg_img']['id']) ? $product_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($product_settings_fields['header_style']) ? $product_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($product_settings_fields['section_title']) ? $product_settings_fields['section_title'] : '';
        $adforest_render_params['section_title_regular'] = isset($product_settings_fields['section_title_regular']) ? $product_settings_fields['section_title_regular'] : '';
        $adforest_render_params['section_description'] = isset($product_settings_fields['section_description']) ? $product_settings_fields['section_description'] : '';

        $adforest_render_params['main_link'] = isset($product_settings_fields['main_link']) ? $product_settings_fields['main_link'] : '';
        $adforest_render_params['link_title'] = isset($product_settings_fields['link_title']) ? $product_settings_fields['link_title'] : '';

        $adforest_render_params['max_limit'] = isset($product_settings_fields['max_limit']) ? $product_settings_fields['max_limit'] : '';
        $adforest_render_params['p_cols'] = isset($product_settings_fields['p_cols']) ? $product_settings_fields['p_cols'] : '';
        $adforest_render_params['all_products'] = isset($product_settings_fields['all_products']) ? $product_settings_fields['all_products'] : '';
        $adforest_render_params['woo_products'] = isset($product_settings_fields['woo_products']) ? $product_settings_fields['woo_products'] : '';

        echo shop_layout_modern_short3_base_func($adforest_render_params);
    }

}
