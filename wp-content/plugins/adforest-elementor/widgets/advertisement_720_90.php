<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_advertisement_720_90 extends Widget_Base {

    public function get_name() {
        return 'ad_720_short_base';
    }

    public function get_title() {
        return __('Advertisement','adforest-elementor');
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
                'advertisement', [
            'label' => esc_html__('Advertisement','adforest-elementor'),
                ]
        );
       
        $this->add_control(
			'ad_720_90',
			[
				'label' => __('Banner Ad 720x90','adforest-elementor'),
				'type' => \Elementor\Controls_Manager::CODE,
				'language' => 'html',
				'rows' => 20,
			]
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
        $adforest_render_params['ad_720_90'] = isset($ads_settings_fields['ad_720_90']) ? $ads_settings_fields['ad_720_90']:'';

         if(function_exists('ad_720_short_base_func')){
        echo ad_720_short_base_func($adforest_render_params);
         }
    }

}
