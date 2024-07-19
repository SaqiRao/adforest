<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_process_cycle_new4 extends Widget_Base {

    public function get_name() {
        return 'process_cycle4_short_base';
    }

    public function get_title() {
        return __('Process Cycle 4','adforest-elementor');
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
            'label' => __('Background Color','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Select background color.','adforest-elementor'),        
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
                'step1', [
            'label' => esc_html__('Step 1','adforest-elementor'),
                ]
        );
        
       $this->add_control(
        's1_icon', [
    'label' => __('Icon','adforest-elementor'),
    'type' => \Elementor\Controls_Manager::ICONS,
    'default' => [
        'value' => 'fas fa-star',
        'library' => 'solid',
    ],
        ]
     );

        $this->add_control(
                's1_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
       ]
        );
         $this->add_control(
                's1_description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',     
                ]
        );

        $this->end_controls_section();
        
        
        $this->start_controls_section(
                'step2', [
            'label' => esc_html__('Step 2','adforest-elementor'),
                ]
        );
        
       $this->add_control(
        's2_icon', [
    'label' => __('Icon','adforest-elementor'),
    'type' => \Elementor\Controls_Manager::ICONS,
    'default' => [
        'value' => 'fas fa-star',
        'library' => 'solid',
    ],
        ]
     );

        $this->add_control(
                's2_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
       ]
        );
         $this->add_control(
                's2_description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',     
                ]
        );

        $this->end_controls_section();
        
       
        
        $this->start_controls_section(
                'step3', [
            'label' => esc_html__('Step 3','adforest-elementor'),
                ]
        );
        
       $this->add_control(
        's3_icon', [
    'label' => __('Icon','adforest-elementor'),
    'type' => \Elementor\Controls_Manager::ICONS,
    'default' => [
        'value' => 'fas fa-star',
        'library' => 'solid',
    ],
        ]
     );

        $this->add_control(
                's3_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
       ]
        );
         $this->add_control(
                's3_description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',     
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
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        //step 1 setting
       $adforest_render_params['s1_icon'] = isset($package_settings_fields['s1_icon']) ? $package_settings_fields['s1_icon'] : '';
       $adforest_render_params['s1_title'] = isset($package_settings_fields['s1_title']) ? $package_settings_fields['s1_title'] : '';
       $adforest_render_params['s1_description'] = isset($package_settings_fields['s1_description']) ? $package_settings_fields['s1_description'] : '';
        //step2 setting 
        $adforest_render_params['s2_icon'] = isset($package_settings_fields['s2_icon']) ? $package_settings_fields['s2_icon'] : '';
       $adforest_render_params['s2_title'] = isset($package_settings_fields['s2_title']) ? $package_settings_fields['s2_title'] : '';
       $adforest_render_params['s2_description'] = isset($package_settings_fields['s2_description']) ? $package_settings_fields['s2_description'] : '';
        //step 3 setting 
       
       $adforest_render_params['s3_icon'] = isset($package_settings_fields['s3_icon']) ? $package_settings_fields['s3_icon'] : '';
       $adforest_render_params['s3_title'] = isset($package_settings_fields['s3_title']) ? $package_settings_fields['s3_title'] : '';
       $adforest_render_params['s3_description'] = isset($package_settings_fields['s3_description']) ? $package_settings_fields['s3_description'] : '';
      
        echo process_cycle4_short_base_func($adforest_render_params);  
        
        
    }
}