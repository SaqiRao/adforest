<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_apps_call_to_action extends Widget_Base {

    public function get_name() {
        return 'apps_call_to_action';
    }

    public function get_title() {
        return __('Apps - Call To Action Modern','adforest-elementor');
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
                'main_quote', [
            'label' => __('Section Quote Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
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
                'section_desc', [
            'label' => __('Section Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
             ]
        );
        
        $this->add_control(
                'side_bg', array(
            'label' => __('Side Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __( 'Background image behind the content.','adforest-elementor' ),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );

        $this->end_controls_section();
        
        
        $this->start_controls_section(
                'pointers', [
            'label' => esc_html__('Points','adforest-elementor'),
                ]
        ); 
        
        $repeater = new \Elementor\Repeater();
       
       $repeater->add_control(
                'point', [
            'label' => __('Points','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
      ]
        );
       
        
        
        $this->add_control(
                'points', [
            'label' => __('Select points under description.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
                    ]
        );
       
       
        $this->end_controls_section();
        
        
        
         $this->start_controls_section(
                'Buttons', [
            'label' => esc_html__('buttoners','adforest-elementor'),
                ]
        ); 
        
          $repeater = new \Elementor\Repeater();
         
         $repeater->add_control(
			'btn_link',
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
         
        $repeater->add_control(
                'btn_txt_1', [
            'label' => __('Button Text 1','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
      ]
        );
        $repeater->add_control(
                'btn_txt_2', [
            'label' => __('Button Text 2','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
      ]
        );
        
        $repeater->add_control(
                'img', array(
            'label' => __('Btn Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __( 'Section side image','adforest-elementor' ),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );
        
        
         $this->add_control(
                'buttons', [
            'label' => __('Select points under description.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
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
          $adforest_render_params['main_quote'] = isset($package_settings_fields['main_quote']) ? $package_settings_fields['main_quote'] : '';
          $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
          $adforest_render_params['section_desc'] = isset($package_settings_fields['section_desc']) ? $package_settings_fields['section_desc'] : '';
          $adforest_render_params['side_bg'] = isset($package_settings_fields['side_bg']['id']) ? $package_settings_fields['side_bg']['id'] : '';
          $adforest_render_params['points'] = isset($package_settings_fields['points']) ? $package_settings_fields['points'] : '';; 
          $adforest_render_params['buttons'] = isset($package_settings_fields['buttons']) ? $package_settings_fields['buttons'] : '';
         
         echo apps_call_to_action_func($adforest_render_params); 
        
        
    }
}