<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_category_ads_slider extends Widget_Base {

    public function get_name() {
        return 'adforest_category_ads_slider';
    }

    public function get_title() {
        return __('Adforest Category Ads Slider','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'sliders_ads_setting', [
            'label' => esc_html__('Slider Ads Settings','adforest-elementor'),
                ]
        );
        $this->add_control(
                'section_bg', [
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
        $this->add_control(
                'ad_typem', [
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
                'ad_orderm', [
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
                'no_of_adsm', [
            'label' => __('Number of Ads for each category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
                ]
        );

        $repeater777 = new \Elementor\Repeater();
        $repeater777->add_control(
                'slider_cat_title', [
            'label' => __('Slider Category Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" => __('For color','adforest-elementor') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag','adforest-elementor') . '<strong>' . esc_html('{/color}') . '</strong>',
                ]
        );

        $repeater777->add_control(
                'cat', [
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
        $repeater777->add_control(
                'banner_place', [
            'label' => __('Banner Place','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __('None','adforest-elementor'),
                'top' => __('Top','adforest-elementor'),
                'bottom' => __('Bottom','adforest-elementor'),
            ],
                ]
        );
        $repeater777->add_control(
                'banner_code', [
            'label' => __('Banner Code','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            "description" => __("Recommended banner size (750x56)", "adforest-elementor"),
                ]
        );

        $this->add_control(
                'catsm', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater777->get_controls(),
                ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
                'sidesettings', [
            'label' => esc_html__('Sidebar Settings','adforest-elementor'),
                ]
        );


        $this->add_control(
                'sidebar_place', [
            'label' => __('Sidebar Place','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __('None','adforest-elementor'),
                'right' => __('Right Side','adforest-elementor'),
                'left' => __('Left Side','adforest-elementor'),
            ],
                ]
        );

        $repeater = new \Elementor\Repeater();





        $repeater->add_control(
                'sidebar_settings', [
            'label' => __('Sidebar','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __('None','adforest-elementor'),
                'side_banner' => __('Banner','adforest-elementor'),
                'side_ads' => __('Ads','adforest-elementor'),
                'side_cats' => __('Categories','adforest-elementor'),
            ],
                ]
        );
          
            $repeater->add_control(
                'category_image', [
            'label' => __('Category Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __('Add an image of Category : Recommended size (30 X 30)','adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
               'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_cats',
                        ],
                    ],
                ],
            ],
                ]
        );
        $repeater->add_control(
                'cats', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
               'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_cats',
                        ],
                    ],
                ],
            ],
                ]
        );








        $repeater->add_control(
                'side_banner_code', [
            'label' => __('Banner Code','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            "description" => __("Recommended size (370 X 500)", "adforest-elementor"),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_banner',
                        ],
                    ],
                ],
            ],
                ]
        );


        $repeater->add_control(
                'side_ads_title', [
            'label' => __('Ads Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_ads',
                        ],
                    ],
                ],
            ],
                ]
        );



        $repeater->add_control(
                'ad_type', [
            'label' => __('Ads Type','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            // 'multiple' => true,
            "description" => __("Select Ads order", 'adforest-elementor'),
            'options' => [
                '' => __('Select Ads Type','adforest-elementor'),
                'feature' => __('Featured Ads','adforest-elementor'),
                'regular' => __('Simple Ads','adforest-elementor'),
                'both' => __('Both','adforest-elementor'),
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_ads',
                        ],
                    ],
                ],
            ],
                ]
        );



        $repeater->add_control(
                'ad_order', [
            'label' => __('Order By','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            // 'multiple' => true,
            "description" => __("Select Ads order", 'adforest-elementor'),
            'options' => [
                'asc' => __('Oldest','adforest-elementor'),
                'desc' => __('Latest','adforest-elementor'),
                'rand' => __('Random','adforest-elementor'),
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_ads',
                        ],
                    ],
                ],
            ],
                ]
        );



        $repeater->add_control(
                'no_of_ads', [
            'label' => __('Number of Ads for each category slider type','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 500,
            'step' => 1,
            'default' => 1,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_ads',
                        ],
                    ],
                ],
            ],
                ]
        );



        $repeater->add_control(
                'more_btn_title', [
            'label' => __('More Button Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_ads',
                        ],
                    ],
                ],
            ],
                ]
        );


        $repeater->add_control(
                'more_link', [
            'label' => __('More Button Link','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => true,
                'nofollow' => true,
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sidebar_settings',
                        'operator' => 'in',
                        'value' => [
                            'side_ads',
                        ],
                    ],
                ],
            ],
                ]
        );




        $this->add_control(
                'sidebar_group', [
            'label' => __('Add Sidebar Items','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
                ]
        );
        $repeatercat = new \Elementor\Repeater();
      

        $this->end_controls_section();
    }

    protected function render() {
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();

        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['ad_typem'] = isset($package_settings_fields['ad_typem']) ? $package_settings_fields['ad_typem'] : '';
        $adforest_render_params['ad_orderm'] = isset($package_settings_fields['ad_orderm']) ? $package_settings_fields['ad_orderm'] : '';
        $adforest_render_params['no_of_adsm'] = isset($package_settings_fields['no_of_adsm']) ? $package_settings_fields['no_of_adsm'] : '';

        $adforest_render_params['catsm'] = isset($package_settings_fields['catsm']) ? $package_settings_fields['catsm'] : '';

        $adforest_render_params['sidebar_place'] = isset($package_settings_fields['sidebar_place']) ? $package_settings_fields['sidebar_place'] : '';
        $adforest_render_params['sidebar_group'] = isset($package_settings_fields['sidebar_group']) ? $package_settings_fields['sidebar_group'] : '';
        echo adforest_category_ads_slider_callback($adforest_render_params);
    }

}
