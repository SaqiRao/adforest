<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_partners extends Widget_Base {

    public function get_name() {
        return 'client_partner_short_base';
    }

    public function get_title() {
        return __('Clients or Partners', 'adforest-elementor');
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
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White', 'adforest-elementor'),
                'bg-gray' => __('Gray', 'adforest-elementor'),
            ),
                )
        );

        $adforest_elementor_repetor = new \Elementor\Repeater();
        $adforest_elementor_repetor->add_control(
                'link', [
            'label' => __('URL or Link', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );

        $adforest_elementor_repetor->add_control(
                'logo', array(
            'label' => __('Logo', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("320x150", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );

        $this->add_control(
                'clients', [
            'label' => __('Add Client', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $adforest_elementor_repetor->get_controls(),
            'default' => [],
            'title_field' => '{{{link}}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['clients'] = isset($atts['clients']) ? $atts['clients'] : "";
        echo partners_short_base_func($params);
    }

}
