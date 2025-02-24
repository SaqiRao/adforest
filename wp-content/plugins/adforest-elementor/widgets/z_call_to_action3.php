<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_call_to_action3 extends Widget_Base {

    public function get_name() {
        return 'call_to_action_m3';
    }

    public function get_title() {
        return __('Call To Action - 3','adforest-elementor');
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
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
      ]
        );
       
       $this->add_control(
                'section_subtitle', [
            'label' => __('Section Subtitle','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            'description' =>  __('For color','adforest-elementor') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag','adforest-elementor') . '<strong>' . esc_html('{/color}') . '</strong>',        

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
         
         
         
         $this->add_control(
                'section_btn_1', [
            'label' => __('Button 1 Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
        ]
        );
         $this->add_control(
			'section_btn_1_url',
			[
				'label' => __( 'Button 1 URL','adforest-elementor' ),
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
         
            $this->add_control(
                'section_img', array(
            'label' => __('Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );
        
        $this->add_control(
                'section_bg', array(
            'label' => __('Background Color','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('White','adforest-elementor'),
                'gray' => __('Gray','adforest-elementor'),
               
            ),
                )
        );
        
        $this->add_control(
			'image_pos',
			[
				'label' => __( 'Image Position','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Select Option','adforest-elementor' ),
					'left'  => __( 'Left','adforest-elementor' ),
					'right' => __( 'Right','adforest-elementor' ),
				],
			]
		);
  
        $this->end_controls_section();
        

    }

    protected function render() {
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true; 
        

        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '' ;
        $adforest_render_params['section_subtitle'] = isset($package_settings_fields['section_subtitle']) ? $package_settings_fields['section_subtitle'] : '' ;
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '' ;
      
        $adforest_render_params['section_btn_1_url'] = isset($package_settings_fields['section_btn_1_url']) ? $package_settings_fields['section_btn_1_url'] : '' ;
        $adforest_render_params['section_btn_1'] = isset($package_settings_fields['section_btn_1']) ? $package_settings_fields['section_btn_1'] : '' ;
        
        
        
        $adforest_render_params['section_img'] = isset($package_settings_fields['section_img']['id']) ? $package_settings_fields['section_img']['id'] : '';
         $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '' ;
          $adforest_render_params['image_pos'] = isset($package_settings_fields['image_pos']) ? $package_settings_fields['image_pos'] : '' ;
        
       
        
         echo adforest_call_to_action_m3_func($adforest_render_params);
        
        
    }
}