<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_call_to_action extends Widget_Base {

    public function get_name() {
        return 'call_to_action_short_base';
    }

    public function get_title() {
        return __('Call to Action','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'general_call', [
            'label' => esc_html__('General','adforest-elementor'),
                ]
        );
        
        $this->add_control(
                'bg_img', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("1280x800", 'adforest-elementor'),
                )
        );

        $this->add_control(
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
                'title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 5,
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
                'link', [
            'label' => __('Read More Link','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => __('https://your-link.com','adforest-elementor'),
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
        $calltoaction_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = TRUE;
        $adforest_render_params['bg_img'] = isset($calltoaction_settings_fields['bg_img']['id']) ? $calltoaction_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['icon'] = isset($calltoaction_settings_fields['icon']) ? $calltoaction_settings_fields['icon']:'';
        $adforest_render_params['title'] = isset($calltoaction_settings_fields['title']) ? $calltoaction_settings_fields['title']:'';
        $adforest_render_params['description'] = isset($calltoaction_settings_fields['description']) ? $calltoaction_settings_fields['description']:'';
        $adforest_render_params['link_title'] = isset($calltoaction_settings_fields['link_title']) ? $calltoaction_settings_fields['link_title']:'';
        $adforest_render_params['link'] = isset($calltoaction_settings_fields['link']) ? $calltoaction_settings_fields['link']:'';
        echo call_to_action_short_base_func($adforest_render_params);
    }

}
