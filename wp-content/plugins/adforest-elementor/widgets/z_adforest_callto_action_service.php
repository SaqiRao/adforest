<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_callto_action_service extends Widget_Base {

    public function get_name() {
        return 'call_to_action_service';
    }

    public function get_title() {
        return __('Call To Action - Service','adforest-elementor');
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
                'section_bg',
                [
                    'label' => __('Background Color','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    //'multiple' => true,
                    "description" => __("Select background color", 'adforest-elementor'),
                    'options' => [
                        '' => __('White','adforest-elementor'),
                        'bg-gray' => __('Gray','adforest-elementor'),
                    ],
                ]
        );
        $this->add_control(
            'heading_1',
            [
                'label' => __( 'Heading','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'heading_2',
            [
                'label' => __( 'Subheading','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'content',
            [
                'label' => __( 'Description','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
            ]
        );
        $this->add_control(
            'more_add_text_button1',
            [
                'label' => __( 'Button1 Text','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'btn_1',
            [
                'label' => __( 'Button 1','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->add_control(
            'more_add_text_button2',
            [
                'label' => __( 'Button2 Text','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'btn_2',
            [
                'label' => __( 'Button 2','adforest-elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );    
        $this->add_control(
                'call_img',
                [
                    'label' => __('Call to Action Image','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => __("Recommended size (555 X 370)", 'adforest-elementor'),
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );
        $this->add_control(
            'call_img_side',
            [
                'label' => __('Image side','adforest-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                //'multiple' => true,
                "description" => __("Change image side to show left or right", 'adforest-elementor'),
                'options' => [
                    'left' => __('Left','adforest-elementor'),
                    'right' => __('Right','adforest-elementor'),
                ],
            ]
    );
         $this->end_controls_section();

    }

    protected function render() {
        
         $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();

        $adforest_render_params['adforest_elementor'] = true;
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg']:'';
        $adforest_render_params['heading_1'] = isset($package_settings_fields['heading_1']) ? $package_settings_fields['heading_1']:'';
        $adforest_render_params['heading_2'] = isset($package_settings_fields['heading_2']) ? $package_settings_fields['heading_2']:'';
        $adforest_render_params['content'] = isset($package_settings_fields['content']) ? $package_settings_fields['content']:'';
        $adforest_render_params['more_add_text_button1'] = isset($package_settings_fields['more_add_text_button1']) ? $package_settings_fields['more_add_text_button1']:'';
        $adforest_render_params['btn_1'] = isset($package_settings_fields['btn_1']) ? $package_settings_fields['btn_1']:'';
        $adforest_render_params['more_add_text_button2'] = isset($package_settings_fields['more_add_text_button2']) ? $package_settings_fields['more_add_text_button2']:'';
        $adforest_render_params['btn_2'] = isset($package_settings_fields['btn_2']) ? $package_settings_fields['btn_2']:'';
        $adforest_render_params['call_img'] = isset($package_settings_fields['call_img']['id']) ? $package_settings_fields['call_img']['id'] : '';
        $adforest_render_params['call_img_side'] = isset($package_settings_fields['call_img_side']) ? $package_settings_fields['call_img_side']:'';
       

        echo adforest_call_to_action_service_func($adforest_render_params);
        
    }
}