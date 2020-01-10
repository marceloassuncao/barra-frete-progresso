<?php

/**

 * Plugin Name: DriftWeb - Frete com Barra de Progresso

 * Description: Plugin de frete com barra de progresso Woocommerce, utilizando o shortcode <strong>[barra_progresso_frete]</strong>.

 * Author: <a href="https://driftweb.com.br/" _target='blank'>DriftWeb</a> | <a href="https://www.linkedin.com/in/marcelo-assun%C3%A7%C3%A3o-dos-santos-junior-19162317a/" _target='blank'>Marcelo Assunção</a>
 
 * Version: 1.0.0

 */



if (!defined('ABSPATH')):

    exit();

endif;



define('SQUID_WOO_BENEFITS_PATH', plugin_dir_path(__FILE__));

define('SQUID_WOO_BENEFITS_URL', plugin_dir_url(__FILE__));



define('SQUID_WOO_BENEFITS_INCLUDES_PATH', plugin_dir_path(__FILE__) . 'includes/');

define('SQUID_WOO_BENEFITS_INCLUDES_URL', plugin_dir_url(__FILE__) . 'includes/');



define('SQUID_WOO_BENEFITS_VIEWS_PATH', plugin_dir_path(__FILE__) . 'views/');

define('SQUID_WOO_BENEFITS_VIEWS_URL', plugin_dir_url(__FILE__) . 'views/');



define('SQUID_WOO_BENEFITS_ASSETS_PATH', plugin_dir_path(__FILE__) . 'assets/');

define('SQUID_WOO_BENEFITS_ASSETS_URL', plugin_dir_url(__FILE__) . 'assets/');





if (!class_exists('squidWooBenefits')):







    class squidWooBenefits{

        /**

         * Instance of this class

         *

         * @var object

         */



        protected static $squidWooBenefits = null;





        /**

         * Initialize plugin loaders

         */



        private function __construct(){



            /**

             * Add plugin Stylesheet and JavaScript, in frontend

             */

            

               

                add_action('wp_enqueue_scripts', array(

                    $this,

                    'enqueue_scripts'

                ));

             

            



            /**

             * Add plugin Stylesheet and JavaScript, in admin

             */

            add_action('admin_enqueue_scripts', array(

                $this,

                'admin_enqueue_scripts'

            ));



            /**

             * Include plugin files

             */

            $this->enqueue_includes();

            // $this->enqueue_views();



        }





        public static function squid_woo_benefits_start(){

            if (self::$squidWooBenefits == null):

                self::$squidWooBenefits = new self();

            endif;



            return self::$squidWooBenefits;

        }





        public function enqueue_scripts(){

            // if(is_woocommerce() || is_cart() || is_checkout() || is_page('novidades-da-semana', 'mais-vendidos', 'em-destaque')){

                wp_enqueue_script(

                    'squid-woo-benefits-js',

                    SQUID_WOO_BENEFITS_ASSETS_URL . 'front/js/squid-woo-benefits-js.js' );



                wp_localize_script( 'squid-woo-benefits-js', 'ajax_object', array( 

                    'ajaxurl' => admin_url('admin-ajax.php')

                ) );



                wp_enqueue_style(

                    'squid-woo-benefits-css',

                    SQUID_WOO_BENEFITS_ASSETS_URL . 'front/css/squid-woo-benefits-css.css'

                );

            // }

        }





        public function admin_enqueue_scripts(){



            if(isset($_GET['page']) && $_GET['page'] == '_squid_woo_benefits'){

                wp_enqueue_script( 

                    'mdc-google-js',
            
                    'https://storage.googleapis.com/code.getmdl.io/1.0.0/material.min.js',
            
                    array()
            
                );
            
            
            
            wp_register_style( 'mdc-google-css', 'https://code.getmdl.io/1.3.0/material.blue-light_blue.min.css' );
        
            wp_enqueue_style( 'mdc-google-css' );

            wp_enqueue_script(

                'squid-woo-benefits-admin-js',

                SQUID_WOO_BENEFITS_ASSETS_URL . 'admin/js/squid-woo-benefits-admin-js.js'

            );



            wp_localize_script( 'squid-woo-benefits-admin-js', 'ajax_object', array( 

                'ajaxurl' => admin_url('admin-ajax.php')

            ) );

            wp_enqueue_style(

                'squid-woo-benefits-admin-css',

                SQUID_WOO_BENEFITS_ASSETS_URL . 'admin/css/squid-woo-benefits-admin-css.css'

            );

            // wp_enqueue_style(

            //     'jquery-ui-css','https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'

            // );

            // wp_enqueue_script(

            //     'jquery-ui', "https://code.jquery.com/ui/1.12.1/jquery-ui.js"

            // );



            }



        }



        private function enqueue_includes(){

            include_once SQUID_WOO_BENEFITS_INCLUDES_PATH . 'class-squid-woo-benefits.php';

        }



        // private function enqueue_views(){

        //     include_once SQUID_WOO_BENEFITS_VIEWS_PATH . 'view-squid-woo-benefits.php';

        // }



    }





    //Start's when plugins are loaded plugin

    // add_action('plugins_loaded', array('squidWooBenefits', 'squid_woo_benefits_start'));



     
    

    add_action('init', array('squidWooBenefits', 'squid_woo_benefits_start'));
    // do_action('marcelo_teste');







endif;







