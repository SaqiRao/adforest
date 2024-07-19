<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_clouds extends Widget_Base {

    public function get_name() {
        return 'clouds_short_base';
    }

    public function get_title() {
        return __('Hero - Clouds','adforest-elementor');
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
                'bg_img',
                [
                    'label' => __('Background Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __("1280x800", 'adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __("For bold the text", 'adforest-elementor'),
                    'placeholder' => __('<strong>Your text</strong> and %count% for total ads.','adforest-elementor'),
                ]
        );
        $this->add_control(
                'search_btn_text',
                [
                    'label' => __('Search Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'ad_btn_text',
                [
                    'label' => __('Ad post Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
         // basic 
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['search_btn_text'] = isset($package_settings_fields['search_btn_text']) ? $package_settings_fields['search_btn_text']:'';
        $adforest_render_params['ad_btn_text'] = isset($package_settings_fields['ad_btn_text']) ? $package_settings_fields['ad_btn_text']:'';

        echo clouds_short_base_func($adforest_render_params);
    }

}