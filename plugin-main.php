<?php
/*
Plugin Name: HF-Preloader-Awesome 
Plugin URI: http://Lazy.org/plugins/Preloder
Description: For awesome style download & Install it.
Author: HelpFull(HF) Institute
Author URI: #
Version: 1.1.0
*/

    /* Adding Latest jQuery from Wordpress */
    function hf_preloader_plugin_wp() {
        wp_enqueue_script('jquery');
    }
    add_action('init', 'hf_preloader_plugin_wp');


    /*Some Set-up*/
    define('HF_PRELOADER', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

function hf_preloader_css_and_js() {
   wp_enqueue_script('hf_preloader_pace_js',HF_PRELOADER.'js/pace.min.js',array('jquery'),'0.5.7',false);
wp_enqueue_script('hf_preloader_lobal_active',HF_PRELOADER.'js/active.js',array('jquery'),'1.0',false);
   wp_enqueue_script('hf_preloader_global_modernizr',HF_PRELOADER.'js/modernizr.custom.63321.js',
                     array('jquery'),'2.6.2',false);
   wp_enqueue_style('hf_preloader_main',HF_PRELOADER.'css/main.css',array(),'1.0','all');
}
add_action('wp_enqueue_scripts', 'hf_preloader_css_and_js');


   function hf_aleart_add_menu_options() {  
        add_menu_page( 'Preloader-Settings', 'HF Preloader Settings', 'manage_options','preloader_option', 'hf_preloader_options_panel', plugins_url( '/img/pre.png', __FILE__  ), 5 );
        add_options_page('Preloader Settings', 'HF-Preloader Settings', 'manage_options', 'preloader-settings','hf_preloader_options_panel');  
    }  
    add_action('admin_menu', 'hf_aleart_add_menu_options');


function hf_wp_color_picker( $hook ) {
    if( is_admin() ) {
        // Add the color picker css file      
        wp_enqueue_style( 'wp-color-picker' );

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( '/js/color-pickr.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_enqueue_style('hf_admin',HF_PRELOADER.'css/admin.css');                                                 wp_enqueue_script('hf_beefup',HF_PRELOADER.'js/jquery.beefup.min.js',array('jquery'),
            '1.0.1',false);                                       
        wp_enqueue_script('hf_pace_admin',HF_PRELOADER.'js/admin.js',array('jquery')); 
    }
}
add_action( 'admin_enqueue_scripts', 'hf_wp_color_picker' );


if ( is_admin() ) : // Load only if It is Admmin

function hf_preloader_register_settings() {
    // Register settings and call sanitation functions 
    register_setting( 'hf_preloader_sf_options', 'hf_preloader_options','hf_preloader_validate_options' );
}
add_action( 'admin_init', 'hf_preloader_register_settings' );


    // Default options values
    $hf_preloader_g_options = array(
        'preloader_bg_color' => '#000',
        'preloader_color' => '#fff',
        'progress_color' => '#ccc',
        'hf_preloader_type' => 'r_plane',
    );

    $hf_preloader_type1 = array(
         'rotating_particles' => array(
            'value' => 'particles',
            'label' => 'Particles'
        )      
    ); 
    



function hf_preloader_options_panel() {
    global $hf_preloader_g_options, $hf_preloader_type1;

    if ( ! isset( $_REQUEST['updated'] ) )
        $_REQUEST['updated'] = false; // Getting custom data from database ?>

    <div class="wrap">

        <h2>HF-Preloader Settings
        <h4 id="h_dis">! Next version will available soon With a powerfull option panel and it will be totally free. </h4>
        </h2>

    <?php if ( false !== $_REQUEST['updated'] ) : ?>
    <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
    <?php endif; // When click done, it will show the notification ?>

    <form method="post" action="options.php">
        <?php $settings = get_option( 'hf_preloader_options', $hf_preloader_g_options ); ?>

        <?php settings_fields( 'hf_preloader_sf_options' );
        /* This function outputs some hidden fields required by the form,
        including a nonce, a unique number used to ensure the form has been submitted from the admin page
        and not somewhere else,it is most important for database security */ ?>


<article class="beefup">
    <h2 class="beefup-head">Preloader Awesome  Style & News</h2>
    <div class="beefup-body">
		<div class="wp-preloader-single-option">
			<?php foreach( $hf_preloader_type1 as $activate ) : ?>  
           <div class="single_option" <?php checked( $settings['hf_preloader_type'], $activate['value'] ); ?>>
         
			    <input type="radio" id="<?php echo $activate['value']; ?>" name="hf_preloader_options[hf_preloader_type]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['hf_preloader_type'], $activate['value'] ); ?> />			    
    <label class="<?php echo $activate['value']; ?>" for="<?php echo $activate['value']; ?>"><span id="<?php  echo $activate['value']; ?>" class="label_img"></span> <?php echo $activate['label']; ?>        </label>
            </div>
			<?php endforeach; ?>
			<p id="dis" class="description">! Next version will available soon With a powerfull option panel and it will be totally free. Use This Awesome style. Here we set few Example,But In <span>premium</span>  version You will find <span>100+</span> Awesome style & design,<span>Unlimited</span> color with progress Bar.You can <span>change</span> any option as your own. This plugin is light weight more faster, Uer friendly, full responsive and supported all kind of device. If You want to Use More You Can buy Our premium latest version ( You will find this plugin By Search hf-awesome preloader in google search ) Thank You for using this.</p> 		
		</div>               
    </div>
</article>



<article class="beefup">
    <h2 class="beefup-head">Preloader Color Settings</h2>
    <div class="beefup-body">
       <table class="form-table">
<tr valign="top">
    <th scope="row"><label for="preloader_color">Preloader Color</label></th>
    <td>
        <input id="preloader_color" type="text" name="hf_preloader_options[preloader_color]" value="<?php echo stripslashes($settings['preloader_color']); ?>" class="color-field" /><p class="description">Select Preloader Color here. You can also add html HEX color code.</p> 
    </td>
</tr>
<tr valign="top">
    <th scope="row"><label for="preloader_bg_color">Preloader Background Color</label></th>
    <td>
        <input id="preloader_bg_color" type="text" name="hf_preloader_options[preloader_bg_color]" value="<?php echo stripslashes($settings['preloader_bg_color']); ?>" class="color-field" /><p class="description">Select Preloader Background Color here. You can also add html HEX color code.</p>
    </td>
</tr>
    <p id="dis" class="description">! Next version will available soon With a powerfull option panel and it will be totally free. Use This Awesome style. Here we set few Example,But In <span>premium</span>  version You will find <span>100+</span> Awesome style & design,<span>Unlimited</span> color with progress Bar.You can <span>change</span> any option as your own. This plugin is light weight more faster, Uer friendly, full responsive and supported all kind of device. If You want to Use More You Can buy Our premium latest version ( You will find this plugin By Search hf-awesome preloader in google search ) Thank You for using this.</p> 
    <hr>	
     </table>        
    </div>
</article>

        <p class="submit"><input type="submit" class="button-primary" value="Done" /></p>
        <hr>
<div class="panel">
    <p id="panel_img_dis" class="description">[  This Option Panel of our <Span>premium</Span> plugin  ]</p> 
    <div class="panel_img1">

    </div>
    <div class="panel_img2">

    </div>
</div>
    </form>
    </div>

<?php
}
// validate data options
    function hf_preloader_validate_options( $input ) {
        global $hf_preloader_g_options, $hf_preloader_type1;

        $settings = get_option( 'hf_preloader_options', $hf_preloader_g_options );

        // We strip all tags from the text field, to avoid vulnerablilties like XSS

        $input['preloader_bg_color'] = wp_filter_post_kses( $input['preloader_bg_color'] );
        $input['preloader_color'] = wp_filter_post_kses( $input['preloader_color'] );
        $input['progress_color'] = wp_filter_post_kses( $input['progress_color'] );
        
        
        $prev = $settings['layout_only'];
        
        if ( !array_key_exists( $input['layout_only'], $hf_preloader_type1 ) )

            
		$input['layout_only'] = $prev;	
	
	return $input;
}
endif; 



    function hf_preloader_html() {
        global $hf_preloader_g_options; $hf_pre_loader_ht_n_settings = get_option( 'hf_preloader_options', $hf_preloader_g_options ); 
        
     
?> 
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div id="zet">
            <canvas id="c"></canvas>
        </div>
           
    </div> 
<?php
 


    }
    add_action('wp_footer', 'hf_preloader_html');


//Add data from custom css file
function add_hf_preloader_data_form_plugin() {
    
    global $hf_preloader_g_options; $hf_pre_loader_n_settings = get_option( 'hf_preloader_options', $hf_preloader_g_options ); 
    

    wp_enqueue_style('hf_preloader_particles',HF_PRELOADER.'css/pre-css/particles.css');   
wp_enqueue_script('particles',HF_PRELOADER.'js/pre/hfindex.js',array('jquery'));
?>
    <style type="text/css">    
       
    </style>
<?php    
   

?><style type="text/css">    
        div.hf_overlay {background-color:<?php echo $hf_pre_loader_n_settings['preloader_bg_color']; ?>}
</style><?php
}
add_action('wp_head', 'add_hf_preloader_data_form_plugin');
    
    










