<?php



if (!defined('ABSPATH')):

    exit();

endif;





add_action( 'woocommerce_shipping_init', 'transportadora_shipping_method_init', 99 );

add_filter( 'woocommerce_shipping_methods', 'add_transportadora_shipping_method' );

/**

 * Insere novo método de entrega

 */

function transportadora_shipping_method_init(){



	if (!class_exists( 'ShippingSquidWooBenefits' ) ) :

		

    

    

	class ShippingSquidWooBenefits extends WC_Shipping_Method {

	    /**

	     * Constructor for your shipping class

	     *

	     * @access public

	     * @return void

	     */



        private $is_true;



	    public function __construct() {

	    	$this->id                 = 'shipping_squid_woo_benefits';

	    	$this->method_title       = __( ' Shipping Method Squid Woo Benefits' );

	    	$this->method_description = __( 'Access the shipping menu to enter the shipping rules' );



	    	$this->enabled            = "yes";

	        $this->title              = " Shipping Method Squid Woo Benefits";



			$this->init();

            

            $calcSquidWooBenefits = new calcSquidWooBenefits();

            $this->is_true = $calcSquidWooBenefits->calcSquidWooBenefits();



		}

	    /**

	     * Init your settings

	     *

	     * @access public

	     * @return void

	     */

	    function init() {

	    	// Load the settings API

	    	$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings

	    	$this->init_settings(); // This is part of the settings API. Loads settings you previously init.



			// Save settings in admin if you have any define

	    	add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

		}



	    /**

	     * calculate_shipping function.

	     *

	     * @access public

	     * @param mixed $package

	     * @return void

	     */

	    public function calculate_shipping( $package = array() ){

	    	if ( 1 === 1 ) {	



                if($this->is_true['status'] == 'true' && $this->is_true['apply'] == 'true'){

                    $shipping_name = $this->is_true['benefits']['shipp_text'];

                    $cost = $this->is_true['benefits']['shipp_value'];



                    $cart_total = WC()->cart->subtotal;

                    setcookie('shipp_cost', $this->is_true['benefits']['shipp_type'], time() + (86400), "/"); // 86400 = 1 day

                    if($this->is_true['benefits']['shipp_type'] == 'false'){

                        $cost = ($cart_total * $cost)/100;

                        

                    }



                    $rate = array(

                        'id' => $this->id,

                        'label' => $shipping_name,

                        'cost' => $cost,

                        'calc_tax' => 'per_item'

                    );

                

                    

                        // Register the rate

                        $this->add_rate( $rate );	

                    

                    

                }

            

			}

        }

        







    }

    endif;

}

/**

 * Registra método de entrega

 */

function add_transportadora_shipping_method( $methods ){


    if(!is_admin()){
        $calcSquidWooBenefits = new calcSquidWooBenefits();

        $is_true = $calcSquidWooBenefits->calcSquidWooBenefits();

        if($is_true['apply'] == 'true'){

            $methods['shipping_squid_woo_benefits'] = 'ShippingSquidWooBenefits';

        }

        return $methods;
    }
    return $methods;

}



if (!class_exists('calcSquidWooBenefits')):



    class calcSquidWooBenefits{



        public function __construct(){
            
            
            $this->calcSquidWooBenefits();

        }

        


        public function calcSquidWooBenefits(){

            // if(is_admin()){

            //     return;

            // }

            global $woocommerce;

            $cart_total = $woocommerce->cart->subtotal;

            



            $squid_benefit_option = get_option('squid_woo_report_option');

            $return = [

                'status' => false,

                'apply' => false,

                'return_msg' => 'Frete Barra de Progresso',

                'dimensions' => 100

            ];
            setcookie('cart_status', $squid_benefit_option['max_value'], time() + (86400), "/"); // 86400 = 1 day

            if($squid_benefit_option['shipp_status'] == 'true'){

                if($cart_total >= $squid_benefit_option['min_value'] && $cart_total <= $squid_benefit_option['max_value']){

                    $remain = $squid_benefit_option['max_value'] - $cart_total;

                    $return_msg = 'Faltam R$'.number_format($remain,2,',','.').' para você ganhar <strong>'.$squid_benefit_option['shipp_text'].'</strong><a href="'. get_permalink( wc_get_page_id( 'shop' ) ) .'">Continue comprando</a>';

                    

                    $valor_inicial = (($cart_total - $squid_benefit_option['min_value']) * 100)/($squid_benefit_option['max_value'] - $squid_benefit_option['min_value']);

                    $valor_inicial_width = (int)$valor_inicial;

                    

                    $return = [

                        'status' => true,

                        'apply' => false,

                        'return_msg' => $return_msg,

                        'benefits' => $squid_benefit_option,

                        'dimensions' => $valor_inicial_width

                    ];

                }if($cart_total > $squid_benefit_option['max_value']){

                    $return_msg = 'Você obteve: <strong>'.$squid_benefit_option['shipp_text'].'</strong>';

                    $return = [

                        'status' => true,

                        'apply' => true,

                        'return_msg' => $return_msg,

                        'benefits' => $squid_benefit_option,

                        'dimensions' => 100

                    ];

                }

            }

            

            return $return;



        }

    }

    // $calcSquidWooBenefits = new calcSquidWooBenefits();

endif;





if (!class_exists('classSquidWooBenefits')):



    class classSquidWooBenefits{



        /**

         * Variable with Calculated Benefits

         */

        private $squidCalculatedBenefits = '';



        public function __construct(){           

            // add_action('wp_footer', array($this,'teste_init'),999);

            add_action('admin_menu', array($this, 'addMenuSquidWooBenefits') );

            add_shortcode( 'barra_progresso_frete', array($this, 'headerSquidWooBenefits') );

            add_filter( 'woocommerce_package_rates' , array( $this, 'squid_sort_shipping_first'), 10, 2 );

            add_action( 'woocommerce_before_cart',array($this, 'atualizar_carrinho'),1);


            /**

             * Save squid options Ajax

             */

            add_action( 'wp_ajax_save_squid_woo_benefits', array($this,'save_squid_woo_benefits') );

            // add_action( 'wp_ajax_nopriv_save_squid_woo_benefits', array($this,'save_squid_woo_benefits') );





            /**

             * Get squid options Ajax

             */

            add_action( 'wp_ajax_get_squid_woo_benefits', array($this,'get_squid_woo_benefits') );

            add_action( 'wp_ajax_nopriv_get_squid_woo_benefits', array($this,'get_squid_woo_benefits') );





        }

        // public function squid_sort_shipping_first( $rates, $package ) {
        //     //  if there are no rates don't do anything
        //     if ( ! $rates ) {
        //         return;
        //     }
            
        //     // get an array of prices
        //     $prices = array();
        //     foreach( $rates as $rate ) {
        //         $prices[] = $rate->cost;
        //     }
        //     if(get_current_user_id() == 1){
        //         update_option('teste_sort1', $prices);
        //         update_option('teste_sort2', $rates);
        //     }
        //     // use the prices to sort the rates
        //     array_multisort( $prices, $rates );
            
        //     // return the rates
        //     return $rates;
        // }

        public function squid_sort_shipping_first($available_shipping_methods, $package)
        {
            // Arrange shipping methods as per your requirement
            $sort_order	= array(
                'shipping_squid_woo_benefits'	=>	[],
                'free_shipping'		=>	[],
                'local_pickup'		=>	[],
                'flat_rate'	=>	[],
                'jadlog-quatro'	=>	[],	
                'wc_table_shipping'	=>	[],	
            );
            $squid_shipping_method_id = 'shipping_squid_woo_benefits';
            $squid_shipping = [];
            
            // unsetting all methods that needs to be sorted
            foreach($available_shipping_methods as $carrier_id => $carrier){
                $carrier_name	=	current(explode(":",$carrier_id));
                if($carrier->method_id == $squid_shipping_method_id){
                    $squid_shipping[$carrier_name][$carrier_id] = $available_shipping_methods[$carrier_id];
                    unset($available_shipping_methods[$carrier_id]);
                }
                // if(array_key_exists($carrier->method_id,$sort_order)){
                //     $sort_order[$carrier_name][$carrier_id]	=		$available_shipping_methods[$carrier_id];
                //     unset($available_shipping_methods[$carrier_id]);
                // }
            }
            foreach($squid_shipping as $carriers){
                $available_shipping_methods	=	array_merge($carriers, $available_shipping_methods);
            }
            // adding methods again according to sort order array
            // foreach($sort_order as $carriers){
            //     $available_shipping_methods	=	array_merge($available_shipping_methods,$carriers);
            // }
            return $available_shipping_methods;
        }


        public function get_squid_woo_benefits(){

            if($_POST['action'] != 'get_squid_woo_benefits'){

                wp_die();

            }else{

                if(empty($this->squidCalculatedBenefits)){

                    $squid_benefit = new calcSquidWooBenefits();

                    $squid_benefit = $squid_benefit->calcSquidWooBenefits();

                }else{

                    $squid_benefit = $this->squidCalculatedBenefits;

                }

               

                $return = $squid_benefit;



                echo json_encode($return);

            }

        }







        public function save_squid_woo_benefits(){

            if($_POST['action'] != 'save_squid_woo_benefits'){

                wp_die();

            }else{

                $shipp_status = $_POST['shipp_status'];

                $min_value = 0;

                $max_value = $_POST['max_value'];

                $shipp_text = $_POST['shipp_text'];

                $shipp_value = $_POST['shipp_value'];

                $shipp_type = $_POST['shipp_type'];



                $array_squid_option = [

                    'shipp_status' => $_POST['shipp_status'],

                    'min_value' => $_POST['min_value'],

                    'max_value' => $_POST['max_value'],

                    'shipp_text' => $_POST['shipp_text'],

                    'shipp_value' => $_POST['shipp_value'],

                    'shipp_type' => $_POST['shipp_type']

                ];



                update_option('squid_woo_report_option', $array_squid_option);



                echo json_encode([ 'jooj' => $array_squid_option]);

            }

        }





        public function atualizar_carrinho() {

            //atualiza carrinho automaticamente

            foreach (WC()->cart->get_cart() as $key => $value) {

                WC()->cart->set_quantity($key, $value['quantity']+1);

                WC()->cart->set_quantity($key, $value['quantity']);

                break;

            }

            // WC()->cart->calculate_shipping();



        }

        public function headerSquidWooBenefits(){

            if(empty($this->squidCalculatedBenefits)){

                $squid_benefit = new calcSquidWooBenefits();

                $squid_benefit = $squid_benefit->calcSquidWooBenefits();

            }else{

                $squid_benefit = $this->squidCalculatedBenefits;

            }
            if(is_checkout()){
                return;
            }

            if($squid_benefit['status'] === true){

            ?>

            

            <div id="headerSquidWooBenefits">
                <div class="info-benefit">

                    <span><?php echo $squid_benefit['return_msg']?></span>

                </div>
                <div class="pre-loading-bar">
                    <div class="loading-bar" style="width: <?php echo $squid_benefit['dimensions']?>%;">
                        <div class="loaded-mark">
                        </div>

                    </div>
                </div>
            </div>
            <?php
            }

        }





        public function addMenuSquidWooBenefits(){



            $page_title = 'Frete com Barra de Progresso';

            $menu_title = 'Frete com Barra de Progresso';

            $capability = 'manage_options';

            $menu_slug  = '_squid_woo_benefits';

            $function   = array($this,'squid_woo_benefits_html');

            $icon_url   = 'dashicons-store';

            $position   = 4;



            add_menu_page( $page_title,

                            $menu_title, 

                            $capability, 

                            $menu_slug, 

                            $function, 

                            $icon_url, 

                            $position );

        }

        public function squid_woo_benefits_html(){

            $user = wp_get_current_user();

            $roles = ( array ) $user->roles;

            // print_r($roles);

            

            ?>

            <div class="squid woo-benefits header">

                <ul class="squid menu">

                

                </ul>

            </div>

            <div class="squid woo-benefits body wrap">



                <div class="box search">



                </div>



                <div class="box results">

                        <?php

                        // $squid_benefit_option = get_option('squid_woo_report_option');

                        // print_r($squid_benefit_option);



                        include_once SQUID_WOO_BENEFITS_VIEWS_PATH . 'view-squid-woo-benefits-admin-page.php';

                        ?>

                </div>



                <div class="squid footer">

                    <div style="display: none;" id="trash-icon"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/delete-empty.png'; ?>"></div>

                </div>

            </div>



            <?php

        }

    }



    $classSquidWooBenefits = new classSquidWooBenefits();



endif;