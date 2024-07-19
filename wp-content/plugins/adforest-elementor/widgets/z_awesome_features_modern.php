<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_awesome_features_modern extends Widget_Base {

    public function get_name() {
        return 'awesome_features_modern';
    }

    public function get_title() {
        return __('Awesome Features - Modern','adforest-elementor');
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
            'label' => __('Background Color','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Select background color.','adforest-elementor'),        
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
            'description' => __('Chose header style.','adforest-elementor'),        
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
             'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),        
        
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
                'screen', [
            'label' => esc_html__('Screenshots','adforest-elementor'),
                ]
        );
        
       $repeater = new \Elementor\Repeater();
       
      $repeater->add_control(
                'title', [
            'label' => __('Main Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Section Title','adforest-elementor'),        
            
            ]
        );  
       $repeater->add_control(
                'subtitle', [
            'label' => __('Subtitle','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Section Title','adforest-elementor'),        
            
            ]
        );  
       
        $repeater->add_control(
                'img', array(
            'label' => __('Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Section side image','adforest-elementor'),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );
        
        
         $this->add_control(
                'screenshots', [
            'label' => __('Select points under description.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{title}}}',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        
        $adforest_render_params['screenshots'] = isset($package_settings_fields['screenshots']) ? $package_settings_fields['screenshots'] : '';
       
        
        echo awesome_features_modern_func($adforest_render_params);
        
    }
}