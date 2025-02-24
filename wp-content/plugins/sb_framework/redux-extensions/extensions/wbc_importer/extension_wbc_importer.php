<?php

/**
 * Extension-Boilerplate
 *
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.2
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// Don't duplicate me!
if (!class_exists('ReduxFramework_extension_wbc_importer')) {

    class ReduxFramework_extension_wbc_importer {

        public static $instance;
        static $version = "1.0.2";
        protected $parent;
        private $filesystem = array();
        public $extension_url;
        public $extension_dir;
        public $demo_data_dir;
        public $wbc_import_files = array();
        public $active_import_id;
        public $active_import;

        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct($parent) {

            $this->parent = $parent;

            if (!is_admin())
                return;

            //Hides importer section if anything but true returned. Way to abort :)
            if (true !== apply_filters('wbc_importer_abort', true)) {
                return;
            }

            if (empty($this->extension_dir)) {
                $this->extension_dir = trailingslashit(plugin_dir_path(__FILE__));
                $this->extension_url = plugin_dir_url(__FILE__);
                $this->demo_data_dir = apply_filters("wbc_importer_dir_path", $this->extension_dir . 'demo-data/');
            }

            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('wbc_imported_demos');

            $this->getImports();

            $this->field_name = 'wbc_importer';

            self::$instance = $this;

            add_filter('redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array(&$this,
                'overload_field_path'
            ));

            add_action('wp_ajax_redux_wbc_importer', array(
                $this,
                'ajax_importer'
            ));

            add_filter('redux/' . $this->parent->args['opt_name'] . '/field/wbc_importer_files', array(
                $this,
                'addImportFiles'
            ));

            //Adds Importer section to panel
            $this->add_importer_section();
        }

        /**
         * Get the demo folders/files
         * Provided fallback where some host require FTP info
         *
         * @return array list of files for demos
         */
        public function demoFiles() {

            $this->filesystem = $this->parent->filesystem->execute('object');
            $dir_array = $this->filesystem->dirlist($this->demo_data_dir, false, true);

            if (!empty($dir_array) && is_array($dir_array)) {

                uksort($dir_array, 'strcasecmp');
                return $dir_array;
            } else {

                $dir_array = array();

                $demo_directory = array_diff(scandir($this->demo_data_dir), array('..', '.'));

                if (!empty($demo_directory) && is_array($demo_directory)) {
                    foreach ($demo_directory as $key => $value) {
                        if (is_dir($this->demo_data_dir . $value)) {

                            $dir_array[$value] = array('name' => $value, 'type' => 'd', 'files' => array());

                            $demo_content = array_diff(scandir($this->demo_data_dir . $value), array('..', '.'));

                            foreach ($demo_content as $d_key => $d_value) {
                                if (is_file($this->demo_data_dir . $value . '/' . $d_value)) {
                                    $dir_array[$value]['files'][$d_value] = array('name' => $d_value, 'type' => 'f');
                                }
                            }
                        }
                    }

                    uksort($dir_array, 'strcasecmp');
                }
            }
            return $dir_array;
        }

        public function getImports() {

            if (!empty($this->wbc_import_files)) {
                return $this->wbc_import_files;
            }

            $imports = $this->demoFiles();

            $imported = get_option('wbc_imported_demos');

            if (!empty($imports) && is_array($imports)) {
                $x = 1;
                foreach ($imports as $import) {

                    if (!isset($import['files']) || empty($import['files'])) {
                        continue;
                    }

                    if ($import['type'] == "d" && !empty($import['name'])) {
                        $this->wbc_import_files['wbc-import-' . $x] = isset($this->wbc_import_files['wbc-import-' . $x]) ? $this->wbc_import_files['wbc-import-' . $x] : array();
                        $this->wbc_import_files['wbc-import-' . $x]['directory'] = $import['name'];

                        if (!empty($imported) && is_array($imported)) {
                            if (array_key_exists('wbc-import-' . $x, $imported)) {
                                $this->wbc_import_files['wbc-import-' . $x]['imported'] = 'imported';
                            }
                        }

                        foreach ($import['files'] as $file) {
                            switch ($file['name']) {
                                case 'content.xml':
                                    $this->wbc_import_files['wbc-import-' . $x]['content_file'] = $file['name'];
                                    break;

                                case 'theme-options.txt':
                                case 'theme-options.json':
                                    $this->wbc_import_files['wbc-import-' . $x]['theme_options'] = $file['name'];
                                    break;

                                case 'widgets.json':
                                case 'widgets.txt':
                                    $this->wbc_import_files['wbc-import-' . $x]['widgets'] = $file['name'];
                                    break;

                                case 'screen-image.png':
                                case 'screen-image.jpg':
                                case 'screen-image.gif':
                                    $this->wbc_import_files['wbc-import-' . $x]['image'] = $file['name'];
                                    break;
                            }
                        }

                        if (!isset($this->wbc_import_files['wbc-import-' . $x]['content_file'])) {
                            unset($this->wbc_import_files['wbc-import-' . $x]);
                            if ($x > 1)
                                $x--;
                        }
                    }

                    $x++;
                }
            }
        }

        public function addImportFiles($wbc_import_files) {

            if (!is_array($wbc_import_files) || empty($wbc_import_files)) {
                $wbc_import_files = array();
            }

            $wbc_import_files = wp_parse_args($wbc_import_files, $this->wbc_import_files);

            return $wbc_import_files;
        }

        public function ajax_importer() {
            if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_wbc_importer")) {
                die(0);
            }
            if (isset($_REQUEST['type']) && $_REQUEST['type'] == "import-demo-content" && array_key_exists($_REQUEST['demo_import_id'], $this->wbc_import_files)) {

                $reimporting = false;

                if (isset($_REQUEST['wbc_import']) && $_REQUEST['wbc_import'] == 're-importing') {
                    $reimporting = true;
                }

                $this->active_import_id = $_REQUEST['demo_import_id'];

                $import_parts = $this->wbc_import_files[$this->active_import_id];

                $this->active_import = array($this->active_import_id => $import_parts);

                $content_file = $import_parts['directory'];
                $demo_data_loc = $this->demo_data_dir . $content_file;

                if (file_exists($demo_data_loc . '/' . $import_parts['content_file']) && is_file($demo_data_loc . '/' . $import_parts['content_file'])) {

                    if (!isset($import_parts['imported']) || true === $reimporting) {
                        include $this->extension_dir . 'inc/init-installer.php';
                        $installer = new Radium_Theme_Demo_Data_Importer($this, $this->parent);
                    } else {
                        echo esc_html__("Demo Already Imported", 'redux-framework');
                    }
                }

                die();
            }

            die();
        }

        public static function get_instance() {
            return self::$instance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path($field) {
            return dirname(__FILE__) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }

        function add_importer_section() {
            // Checks to see if section was set in config of redux.
            for ($n = 0; $n <= count($this->parent->sections); $n++) {
                if (isset($this->parent->sections[$n]['id']) && $this->parent->sections[$n]['id'] == 'wbc_importer_section') {
                    return;
                }
            }

            $wbc_importer_label = trim(esc_html(apply_filters('wbc_importer_label', __('Demo Importer', 'redux-framework'))));

            $wbc_importer_label = (!empty($wbc_importer_label) ) ? $wbc_importer_label : __('Demo Importer', 'redux-framework');

            $this->parent->sections[] = array(
                'id' => 'wbc_importer_section',
                'title' => $wbc_importer_label,
                'desc' => '<p class="description">' . apply_filters('wbc_importer_description', esc_html__('Note : You can only import 1 demo data at a time on one domain.', 'redux-framework')) . '</p>',
                'icon' => 'el-icon-website',
                'fields' => array(
                    array(
                        'id' => 'wbc_demo_importer',
                        'type' => 'wbc_importer'
                    )
                )
            );
        }

    }

    // class
    if (!function_exists('wbc_after_theme_options')) {
        add_action('wbc_importer_after_theme_options_import', 'wbc_after_theme_options', 10, 2);

        function wbc_after_theme_options($demo_active_import, $demo_data_directory_path) {
            // Relace the tables if fresh installation
            
            $demo_type = end(explode("/", rtrim($demo_data_directory_path, '/')));
            if (get_option('adforest_fresh_installation') == 'yes') {
                global $wpdb;

                // Backing up the tables
                /* 				$wpdb->query("CREATE TABLE postmeta_backup AS SELECT * FROM $wpdb->postmeta");
                  $wpdb->query("CREATE TABLE posts_backup AS SELECT * FROM $wpdb->posts");
                  $wpdb->query("CREATE TABLE term_relationships_backup AS SELECT * FROM $wpdb->term_relationships");
                  $wpdb->query("CREATE TABLE term_taxonomy_backup AS SELECT * FROM $wpdb->term_taxonomy");
                  $wpdb->query("CREATE TABLE termmeta_backup AS SELECT * FROM $wpdb->termmeta");
                  $wpdb->query("CREATE TABLE terms_backup AS SELECT * FROM $wpdb->terms");
                 */
                // Trancate the table
                //$wpdb->query("TRUNCATE TABLE $wpdb->postmeta");
                //$wpdb->query("TRUNCATE TABLE $wpdb->posts");
                $wpdb->query("TRUNCATE TABLE $wpdb->term_relationships");
                $wpdb->query("TRUNCATE TABLE $wpdb->term_taxonomy");
                $wpdb->query("TRUNCATE TABLE $wpdb->termmeta");
                $wpdb->query("TRUNCATE TABLE $wpdb->terms");

                // replacing the table data
                
                adforest_importing_data($demo_type);

                update_option('adforest_fresh_installation', 'no');
            }

            if ($demo_type == 'Adforest') {
                $home = get_page_by_title('Sugar Candy');
                update_option('page_on_front', $home->ID);
                update_option('show_on_front', 'page');

                // Blog Page
                $blog = get_page_by_title('Blog');
                update_option('page_for_posts', $blog->ID);

                // Set Menu
                //now see if the main navigation menu is there - if not, create it.
                $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
                if (isset($primary_menu->term_id)) {
                    set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
                }
            }  else {
                // Set home page
                $home = get_page_by_title('اللوز كلاسي�?يد');
                update_option('page_on_front', $home->ID);
                update_option('show_on_front', 'page');
                // Blog Page
                $blog = get_page_by_title('مدون');
                update_option('page_for_posts', $blog->ID);
                // Set Menu
                //now see if the main navigation menu is there - if not, create it.
                $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
                if (isset($primary_menu->term_id)) {
                    set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
                }
            }
            // Setting pretty pwrmalink
            global $wp_rewrite;
            $wp_rewrite->set_permalink_structure('/%postname%/');
        }

    }
}