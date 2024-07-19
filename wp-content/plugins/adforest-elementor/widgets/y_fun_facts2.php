<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_y_fun_facts2 extends Widget_Base {

    public function get_name() {
        return 'fun2_factsshort_base';
    }

    public function get_title() {
        return __('Fun Facts 2','adforest-elementor');
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
                'bg_img', [
            'label' => __('Background Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("1280x800", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->add_control(
                'p_cols', [
            'label' => __('Column','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            // 'multiple' => true,
            'description' => __('Select Col','adforest-elementor'),
            'options' => [
                '4' => __('3 Col','adforest-elementor'),
                '3' => __('4 Col','adforest-elementor'),
            ],
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'fun_facts_section', [
            'label' => esc_html__('Fun Facts','adforest-elementor'),
                ]
        );
        $repeater2 = new \Elementor\Repeater();
        $repeater2->add_control(
                'icon', [
            'label' => __('Icon','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'library' => 'solid',
                'iconsPerPage' => 100,
            ],
                ]
        );
        $repeater2->add_control(
                'numbers', [
            'label' => __('Numbers','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater2->add_control(
                'title', [
            'label' => __('Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $repeater2->add_control(
                'color_title', [
            'label' => __('Color Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'fun_facts', [
            'label' => __('Fun Facts','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater2->get_controls(),
            'title_field' => '{{{ title }}}',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {

        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['p_cols'] = isset($package_settings_fields['p_cols']) ? $package_settings_fields['p_cols']:'';
        $adforest_render_params['fun_facts'] = isset($package_settings_fields['fun_facts']) ? $package_settings_fields['fun_facts']:'';
        echo fun2_factsshort_base_func($adforest_render_params);
        
    }
}