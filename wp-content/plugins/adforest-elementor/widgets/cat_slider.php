<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_cat_slider extends Widget_Base {

    public function get_name() {
        return 'grid_modern_typesss_short_base';
    }

    public function get_title() {
        return __('Cat Image slider', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'ad_category1', [
            'label' => esc_html__('Categories', 'adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['cats_round'] = isset($atts['cats_round']) ? $atts['cats_round'] : array();

        echo ads_cats_slider_short_base_func($params);
    }

}
