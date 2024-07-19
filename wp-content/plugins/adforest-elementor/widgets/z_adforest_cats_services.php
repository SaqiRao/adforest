<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_cats_services extends Widget_Base {

    public function get_name() {
        return 'adforest_cats_services_short_base';
    }

    public function get_title() {
        return __('Categories - Srevices','adforest-elementor');
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
                'cat_link_page',
                [
                    'label' => __('Category link Page','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'description' => __('Choose Header Style','adforest-elementor'),
                    'options' => [
                        'search' => __('Search Page','adforest-elementor'),
                        'category' => __('Category Page','adforest-elementor')
                    ],
                ]
        );
        $this->add_control(
                'section_bg',
                [
                    'label' => __('Background Color', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    "description" => __("Select background color", 'adforest-elementor'),
                    'options' => [
                        '' => __('White', 'adforest-elementor'),
                        'gray' => __('Gray', 'adforest-elementor'),
                    ],
                ]
        );
          $this->add_control(
                'section_tagline', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
                   
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                  
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'categories_section', [
            'label' => esc_html__('Categories_section','adforest-elementor'),
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
                    'label' => __('Category Image : Recommended size (40x46)"','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __('94x90','adforest-elementor'),
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
        $adforest_render_params['cat_link_page'] = isset($package_settings_fields['cat_link_page']) ? $package_settings_fields['cat_link_page']:'';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats']:'';


        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';

        echo adforest_cats_services_short_base_func($adforest_render_params);
    }

}
