<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_search_services extends Widget_Base {

    public function get_name() {
        return 'adforest_search_services';
    }

    public function get_title() {
        return __('Search - Services','adforest-elementor');
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
                'screen', [
            'label' => esc_html__('Search Settings','adforest-elementor'),
                ]
        );
        
        
        $this->add_control(
                'location_type', array(
            'label' => __('Location type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Chose header style.','adforest-elementor'),        
            'options' => array(
                'g_locations' => __('Google','adforest-elementor'),
                'custom_locations' => __('Custom Location','adforest-elementor'),
                
            ),
                )
        );
     
       
      $this->add_control(
                'keyword_label', [
            'label' => __('Search Keyword Label','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Section Title','adforest-elementor'),        
            
            ]
        );  
      $this->add_control(
                'location_label', [
            'label' => __('Search Location Label','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Section Title','adforest-elementor'),        
            
            ]
        );  
      $this->add_control(
                'type_label', [
            'label' => __('Search Ads Type Label','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'title' => __('Section Title','adforest-elementor'),        
            
            ]
        );  
       
       
        $this->end_controls_section();
        
        
        $this->start_controls_section(
                'clocation', [
            'label' => esc_html__('Custom Locations','adforest-elementor'),
                ]
        );
        
        $this->add_control(
                'locations', array(
            'label' => __('Location','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,    
            'multiple' => true,      
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country','yes'),
                )
        );
        
       $this->end_controls_section(); 
        
    }

    protected function render() {
        
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular']:'';
        
        $adforest_render_params['location_type'] = isset($package_settings_fields['location_type']) ? $package_settings_fields['location_type']:'';
        $adforest_render_params['keyword_label'] = isset($package_settings_fields['keyword_label']) ? $package_settings_fields['keyword_label']:'';
        $adforest_render_params['location_label'] = isset($package_settings_fields['location_label']) ? $package_settings_fields['location_label']:'';
        $adforest_render_params['type_label'] = isset($package_settings_fields['type_label']) ? $package_settings_fields['type_label']:'';
        
        $adforest_render_params['locations'] = isset($package_settings_fields['locations']) ? $package_settings_fields['locations']:'';
        
        
        echo adforest_search_services_func_callback($adforest_render_params);
        
    }
}