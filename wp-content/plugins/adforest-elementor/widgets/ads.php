<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ads extends Widget_Base {

    public function get_name() {
        return 'ads_short_base';
    }

    public function get_title() {
        return __('ADs','adforest-elementor');
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
            'label' => __('Read More Link','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => '',
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
                'ads_settings', [
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );

        $this->add_control(
                'ad_type', array(
            'label' => __('Ads Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads Type','adforest-elementor'),
                'feature' => __('Featured Ads','adforest-elementor'),
                'regular' => __('Simple Ads','adforest-elementor'),
                'both' => __('Both','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'ad_order', array(
            'label' => __('Order By','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads order','adforest-elementor'),
                'asc' => __('Oldest','adforest-elementor'),
                'desc' => __('Latest','adforest-elementor'),
                'rand' => __('Random','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'layout_type', array(
            'label' => __('Layout Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,

            'options' => apply_filters('adforest_elementor_ads_styles', array()),

                )
        );

        $this->add_control(
                'no_of_ads', array(
            'label' => __('Number fo Ads','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 10,
            'min' => 1,
            'max' => 500,
                )
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'ad_categories', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );

        $this->add_control(
                'cats', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats','yes')
                )
        );
        $this->end_controls_section();
        
        
    }

    protected function render() {
        $ads_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['section_bg'] = isset($ads_settings_fields['section_bg']) ? $ads_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($ads_settings_fields['bg_img']['id']) ? $ads_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($ads_settings_fields['header_style']) ? $ads_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($ads_settings_fields['section_title']) ? $ads_settings_fields['section_title']:'';
        $adforest_render_params['section_title_regular'] = isset($ads_settings_fields['section_title_regular']) ? $ads_settings_fields['section_title_regular']:'';
        $adforest_render_params['section_description'] = isset($ads_settings_fields['section_description']) ? $ads_settings_fields['section_description']:'';
        $adforest_render_params['main_link'] = isset($ads_settings_fields['main_link']) ? ($ads_settings_fields['main_link']):'';
        $adforest_render_params['link_title'] = isset($ads_settings_fields['link_title']) ? ($ads_settings_fields['link_title']):'';
         // ads settings
        $adforest_render_params['ad_type'] = isset($ads_settings_fields['ad_type']) ? $ads_settings_fields['ad_type']:'';
        $adforest_render_params['ad_order'] = isset($ads_settings_fields['ad_order']) ? $ads_settings_fields['ad_order']:'';
        $adforest_render_params['layout_type'] = isset($ads_settings_fields['layout_type']) ? $ads_settings_fields['layout_type']:'';
        $adforest_render_params['no_of_ads'] = isset($ads_settings_fields['no_of_ads']) ? $ads_settings_fields['no_of_ads']:'';
        //cats
        $adforest_render_params['cats'] = isset($ads_settings_fields['cats']) ? $ads_settings_fields['cats']:'';
        

        if(function_exists('ads_short_base_func')){

         echo ads_short_base_func($adforest_render_params);
         
         }
        
    }

}
