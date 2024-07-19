<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_blog extends Widget_Base {

    public function get_name() {
        return 'blog_short_base';
    }

    public function get_title() {
        return __('Blog Posts', 'adforest-elementor');
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
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('No Header','adforest-elementor'),
                'classic' => __('Classic','adforest-elementor'),
                'regular' => __('Regular','adforest-elementor'),
                'fancy' => __('Fancy','adforest-elementor'),
                'new' => __('New','adforest-elementor'),
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
                            'new'
                        ],
                    ],
                ],
            ],
                ]
        );
         $this->add_control(
                'section_tagline', [
            'label' => __('Section tagline','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section tagline','adforest-elementor'),
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
                'section_title_fancy', [
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
                            'fancy',
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
                'title_limit', array(
            'label' => __('Title limit', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => __(20, 'adforest-elementor'),
            'min' => 10,
            'step'=> 5,
            'max' => 200,
                )
        );

        $this->add_control(
                'max_limit', array(
            'label' => __('Number fo Posts', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => __('3', 'adforest-elementor'),
            'min' => 1,
            'max' => 500,
                )
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'ad_categories', [
            'label' => esc_html__('Categories', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'cats', array(
            'label' => __('Select Category', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'category', 'no')
                )
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['section_tagline'] = isset($atts['section_tagline']) ? $atts['section_tagline'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : array();
        $params['max_limit'] = isset($atts['max_limit']) ? $atts['max_limit'] : "";  

        $params['max_limit'] = isset($atts['max_limit']) ? $atts['max_limit'] : "";  
        $params['section_title_regular'] = isset($atts['section_title_regular']) ? $atts['section_title_regular'] : "";  
         $params['header_style'] = isset($atts['header_style']) ? $atts['header_style'] : "";
           $params['title_limit'] = isset($atts['title_limit']) ? $atts['title_limit'] : "";  




        

        if(function_exists('apps_modern_short_base_func')){  
        echo blog_short_base_func($params);
      }

 }
}
