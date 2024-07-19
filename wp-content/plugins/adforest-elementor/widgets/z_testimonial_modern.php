<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_testimonial_modern extends Widget_Base {

    public function get_name() {
        return 'adf_testimonial_modern2';
    }

    public function get_title() {
        return __('Testimonials - Modern old','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'testimonials-modern', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background Color','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            "description" => __("Select background color", 'adforest-elementor'),
            'options' => array(
                '' => __('White','adforest-elementor'),
                'gray' => __('Gray','adforest-elementor'),
            ),
                )
        );


        $this->end_controls_section();


        $this->start_controls_section(
                'points', [
            'label' => esc_html__('Points','adforest-elementor'),
                ]
        );

        $repeater = new \Elementor\Repeater();


        $repeater->add_control(
                'title', [
            'label' => __('Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Title','adforest-elementor'),
                ]
        );

        $repeater->add_control(
                'desc', [
            'label' => __('Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );

        $repeater->add_control(
                'stars', array(
            'label' => __('Select Stars','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1,
            'min' => 1,
            'max' => 5,
                )
        );

        $repeater->add_control(
                'img', array(
            'label' => __('Side Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => array(
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ),
                )
        );

        $this->add_control(
                'points_test', [
            'label' => __('Select points under description.','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ title }}}',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {

        $testimonail_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($testimonail_settings_fields['section_bg']) ? $testimonail_settings_fields['section_bg'] : '';
        $adforest_render_params['points'] = isset($testimonail_settings_fields['points_test']) ? $testimonail_settings_fields['points_test'] : '' ;
        
        echo adf_testimonial2_modern_func($adforest_render_params);
    }

}
