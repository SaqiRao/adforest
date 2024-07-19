<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_hero_section_toy extends Widget_Base {

    public function get_name() {
        return 'adforest_hero_section_toys';
    }

    public function get_title() {
        return __('Hero Section - Toys Banner Slider','adforest-elementor');
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
            'label' => esc_html__('Categories Settings','adforest-elementor'),
                ]
        );
        
        
         $this->add_control(
                'category_title', [
            'label' => __('Categories Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );
         
         
         $repeater = new \Elementor\Repeater();
         
         
         $repeater->add_control(
                'category_image', array(
            'label' => __('Category Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of Category : Recommended size (53 X 43)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
         
         
          $repeater->add_control(
                'cat', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => '',
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
         
         $this->add_control(
                'cats', [
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'description' =>'',
            'fields' => $repeater->get_controls(),
            'default' => [],
               'title_field' => '{{{ cat }}}',
                ]
        ); 
         
 
         $this->end_controls_section();
        

        $this->start_controls_section(
                'slidesers', [
            'label' => esc_html__('Add Slides','adforest-elementor'),
                ]
        );
        
        $repeater2 = new \Elementor\Repeater();
        
        
        
        $repeater2->add_control(
                'slider_logo_image', array(
            'label' => __('Slider Logo Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of Slider : Recommended size (175 X 66)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
        
        $repeater2->add_control(
                'slider_image', array(
            'label' => __('Slider Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of Slider : Recommended size (346 X 496)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
        
        
        $repeater2->add_control(
                'slider_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );

        $repeater2->add_control(
                'slider_description', [
            'label' => __('Slider Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
           
                ]
        );

        
        $repeater2->add_control(
                'slider_btn_title', [
            'label' => __('Slider button Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );
        
         $repeater2->add_control(
	   'slider_btn',
	   [
	  'label' => __( 'Slider Button','adforest-elementor' ),
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
                'slides', [
            'label' => __('Add Slides)','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'description' => __('Category: Beagle (beagle)','adforest-elementor'),
            'fields' => $repeater2->get_controls(),
            'default' => [],
               'title_field' => '{{{ slider_title }}}',
                ]
        );
        
        
        
        $this->end_controls_section(); 
        
       
    }

    protected function render() {

        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        
        
        $adforest_render_params['category_title'] = isset($search_settings_fields['category_title']) ? $search_settings_fields['category_title']:'';
        $adforest_render_params['cats'] = isset ($search_settings_fields['cats']) ? $search_settings_fields['cats']:'';
        $adforest_render_params['slides'] = isset ($search_settings_fields['slides']) ? $search_settings_fields['slides']:'';
      
        echo adforest_hero_section_toys_callback($adforest_render_params);
    }

}
