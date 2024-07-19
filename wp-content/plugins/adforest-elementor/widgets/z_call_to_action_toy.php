<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_call_to_action_toy extends Widget_Base {

    public function get_name() {
        return 'call_to_action_toy';
    }

    public function get_title() {
        return __('Call To Action - Toy','adforest-elementor');
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
                'toy_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
      ]
        );
         
      $this->add_control(
                'toy_description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
             ]
        );
      
       $this->add_control(
                'btn_title', [
            'label' => __('Button Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
        ]
        );
         $this->add_control(
			'toy_link',
			[
				'label' => __( 'Button Link','adforest-elementor' ),
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
                'images', [
            'label' => esc_html__('Images','adforest-elementor'),
                ]
        ); 
        $this->add_control(
			'image_1',
			[
				'label' => __( 'Image 1','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __('Add an image of service : Recommended size (246x448)','adforest-elementor'),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        
        $this->add_control(
			'image_2',
			[
				'label' => __( 'Image 2','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __('Add an image of service : Recommended size (621x512)','adforest-elementor'),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
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
        $adforest_render_params['toy_title'] = isset($package_settings_fields['toy_title']) ? $package_settings_fields['toy_title'] : '';
        $adforest_render_params['toy_description'] = isset($package_settings_fields['toy_description']) ? $package_settings_fields['toy_description'] : '';
        $adforest_render_params['btn_title'] = isset($package_settings_fields['btn_title']) ? $package_settings_fields['btn_title'] : '';
        $adforest_render_params['toy_link'] = isset($package_settings_fields['toy_link']) ? $package_settings_fields['toy_link'] : '';
        $adforest_render_params['image_1'] = isset($package_settings_fields['image_1']['id']) ? $package_settings_fields['image_1']['id'] : '';
        $adforest_render_params['image_2'] = isset($package_settings_fields['image_2']['id']) ? $package_settings_fields['image_2']['id'] : '';




        echo adforest_call_to_action_toy_func($adforest_render_params);
        
        
    }
}