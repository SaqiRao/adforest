<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_hero_decoration extends Widget_Base {

    public function get_name() {
        return 'adforest_hero_decoration';
    }

    public function get_title() {
        return __('Hero - Decoration Banner','adforest-elementor');
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
                'heading_1',
                [
                    'label' => __('Heading 1','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'heading_2',
                [
                    'label' => __('Heading 2','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'banner_description',
                [
                    'label' => __('Description','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'description' => 'Enter banner description here .',
                ]
        );
        $this->add_control(
                'bg_image',
                [
                    'label' => __('Background Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __('Add an image of background : Recommended size (1920x700)','adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
                'categories_section', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
        $repeater123 = new \Elementor\Repeater();

        $repeater123->add_control(
                'cat',
                [
                    'label' => __('Select Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    "description" => __("Category", 'adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
        $repeater123->add_control(
                'img',
                [
                    'label' => __('Category Image : Recommended size (32 X 32)','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __('32 X 32','adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater123->get_controls(),
                    'title_field' => '{{{ cat }}}',
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['heading_1'] = isset( $package_settings_fields['heading_1']) ? $package_settings_fields['heading_1']:'';
        $adforest_render_params['heading_2'] = isset($package_settings_fields['heading_2']) ? $package_settings_fields['heading_2']:'';
        $adforest_render_params['banner_description'] = isset($package_settings_fields['banner_description']) ? $package_settings_fields['banner_description']:'';
        $adforest_render_params['bg_image'] = isset($package_settings_fields['bg_image']['id']) ? $package_settings_fields['bg_image']['id'] : '';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats']:'';


        echo adforest_hero_decoration_callback($adforest_render_params);
    }

}
