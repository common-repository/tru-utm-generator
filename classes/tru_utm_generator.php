<?php if(!class_exists('tru_utm_generator')) {

         class tru_utm_generator {

             public function __construct() {
                register_activation_hook( TRU_UTM_FILE, array( &$this, 'install' ) );                
                add_action('admin_menu', array(&$this, 'tru_menu_page'));
                add_shortcode('tru_utm_generator', array($this, 'tru_utm_generator_func'));
                add_action('wp_ajax_tru_utm_url_generate', array(&$this, 'tru_utm_url_generate_callback'));
                add_action('wp_ajax_nopriv_tru_utm_url_generate', array(&$this, 'tru_utm_url_generate_callback'));
                add_action('wp_enqueue_scripts', array(&$this, 'shortcode_assets'));
                add_action('admin_enqueue_scripts', array(&$this, 'admin_assets'));
                add_action('wp_ajax_mk_tru_utm_generator_help', array($this, 'mk_tru_utm_generator_help'));
             }
             /*
             Install
             */
             public function install() {
                global $wpdb;

                $table_name = $wpdb->prefix . "tru_utm_generator";

                $charset_collate = $wpdb->get_charset_collate();

                $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                client_name text NOT NULL,
                client_email text NOT NULL,
                client_domain text NOT NULL,
                utm_source text NOT NULL,
                utm_medium text NOT NULL,
                utm_campaign text NOT NULL,
                utm_date text,
                publish_date text NOT NULL,
                PRIMARY KEY  (id)
                ) $charset_collate;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
             }
             /*
              Admin menus
             */
             public function tru_menu_page() {
                add_menu_page(
                    __('UTM Generator', 'tru-utm-generator'),
                    __('UTM Generator', 'tru-utm-generator'),
                     'manage_options',
                    'tru_utm_generator',
                    array(&$this, 'tru_utm_generator_menu'),
                    'dashicons-chart-bar'
                    );      
                    /* Only for admin */
                    add_submenu_page('tru_utm_generator', __('Settings', 'tru-utm-generator'), __('Settings', 'tru-utm-generator'), 'manage_options', 'tru_utm_generator_settings', array(&$this, 'tru_utm_generator_settings'));
                    /* Only for admin */
                    add_submenu_page('tru_utm_generator', __('Email', 'tru-utm-generator'), __('Email', 'tru-utm-generator'), 'manage_options', 'tru_utm_generator_email_settings', array(&$this, 'tru_utm_generator_email_settings'));
             }
             /*
              UTM Generator View
             */
             public function tru_utm_generator_menu() {
                include(TRU_UTM_PLUGIN_PATH.'inc/view.php');
             }
             /*
              UTM Generator Settings
             */
             public function tru_utm_generator_settings() {
                include(TRU_UTM_PLUGIN_PATH.'inc/settings.php'); 
             }
             /*
              UTM Generator Email
             */
             public function tru_utm_generator_email_settings() {
                include(TRU_UTM_PLUGIN_PATH.'inc/email.php');
             }
             /*
              UTM Generator Shortcode
             */
             public function tru_utm_generator_func($atts) {
                  include(TRU_UTM_PLUGIN_PATH.'inc/shortcode.php');
             }
             /*
              UTM Generator Callback
             */
             public function tru_utm_url_generate_callback() {
                $nonce = $_POST['nonce'];
                global $wpdb;
                $table_name = $wpdb->prefix . "tru_utm_generator";
                if ( wp_verify_nonce( $nonce, 'tru_utm_url_generate' ) ) {
                    $utm_fname = sanitize_text_field($_POST['utm_fname']);
                    $utm_email = sanitize_email($_POST['utm_email']);
                    $utm_selected_domain = esc_url_raw($_POST['utm_selected_domain']);
                    $utm_source = sanitize_text_field($_POST['utm_source']);
                    $utm_medium = sanitize_text_field($_POST['utm_medium']);
                    $utm_campaign = sanitize_text_field($_POST['utm_campaign']);
                    $utm_date = sanitize_text_field($_POST['utm_date']);
                    $save = $wpdb->insert($table_name, array(
                     'client_name' => $utm_fname,
                     'client_email' => $utm_email,
                     'client_domain' => $utm_selected_domain,
                     'utm_source' => $utm_source,
                     'utm_medium' => $utm_medium,
                     'utm_campaign' => $utm_campaign,
                     'utm_date' => $utm_date,
                     'publish_date' => date('Y-m-d h:i:s a'),
                    ));
                    if($save) {
                        $buildUrl = $utm_selected_domain.'?utm_medium='.$utm_medium.'&utm_source='.$utm_source.'&utm_campaign='.$utm_campaign.(!empty($utm_date) ? '&utm_date='.$utm_date : '');
                        $res = array('error' => '0', 'response' => $buildUrl);
                        $this->send($utm_fname,$utm_email,$buildUrl);                       
                        echo json_encode($res);
                    } else {
                        $res = array('error' => '1', 'response' => 'Unable to generate UTM url.');
                        echo json_encode($res);
                    }
                } else {
                    $res = array('error' => '1', 'response' => 'Security issues.');
                    echo json_encode($res);
                }
                die;
                
             }
            /**
             * Email Send
             */
            public function send($utm_name, $utm_email, $buildUrl) {
                $opt = get_option('tru_utm_generator_email_options');

                $from = (isset($opt['utm_email_from']) && !empty($opt['utm_email_from'])) ? $opt['utm_email_from'] : get_option('admin_email');

                $cc = (isset($opt['utm_email_reply_to']) && !empty($opt['utm_email_reply_to'])) ? $opt['utm_email_reply_to'] : '';                

                $subject = (isset($opt['utm_email_subject']) && !empty($opt['utm_email_subject'])) ? $opt['utm_email_subject'] : 'Generated UTM Link';

                $body = (isset($opt['utm_email_body']) && !empty($opt['utm_email_body'])) ? $opt['utm_email_body'] : $buildUrl;
                $body = str_replace(array('{{name}}','{{email}}','{{link}}'), array($utm_name, $utm_email, $buildUrl), $body);
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: <'.$from.'>' . "\r\n";
                if(!empty($cc)) {
                  $headers .= 'Cc: '.$cc.'' . "\r\n";
                }

                mail($utm_email, $subject, stripslashes($body), $headers);
            }
            /**
             * Admin Assets
             */
            public function admin_assets() {
                wp_enqueue_script( 'tru-utm-dataTables-js', TRU_UTM_PLUGIN_URL . '/js/jquery.dataTables.min.js', array(),'', false  );
                wp_enqueue_script( 'tru-utm-bootstrap-js', TRU_UTM_PLUGIN_URL . '/js/dataTables.bootstrap.min.js', array(),'', false  );              
                wp_enqueue_script( 'tru-utm-admin-js', TRU_UTM_PLUGIN_URL . '/js/admin.js', array(),'', false  );
                wp_enqueue_style( 'tru-utm-bootstrap-css',TRU_UTM_PLUGIN_URL . '/css/bootstrap.min.css' );
                wp_enqueue_style( 'tru-utm-dataTables-css', TRU_UTM_PLUGIN_URL . '/css/dataTables.bootstrap.min.css');
                wp_enqueue_style( 'tru-utm-admin-css', TRU_UTM_PLUGIN_URL . '/css/admin.css');
            }
            /**
             * Shortcode Assets
             */
            public function shortcode_assets() {
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_register_style( 'jquery-ui', TRU_UTM_PLUGIN_URL . '/css/jquery-ui.css' );
                wp_enqueue_style( 'jquery-ui' ); 
                wp_register_script( 'tru-utm-shortcode-js', TRU_UTM_PLUGIN_URL . '/js/shortcode.js', array( 'jquery' ));
                wp_localize_script( 'tru-utm-shortcode-js', 'tru_utm', array('ajaxurl' => 
                admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('tru_utm_url_generate') ) );        
                wp_enqueue_script( 'tru-utm-shortcode-js' );
                wp_enqueue_style( 'tru-utm-shortcode-css', TRU_UTM_PLUGIN_URL . '/css/shortcode.css','','', 'screen' );
            }
            /**
             * Redirect
             */
            public function redirect($url)
            {
                echo '<script>window.location.href="'.$url.'"</script>';
                die;
            }
            /*
         Load Help Desk
        */
        public function load_help_desk()
        {
            $mkcontent = '';
            $mkcontent .= '<div class="trutm">';
            $mkcontent .= '<div class="l_trutm">';
            $mkcontent .= '';
            $mkcontent .= '</div>';
            $mkcontent .= '<div class="r_trutm">';
            $mkcontent .= '<a class="close_utm_help fm_close_btn" href="javascript:void(0)" data-ct="rate_later" title="close">X</a><strong>Tru UTM Generator </strong><p>We love and care about you. Our team is putting maximum efforts to provide you the best functionalities. It would be highly appreciable if you could spend a couple of seconds to give a Nice Review to the plugin to appreciate our efforts. So we can work hard to provide new features regularly :)</p><a class="close_utm_help fm_close_btn_1" href="javascript:void(0)" data-ct="rate_later" title="Remind me later">Later</a> <a class="close_utm_help fm_close_btn_2" href="https://wordpress.org/support/plugin/tru-utm-generator/reviews/?filter=5" data-ct="rate_now" title="Rate us now" target="_blank">Rate Us</a> <a class="close_utm_help fm_close_btn_3" href="javascript:void(0)" data-ct="rate_never" title="Not interested">Never</a>';
            $mkcontent .= '</div></div>';
            if (false === ($mk_tru_utm_close_help_c = get_option('mk_tru_utm_close_help_c'))) {
                echo apply_filters('the_content', $mkcontent);
            }
        }
        /*
         Close Help
        */
        public function mk_tru_utm_generator_help()
        {
            if (false === ($mk_tru_utm_close_help_c = get_option('mk_tru_utm_close_help_c'))) {
                $set = update_option('mk_tru_utm_close_help_c', 'done');
                if ($set) {
                    echo 'ok';
                } else {
                    echo 'oh';
                }
            } else {
                echo 'ac';
            }
            die;
        }

         }
         new tru_utm_generator;
}