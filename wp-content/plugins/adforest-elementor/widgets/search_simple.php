<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_search_simple extends Widget_Base {

    public function get_name() {
        return 'search_simple_short_base';
    }

    public function get_title() {
        return __('Search - Simple','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic_settings', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );

        $this->add_control(
                'bg_img', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("1280x800", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                    "description" => "%count% " . __( "for total ads", 'adforest-elementor' ),
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_tag_line', [
            'label' => __('Section Tagline','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['bg_img'] = isset($search_settings_fields['bg_img']['id']) && $search_settings_fields['bg_img']['id'] != '' ? $search_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['section_title'] = isset($search_settings_fields['section_title']) ? $search_settings_fields['section_title']:'';

        $adforest_render_params['section_tag_line'] = isset($search_settings_fields['section_tag_line']) ? $search_settings_fields['section_tag_line']:'';

        echo search_simple_short_base_func($adforest_render_params);
    }

}
