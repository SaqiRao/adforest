<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_contact_info extends Widget_Base {

    public function get_name() {
        return 'adforest_contactinfo';
    }

    public function get_title() {
        return __('Adforest Contact Info','adforest-elementor');
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
                'info_title',
                [
                    'label' => __('Info Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __('Enter contact information title here .','adforest-elementor'),
                ]
        );
        $this->add_control(
                'info_description',
                [
                    'label' => __('Info Description','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    "description" => __('Enter contact information description here .','adforest-elementor'),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'Information_section', [
            'label' => esc_html__('Information','adforest-elementor'),
                ]
        );
        $repeater123 = new \Elementor\Repeater();
        $repeater123->add_control(
                'contact_image',
                [
                    'label' => __('Contact Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __('Add an image of contact : Recommended size (64x64)','adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $repeater123->add_control(
                'contact_title',
                [
                    'label' => __('Contact Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater123->add_control(
                'contact_detail',
                [
                    'label' => __('Contact Detail','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'contact_info_deatail',
                [
                    'label' => __('Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater123->get_controls(),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['info_title'] = isset($package_settings_fields['info_title']) ? $package_settings_fields['info_title']:'';
        $adforest_render_params['info_description'] = isset($package_settings_fields['info_description']) ? $package_settings_fields['info_description']:'';
        $adforest_render_params['contact_info_deatail'] = isset($package_settings_fields['contact_info_deatail']) ? $package_settings_fields['contact_info_deatail']:'';

        echo adforest_contactinfo_callback($adforest_render_params);
    }

}
