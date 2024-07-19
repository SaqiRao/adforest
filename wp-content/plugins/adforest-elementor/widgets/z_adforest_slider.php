<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_slider extends Widget_Base {

    public function get_name() {
        return 'adforest_slider';
    }

    public function get_title() {
        return __('Adforest Banner Slider','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

       $this->start_controls_section(
                'sliders', [
            'label' => esc_html__('Slider Settings','adforest-elementor'),
                ]
        );
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
                'slider_image', array(
            'label' => __('Service Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __( 'Add an image of slider','adforest-elementor' ),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );

        $repeater->add_control(
                'slider_title', [
            'label' => __('Slider Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
           
                ]
        );
         $repeater->add_control(
                'slider_description', [
            'label' => __('Slider Description','adforest-elementor'),
            'description' => __( 'Enter slider description here .','adforest-elementor' ),           
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
             
                    
                ]
        );
        
        $this->add_control(
                'slides', [
            'label' => __('Add Slides','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{slider_title}}}',
                ]
        );
       
     
        $this->end_controls_section(); 
        
        
        


    }

    protected function render() {
    $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true; 
        
        $adforest_render_params['slides'] = isset($package_settings_fields['slides']) ? $package_settings_fields['slides'] : '';
       
         echo adforest_slider_callback($adforest_render_params);
        
    }
}