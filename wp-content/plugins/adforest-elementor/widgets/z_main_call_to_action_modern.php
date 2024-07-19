<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_main_call_to_action_modern extends Widget_Base {

    public function get_name() {
        return 'adforest_main_call_to_action_modern';
    }

    public function get_title() {
        return __('Main Section - Call To Action Modern','adforest-elementor');
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
                'main_quote', [
            'label' => __('Section Quote Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_subtitle', [
            'label' => __('Section Subtitle','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            'description' => __('For color','adforest-elementor') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag','adforest-elementor') . '<strong>' . esc_html('{/color}') . '</strong>',
                ]
        );

        $this->add_control(
                'section_desc', [
            'label' => __('Section Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $this->add_control(
                'block_text', [
            'label' => __('Search Block Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
                ]
        );



        $this->add_control(
                'section_btn_1', [
            'label' => __('Button 1 Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_btn_1_url', [
            'label' => __('Button 1 URL','adforest-elementor'),
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

        $this->add_control(
                'section_btn_2', [
            'label' => __('Button 2 Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_btn_2_url', [
            'label' => __('Button 2 URL','adforest-elementor'),
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




        $this->add_control(
                'section_content_bg', array(
            'label' => __('Content Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Background image behind the content.','adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'categories', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );

        $this->add_control(
                'cats', [
            'label' => __('Select Category ( All or Selective )','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'placeholder' => 'Select Options',
            'default' => 'g_locations',
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes'),
                ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
                'custom_location', [
            'label' => esc_html__('Custom Locations','adforest-elementor'),
                ]
        );


        $this->add_control(
                'location_type', [
            'label' => __('Location type','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => 'g_locations',
            //'multiple'=>true,
            'options' => [
                'g_locations' => __('Google','adforest-elementor'),
                'custom_locations' => __('Custom Location','adforest-elementor'),
            ],
                ]
        );



        $this->add_control(
                'location', [
            'label' => __('Custom Locations','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => '',
            'description' =>'',
            'title' => __('Section Title','adforest-elementor'),
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country', 'yes'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'location_type',
                        'operator' => 'in',
                        'value' => [
                            'custom_locations',
                        ],
                    ],
                ],
            ],
                ]
        );



        $this->end_controls_section();


        $this->start_controls_section(
                'search_type', [
            'label' => esc_html__('Search Type','adforest-elementor'),
                ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
                'type', [
            'label' => __('Select Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            //'multiple'=>true,		
            'default' =>'',
            'description' =>'',
            'title' => __('Section Title','adforest-elementor'),
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_type'),
                ]
        );

        $repeater->add_control(
                'image', [
            'label' => __('Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'description' => __('select icon image (50pxX50px)','adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->add_control(
                'select_type', [
            'label' => __('Select Type.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ type }}}',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;

        $adforest_render_params['main_quote'] = isset($package_settings_fields['main_quote']) ? $package_settings_fields['main_quote'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_subtitle'] = isset($package_settings_fields['section_subtitle']) ? $package_settings_fields['section_subtitle'] : '';
        $adforest_render_params['section_desc'] = isset($package_settings_fields['section_desc']) ? $package_settings_fields['section_desc'] : '';
        $adforest_render_params['block_text'] = isset($package_settings_fields['block_text']) ? $package_settings_fields['block_text'] : '';
        $adforest_render_params['section_video'] = isset($package_settings_fields['section_video']) ? $package_settings_fields['section_video'] : '';

        $adforest_render_params['link_title_1'] = isset($package_settings_fields['section_btn_1']) ? $package_settings_fields['section_btn_1'] : '';
        $adforest_render_params['section_btn_1'] = isset($package_settings_fields['section_btn_1_url']) ? $package_settings_fields['section_btn_1_url'] : '';

        $adforest_render_params['link_title_2'] = isset($package_settings_fields['section_btn_2']) ? $package_settings_fields['section_btn_2'] : '';
        $adforest_render_params['section_btn_2'] = isset($package_settings_fields['section_btn_2_url']) ? $package_settings_fields['section_btn_2_url'] : '';

        $adforest_render_params['section_content_bg'] = isset($package_settings_fields['section_content_bg']['id']) ? $package_settings_fields['section_content_bg']['id'] : '';
        $adforest_render_params['side_bg'] = isset($package_settings_fields['side_bg']['id']) ? $package_settings_fields['side_bg']['id'] : '';

        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats'] : '';

        $adforest_render_params['locations'] = isset($package_settings_fields['location']) ? $package_settings_fields['location'] : '';
        $adforest_render_params['location_type'] = isset($package_settings_fields['location_type']) ? $package_settings_fields['location_type'] : '';

        $adforest_render_params['types'] = isset($package_settings_fields['select_type']) ? $package_settings_fields['select_type'] : '';


        echo adforest_maincallt_modern__shortcode_func($adforest_render_params);
    }

}
