<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_shop_layout extends Widget_Base {

    public function get_name() {
        return 'shop_layout_modern_short_base';
    }

    public function get_title() {
        return __('Shop Layout - Modern','adforest-elementor');
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
                    'multiple' => true,
                    'description' => __('Select Background Color','adforest-elementor'),
                    'options' => [
                        '' => __('White','adforest-elementor'),
                        'gray' => __('Gray','adforest-elementor'),
                        'img' => __('Image','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'bg_img',
                [
                    'label' => __('Background Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
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
                ]
        );

        $this->add_control(
                'header_style',
                [
                    'label' => __('Header Style','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
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
                    "description" => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
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
                'product_settings_sec', [
            'label' => esc_html__('Products Setting','adforest-elementor'),
                ]
        );
        $this->add_control(
                'max_limit',
                [
                    'label' => __('Select Number of Product','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 1,
                ]
        );
        $this->add_control(
                'p_cols',
                [
                    'label' => __('Column','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'multiple' => true,
                    'description' => __('Select Column','adforest-elementor'),
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
                'main_link',
                [
                    'label' => __('View All Link','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('Read more Link if any','adforest-elementor'),
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
                'all_products_sett', [
            'label' => esc_html__('Products','adforest-elementor'),
                ]
        );

        $this->add_control(
                'all_products',
                [
                    'label' => __('Select Products','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    // 'multiple' => true,
                    'description' => __('Choose Header Style','adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'product_cat'),
                    'options' => [
                        'all' => __('All Categories','adforest-elementor'),
                        'selective' => __('Selective Categories','adforest-elementor')
                    ],
                ]
        );
        $this->add_control(
                'woo_products',
                [
                    'label' => __('Select Products','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'description' => __('Select Product','adforest-elementor'),
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
                ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        $adforest_render_params['max_limit'] = isset($package_settings_fields['max_limit']) ? $package_settings_fields['max_limit']:'';
        $adforest_render_params['p_cols'] = isset($package_settings_fields['p_cols']) ? $package_settings_fields['p_cols']:'';
        $adforest_render_params['main_link'] = isset( $package_settings_fields['main_link']) ? $package_settings_fields['main_link']:'';
        $adforest_render_params['link_title'] = isset($package_settings_fields['link_title']) ? $package_settings_fields['link_title']:'';
        $adforest_render_params['all_products'] = isset($package_settings_fields['all_products']) ? $package_settings_fields['all_products']:'';
        $adforest_render_params['woo_products'] = isset($package_settings_fields['woo_products']) ? $package_settings_fields['woo_products']:'';

        echo shop_layout_modern_short_base_func($adforest_render_params);
    }

}