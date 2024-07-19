<?php
/**
 * Plugin Name: Adforest Elementor
 * Plugin URI: https://themeforest.net/user/scriptsbundle/
 * Description: This plugin is used to add shortcodes by Elementor Pagebuilder.
 * Version: 2.1.2
 * Author: Scripts Bundle
 * Author URI: https://themeforest.net/user/scriptsbundle/
 * License: GPL2
 * Text Domain: adforest-elementor
 */
if (!defined('ABSPATH'))
    exit;
class Adforest_Elementor {
    private static $instance = null;
    public static function get_instance() {
        if (!self::$instance)
            self::$instance = new self;
        return self::$instance;
    }
    public function init() {
        $this->adforest_elementor_files_inclusion();
        add_action('elementor/widgets/register', array($this, 'widgets_registered'));
        add_action('elementor/frontend/after_register_scripts', array($this, 'widget_scripts'));
        add_action('elementor/elements/categories_registered', array($this, 'adforest_elementor_register_widgets_sections'));
        add_action('init', array($this, 'adforest_elementor_plugin_textdomain'), 0);
    }
    public function adforest_elementor_plugin_textdomain() {
        $locale = apply_filters('plugin_locale', get_locale(), 'adforest-elementor');
        $dir = trailingslashit(WP_LANG_DIR);
        load_textdomain('adforest-elementor', plugin_dir_path(__FILE__) . "languages/adforest-elementor-" . $locale . '.mo');
        load_plugin_textdomain('adforest-elementor', false, plugin_basename(dirname(__FILE__)) . '/languages');
    }
    public function adforest_elementor_files_inclusion() {
        require_once 'includes/adforest-elementor-functions.php';
    }
    public function widget_scripts() {
        wp_register_script('adforest-elementor-plugin', plugins_url('/assets/js/adforest-elementor.js', __FILE__), ['jquery'], false, true);
    }
    public function widgets_registered() {
        if (defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
            if (class_exists('Elementor\Plugin') && class_exists('Elementor\Widget_Base')) {
                if (is_callable('Elementor\Plugin', 'instance')) {
                    $elementor = Elementor\Plugin::instance();
                    if (isset($elementor->widgets_manager)) {
                        if (method_exists($elementor->widgets_manager, 'register_widget_type')) {
                            $widgets_file_paths = plugin_dir_path(__FILE__) . "widgets/";
                            $adforest_elementor_widgets = array_diff(scandir($widgets_file_paths), array('.', '..'));
                            foreach ($adforest_elementor_widgets as $widget_filename) {
                                $widget_file = "plugins/adforest-elementor/widgets/{$widget_filename}";
                                $template_file = locate_template($widget_file);
                                if (!$template_file || !is_readable($template_file)) {
                                    $template_file = plugin_dir_path(__FILE__) . 'widgets/' . $widget_filename;
                                }
                                if ($template_file && is_readable($template_file)) {
                                    require_once $template_file;
                                }
                                $reg_class_name = str_replace('.php', '', $widget_filename);
                                $reg_file_name = "Elementor\Widget_{$reg_class_name}";                                                                                    
                               Elementor\Plugin::instance()->widgets_manager->register(new $reg_file_name);
                            }
                        }
                    }
                }
            }
        }
    }
    public function adforest_elementor_register_widgets_sections($category_manager) {
        $category_manager->add_category(
                'adforest_elementor', [
            'title' => __('Adforest Widgets', 'adforest-elementor'),
            'icon' => 'fa fa-home',
                ]
        );
    }
}
register_activation_hook(__FILE__, 'activate_adforest_elementor');
function activate_adforest_elementor() {
    $adforest_theme = wp_get_theme();
    if ($adforest_theme->get('Name') != 'adforest' && $adforest_theme->get('Name') != 'adforest child') {
        deactivate_plugins(plugin_basename(__FILE__));
    }
    if (!is_plugin_active('elementor/elementor.php')) {
        deactivate_plugins(plugin_basename(__FILE__));
    }
}
Adforest_Elementor::get_instance()->init();
