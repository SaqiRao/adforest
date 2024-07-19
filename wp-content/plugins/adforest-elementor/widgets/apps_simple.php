<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_apps_simple extends Widget_Base {

    public function get_name() {
        return 'apps_short_base';
    }

    public function get_title() {
        return __('Apps - Simple','adforest-elementor');
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
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),
            'title' => __('Section Title','adforest-elementor'),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'andriod', [
            'label' => esc_html__('Andriod','adforest-elementor'),
                ]
        );


        $this->add_control(
                'a_tag_line', [
            'label' => __('Tag Line','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Tag Line','adforest-elementor'),
                ]
        );
        $this->add_control(
                'a_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title','adforest-elementor'),
                ]
        );
        $this->add_control(
                'a_link', [
            'label' => __('Download Link','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Download Link','adforest-elementor'),
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'ios', [
            'label' => esc_html__('IOS','adforest-elementor'),
                ]
        );


        $this->add_control(
                'i_tag_line', [
            'label' => __('Tag Line','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Tag Line','adforest-elementor'),
                ]
        );
        $this->add_control(
                'i_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title','adforest-elementor'),
                ]
        );
        $this->add_control(
                'i_link', [
            'label' => __('Download Link','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Download Link','adforest-elementor'),
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'windows', [
            'label' => esc_html__('Windows','adforest-elementor'),
                ]
        );


        $this->add_control(
                'w_tag_line', [
            'label' => __('Tag Line','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Tag Line','adforest-elementor'),
                ]
        );
        $this->add_control(
                'w_title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title','adforest-elementor'),
                ]
        );
        $this->add_control(
                'w_link', [
            'label' => __('Download Link','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Download Link','adforest-elementor'),
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display(); 
        extract($atts);
       
        $apps = '';
        $count = 0;
        if ($a_link != "") {
            $count++;
            $apps .= '<div class="col-md-4">
                           <a href="' . esc_url($a_link) . '" title="' . esc_attr($a_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-android"></i>
                           <span>
                           <span>' . esc_html($a_tag_line) . '</span> <span>' . esc_html($a_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }
        if ($i_link != "") {
            $count++;
            $apps .= '<div class="col-md-4">
                           <a href="' . esc_url($i_link) . '" title="' . esc_attr($i_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-apple"></i>
                           <span>
                           <span>' . esc_html($i_tag_line) . '</span> <span>' . esc_html($i_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }
        if ($w_link != "") {
            $count++;
            $apps .= '<div class="col-md-4">
                           <a href="' . esc_url($w_link) . '" title="' . esc_attr($w_title) . '" class="btn app-download-button"> <span class="app-store-btn">
                           <i class="fa fa-windows"></i>
                           <span>
                           <span>' . esc_html($w_tag_line) . '</span> <span>' . esc_html($w_title) . '</span> </span>
                           </span>
                           </a>
                        </div>';
        }

        $off_set = '';
        if ($count == 1) {
            $off_set = 'col-md-offset-4';
        } else if ($count == 2) {
            $off_set = 'col-md-offset-2';
        } else if ($count == 3) {
            $off_set = '';
        }


        echo  ' <div class="app-download-section cashew-app parallex">
            <div class="app-download-section-wrapper">
               <div class="app-download-section-container">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="section-title"> <span>' . $section_title . '</span></div>
                        </div>
						<div class="col-md-12 ' . $off_set . '">
                                                    <div class="row">
						' . $apps . '
                                                    </div>
						</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>';
    }

}
