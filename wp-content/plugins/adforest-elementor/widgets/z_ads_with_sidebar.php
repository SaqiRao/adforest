<?php
namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_z_ads_with_sidebar extends Widget_Base {

    public function get_name() {
        return 'ads_with_sidebar_ajax';
    }

    public function get_title() {
        return __('Ads With Sidebar - Ajax Based','adforest-elementor');
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
            'label' => esc_html__('Main Section','adforest-elementor'),
                ]
        );
   
       $this->add_control(
                'section_title', [
            'label' => __('Section Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            'description' =>  __('For color','adforest-elementor') . '<strong>' . esc_html('{color}') . '</strong>' . __('warp text within this tag','adforest-elementor') . '<strong>' . esc_html('{/color}') . '</strong>',        

        ]
        );
       
       $this->add_control(
                'ad_type', array(
            'label' => __('Ads Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads Type','adforest-elementor'),
                'feature' => __('Featured Ads','adforest-elementor'),
                'regular' => __('Simple Ads','adforest-elementor'),
                'both' => __('Both','adforest-elementor'),
            ),
                )
        );
       $this->add_control(
                'ad_order', array(
            'label' => __('Order By','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Ads order','adforest-elementor'),
                'asc' => __('Oldest','adforest-elementor'),
                'desc' => __('Latest','adforest-elementor'),
                'rand' => __('Random','adforest-elementor'),
            ),
                )
        );

       $this->add_control(
			'no_of_ads',
			[
				'label' => __( 'Number fo Ads','adforest-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 500,
				'step' => 1,
				'default' => 1,
			]
		);
       
       $this->add_control(
                'sidebar_pos', array(
            'label' => __('Sider Position','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Option','adforest-elementor'),
                'left' => __('Left','adforest-elementor'),
                'right' => __('Right','adforest-elementor'),
                
            ),
                )
        );
              $this->add_control(
                'layout_type', array(
            'label' => __('Layout Type','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Layout Type','adforest-elementor'),
                'grid_1' => __('Grid 1','adforest-elementor'),
                'grid_2' => __('Grid 2','adforest-elementor'),
                'grid_3' => __('Grid 3','adforest-elementor'),
                'grid_4' => __('Grid 4','adforest-elementor'),
                'grid_5' => __('Grid 5','adforest-elementor'),
                'grid_6' => __('Grid 6','adforest-elementor'),
                'grid_7' => __('Grid 7','adforest-elementor'),
                'grid_8' => __('Grid 8','adforest-elementor'),
                'grid_9' => __('Grid 9','adforest-elementor'),
                'grid_10' => __('Grid 10','adforest-elementor'),
                'grid_11' => __('Grid 11','adforest-elementor'),

            ),
                )
        );
       
       $this->add_control(
                'view_all', [
            'label' => __('View All Button Text','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            'description' => __('Leave empty if you want to hide the view all button.','adforest-elementor'),        

        ]
        );
       
        $this->add_control(
                'banner_top', [
            'label' => __('Banner Top','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'description' => __('Write your html or simple code here','adforest-elementor'),        
            'title' => '',
            'rows' => 6,
            'placeholder' => '',
             ]
        );
        $this->add_control(
                'banner_bottom', [
            'label' => __('Banner Bottom','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'description' => __('Write your html or simple code here','adforest-elementor'),        
            'title' => '',
            'rows' => 6,
            'placeholder' => '',
             ]
        );
        
        $this->end_controls_section();
        
        
        
        
        
        
        $this->start_controls_section(
                'sidebar', [
            'label' => esc_html__('Sidebar','adforest-elementor'),
                ]
        );
        
        $this->add_control(
                'sidebar_title', [
            'label' => __('Sidebar Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
        ]
        );
        
        $this->add_control(
                'cat_link_page', array(
            'label' => __('Category link Page','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                '' => __('Select Option','adforest-elementor'),
                'search' => __('Search Page','adforest-elementor'),
                'category' => __('Category Page','adforest-elementor'),
                
            ),
                )
        );
        
        
        $repeater = new \Elementor\Repeater();
        
        $repeater->add_control(
                'cat', [
            'label' => __('Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'placeholder' => 'Select Options',
            'default' => '',
            'description' => __('Categories Load on frontend','adforest-elementor'),
            //'multiple'=>true,
            'options' => apply_filters('adforest_elementor_ads_categories', array(), 'ad_cats'),
                ]
        );
        
         $repeater->add_control(
        'icon', [
        'label' => __('Icon','adforest-elementor'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-star',
            'library' => 'solid',
        ],
            ]
         );
        $repeater->add_control(
                'icon_img', array(
            'label' => __('Icon Image','adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'description' => __( 'If you upload the icons images then icons will be overidden. max icon image size (32px X 32px)','adforest-elementor' ),        
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            
                )
        );
        
       
        
        $this->add_control(
                'cats', [
            'label' => __('Select Category','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'description' => __('Category: Beagle (beagle)','adforest-elementor'),
            'fields' => $repeater->get_controls(),
            'default' => [],
                //'title_field' => '{{{  }}}',
                ]
        );
        
        
       
        
        $this->end_controls_section();
        
        $this->start_controls_section(
                'siblinke', [
            'label' => esc_html__('Sidebar (Links)','adforest-elementor'),
                ]
        );
     
        $repeater = new \Elementor\Repeater();
        
       $repeater->add_control(
                'sidebar_btn_title', [
            'label' => __('Sidebar button Title','adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'title' => __('Section Title','adforest-elementor'),
            
        ]
        );
       $repeater->add_control(
	   'btn_1',
	   [
	  'label' => __( 'Buttons','adforest-elementor' ),
	  'type' => \Elementor\Controls_Manager::URL,
	  'placeholder' => __( 'https://your-link.com','adforest-elementor' ),
	  'show_external' => true,
	  'default' => [
	  'url' => '',
	  'is_external' => true,
	  'nofollow' => true,
	   ],
	   ]
		);
         
        
       
        
        $this->add_control(
                'cats_links', [
            'label' => __('Select Links','adforest-elementor'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'description' => __('Category: Beagle (beagle)','adforest-elementor'),
            'fields' => $repeater->get_controls(),
            'default' => [],
                'title_field' => '{{{ sidebar_btn_title }}}',
                ]
        );
        
        
       
        
        $this->end_controls_section();
        
        
        
        
        
        
        
        
            
}

    protected function render() {
        
         $package_settings_fields = $this->get_settings_for_display();
        $adforest_render_params = array();
        // basic
        $adforest_render_params['adforest_elementor'] = true; 
        
        $adforest_render_params['section_title'] = isset($package_settings_fields['section_title']) ? $package_settings_fields['section_title'] : '';
        $adforest_render_params['ad_type'] = isset($package_settings_fields['ad_type']) ? $package_settings_fields['ad_type'] : '';
        $adforest_render_params['ad_order'] = isset($package_settings_fields['ad_order']) ? $package_settings_fields['ad_order'] : '';
        $adforest_render_params['layout_type'] = isset($package_settings_fields['layout_type']) ? $package_settings_fields['layout_type'] : '';
        $adforest_render_params['no_of_ads'] = isset($package_settings_fields['no_of_ads']) ? $package_settings_fields['no_of_ads'] : '';
        $adforest_render_params['sidebar_pos'] = isset($package_settings_fields['sidebar_pos']) ? $package_settings_fields['sidebar_pos'] : '';
        $adforest_render_params['view_all'] = isset($package_settings_fields['view_all']) ? $package_settings_fields['view_all'] : '';
        $adforest_render_params['banner_top'] = isset($package_settings_fields['banner_top']) ? $package_settings_fields['banner_top'] : '';
        $adforest_render_params['banner_bottom'] = isset($package_settings_fields['banner_bottom']) ? $package_settings_fields['banner_bottom'] : '';
        $adforest_render_params['sidebar_title'] = isset($package_settings_fields['sidebar_title']) ? $package_settings_fields['sidebar_title'] : '';
        $adforest_render_params['cat_link_page'] = isset($package_settings_fields['cat_link_page']) ? $package_settings_fields['cat_link_page'] : '';
        $adforest_render_params['cats'] = isset($package_settings_fields['cats']) ? $package_settings_fields['cats'] : '';
        $adforest_render_params['cats_links'] = isset($package_settings_fields['cats_links']) ? $package_settings_fields['cats_links'] : '';
       
         echo adforest_adswithsidebaraja_shortcode($adforest_render_params);
        
    }
}