<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_success_stories_2 extends Widget_Base {

    public function get_name() {
        return 'success_stories_2';
    }

    public function get_title() {
        return __('Success Stories 2','adforest-elementor');
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
                'basic_settings', [
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
        $this->end_controls_section();

        $this->start_controls_section(
                'partners_settings', [
            'label' => esc_html__('Success Stories.','adforest-elementor'),
                ]
        );

        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
                'p1name', [
            'label' => __('Partner 1 Name','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
                ]
        );

        $repeater->add_control(
                'p1subline', [
            'label' => __('Partner 1 Subline','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
                ]
        );

        $repeater->add_control(
                'p1desc', [
            'label' => __('Partner 1 Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',]
        );


        $repeater->add_control(
                'img', array(
            'label' => __('Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );


        $repeater->add_control(
                'p2name', [
            'label' => __('Partner 2 Name','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
                ]
        );

        $repeater->add_control(
                'p2subline', [
            'label' => __('Partner 2 Subline','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
                ]
        );

        $repeater->add_control(
                'p2desc', [
            'label' => __('Partner 2 Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',]
        );

        $this->add_control(
                'partners', [
            'label' => __('Client Success Stories.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ p1name }}}',
                ]
        );



        $this->end_controls_section();
    }

    protected function render() {
        $product_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($product_settings_fields['section_bg']) ? $product_settings_fields['section_bg'] : '';
        $adforest_render_params['header_style'] = isset($product_settings_fields['header_style']) ? $product_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($product_settings_fields['section_title']) ? $product_settings_fields['section_title'] : '';
        $adforest_render_params['section_title_regular'] = isset($product_settings_fields['section_title_regular']) ? $product_settings_fields['section_title_regular'] : '';
        $adforest_render_params['section_description'] = isset($product_settings_fields['section_description']) ? $product_settings_fields['section_description'] : '';
        // partners
        $adforest_render_params['partners'] = isset($product_settings_fields['partners']) ? $product_settings_fields['partners'] : '';
        echo adforest_success_stories_2_func($adforest_render_params);
    }

}
