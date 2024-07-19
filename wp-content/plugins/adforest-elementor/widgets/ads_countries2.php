<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ads_countries2 extends Widget_Base {

    public function get_name() {
        return 'location_short_base2';
    }

    public function get_title() {
        return __('Custom Locations 2', 'adforest-elementor');
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
                'cat_link_page',
                [
                    'label' => __('Category link Page', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    'options' => [
                        'search' => __('Search Page', 'adforest-elementor'),
                        'category' => __('Category Page', 'adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'section_bg',
                [
                    'label' => __('Background Color', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    "description" => __("Select background color", 'adforest-elementor'),
                    'options' => [
                        '' => __('White', 'adforest-elementor'),
                        'gray' => __('Gray', 'adforest-elementor'),
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
                        'regular' => __('Regular','adforest-elementor'),
                         'new' => __('New','adforest-elementor')

                    ],
                ]
        );
        $this->add_control(
                'section_tagline', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'conditions' => [
                        'terms' => [
                            [
                                'name' => 'header_style',
                                'operator' => 'in',
                                'value' => [
                                    
                                    'new'
                                ],
                            ],
                        ],
                    ],
                ]
        );

        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'header_style',
                                'operator' => 'in',
                                'value' => [
                                    'classic',
                                    'new'
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                       'conditions' => [
                        'terms' => [
                            [
                                'name' => 'header_style',
                                'operator' => 'in',
                                'value' => [
                                    'classic',
                                    'new'
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
                'select_locations111',
                [
                    'label' => __('Locations', 'adforest-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater_country = new \Elementor\Repeater();

        $repeater_country->add_control(
                'name', [
            'label' => __('Select Locations', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'label_block' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country'),
                ]
        );

        $repeater_country->add_control(
                'img',
                [
                    'label' => __('Location Background Image', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __("Recommended size 250x160", 'adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
                'select_locations',
                [
                    'label' => __('Select Locations', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater_country->get_controls(),
                    'title_field' => '{{{ name }}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['cat_link_page'] = isset($atts['cat_link_page']) ? $atts['cat_link_page'] : "search";
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['section_tagline'] = isset($atts['section_tagline']) ? $atts['section_tagline'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['select_locations'] = isset($atts['select_locations']) ? $atts['select_locations'] : "";

$params['header_style'] = isset($atts['header_style']) ? $atts['header_style'] : "";



 if(function_exists('location_short_base_func')){
     echo   location_short_base_func($params);
 }
    }

}
