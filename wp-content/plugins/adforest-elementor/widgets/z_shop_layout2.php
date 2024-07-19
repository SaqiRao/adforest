<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_shop_layout2 extends Widget_Base {

    public function get_name() {
        return 'shop_layout_modern_short2_base';
    }

    public function get_title() {
        return __('Shop Layout - Modern','adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

    // basic

        $this->start_controls_section(
                'basic', [
            'label' => esc_html__('Basic','adforest-elementor'),
                ]
        );

        $this->add_control(
                'section_bg', array(
            'label' => __('Background Color','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Select background color.','adforest-elementor'),        
            'options' => array(
                '' => __('White','adforest-elementor'),
                'gray' => __('Gray','adforest-elementor'),
                'img' => __('Image','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'bg_img', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'section_bg',
                        'operator' => 'in',
                        'value' => [
                            'img',
                        ],
                    ],
                ],
            ],
                )
        );

        $this->add_control(
                'header_style', array(
            'label' => __('Header Style','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Chose header style.','adforest-elementor'),        
            'options' => array(
                '' => __('No Header','adforest-elementor'),
                'classic' => __('Classic','adforest-elementor'),
                'regular' => __('Regular','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'header_style',
                        'operator' => 'in',
                        'value' => [
                            'classic',
                        ],
                    ],
                ],
            ],
             'description' => __('For color {color}warp text within this tag{/color}','adforest-elementor'),        
        
                ]
        );
         $this->add_control(
                'section_description', [
            'label' => __('Section Description','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
             'conditions' => [
                'terms' => [
                    [
                        'name' => 'header_style',
                        'operator' => 'in',
                        'value' => [
                            'classic',
                        ],
                    ],
                ],
            ],
                    
                ]
        );
        $this->add_control(
                'section_title_regular', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'header_style',
                        'operator' => 'in',
                        'value' => [
                            'regular',
                        ],
                    ],
                ],
            ],
                ]
        );

       
        $this->end_controls_section();
        
   

        $this->start_controls_section(
                'main_all_products', [
            'label' => esc_html__('Product Settings','adforest-elementor'),
                ]
        );

        
        $this->add_control(
                'max_limit', [
            'label' => __('Select Number of Product','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 100,
            'step' => 1,
            'default' => 1,
                ]
        );


        $this->add_control(
                'p_cols', array(
            'label' => __('Column','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',  
            'options' => [
                        '' => __('Select Col','adforest-elementor'),
                        '4' => __('3 Col','adforest-elementor'),
                        '3' => __('4 Col','adforest-elementor'),
                        '2' => __('6 Col','adforest-elementor'),
                        
                    ],
            
                )
        );
        
         $this->add_control(
                'main_link_title',
                [
                    'label' => __('View All Link','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    "description" => __('For Read more Link if any Text','adforest-elementor'),
                    
                ]
        );

         
          $this->add_control(
                'main_link',
                [
                    'label' => __('View All Link','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    "description" => __('Read more Link if any.','adforest-elementor'),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
        ); 


        $this->end_controls_section();
        
        
         $this->start_controls_section(
                'main_productsss', [
            'label' => esc_html__('Products','adforest-elementor'),
                ]
        );
         
         
         $this->add_control(
                'all_products', array(
            'label' => __('Select Product Categories','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',  
            'options' => [
                        '' => __('Select Option','adforest-elementor'),
                        'all' => __('All Categories','adforest-elementor'),
                        'selective' => __('Selective Categories','adforest-elementor'),
                        
                    ],
            
                )
        );
         
         $this->add_control(
                'product',
                [
                    'label' => __('Select Category','adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT2, 
                    'multiple'=> true,
                    "description" => __("Category", 'adforest-elementor'),
                    'options' => apply_filters('adforest_elementor_ads_categories', array(), 'product_cat'),
                     'conditions' => [
                        'terms' => [
                            [
                                'name' => 'all_products',
                                'operator' => 'in',
                                'value' => [
                                    'selective',
                                ],
                            ],
                        ],
                    ],
                ]
        );
         
         
        
         $this->end_controls_section();
        
        
        
    }

    protected function render() {
        
        
        $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;        
        $adforest_render_params['section_bg'] = isset($package_settings_fields['section_bg']) ? $package_settings_fields['section_bg'] : '';
        $adforest_render_params['bg_img'] = isset($package_settings_fields['bg_img']['id']) ? $package_settings_fields['bg_img']['id'] : '';
        $adforest_render_params['header_style'] = isset($package_settings_fields['header_style']) ? $package_settings_fields['header_style'] : '';
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['section_description'] = isset($package_settings_fields['section_description']) ? $package_settings_fields['section_description'] : '';
        $adforest_render_params['section_title_regular'] = isset($package_settings_fields['section_title_regular']) ? $package_settings_fields['section_title_regular'] : '';
        
        
        $adforest_render_params['max_limit'] = isset($package_settings_fields['max_limit']) ? $package_settings_fields['max_limit'] : '';
        $adforest_render_params['p_cols'] = isset($package_settings_fields['p_cols']) ? $package_settings_fields['p_cols'] : '';
        $adforest_render_params['main_link_title'] = isset($package_settings_fields['main_link_title']) ? $package_settings_fields['main_link_title'] : '';
        $adforest_render_params['main_link'] = isset($package_settings_fields['main_link']) ? $package_settings_fields['main_link'] : '';
        
        $adforest_render_params['all_products'] = isset($package_settings_fields['all_products']) ? $package_settings_fields['all_products'] : '';
        $adforest_render_params['woo_products'] = isset($package_settings_fields['product']) ? $package_settings_fields['product'] : '';
        
        echo shop_layout_modern_short2_base_func($adforest_render_params);
        
    }
}