<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_hero_sports extends Widget_Base {

    public function get_name() {
        return 'adforest_hero_sports';
    }

    public function get_title() {
        return __('Hero - Sports Banner','adforest-elementor');
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
                'heading_1', [
            'label' => __('Heading 1','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );
         
          
           $this->add_control(
                'heading_2', [
            'label' => __('Heading 2','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );
           
         
        $this->add_control(
                'banner_description', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'description' => __('Enter banner description here','adforest-elementor'),        
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
            
                ]
        );   
         
         
        
         $this->add_control(
                'bg_image', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of  background : Recommended size (1920x946)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );

       


        $this->add_control(
                'btn_title', [
            'label' => __('Button Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );
        
        $this->add_control(
	   'sport_link',
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
        
       
    }

    protected function render() {

        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        
        
        $adforest_render_params['heading_1'] = isset($search_settings_fields['heading_1']) ? $search_settings_fields['heading_1']:'';
        $adforest_render_params['heading_2'] = isset($search_settings_fields['heading_2']) ? $search_settings_fields['heading_2']:'';
        $adforest_render_params['banner_description'] = isset($search_settings_fields['banner_description']) ? 
        $search_settings_fields['banner_description']:'';
        $adforest_render_params['bg_image'] = isset($search_settings_fields['bg_image']['id']) ? $search_settings_fields['bg_image']['id'] : '';
        $adforest_render_params['btn_title'] = isset($search_settings_fields['btn_title']) ? $search_settings_fields['btn_title']:'';
        $adforest_render_params['sport_link'] = isset($search_settings_fields['sport_link'])  ? $search_settings_fields['sport_link']:'';
       
        echo adforest_hero_sports_callback($adforest_render_params);
    }

}
