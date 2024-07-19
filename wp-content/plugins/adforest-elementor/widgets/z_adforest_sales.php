<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_adforest_sales extends Widget_Base {

    public function get_name() {
        return 'adforest_sales';
    }

    public function get_title() {
        return __('Adforest Sales','adforest-elementor');
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
            'label' => esc_html__('Sale Data','adforest-elementor'),
                ]
        );

        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
                'sale_size', array(
            'label' => __('Size','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'grid' => __('Grid','adforest-elementor'),
                'wide' => __('Wide','adforest-elementor'),
            ),
                )
        );

        $repeater->add_control(
                'sale_grid_bg', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("Add an image of Background : Recommended size (270x200)", "adforest-elementor"),        
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sale_size',
                        'operator' => 'in',
                        'value' => [
                            'grid',
                        ],
                    ],
                ],
            ],
                )
        );
        
        
         $repeater->add_control(
                'sale_grid_img', array(
            'label' => __('Sale Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("Add an image of sale : Recommended size (108 X 103", "adforest-elementor"),        
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sale_size',
                        'operator' => 'in',
                        'value' => [
                            'grid',
                        ],
                    ],
                ],
            ],
                )
        );
         
         
        $repeater->add_control(
                'sale_wide_bg', array(
            'label' => __('Background Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("Add an image of Background : Recommended size (570x200)", "adforest-elementor"),        
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sale_size',
                        'operator' => 'in',
                        'value' => [
                            'wide',
                        ],
                    ],
                ],
            ],
                )
        );
        
        
         $repeater->add_control(
                'sale_wide_img', array(
            'label' => __('Sale Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            "description" => __("Add an image of sale : Recommended size (246 X 182)", "adforest-elementor"),        
            'conditions' => [
                'terms' => [
                    [
                        'name' => 'sale_size',
                        'operator' => 'in',
                        'value' => [
                            'wide',
                        ],
                    ],
                ],
            ],
                )
        ); 
         
         
         
         
       $repeater->add_control(
                'sale_title', [
            'label' => __('Sale Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );  
       
       $repeater->add_control(
                'link_title', [
            'label' => __('Sale Link Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
                ]
        );  
       
       $repeater->add_control(
                'sale_link', [
            'label' => __('Sale Link','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => __('https://your-link.com','adforest-elementor'),
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => true,
                'nofollow' => true,
            ],
                ]
        );
       
       
       $this->add_control(
                'sales', [
            'label' => __('Add Services','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [],
            'title_field' => '{{{ sale_title }}}',
                ]
        );
         
        
        $this->end_controls_section();



        
    }

    protected function render() {
        
        $product_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true;  
        
//        $adforest_render_params['sale_size'] = $product_settings_fields['sale_size'];
//        $adforest_render_params['sale_grid_bg'] = isset($product_settings_fields['sale_grid_bg']['id']) ? $product_settings_fields['sale_grid_bg']['id'] : '';
//        $adforest_render_params['sale_grid_img'] = isset($product_settings_fields['sale_grid_img']['id']) ? $product_settings_fields['sale_grid_img']['id'] : '';
//        $adforest_render_params['sale_wide_bg'] = isset($product_settings_fields['sale_wide_bg']['id']) ? $product_settings_fields['sale_wide_bg']['id'] : '';
//        $adforest_render_params['sale_wide_bg'] = isset($product_settings_fields['sale_wide_bg']['id']) ? $product_settings_fields['sale_wide_bg']['id'] : '';
//        $adforest_render_params['sale_wide_img'] = isset($product_settings_fields['sale_wide_img']['id']) ? $product_settings_fields['sale_wide_img']['id'] : '';
//        $adforest_render_params['sale_wide_img'] = isset($product_settings_fields['sale_wide_img']['id']) ? $product_settings_fields['sale_wide_img']['id'] : '';
//        $adforest_render_params['sale_title'] = $product_settings_fields['sale_title'];
//        $adforest_render_params['link_title'] = $product_settings_fields['link_title'];
        $adforest_render_params['sales'] = isset($product_settings_fields['sales']) ? $product_settings_fields['sales']:'';
        
      
        echo adforest_sales_callback($adforest_render_params);
        
    }
}