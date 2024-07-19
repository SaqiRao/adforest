<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_cats_classic_2 extends Widget_Base {

    public function get_name() {
        return 'cats_classic2_short_base';
    }

    public function get_title() {
        return __('Categories - Classic 2','adforest-elementor');
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
                'cat_link_page', [
            'label' => __('Category link Page','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'options' => [
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Page','adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'section_bg', [
            'label' => __('Background Color','adforest-elementor'),
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
                'section_title', [
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
                'section_description', [
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
                'section_title_regular', [
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
        $this->add_control(
                'sub_limit', [
            'label' => __('Sub cats limit','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'category_section_selec1', [
            'label' => __('Categories','adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater_cat = new \Elementor\Repeater();

        $repeater_cat->add_control(
                'cat', [
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'label_block' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats','yes'),
                ]
        );
        $repeater_cat->add_control(
                'icon', [
            'label' => __('Icon','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'library' => 'solid',
            ],
                ]
        );
        $this->add_control(
                'cats', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater_cat->get_controls(),
            'title_field' => '{{{ cat }}}',
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['cat_link_page'] = isset($package_settings_fields['cat_link_page']) ? $package_settings_fields['cat_link_page']:'';
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        $adforest_render_params['sub_limit'] = isset($package_settings_fields['sub_limit']) ? $package_settings_fields['sub_limit']:'';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats']:'';

        echo cats_classic2_short_base_func($adforest_render_params);
    }

}