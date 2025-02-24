<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_ads_slider_modern2 extends Widget_Base {

    public function get_name() {
        return 'ads_short_slider2_base';
    }

    public function get_title() {
        return __('ADs - Slider Box','adforest-elementor');
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
                'section_bg', array(
            'label' => __('Background','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White','adforest-elementor'),
                'gray' => __('Gray','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('No Header','adforest-elementor'),
                'regular' => __('Regular','adforest-elementor'),
            ),
                )
        );

        
        $this->add_control(
                'section_title_regular', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'header_style',
                        'operator' => 'in',
                        'value' => [
                            'regular',
                        ],
                    ],
                ],
            ],
                ]
        );

        $this->end_controls_section();


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
                'layout_type', array(
            'label' => __('Layout Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => apply_filters('adforest_elementor_ads_styles', array()),
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
        $ads_slider_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($ads_slider_settings_fields['section_bg']) ? $ads_slider_settings_fields['section_bg']:'';
        $adforest_render_params['header_style'] = isset($ads_slider_settings_fields['header_style']) ? $ads_slider_settings_fields['header_style']:'';
        $adforest_render_params['section_title_regular'] = isset($ads_slider_settings_fields['section_title_regular']) ? $ads_slider_settings_fields['section_title_regular']:'';
        // ads settings
        $adforest_render_params['ad_type'] = isset($ads_slider_settings_fields['ad_type']) ? $ads_slider_settings_fields['ad_type']:'';
        $adforest_render_params['ad_order'] = isset($ads_slider_settings_fields['ad_order']) ? $ads_slider_settings_fields['ad_order']:'';
        $adforest_render_params['layout_type'] = isset($ads_slider_settings_fields['layout_type']) ? $ads_slider_settings_fields['layout_type']:'';
        $adforest_render_params['no_of_ads'] = isset($ads_slider_settings_fields['no_of_ads']) ? $ads_slider_settings_fields['no_of_ads']:'';
        //cats
        $adforest_render_params['cats'] = isset($ads_slider_settings_fields['cats']) ? $ads_slider_settings_fields['cats']:'';

        if(function_exists('ads_short_slider2_base_func')){
        echo ads_short_slider2_base_func($adforest_render_params);
        }

    }

}