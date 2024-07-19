<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_browse_categories extends Widget_Base {

    public function get_name() {
        return 'Browse Categories - With Icons';
    }

    public function get_title() {
        return __('Browse Categories - With Icons','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic_settings', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
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




        $this->end_controls_section();

        $this->start_controls_section(
                'categories', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );

        $this->add_control(
                'cat_link_page', [
            'label' => __('Category link Page','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => '',
            'description' => __('Categories Load on frontend','adforest-elementor'),
            'multiple' => true,
            'options' => [
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Page','adforest-elementor'),
            ],
                ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
                'cat', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => '',
            'description' => __('Categories Load on frontend','adforest-elementor'),
            //'multiple'=>true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );

        $repeater->add_control(
                'cat_img', array(
            'label' => __('Category Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('250X250','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );

        $this->add_control(
                'cats', [
            'label' => __('Select Category ( All or Selective )','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'description' => __('Category: Beagle (beagle)','adforest-elementor'),
            'fields' => $repeater->get_controls(),
            'default' => [],
                //'title_field' => '{{{  }}}',
                ]
        );



        $this->end_controls_section();
    }

    protected function render() {

        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['header_style'] = isset($search_settings_fields['header_style']) ? $search_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($search_settings_fields['section_title']) ? $search_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($search_settings_fields['section_description']) ? $search_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($search_settings_fields['section_title_regular']) ? $search_settings_fields['section_title_regular'] : '';
        $adforest_render_params['cat_link_page'] = isset($search_settings_fields['cat_link_page']) ? $search_settings_fields['cat_link_page'] : '';
        $adforest_render_params['cats'] = isset($search_settings_fields['cats']) ? $search_settings_fields['cats'] : '';

        echo adforest_browsecategorieswi_shortcode($adforest_render_params);
    }

}
