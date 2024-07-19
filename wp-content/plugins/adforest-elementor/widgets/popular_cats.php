<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_popular_cats extends Widget_Base {

    public function get_name() {
        return 'popular_cats_short_base';
    }

    public function get_title() {
        return __('Popular - Categories','adforest-elementor');
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
                'bg_img', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
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
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
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
        
        $popular_cats_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['bg_img'] = isset($popular_cats_settings_fields['bg_img']['id']) ? $popular_cats_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['section_title'] = isset($popular_cats_settings_fields['section_title']) ? $popular_cats_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($popular_cats_settings_fields['section_description']) ? $popular_cats_settings_fields['section_description']:'';
        //
        $adforest_render_params['cats'] = isset($popular_cats_settings_fields['cats_classic']) ? $popular_cats_settings_fields['cats_classic']:'';
        echo popular_cats_short_base_func($adforest_render_params);
        
    }

}
