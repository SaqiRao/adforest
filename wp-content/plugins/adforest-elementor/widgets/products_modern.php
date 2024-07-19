<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_products_modern extends Widget_Base {

    public function get_name() {
        return 'price_modern_short_base';
    }

    public function get_title() {
        return __('Products - Modern', 'adforest-elementor');
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
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background', 'adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White', 'adforest-elementor'),
                'bg-gray' => __('Gray', 'adforest-elementor'),
              
            ),
                )
        );

  
         $this->add_control(
                'section_tagline', [
            'label' => __('Section Tagline', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );


        $this->add_control(
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
            'title' => __('Section Title', 'adforest-elementor'),
        
                ]
        );
   

        $this->add_control(
                'section_description', [
            'label' => __('Section Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();

       
        $this->start_controls_section(
                'main_all_products', [
            'label' => esc_html__('Products', 'adforest-elementor'),
                ]
        );

        // $this->add_control(
        //      'woo_products', array(
        //      'label' => __('Select Packages', 'adforest-elementor'),
        //      'type' => \Elementor\Controls_Manager::SELECT2,
        //      'multiple' => true,
        //      'default' => 'all',
        //      'placeholder' => 'Select Options',
        //      'options' => apply_filters('adforest_elementor_get_packages', array()),
        //         )
        // );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
			'woo_products', array(
                'label' => __('Select Packages', 'adforest-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => 'all',
                'placeholder' => 'Select Options',
                'options' => apply_filters('adforest_elementor_get_packages', array()),
                )
		);  


        $this->add_control(
			'list',
			[
				'label' => esc_html__( 'Repeater List', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'woo_products',
						'label' => __('Select Packages', 'adforest-elementor'),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'all',
                        'placeholder' => 'Select Options',
                        'options' => apply_filters('adforest_elementor_get_packages', array()),
					],
					
				],
			]
		);


        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();     
        $params = array();
        $params['adforest_elementor'] = true;
        $params['section_bg'] = isset($atts['section_bg']) ? $atts['section_bg'] : "";
        $params['section_tagline'] = isset($atts['section_tagline']) ? $atts['section_tagline'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        if (isset($atts['list']) && !empty($atts['list'])) {
            foreach ($atts['list'] as $item) {
                $woo_product = $item['woo_products'];
                $params['woo_products'][] = $woo_product; 
            }
        }
        $params['woo_products'] = isset($params['woo_products']) ? $params['woo_products'] : array();

           if(function_exists('price_modern2_short_base_func')){ 
             echo price_modern2_short_base_func($params);
         }
}
}