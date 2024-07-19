<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_locations_slider extends Widget_Base {

    public function get_name() {
        return 'adforest_locations_slider';
    }

    public function get_title() {
        return __('Adforest Locations Slider','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic_settings', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );
        
        
         $this->add_control(
                'location_bg', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of locations background. Note : Recommended size (1920 X 965)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );

        $this->add_control(
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Chose Header Style','adforest-elementor'),        
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
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
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
        
        $this->add_control(
                'country_link_page', [
            'label' => __('Country link Page','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => '',
            'description' => __('Categories Load on frontend','adforest-elementor'),
            'multiple' => true,
            'options' => [
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Pagee','adforest-elementor'),
            ],
                ]
        );  
        
        
        
        
         $this->end_controls_section();
         
         
         

        $this->start_controls_section(
                'categoriesss', [
            'label' => esc_html__('Categories','adforest-elementor'),
                ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        
          $repeater->add_control(
                'ads_counry', [
            'label' => __('Ad Location','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_country'),
                ]
        );
        
        
        
        $repeater->add_control(
                'country_image', array(
            'label' => __('Country Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of country you selected.Note : Recommented size (370 X 270)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
        
        $this->add_control(
                'ads_counries', [
            'label' => __('Select Ad Countries)','adforest-elementor'),
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

        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        
        
        $adforest_render_params['location_bg'] = isset($search_settings_fields['location_bg']['id']) ? $search_settings_fields['location_bg']['id'] : '';
        $adforest_render_params['header_style'] = isset($search_settings_fields['header_style']) ? $search_settings_fields['header_style']:'';
        $adforest_render_params['section_title'] = isset($search_settings_fields['section_title']) ? $search_settings_fields['section_title']:'';
        $adforest_render_params['section_description'] = isset($search_settings_fields['section_description']) ? 
        $search_settings_fields['section_description']:'';
        $adforest_render_params['section_title_regular'] = isset($search_settings_fields['section_title_regular']) ? $search_settings_fields['section_title_regular']:'';
        $adforest_render_params['country_link_page'] = isset($search_settings_fields['country_link_page']) ? $search_settings_fields['country_link_page']:'';
        
        $adforest_render_params['ads_counries'] = isset($search_settings_fields['ads_counries']) ? $search_settings_fields['ads_counries']:'';

        echo adforest_locations_slider_callback($adforest_render_params);
    }

}
