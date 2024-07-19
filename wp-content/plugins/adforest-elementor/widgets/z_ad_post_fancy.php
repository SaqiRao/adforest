<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_ad_post_fancy extends Widget_Base {

    public function get_name() {
        return 'ad_post_fancy_short_base';
    }

    public function get_title() {
        return __('Ad Post - Fancy','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'general_ad', [
            'label' => esc_html__('General','adforest-elementor'),
                ]
        );
        $this->add_control(
                'ad_post_form_type',
                [
                    'label' => __('Ad Post Form Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'description' => __('Select Post Form','adforest-elementor'),
                    'options' => [
                        'no' => __('Default Form','adforest-elementor'),
                        'yes' => __('Categories Based Form','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'terms_switch',
                [
                    'label' => __('Terms & Condition Field','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'description' => __('Select the ad post form type default or with dynamic categories based. Extra fields will only works with default form.','adforest-elementor'),
                    'options' => [
                        'hide' => __('Hide','adforest-elementor'),
                        'show' => __('Show','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
                'terms_title',
                [
                    'label' => __('Terms & Condition Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'terms_switch',
                                'operator' => 'in',
                                'value' => [
                                    'show',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'terms_link',
                [
                    'label' => __('Terms & Conditions','adforest-elementor'),
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
                                'name' => 'terms_switch',
                                'operator' => 'in',
                                'value' => [
                                    'show',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'extra_section_title',
                [
                    'label' => __('Extra Fields Section Title','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
                'Extra_fields_section',
                [
                    'label' => __('Extra Fields','adforest-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        
        
        $extra_fields_repeater = new \Elementor\Repeater();
        $extra_fields_repeater->add_control(
                'title',
                [
                    'label' => __('Add field','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $extra_fields_repeater->add_control(
                'slug',
                [
                    'label' => __('Slug','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        
        $extra_fields_repeater->add_control(
                'type',
                [
                    'label' => __('Type','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'text' => __('Textfield','adforest-elementor'),
                        'select' => __('Select/List','adforest-elementor'),
                    ],
                ]
        );
        
        $extra_fields_repeater->add_control(
                'option_values',
                [
                    'label' => __('Values for Select/List','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'description' => __('Like: value1,value2,value3','adforest-elementor'),
                    'conditions' => [
                        'terms' => [
                            [
                                'name' => 'type',
                                'operator' => 'in',
                                'value' => [
                                    'select',
                                ],
                            ],
                        ],
                    ],
                ]
        );
        $this->add_control(
                'fields_set',
                [
                    'label' => __('Add field','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $extra_fields_repeater->get_controls(),
                    'title_field' => '{{{ title }}}',
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();

        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['ad_post_form_type'] = isset($package_settings_fields['ad_post_form_type']) ? $package_settings_fields['ad_post_form_type'] : '';
        $adforest_render_params['terms_switch'] = isset($package_settings_fields['terms_switch']) ? $package_settings_fields['terms_switch'] : '';
        $adforest_render_params['terms_title'] = isset($package_settings_fields['terms_title']) ? $package_settings_fields['terms_title'] : '';
        $adforest_render_params['terms_link'] = isset($package_settings_fields['terms_link']) ? $package_settings_fields['terms_link'] : '';
        $adforest_render_params['extra_section_title'] = isset($package_settings_fields['extra_section_title']) ? $package_settings_fields['extra_section_title'] : '';
        $adforest_render_params['fields'] = isset($package_settings_fields['fields_set']) ? $package_settings_fields['fields_set'] : '';
        



        echo ad_post_fancy_short_base_func($adforest_render_params);
    }

}
