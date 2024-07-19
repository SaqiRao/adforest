<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_ads_team_member extends Widget_Base {

    public function get_name() {
        return 'ads_team_member';
    }

    public function get_title() {
        return __('Team Memebers','adforest-elementor');
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
                'team-mem', [
            'label' => esc_html__('Team member','adforest-elementor'),
                ]
        );
        
        
        $repeater = new \Elementor\Repeater();
        
          $repeater->add_control(
                'member_name', [
            'label' => __('Memeber Name','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );
         $repeater->add_control(
                'member_address', [
            'label' => __('Memeber Address','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );  
        $repeater->add_control(
                'member_designation', [
            'label' => __('Memeber Designation','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );  
        
        $repeater->add_control(
                'member_image', array(
            'label' => __('Member Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of your team member : Recommended size (270 X 237)','adforest-elementor'),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
               )
        );
         $repeater->add_control(
                'facebook', [
            'label' => __('Facebook','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );  
         $repeater->add_control(
                'twitter', [
            'label' => __('Twitter','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );  
         
         $repeater->add_control(
                'linkedin', [
            'label' => __('Linkedin','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        ); 
         
         $repeater->add_control(
                'google', [
            'label' => __('Google +','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        ); 
         
         $this->add_control(
                'team_members', [
            'label' => __('Add Team Members','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ member_name }}}',
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
        
        
        $adforest_render_params['team_members'] = isset($package_settings_fields['team_members']) ? $package_settings_fields['team_members'] : '';
      
       
        //$adforest_render_params['side_bg'] = isset($package_settings_fields['side_bg']['id']) ? $package_settings_fields['side_bg']['id'] : '';
        
       
        
        
         echo ads_team_member_callback($adforest_render_params);
        
    }
}