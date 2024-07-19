<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_products_simple extends Widget_Base {

    public function get_name() {
        return 'price_simple_short_base';
    }

    public function get_title() {
        return __('Products - Simple','adforest-elementor');
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
                ]
        );
        $this->end_controls_section();
        
        
        $this->start_controls_section(
                'product_settings', [
            'label' => esc_html__('Products Setting','adforest-elementor'),
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
                'woo_products', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => 'all',
            'placeholder' => 'Select Options',
            'options' => apply_filters('adforest_elementor_get_packages', array()),
                )
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        // procts settings        
        $adforest_render_params['p_cols'] = isset($package_settings_fields['p_cols']) ? $package_settings_fields['p_cols']:'';
        $adforest_render_params['woo_products'] = isset($package_settings_fields['woo_products']) ? $package_settings_fields['woo_products']:'';
        
        echo price_simple_short_base_func($adforest_render_params);
        
    }
}