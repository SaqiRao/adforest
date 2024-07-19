<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_Vendor_Banners extends Widget_Base
{

    public function get_name()
    {
        return 'vendor_banners_short_base';
    }

    public function get_title()
    {
        return __('Adforest - Vendor Banners', 'adforest-elementor');
    }

    public function get_icon()
    {
        return 'fa fa-audio-description';
    }

    public function get_categories()
    {
        return ['adforest_elementor'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'basic', [
                'label' => esc_html__('Basic', 'adforest-elementor'),
            ]
        );

        $this->add_control(
            'col-style-left', array(
                'label' => __('Left Coloumn', 'adforest-elementor'),
                'type' => Controls_Manager::SELECT,

                'options' => array(
                    'col-xl-3' => __('Col 3', 'adforest-elementor'),
                    'col-xl-6' => __('col 6', 'adforest-elementor'),
                    'col-xl-9' => __('col 9', 'adforest-elementor'),
                ),
            )
        );
        
           $this->add_control(
            'banner_left', array(
                'label' => __('Banner Image Left', 'adforest-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                "description" => __("312x422", 'adforest-elementor'),
            )
        );
           
           $this->add_control(
            'col-style-right', array(
                'label' => __('Right Column', 'adforest-elementor'),
                'type' => Controls_Manager::SELECT,

                'options' => array(
                    'col-xl-3' => __('Col 3', 'adforest-elementor'),
                    'col-xl-6' => __('col 6', 'adforest-elementor'),
                    'col-xl-9' => __('col 9', 'adforest-elementor'),
                ),
            )
        );
        
           $this->add_control(
            'banner_right', array(
                'label' => __('Banner Image Right', 'adforest-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                "description" => __("312x422", 'adforest-elementor'),
            )
        );
     
   
        $this->end_controls_section();    

        //===============
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['col-style-left'] = isset($atts['col-style-left']) ? $atts['col-style-left'] : "";
        $params['banner_left'] = isset($atts['banner_left']) ? $atts['banner_left'] : "";
        $params['col-style-right'] = isset($atts['col-style-right']) ? $atts['col-style-right'] : "";
        $params['banner_right'] = isset($atts['banner_right']) ? $atts['banner_right'] : "";
        echo adforest_vendor_banners_func($params);   
    }
}
