<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_search_modern2 extends Widget_Base {

    public function get_name() {
        return 'search_modern_type_short_base';
    }
    public function get_title() {
        return __('Search - Modern with cats','adforest-elementor');
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
                'cat_link_page', [
            'label' => __('Category link Page','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Page','adforest-elementor'),
            ],
                ]
        );
      
        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXT,
            "description" => __('For bold the text;<strong>Your text</strong> and %count% for total ads.','adforest-elementor'),
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'dropdown_cats_section', [
            'label' => esc_html__('Dropdown Categories','adforest-elementor'),
                ]
        );
        $this->add_control(
                'cat_frontend_switch', [
            'label' => __('Categories Load on frontend','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'description' => "Please choose categories load type on frontend for this element.",
            'options' => [
                'default' => __('Default','adforest-elementor'),
                'ajaxbased' => __('Ajax Based(Load All)','adforest-elementor'),
            ],
                ]
        );

        $this->add_control(
                'cats', [
            'label' => __('Select Category ( All or Selective )','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'cat_frontend_switch',
                        'operator' => 'in',
                        'value' => [
                            'default',
                        ],
                    ],
                ],
            ],
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'cat_settings', [
            'label' => esc_html__('Categories','adforest-elementor'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat', [
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats', 'yes'),
                ]
        );
        $repeater->add_control(
                'img', [
            'label' => __('Category Image','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            "description" => __("100x100", 'adforest-elementor'),
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
                ]
        );
        $this->add_control(
                'cats_round', [
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ cat }}}',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['cat_link_page'] = isset($atts['cat_link_page']) ? $atts['cat_link_page'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['cats_round'] = isset($atts['cats_round']) ? $atts['cats_round'] : "";
        $params['cat_frontend_switch'] = isset($atts['cat_frontend_switch']) ? $atts['cat_frontend_switch'] : "";
        $params['cats'] = isset($atts['cats']) ? $atts['cats'] : "";
     
      echo  search_modern_type_short_base_func($params);
    }
}
