<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_cats_1 extends Widget_Base {

    public function get_name() {
        return 'cats_1_short_base';
    }

    public function get_title() {
        return __('Categories - 1','adforest-elementor');
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
                'section_bg', [
            'label' => __('Section Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("1920x474", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
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
                'bg_color', [
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
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" => __("For color {color}warp text within this tag{/color}", 'adforest-elementor'),
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
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
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
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']['id']) ? $package_settings_fields['section_bg']['id'] : '';
        $adforest_render_params['cat_link_page'] = isset($package_settings_fields['cat_link_page']) ? $package_settings_fields['cat_link_page']:'';
        $adforest_render_params['bg_color'] = isset($package_settings_fields['bg_color']) ? $package_settings_fields['bg_color']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats']:'';
        echo cats_1_short_base_func($adforest_render_params);
    }

}