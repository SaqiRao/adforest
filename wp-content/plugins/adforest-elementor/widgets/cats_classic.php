<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_cats_classic extends Widget_Base {

    public function get_name() {
        return 'cats_classic_short_basee';
    }

    public function get_title() {
        return __('Categories - Classic','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-address-card';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        // basic

        $this->start_controls_section(
                'basic_settings', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );

        $this->add_control(
                'cat_link_page', array(
            'label' => __('Category link Page','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 5,
            'options' => [
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Page','adforest-elementor'),
            ]
                )
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

        $this->add_control(
                'sub_limit', array(
            'label' => __('Sub cats limit','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 10,
            'min' => 0,
            'max' => 500,
                )
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
                'cats_settings', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
        
        $adforest_elementor_repetor = new \Elementor\Repeater();


        $adforest_elementor_repetor->add_control(
                'cat', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats')
                )
        );
        $adforest_elementor_repetor->add_control(
                'icon', [
            'label' => __('Icon','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'solid',
            ],
                ]
        );

        $this->add_control(
                'cats_classic', [
            'label' => __('Add Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $adforest_elementor_repetor->get_controls(),
            'default' => [],
            'title_field' => '{{{cat}}}',
                ]
        );
         $this->end_controls_section();
    }

    protected function render() {
        
        
        $category_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;  
        $adforest_render_params['cat_link_page'] = isset($category_settings_fields['cat_link_page']) ? $category_settings_fields['cat_link_page']:'';
        
        $adforest_render_params['section_bg'] = isset($category_settings_fields['section_bg']) ? $category_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($category_settings_fields['bg_img']['id']) ? $category_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($category_settings_fields['header_style']) ? $category_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($category_settings_fields['section_title']) ? $category_settings_fields['section_title']:'';
        $adforest_render_params['section_title_regular'] = isset($category_settings_fields['section_title_regular']) ? $category_settings_fields['section_title_regular']:'';
        $adforest_render_params['section_description'] = isset($category_settings_fields['section_description']) ? $category_settings_fields['section_description']:'';
        $adforest_render_params['sub_limit'] = isset($category_settings_fields['sub_limit']) ? $category_settings_fields['sub_limit']:'';
        $adforest_render_params['cats'] = isset($category_settings_fields['cats_classic']) ? $category_settings_fields['cats_classic']:'';     
        echo cats_classic_short_base_func($adforest_render_params);
    }

}
