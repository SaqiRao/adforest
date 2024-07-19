<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_partners_grid extends Widget_Base {

    public function get_name() {
        return 'client_partner_grid_short_base';
    }

    public function get_title() {
        return __('Clients or Partners - Grid','adforest-elementor');
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
                'client_settings', [
            'label' => esc_html__('Client or Partners','adforest-elementor'),
                ]
        );

        $adforest_elementor_repetor = new \Elementor\Repeater();

        $adforest_elementor_repetor->add_control(
                'link', [
            'label' => __('URL or Link','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
                ]
        );

        $adforest_elementor_repetor->add_control(
                'logo', array(
            'label' => __('Logo','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            "description" => __("320x150", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                )
        );

        $this->add_control(
                'clients', [
            'label' => __('Add Client','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $adforest_elementor_repetor->get_controls(),
            'default' => [],
            'title_field' => '{{{link}}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $partners_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['section_bg'] = isset($partners_settings_fields['section_bg']) ? $partners_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($partners_settings_fields['bg_img']['id']) ? $partners_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($partners_settings_fields['header_style']) ? $partners_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($partners_settings_fields['section_title']) ? $partners_settings_fields['section_title']:'';
        $adforest_render_params['section_title_regular'] = isset($partners_settings_fields['section_title_regular']) ? $partners_settings_fields['section_title_regular']:'';
        $adforest_render_params['section_description'] = isset($partners_settings_fields['section_description']) ? $partners_settings_fields['section_description']:'';
        // clients
        $adforest_render_params['clients'] = isset($partners_settings_fields['clients']) ? $partners_settings_fields['clients']:'';
        echo client_partner_grid_short_base_func($adforest_render_params);
    }
}