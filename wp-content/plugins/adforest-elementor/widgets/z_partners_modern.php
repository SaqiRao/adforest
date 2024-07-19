<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_partners_modern extends Widget_Base {

    public function get_name() {
        return 'client_partner_modern2_short_base';
    }

    public function get_title() {
        return __('Clients or Partners - Modern 2','adforest-elementor');
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
                'section_img', array(
            'label' => __('Side Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
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
                'clients', [
            'label' => esc_html__('Clients or Partners','adforest-elementor'),
            'description' => __('Select Category','adforest-elementor'),        
                ]
        );
        
        
        $repeater = new \Elementor\Repeater();
        
       $repeater->add_control(
                'link', [
            'label' => __('URL or Link','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Link Title','adforest-elementor'),
                ]
        );
       
        $repeater->add_control(
                'logo', array(
            'label' => __('Logo','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('165X107','adforest-elementor'),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );
        
        $this->add_control(
                'partners', [
            'label' => __('Select Category.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ link }}}',
                ]
        );

        $this->end_controls_section();
        
        
        
            
}
//isset() ? $testimonail_settings_fields[''] : '';
    protected function render() {
        
         $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = TRUE;        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '' ;
        $adforest_render_params['section_img'] = isset($package_settings_fields['section_img']['id']) ? $package_settings_fields['section_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        
        $adforest_render_params['clients'] = isset($package_settings_fields['partners']) ? $package_settings_fields['partners'] : '';
     
         echo client_partner_modern2_short_base_func($adforest_render_params);
        
    }
}