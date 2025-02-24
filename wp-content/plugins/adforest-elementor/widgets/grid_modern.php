<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_grid_modern extends Widget_Base {

    public function get_name() {
        return 'grid_modern_type_short_base';
    }

    public function get_title() {
        return __('Cats , ads , sidebar', 'adforest-elementor');
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
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_bg', array(
            'label' => __('Background', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White', 'adforest-elementor'),
                'bg-gray' => __('Gray', 'adforest-elementor'),
            ),
                )
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'ad_category1', [
            'label' => esc_html__('Categories', 'adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'show_cat',
                [
                    'label' => __('Show Category', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'hide',
                    'options' => [
                        'show' => __('Show', 'adforest-elementor'),
                        'hide' => __('hide', 'adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'cat_section_title', [
            'label' => __('Category Section Title', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'show_cat',
                        'operator' => 'in',
                        'value' => [
                            'show',
                        ],
                    ],
                ],
            ],
                ]
        );
        $repeater22 = new \Elementor\Repeater();
        $repeater22->add_control(
                'cat', [
            'label' => __('Select Category ( Selective )', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
        $repeater22->add_control(
                'img', [
            'label' => __('Category Image', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'description' => __('100x100', 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->add_control(
                'cats_round', [
            'label' => '',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater22->get_controls(),
            'title_field' => '{{{ cat }}}',
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'show_cat',
                        'operator' => 'in',
                        'value' => [
                            'show',
                        ],
                    ],
                ],
            ],
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'ad_settings', [
            'label' => esc_html__('Ads Settings', 'adforest-elementor'),
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
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'section_desc', [
            'label' => __('Ads Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'ad_type', [
            'label' => __('Ads Type', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'description' => __('Select Ads Type', 'adforest-elementor'),
            'options' => [
                'feature' => __('Featured Ads', 'adforest-elementor'),
                'regular' => __('Simple Ads', 'adforest-elementor'),
                'both' => __('Both', 'adforest-elementor'),
            ],
                ]
        );
        $this->add_control(
                'ad_order', [
            'label' => __('Order By', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            //'multiple' => true,
            'description' => __('Select Ads order', 'adforest-elementor'),
            'options' => [
                'asc' => __('Oldest', 'adforest-elementor'),
                'desc' => __('Latest', 'adforest-elementor'),
                'rand' => __('Random', 'adforest-elementor'),
            ],
                ]
        );

        $this->add_control(
                'no_of_ads', [
            'label' => __('Number fo Ads to display', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
                ]
        );
        $this->add_control(
                'link_title', [
            'label' => __('Link Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Link Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'view_all', [
            'label' => __('View all button link', 'adforest-elementor'),
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
                'category', [
            'label' => esc_html__('Categories for ads', 'adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'cats', [
            'label' => __('Select Category ( Selective )', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', '', 1),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['cat_link_page'] = isset($atts['cat_link_page']) ? $atts['cat_link_page'] : "";
        $params['show_cat'] = isset($atts['show_cat']) ? $atts['show_cat'] : "";
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['section_tagline'] = isset($atts['section_tagline']) ? $atts['section_tagline'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_desc'] = isset($atts['section_desc']) ? $atts['section_desc'] : "";
        $params['ad_type'] = isset($atts['ad_type']) ? $atts['ad_type'] : "";    
        $params['link_title'] = isset($atts['link_title']) ? $atts['link_title'] : "";
        $params['main_link'] = isset($atts['main_link']) ? $atts['main_link'] : "";
        $params['ad_order'] = isset($atts['ad_order']) ? $atts['ad_order'] : "";
        $params['no_of_ads'] = isset($atts['no_of_ads']) ? $atts['no_of_ads'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";
        $params['view_all'] = isset($atts['view_all']) ? $atts['view_all'] : "";
        $params['cat_section_title'] = isset($atts['cat_section_title']) ? $atts['cat_section_title'] : "";
        $params['cats_round'] = isset($atts['cats_round']) ? $atts['cats_round'] : "";
       
        if(function_exists('grid_modern_type_short_base_func')){
        echo grid_modern_type_short_base_func($params);
    }
    }
}
