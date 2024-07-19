<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ads_google_map_modern extends Widget_Base {

    public function get_name() {
        return 'ads_google_map_short_base';
    }

    public function get_title() {
        return __('ADs - Google Map Modern','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'ads_settings', [
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'ad_type', array(
            'label' => __('Ads Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads Type','adforest-elementor'),
                'feature' => __('Featured Ads','adforest-elementor'),
                'regular' => __('Simple Ads','adforest-elementor'),
                'both' => __('Both','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'ad_order', array(
            'label' => __('Order By','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads order','adforest-elementor'),
                'asc' => __('Oldest','adforest-elementor'),
                'desc' => __('Latest','adforest-elementor'),
                'rand' => __('Random','adforest-elementor'),
            ),
                )
        );
        $this->add_control(
                'no_of_ads', array(
            'label' => __('Number fo Ads','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 10,
            'min' => 1,
            'max' => 500,
                )
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'map', [
            'label' => esc_html__('Map','adforest-elementor'),
                ]
        );

        $this->add_control(
                'map_marker_img', array(
            'label' => __('Map Marker','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("50x77", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );

        $this->add_control(
                'map_marker_more_img', array(
            'label' => __('Map Marker Many','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("50x77", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );
        $this->add_control(
                'map_latitude', [
            'label' => __('Latitude','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );
        $this->add_control(
                'map_longitude', [
            'label' => __('Longitude','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );

        $this->add_control(
                'map_zoom', array(
            'label' => __('Map Zoom','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
            'max' => 12,
                )
        );
        
        $this->add_control(
                'map_info_address_limit', [
            'label' => __('Map infobox address limit','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            "description" => __("Characters limit should be integer value", 'adforest-elementor'),
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'ad_categories', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );

        $this->add_control(
                'cats', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats')
                )
        );
        $this->end_controls_section();
    }

    protected function render() {
        $map_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['ad_type'] = isset($map_settings_fields['ad_type']) ? $map_settings_fields['ad_type']:'';
        $adforest_render_params['ad_order'] = isset($map_settings_fields['ad_order']) ? $map_settings_fields['ad_order']:'';
        $adforest_render_params['map_marker_img'] = isset($map_settings_fields['map_marker_img']['id']) ? $map_settings_fields['map_marker_img']['id']:'';
        $adforest_render_params['map_marker_more_img'] = isset($map_settings_fields['map_marker_more_img']['id']) ? $map_settings_fields['map_marker_more_img']['id']:'';
        $adforest_render_params['map_latitude'] = isset($map_settings_fields['map_latitude']) ? $map_settings_fields['map_latitude']:'';
        $adforest_render_params['map_longitude'] = isset($map_settings_fields['map_longitude']) ? $map_settings_fields['map_longitude']:'';
        $adforest_render_params['map_zoom'] = isset($map_settings_fields['map_zoom']) ? $map_settings_fields['map_zoom']:'';
        $adforest_render_params['no_of_ads'] = isset($map_settings_fields['no_of_ads'])  ? $map_settings_fields['no_of_ads']:'';
        $adforest_render_params['map_info_address_limit'] = isset($map_settings_fields['map_info_address_limit']) ? $map_settings_fields['map_info_address_limit']:'';
        $adforest_render_params['cats'] = isset($map_settings_fields['cats']) ? $map_settings_fields['cats']:'';
        echo ads_google_map_short_base_func($adforest_render_params);
    }

}
