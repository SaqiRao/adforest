<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_hero_services extends Widget_Base {

    public function get_name() {
        return 'adforest_hero_services';
    }

    public function get_title() {
        return __('Hero - Services Banner','adforest-elementor');
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
                'banner_title', [
            'label' => __('Banner Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );
           
         
        $this->add_control(
                'banner_description', [
            'label' => __('Banner Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'description' => __('Enter banner description here .','adforest-elementor'),        
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
            
                ]
        );   
         
         
        
         $this->add_control(
                'banner_bg_image', array(
            'label' => __('Banner Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of banner background : Recommended size (1920x850)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
       
         
        $this->add_control(
                'banner_image', array(
            'label' => __('Banner Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __('Add an image of banner that will apply at the bottom of banner descrpition.: Recommended size (1079x187)','adforest-elementor'),
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );
  
       


       
      
        $this->end_controls_section(); 
        
       
    }

    protected function render() {

        $search_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        
        
        $adforest_render_params['banner_title'] = isset($search_settings_fields['banner_title']) ? $search_settings_fields['banner_title']:'';
        $adforest_render_params['banner_description'] = isset($search_settings_fields['banner_description']) ? $search_settings_fields['banner_description']:'';
        $adforest_render_params['banner_bg_image'] = isset($search_settings_fields['banner_bg_image']['id']) ? $search_settings_fields['banner_bg_image']['id'] : '';
        $adforest_render_params['banner_image'] = isset($search_settings_fields['banner_image']['id']) ? $search_settings_fields['banner_image']['id'] : '';
       
        echo adforest_hero_services_callback($adforest_render_params);
    }

}
