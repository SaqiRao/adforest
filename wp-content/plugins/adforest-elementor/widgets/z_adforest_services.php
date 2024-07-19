<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_services extends Widget_Base {

    public function get_name() {
        return 'adforest_services';
    }

    public function get_title() {
        return __('Adforest Services','adforest-elementor');
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
                'servc', [
            'label' => esc_html__('Add Services','adforest-elementor'),
                ]
        );
        
        
          $repeater = new \Elementor\Repeater();
       

            $repeater->add_control(
                    'service_image', array(
                'label' => __('Service Image','adforest-elementor'),
                'type' => Controls_Manager::MEDIA,
                'description' => __('Add an image of service : Recommended size (64x64)','adforest-elementor'),        
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],

                    )
            );

          $repeater->add_control(
                    'service_title', [
                'label' => __('Service Title','adforest-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'title' => __('Section Title','adforest-elementor'),        

                ]
            );
          
          $repeater->add_control(
                'service_description', [
            'label' => __('Service Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                   
                ]
        );
          
           $this->add_control(
                'services', [
            'label' => __('Add Services','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{service_title}}}',
                ]
        );
       
      
        $this->end_controls_section();
        
        
        
       
        
        
        
    }

    protected function render() {
        
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        
       
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        
        $adforest_render_params['services'] = isset($package_settings_fields['services']) ? $package_settings_fields['services']:'';
        
        echo adforest_services_callback($adforest_render_params);
        
    }
}