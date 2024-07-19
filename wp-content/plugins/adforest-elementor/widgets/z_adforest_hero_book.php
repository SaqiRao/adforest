<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_hero_book extends Widget_Base {

    public function get_name() {
        return 'adforest_hero_book';
    }

    public function get_title() {
        return __('Hero - Book Banner','adforest-elementor');
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
                ]
        );
        $this->add_control(
                'bg_image',
                [
                    'label' => __('Background Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __('Add an image of background : Recommended size (1920x946)','adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
                'button_text',
                [
                    'label' => __('Enter Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'sport_link',
                [
                    'label' => __('Button Link','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['heading_1'] = isset($package_settings_fields['heading_1']) ? $package_settings_fields['heading_1']:'';
        $adforest_render_params['heading_2'] = isset($package_settings_fields['heading_2']) ? $package_settings_fields['heading_2']:'';
        $adforest_render_params['banner_description'] = isset($package_settings_fields['banner_description']) ? $package_settings_fields['banner_description']:'';
        $adforest_render_params['bg_image'] = isset($package_settings_fields['bg_image']['id']) ? $package_settings_fields['bg_image']['id'] : '';
        $adforest_render_params['button_text'] = isset($package_settings_fields['button_text']) ? $package_settings_fields['button_text']:'';
        $adforest_render_params['sport_link'] = isset($package_settings_fields['sport_link']) ? $package_settings_fields['sport_link']:'';

        echo adforest_hero_book_callback($adforest_render_params);
    }

}
