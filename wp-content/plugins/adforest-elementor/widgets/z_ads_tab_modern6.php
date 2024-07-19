<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_ads_tab_modern6 extends Widget_Base {

    public function get_name() {
        return 'ads_tabs_modern6';
    }

    public function get_title() {
        return __('ADs Tabs Modern 2','adforest-elementor');
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
            ),
                )
        );
        
        $this->add_control(
                'element_title', [
            'label' => __('Element Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
        ]
        );
        
        $this->add_control(
                'more_ads_text', [
            'label' => __('More ads Button Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
        ]
        );
        
        $this->add_control(
			'more_ads',
			[
				'label' => __( 'More ads Button','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com','adforest-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
         
        


        $this->end_controls_section();

   $this->start_controls_section(
                'ads_settings', [
            'label' => esc_html__('Ads Settings','adforest-elementor'),
                ]
        );
   
      
   
       $this->add_control(
                'layout_type', array(
            'label' => __('Layout Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Layout Type','adforest-elementor'),
                'grid_1' => __('Grid 1','adforest-elementor'),
                'grid_2' => __('Grid 2','adforest-elementor'),
                'grid_3' => __('Grid 3','adforest-elementor'),
                'grid_4' => __('Grid 4','adforest-elementor'),
                'grid_5' => __('Grid 5','adforest-elementor'),
                'grid_6' => __('Grid 6','adforest-elementor'),
                'grid_7' => __('Grid 7','adforest-elementor'),
                'grid_8' => __('Grid 8','adforest-elementor'),
                'grid_9' => __('Grid 9','adforest-elementor'),
                'grid_10' => __('Grid 10','adforest-elementor'),
                'grid_11' => __('Grid 10','adforest-elementor'),
            ),
                )
        );
     
        $this->add_control(
                'ad_type', array(
            'label' => __('Ads Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads Type','adforest-elementor'),
                'feature' => __('Featured Ads','adforest-elementor'),
                'regular' => __('Simple Ads','adforest-elementor'),
                'both' => __('Both','adforest-elementor'),
            ),
                )
        );
        
         $this->add_control(
                'ad_order', array(
            'label' => __('Order By','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads order','adforest-elementor'),
                'asc' => __('Oldest','adforest-elementor'),
                'desc' => __('Latest','adforest-elementor'),
                'rand' => __('Random','adforest-elementor'),
            ),
                )
        );
         
        $this->add_control(
			'no_of_ads',
			[
				'label' => __( 'Number fo Ads for Each Tab','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'default' => 1,
			]
		); 
         
       
         
     
        $this->end_controls_section();
        
        
        
        $this->start_controls_section(
                'tabers', [
            'label' => esc_html__('Tabs','adforest-elementor'),
                ]
        );
        
      
         $this->add_control(
                'ads_tab_switch', array(
            'label' => __('Display Tabs','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads Tabing','adforest-elementor'),
                'categories' => __('Categories','adforest-elementor'),
                'ad_type' => __('Ad Type','adforest-elementor'),
                'conditions' => __('Condition','adforest-elementor'),
                'warranty' => __('Warranty','adforest-elementor'),
            ),
                )
        ); 
        
        
        $this->add_control(
                'cats', array(
            'label' => __('Select Category','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,        
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'ads_tab_switch',
                        'operator' => 'in',
                        'value' => [
                            'categories',
                        ],
                    ],
                ],
            ],        
       )
                ); 
        
        $this->add_control(
                'ads_type', array(
            'label' => __('Ad Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,        
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_type','no'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'ads_tab_switch',
                        'operator' => 'in',
                        'value' => [
                            'ad_type',
                        ],
                    ],
                ],
            ],        
       )
                ); 
        
        $this->add_control(
                'ad_condition', array(
            'label' => __('Ad Conditions','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,         
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_condition','no'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'ads_tab_switch',
                        'operator' => 'in',
                        'value' => [
                            'conditions',
                        ],
                    ],
                ],
            ],        
       )
                ); 
        
        $this->add_control(
                'ad_warranty', array(
            'label' => __('Ad Warranty','adforest-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,        
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_warranty','no'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'ads_tab_switch',
                        'operator' => 'in',
                        'value' => [
                            'warranty',
                        ],
                    ],
                ],
            ],        
       )
                ); 
        

        
       $this->end_controls_section(); 
        
        
        

    }

    protected function render() {
        
         $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true; 
        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['element_title'] = isset($package_settings_fields['element_title']) ? $package_settings_fields['element_title'] : '';
        $adforest_render_params['more_ads_text'] = isset($package_settings_fields['more_ads_text']) ? $package_settings_fields['more_ads_text'] : '';
        $adforest_render_params['more_ads'] = isset($package_settings_fields['more_ads']) ? $package_settings_fields['more_ads'] : '';
        $adforest_render_params['layout_type'] = isset($package_settings_fields['layout_type']) ? $package_settings_fields['layout_type'] : '';
        $adforest_render_params['ad_type'] = isset($package_settings_fields['ad_type']) ? $package_settings_fields['ad_type'] : '';
        $adforest_render_params['ad_order'] = isset($package_settings_fields['ad_order']) ? $package_settings_fields['ad_order'] : '';
        $adforest_render_params['no_of_ads'] = isset($package_settings_fields['no_of_ads']) ? $package_settings_fields['no_of_ads'] : '';
        $adforest_render_params['ads_tab_switch'] = isset($package_settings_fields['ads_tab_switch']) ? $package_settings_fields['ads_tab_switch'] : '';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats'] : '';
        $adforest_render_params['ads_types'] = isset($package_settings_fields['ads_type']) ? $package_settings_fields['ads_type'] : '';
        $adforest_render_params['ad_condition'] = isset($package_settings_fields['ad_condition']) ? $package_settings_fields['ad_condition'] : '';
        $adforest_render_params['ad_warranty'] = isset($package_settings_fields['ad_warranty']) ? $package_settings_fields['ad_warranty'] : '';
             
         echo ads_tabs_modern6_callback($adforest_render_params);
        
    }
}