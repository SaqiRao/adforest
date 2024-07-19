<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_brands extends Widget_Base {

    public function get_name() {
        return 'adforest_brands';
    }

    public function get_title() {
        return __('Adforest Brands','adforest-elementor');
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
                'section_bg',
                [
                    'label' => __('Background Color','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    "description" => __("Select background color", 'adforest-elementor'),
                    'options' => [
                        '' => __('White','adforest-elementor'),
                        'gray' => __('Gray','adforest-elementor'),
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
                'ad_title',
                [
                    'label' => __('Ads Head Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'ad_type',
                [
                    'label' => __('Ads Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    "description" => __("Select Ads Type", 'adforest-elementor'),
                    'options' => [
                        'feature' => __('Featured Ads','adforest-elementor'),
                        'regular' => __('Simple Ads','adforest-elementor'),
                        'both' => __('Both','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'ad_order',
                [
                    'label' => __('Order By','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    // 'multiple' => true,
                    "description" => __("Select Ads order", 'adforest-elementor'),
                    'options' => [
                        'asc' => __('Oldest','adforest-elementor'),
                        'desc' => __('Latest','adforest-elementor'),
                        'rand' => __('Random','adforest-elementor'),
                    ],
                ]
        );

        $this->add_control(
                'no_of_ads',
                [
                    'label' => __('Number of Ads for each category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 500,
                    'step' => 1,
                    'default' => 1,
                ]
        );
        $this->add_control(
                'more_add_text',
                [
                    'label' => __('Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'more_add_link',
                [
                    'label' => __('More ads Link','adforest-elementor'),
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
        $this->start_controls_section(
                'banners_settings', [
            'label' => esc_html__('Banner Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'brands_banner_code',
                [
                    'label' => __('Banner Code','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    "description" => __("Recommended banner size (750x56)", "adforest-elementor"),
                ]
        );
        $this->add_control(
                'banner_place',
                [
                    'label' => __('Banner Place','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        '' => __('None','adforest-elementor'),
                        'top' => __('Top','adforest-elementor'),
                        'bottom' => __('Bottom','adforest-elementor'),
                    ],
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'brands_settings', [
            'label' => esc_html__('Brand Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'brand_title',
                [
                    'label' => __('Brand Head Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'brand_button_text',
                [
                    'label' => __('Button Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'brand_all_link',
                [
                    'label' => __('View All Brands Link','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        );
        $this->add_control(
                'brand_all_link_text',
                [
                    'label' => __('All Brands Link Text','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'brand_image',
                [
                    'label' => __('Brand Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __("Add an image of brand: Recommended size (150 X 110)", "adforest-elementor"),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $repeater->add_control(
                'image_link',
                [
                    'label' => __('Image Link','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'brand_images',
                [
                    'label' => __('Add Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();

        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['ad_title'] = isset($package_settings_fields['ad_title']) ? $package_settings_fields['ad_title'] : '';
        $adforest_render_params['ad_type'] = isset($package_settings_fields['ad_type']) ? $package_settings_fields['ad_type'] : '';
        $adforest_render_params['ad_order'] = isset($package_settings_fields['ad_order']) ? $package_settings_fields['ad_order'] : '';
        $adforest_render_params['no_of_ads'] = isset($package_settings_fields['no_of_ads']) ? $package_settings_fields['no_of_ads'] : '';
        $adforest_render_params['more_add_text'] = isset($package_settings_fields['more_add_text']) ? $package_settings_fields['more_add_text'] : '';
        $adforest_render_params['more_add_link'] = isset($package_settings_fields['more_add_link']) ? $package_settings_fields['more_add_link'] : '';
        $adforest_render_params['brands_banner_code'] = isset($package_settings_fields['brands_banner_code']) ? $package_settings_fields['brands_banner_code'] : '';
        $adforest_render_params['banner_place'] = isset($package_settings_fields['banner_place']) ? $package_settings_fields['banner_place'] : '';
        $adforest_render_params['brand_title'] = isset($package_settings_fields['brand_title']) ? $package_settings_fields['brand_title'] : '';
        $adforest_render_params['brand_button_text'] = isset($package_settings_fields['brand_button_text']) ? $package_settings_fields['brand_button_text'] : '';
        $adforest_render_params['brand_button_text'] = isset($package_settings_fields['brand_button_text']) ? $package_settings_fields['brand_button_text'] : '';
        $adforest_render_params['brand_all_link'] = isset($package_settings_fields['brand_all_link']) ? $package_settings_fields['brand_all_link'] : '';
        $adforest_render_params['brand_all_link_text'] = isset($package_settings_fields['brand_all_link_text']) ? $package_settings_fields['brand_all_link_text'] : '';
        $adforest_render_params['brand_images'] = isset($package_settings_fields['brand_images']) ? $package_settings_fields['brand_images'] : '';

        echo adforest_brands_callback($adforest_render_params);
    }

}
