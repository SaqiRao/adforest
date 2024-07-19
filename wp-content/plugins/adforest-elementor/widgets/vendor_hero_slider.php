<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_Vendor_Hero_Slider extends Widget_Base {

    public function get_name() {
        return 'vendor_hero_short_base';
    }

    public function get_title() {
        return __('Adforest - Vendor Hero', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {
        /*
         * Hero slider
         */
        $this->start_controls_section(
                'vendor_slides_sec', [
            'label' => esc_html__('Slider Settings', 'adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'slider_signature_image', array(
            'label' => __('Signature Image', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("322 X 56", 'adforest-elementor'),
                )
        );

        $this->add_control(
                'product_title', [
            'label' => __('Product Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );
        $this->add_control(
                'product_reg_prie', [
            'label' => __('Product Reguler price', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );
        $this->add_control(
                'product_sale_price', [
            'label' => __('Product Sale Price', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );
        $this->add_control(
                'link_title', [
            'label' => __('Button Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );
        $this->add_control(
                'main_link', [
            'label' => __('Button Link', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => '',
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => true,
                'nofollow' => true,
            ],
                ]
        );

        $this->add_control(
                'woo_products', array(
            'label' => __('Select Products', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => 'all',
            'placeholder' => 'Select Options',
            'options' => apply_filters('adforest_elementor_get_packages', 'products'),
                )
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params['adforest_elementor'] = true;
        $params['vendor_slides_sec'] = isset($atts['vendor_slides_sec']) ? $atts['vendor_slides_sec'] : "";
        $params['slider_signature_image'] = isset($atts['slider_signature_image']) ? $atts['slider_signature_image'] : "";
        $params['product_title'] = isset($atts['product_title']) ? $atts['product_title'] : "";
        $params['product_reg_prie'] = isset($atts['product_reg_prie']) ? $atts['product_reg_prie'] : "";
        $params['product_sale_price'] = isset($atts['product_sale_price']) ? $atts['product_sale_price'] : "";
        $params['link_title'] = isset($atts['link_title']) ? $atts['link_title'] : "";
        $params['main_link'] = isset($atts['main_link']) ? $atts['main_link'] : "";
        $params['woo_products'] = isset($atts['woo_products']) ? $atts['woo_products'] : "";
        echo vendor_hero_1_short_base_func($params);
    }

}
