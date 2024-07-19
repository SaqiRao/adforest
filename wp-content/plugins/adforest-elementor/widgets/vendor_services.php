<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_Vendor_Services extends Widget_Base {

    public function get_name() {
        return 'vendor_services_short_base';
    }

    public function get_title() {
        return __('Adforest - Vendor Services', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {
        /*
         * Services
         */
        $this->start_controls_section(
                'vendor_services_sec', [
            'label' => esc_html__('Services', 'adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'vservice_icon_img', array(
            'label' => __('Icon Image', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("40x40", 'adforest-elementor'),
                )
        );
        $repeater->add_control(
                'vservice_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '#',
                ]
        );
        $repeater->add_control(
                'vservice_desc', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => '#',
                ]
        );
        $this->add_control(
                'vendor_services',
                [
                    'label' => __('Banner Left and Right Image', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'vservice_title' => '',
                            'vservice_desc' => '',
                            'vservice_icon_img' => '',
                        ],
                    ],
                ]
        );
        $this->end_controls_section();
        //===============
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['vservice_icon_img'] = isset($atts['vservice_icon_img']) ? $atts['vservice_icon_img'] : "";
        $params['vservice_title'] = isset($atts['vservice_title']) ? $atts['vservice_title'] : "";
        $params['vservice_desc'] = isset($atts['vservice_desc']) ? $atts['vservice_desc'] : "";
        $params['vendor_services'] = isset($atts['vendor_services']) ? $atts['vendor_services'] : "";     
        echo adforest_vendor_services_func($params);
    }

}
