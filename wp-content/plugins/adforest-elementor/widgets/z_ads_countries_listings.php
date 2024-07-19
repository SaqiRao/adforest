<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_ads_countries_listings extends Widget_Base {

    public function get_name() {
        return 'ads_countries_listings';
    }

    public function get_title() {
        return __('adforest locations listings','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {
        
         $this->start_controls_section(
                'output', [
            'label' => esc_html__('Shortcode Output','adforest-elementor'),
                ]
        );
        
         $this->add_control(
                'country_style', array(
            'label' => __('Countries Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Style 1','adforest-elementor'),
                'style2' => __('Style 2','adforest-elementor'),
                'style3' => __('Style 3','adforest-elementor'),
                'style4' => __('Style 4','adforest-elementor'),
            ),
                )
        );
         
         
        
        $this->end_controls_section();

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

        $this->add_control(
			'no_of_countries',
			[
				'label' => __('Number of Countries','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'default' => 1,
                                 'description' => __('Add num of countries to display in per page.','adforest-elementor'),      
			]
		); 
        
        $this->add_control(
                'country_link_page', array(
            'label' => __('Country link Page','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Page','adforest-elementor'),
                
            ),
                )
        );
        
        
        
        
        $this->end_controls_section(); 

        
        
        
         $this->start_controls_section(
                'country', [
            'label' => esc_html__('Countries','adforest-elementor'),
                ]
        );
        
      
         $repeater = new \Elementor\Repeater();
        
        
        $repeater->add_control(
                'ads_counry', array(
            'label' => __('Ad Conditions','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
                   
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country'),
            
       )
       );
       
        $repeater->add_control(
                'country_image', array(
            'label' => __('Country Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('<b>Note :</b> Uploaded image size should be greater or equal to these following image size for best results. <br /> <b> Grid : Recommended(360 x 252)</b><br /> <b> wide : Recommended(750 x 270)</b><br /> <b> large : Recommended(370 x 560)</b>','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
        
        
        $this->add_control(
                'ads_counries', [
            'label' => __('Select Ad Countries','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'description' => __('Category: Beagle (beagle)','adforest-elementor'),
            'fields' => $repeater->get_controls(),
            'default' => [],
                'title_field' => '{{{ ads_counry }}}',
                ]
        );

         
       $this->end_controls_section(); 
        
 

    }

    protected function render() {
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true; 
        
        
        $adforest_render_params['country_style'] = $package_settings_fields['country_style'];
        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        $adforest_render_params['no_of_countries'] = isset($package_settings_fields['no_of_countries']) ? $package_settings_fields['no_of_countries'] : '';
        $adforest_render_params['country_link_page'] = isset($package_settings_fields['country_link_page']) ? $package_settings_fields['country_link_page'] : '';
        
        $adforest_render_params['ads_counries'] = isset($package_settings_fields['ads_counries']) ? $package_settings_fields['ads_counries'] : '';
             
         echo ads_countries_listings_callback($adforest_render_params);
        
    }
}