<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_Vendor_Grid extends Widget_Base {

    public function get_name() {
        return 'shop_vendor_grid_base';
    }

    public function get_title() {
        return __('Adforest - Vendor Grid', 'adforest-elementor');
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
                'section_title_category', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'woo_products', array(
            'label' => __('Select Category', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => 'all',
            'placeholder' => 'Select Options',
            'options' => apply_filters('adforest_elementor_get_product_categories', 'product_cat'),
                )
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'vendor_settings', [
            'label' => esc_html__('Vendor Setting', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_title_vendor', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );
        $this->add_control(
                'no_of_vendors',
                [
                    'label' => __('Number fo Vendors', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 4,
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $atts = $this->get_settings_for_display();
        $params['adforest_elementor'] = true;
        $params['section_title_category'] = isset($atts['section_title_category']) ? $atts['section_title_category'] : "";
        $params['woo_products'] = isset($atts['woo_products']) ? $atts['woo_products'] : "";
        $params['section_title_vendor'] = isset($atts['section_title_vendor']) ? $atts['section_title_vendor'] : "";
        $params['no_of_vendors'] = isset($atts['no_of_vendors']) ? $atts['no_of_vendors'] : "";

        echo vendro_grid_base_func($params);
    }

}
