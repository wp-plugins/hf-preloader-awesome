<?php
/*
Plugin Name: HF-Preloader-awesome
Plugin URI: http://hf-it.org
Description: This plugin add preloader in your wordpress site.
Author: HF Persons
Author URI: http://hf-it.org
Version: 1.2
*/

    /* Adding Latest jQuery from Wordpress */
    function hf_preloader_plugin_wp() {
        wp_enqueue_script('jquery');
    }
    add_action('init', 'hf_preloader_plugin_wp');


    /*Some Set-up*/
    define('HF_PRELOADER', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

function hf_preloader_css_and_js() {
   wp_enqueue_script('hf_preloader_pace_js',HF_PRELOADER.'js/pace.min.js',array('jquery'),'1.0.2',false);
   wp_enqueue_script('hf_preloader_lobal_active',HF_PRELOADER.'js/active.js',array('jquery'),'1.0',false);
   wp_enqueue_style('hf_preloader_main',HF_PRELOADER.'css/main.css',array(),'1.0','all');
}
add_action('wp_enqueue_scripts', 'hf_preloader_css_and_js');


  


    function hf_aleart_add_menu_options() {  
        add_options_page('Preloader Settings', 'HF-Preloader Settings', 'manage_options', 'preloader-settings','hf_preloader_options_panel');  
    }  
    add_action('admin_menu', 'hf_aleart_add_menu_options');



function hf_wp_color_picker( $hook ) {
    if( is_admin() ) {
        // Add the color picker css file      
        wp_enqueue_style( 'wp-color-picker' );

        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( '/js/color-pickr.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
        wp_enqueue_style('hf_admin',HF_PRELOADER.'css/admin.css');                              wp_enqueue_script('hf_beefup',HF_PRELOADER.'js/jquery.beefup.min.js',array('jquery'),'1.0.1',false);
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
        'hf_pace_options_type' => 'barber'
    );


    $hf_preloader_type = array(
        'rotating_plane' => array(
            'value' => 'r_plane',
            'label' => 'Rotating Plane'
        ),
        'double_bounce' => array(
            'value' => 'd_bounce',
            'label' => 'Double Bounce'
        ),  
         'hf_pre_wave' => array(
            'value' => 'hf_wave',
            'label' => 'Wave'
        ),  
         'wandering-cubes' => array(
            'value' => 'wandering_c',
            'label' => 'Wandering Cubes'
        ),  
         'chasing-dots' => array(
            'value' => 'chasing_dot',
            'label' => 'Chasing Dots'
        ),  
         'cube-grid' => array(
            'value' => 'cube_g',
            'label' => 'Cube Grid'
        )         
    );

    $hf_pace_options_type = array(
        'barber_shop_animation' => array(
            'value' => 'barber',
            'label' => 'Barber Shop'
        ),
        'big_c_animation' => array(
            'value' => 'bc',
            'label' => 'Big Counter'
        ),
        'loading_bar_animation' => array(
            'value' => 'loading_bar',
            'label' => 'Loading Bar'
        ),          
        'mac_osx_animation' => array(
            'value' => 'mac_osx',
            'label' => 'Mac-Osx'
        ),  
        'center_cir_animation' => array(
            'value' => 'center_cir',
            'label' => 'Center Circle'
        ),
        'center_nu_animation' => array(
            'value' => 'center_nu',
            'label' => 'Center Numaric'
        ),          
        'center_atom_animation' => array(
            'value' => 'center_atom',
            'label' => 'Center Atom'
        ), 
        'center_Mini_animation' => array(
            'value' => 'center_mini',
            'label' => 'Center Minimul'
        ), 
        'center_flash_animation' => array(
            'value' => 'center_fla',
            'label' => 'Flash'
        ), 
        'center_s_animation' => array(
            'value' => 'center_sim',
            'label' => 'Center Simple'
        ), 
        
    );


function hf_preloader_options_panel() {
    global $hf_preloader_g_options, $hf_preloader_type, $hf_pace_options_type;

    if ( ! isset( $_REQUEST['updated'] ) )
        $_REQUEST['updated'] = false; // Getting custom data from database ?>

    <div class="wrap">

        <h2>HF-Preloader Settings</h2>

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
    <h2 class="beefup-head">Page Loading Progress Style</h2>
    <div class="beefup-body">
        <div id="pro" class="wp-preloader-single-option">
			<?php foreach( $hf_pace_options_type as $activate ) : ?>
           <div class="single_option" <?php checked( $settings['hf_pace_options_type'], $activate['value'] ); ?>>
            
			    <input type="radio" id="<?php echo $activate['value']; ?>" name="hf_preloader_options[hf_pace_options_type]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['hf_pace_options_type'], $activate['value'] ); ?> />
            
			<label class="<?php  echo $activate['value']; ?>" for="<?php echo $activate['value']; ?>"><span id="<?php  echo $activate['value']; ?>" class="label_img"></span> <p><?php echo $activate['label']; ?></p></label>
			</div>
			<?php endforeach; ?>		
		</div>
		
<div class="progres_color">
    <table id="p_color_area" class="form-table">
       <h2 id="p_color">Progress Style Color Settings</h2>
        <tr valign="top" id="Pcolor">
            <th scope="row"><label for="progress_color">Progress  Color</label></th>
            <td>
            <input id="progress_color" type="text" name="hf_preloader_options[progress_color]" value="<?php echo stripslashes($settings['progress_color']); ?>" class="color-field" /><p class="description">Select Progress Color here. You can also add html HEX color code.</p> 
            </td>
        </tr>

    </table>        
</div>
   
    </div>
</article>
<article class="beefup">
    <h2 class="beefup-head">Preloader Awesome Style</h2>
    <div class="beefup-body">
		<div class="wp-preloader-single-option">
			<?php foreach( $hf_preloader_type as $activate ) : ?>  
           <div class="single_option" <?php checked( $settings['hf_preloader_type'], $activate['value'] ); ?>>
         
			    <input type="radio" id="<?php echo $activate['value']; ?>" name="hf_preloader_options[hf_preloader_type]" value="<?php esc_attr_e( $activate['value'] ); ?>" <?php checked( $settings['hf_preloader_type'], $activate['value'] ); ?> />			    
    <label class="<?php echo $activate['value']; ?>" for="<?php echo $activate['value']; ?>"><span id="<?php  echo $activate['value']; ?>" class="label_img"></span> <?php echo $activate['label']; ?>        </label>
            </div>
			<?php endforeach; ?>		
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
     </table>        
    </div>
</article>



        <p class="submit"><input type="submit" class="button-primary" value="Done" /></p>
    </form>
    </div>

<?php
}
// validate data options
    function hf_preloader_validate_options( $input ) {
        global $hf_preloader_g_options, $hf_preloader_type, $hf_pace_options_type;

        $settings = get_option( 'hf_preloader_options', $hf_preloader_g_options );

        // We strip all tags from the text field, to avoid vulnerablilties like XSS

        $input['preloader_bg_color'] = wp_filter_post_kses( $input['preloader_bg_color'] );
        $input['preloader_color'] = wp_filter_post_kses( $input['preloader_color'] );
        $input['progress_color'] = wp_filter_post_kses( $input['progress_color'] );
        
        
        $prev = $settings['layout_only'];
        
        if ( !array_key_exists( $input['layout_only'], $hf_preloader_type ) )
            
        if ( !array_key_exists( $input['layout_only'], $hf_pace_options_type ) )
		$input['layout_only'] = $prev;	
	
	return $input;
}
endif; 

function pace_animation_css(){
    global $hf_preloader_g_options; $hf_pace_css_and_color_settings = get_option( 'hf_preloader_options', $hf_preloader_g_options );
   
if ( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'bc' ) : 
    
wp_enqueue_style('hf_pace_bc', HF_PRELOADER.'css/pace/pace-theme-big-counter.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress:after {background-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>}
    </style>
<?php    
    
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'loading_bar') : 		
wp_enqueue_style('hf_pace_loading_bar', HF_PRELOADER.'css/pace/pace-theme-loading-bar.css'); 
?>
    <style type="text/css">    
        .pace {background-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>;
        border-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>
        }
        .pace .pace-progress{ color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>}
    </style>
<?php
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'mac_osx') : 		
wp_enqueue_style('hf_mac_osx', HF_PRELOADER.'css/pace/pace-theme-mac-osx.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress {background-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?> !important            color:  <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
                            
    </style>
<?php
    
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'center_cir') : 		
wp_enqueue_style('hf_center_cir', HF_PRELOADER.'css/pace/pace-theme-center-circle.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress {background: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>}
    </style>
<?php
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'center_nu') : 		
wp_enqueue_style('hf_center_nu', HF_PRELOADER.'css/pace/pace-theme-center-nu.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress {color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    </style>
<?php
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'center_mini') : 		
wp_enqueue_style('hf_center_mini', HF_PRELOADER.'css/pace/pace-theme-minimal.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress {background: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    </style>
<?php
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'center_fla') : 		
wp_enqueue_style('hf_center_fla', HF_PRELOADER.'css/pace/pace-theme-flash.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress {background: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    .pace .pace-activity {border-top-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important;
    border-left-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    </style>
<?php

        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'center_atom') : 		
wp_enqueue_style('hf_center_atom', HF_PRELOADER.'css/pace/pace-theme-center-atom.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress:before {color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    .pace .pace-progress:after,.pace .pace-activity:after,.pace .pace-activity:before{border-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    </style>
<?php
        elseif( $hf_pace_css_and_color_settings['hf_pace_options_type'] == 'center_sim') : 		
wp_enqueue_style('hf_center_sim', HF_PRELOADER.'css/pace/pace-theme-center-simple.css'); 
?>
    <style type="text/css">    
    .pace .pace-progress:before {color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    .pace .pace-progress:after,.pace .pace-activity:after,.pace .pace-activity:before{border-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>!important}
    </style>
<?php
    
        else : 	wp_enqueue_style('hf_pace_barber',HF_PRELOADER.'css/pace/pace-theme-barber-shop.css',array());
?>
    <style type="text/css">    
    .pace .pace-progress { background-color: <?php echo $hf_pace_css_and_color_settings['progress_color']; ?>}
    </style>
<?php
endif;
}
add_action('wp_enqueue_scripts','pace_animation_css');


    function hf_preloader_html() {
        global $hf_preloader_g_options; $hf_pre_loader_ht_n_settings = get_option( 'hf_preloader_options', $hf_preloader_g_options ); 
        
     if( $hf_pre_loader_ht_n_settings['hf_preloader_type'] == 'd_bounce') : 

?>  
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div class="hf_spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>      
    </div>
<?php
  elseif( $hf_pre_loader_ht_n_settings['hf_preloader_type'] == 'hf_wave') : 
?>  
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div class="hf_spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>      
    </div>
<?php
  elseif( $hf_pre_loader_ht_n_settings['hf_preloader_type'] == 'wandering_c') : 
?>  
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div class="hf_spinner"></div>      
    </div>
<?php
  elseif( $hf_pre_loader_ht_n_settings['hf_preloader_type'] == 'chasing_dot') : 
?>  
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div class="hf_spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>     
    </div>
<?php
  elseif( $hf_pre_loader_ht_n_settings['hf_preloader_type'] == 'cube_g') : 
?>  
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div class="hf_spinner">
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
        </div>    
    </div>
<?php

      
else:
?>       
    <div class="hf_preloader_container">
        <div class="hf_overlay"></div>
        <div class="hf_spinner"></div>      
    </div>
<?php
endif;
    }
    add_action('wp_footer', 'hf_preloader_html');


//Add data from custom css file
function add_hf_preloader_data_form_plugin() {
    
    global $hf_preloader_g_options; $hf_pre_loader_n_settings = get_option( 'hf_preloader_options', $hf_preloader_g_options ); 
    
if ( $hf_pre_loader_n_settings['hf_preloader_type'] == 'd_bounce') : 
wp_enqueue_style('hf_preloader_d_bounce',HF_PRELOADER.'css/pre-css/double-bounce.css');
?>
    <style type="text/css">    
        div.double-bounce1, div.double-bounce2 {background-color: <?php echo $hf_pre_loader_n_settings['preloader_color']; ?>}
    </style>
<?php    
    elseif( $hf_pre_loader_n_settings['hf_preloader_type'] == 'hf_wave') : 
wp_enqueue_style('hf_preloader_hf_wave',HF_PRELOADER.'css/pre-css/wave.css');
?>
    <style type="text/css">    
    div.hf_spinner > div {background-color: <?php echo $hf_pre_loader_n_settings['preloader_color']; ?>}
    </style>
<?php
    elseif( $hf_pre_loader_n_settings['hf_preloader_type'] == 'wandering_c') : 
wp_enqueue_style('hf_preloader_hf_wandering_c',HF_PRELOADER.'css/pre-css/wandering-cubes.css');
?>
    <style type="text/css">    
        div.hf_spinner:before, div.hf_spinner:after {background-color: <?php echo $hf_pre_loader_n_settings['preloader_color']; ?>}
    </style>
<?php
    elseif( $hf_pre_loader_n_settings['hf_preloader_type'] == 'chasing_dot') : 
wp_enqueue_style('hf_preloader_hf_chasing_dot',HF_PRELOADER.'css/pre-css/chasing-dots.css');
?>
    <style type="text/css">    
        div.dot1, div.dot2 {background-color: <?php echo $hf_pre_loader_n_settings['preloader_color']; ?>}
    </style>
<?php
    elseif( $hf_pre_loader_n_settings['hf_preloader_type'] == 'cube_g') : 
wp_enqueue_style('hf_preloader_hf_cube_g',HF_PRELOADER.'css/pre-css/cube-grid.css');
?>
    <style type="text/css">    
        div.cube {background-color: <?php echo $hf_pre_loader_n_settings['preloader_color']; ?>}
    </style>
<?php

     
    else:
wp_enqueue_style('hf_preloader_rotat',HF_PRELOADER.'css/pre-css/rotating.css');
?>
    <style type="text/css">    
        div.hf_spinner {background-color: <?php echo $hf_pre_loader_n_settings['preloader_color']; ?>}
    </style>
<?php
endif;   
    
    

?><style type="text/css">    
        div.hf_overlay {background-color:<?php echo $hf_pre_loader_n_settings['preloader_bg_color']; ?>}
</style><?php
}
add_action('wp_head', 'add_hf_preloader_data_form_plugin');
    
    




