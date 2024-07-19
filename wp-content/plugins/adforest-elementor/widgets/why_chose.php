<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_why_chose extends Widget_Base {

    public function get_name() {
        return 'Why Us';
    }

    public function get_title() {
        return __('Why Us','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        // basic

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
                'img' => __('Image','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'bg_img', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'section_bg',
                        'operator' => 'in',
                        'value' => [
                            'img',
                        ],
                    ],
                ],
            ],
                )
        );

        $this->add_control(
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('No Header','adforest-elementor'),
                'classic' => __('Classic','adforest-elementor'),
                'regular' => __('Regular','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'section_title', [
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
                            'classic',
                        ],
                    ],
                ],
            ],
                ]
        );
        $this->add_control(
                'section_title_regular', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
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

        $this->add_control(
                'section_description', [
            'label' => __('Section Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
                'factssettings', [
            'label' => esc_html__('Facts','adforest-elementor'),
                ]
        );

        $why_chose_repeater = new \Elementor\Repeater();

        $why_chose_repeater->add_control(
                'title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );

        $why_chose_repeater->add_control(
                'description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $why_chose_repeater->add_control(
                'title_link', [
            'label' => __('Link Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );

        $why_chose_repeater->add_control(
                'link', [
            'label' => __('Link','adforest-elementor'),
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
                'facts', [
            'label' => __('Add Facts','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $why_chose_repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{title}}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $why_chose_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = TRUE;
        $adforest_render_params['section_bg'] = isset($why_chose_settings_fields['section_bg']) ? $why_chose_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($why_chose_settings_fields['bg_img']['id']) ? $why_chose_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($why_chose_settings_fields['header_style']) ? $why_chose_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($why_chose_settings_fields['section_title']) ? $why_chose_settings_fields['section_title']:'';
        $adforest_render_params['section_title_regular'] = isset($why_chose_settings_fields['section_title_regular']) ? $why_chose_settings_fields['section_title_regular'] :'';
        $adforest_render_params['section_description'] = isset($why_chose_settings_fields['section_description']) ? $why_chose_settings_fields['section_description']:'';
        $adforest_render_params['facts'] = isset($why_chose_settings_fields['facts']) ? $why_chose_settings_fields['facts']:'';
        echo why_us_short_base_func($adforest_render_params);
        
    }

}
