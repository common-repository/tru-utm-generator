<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap tru_utm_settings_page">
<?php $this->load_help_desk(); ?>
  <div class="utm_setting_container">
<?php if (isset($_GET['msg']) && $_GET['msg'] == '1'):?>
<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('Settings saved.', 'tru-utm-generator'); ?></strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'tru-utm-generator'); ?></span></button></div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] == '2'):?>
<div class="error updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('Settings not saved.', 'tru-utm-generator'); ?></strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'tru-utm-generator'); ?></span></button></div>
<?php endif; ?>
  <div class="setting_heading">
  <span class="dash_utm_icon">
    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/settings.svg'; ?>">
    </span>
    <h3><?php _e('Settings', 'tru-utm-generator');?></h3>
  </div>
<?php if (isset($_POST['save_utm_settings']) && wp_verify_nonce($_POST['tru_utm_nonce_field'], 'tru_utm_action')):
  _e('<strong>Saving Please wait...</strong>', 'tru-utm-generator');
  $tru_utm_generator_options = array();
  if((isset($_POST['utm_domains']) && !empty($_POST['utm_domains'])) || (isset($_POST['utm_source']) && !empty($_POST['utm_source'])) || (isset($_POST['utm_medium']) && !empty($_POST['utm_medium']))) {

    $tru_utm_generator_options['utm_domains'] = (isset($_POST['utm_domains']) && !empty($_POST['utm_domains'])) ? sanitize_text_field($_POST['utm_domains']) : '';
    $tru_utm_generator_options['utm_source'] = (isset($_POST['utm_source']) && !empty($_POST['utm_source'])) ? sanitize_text_field($_POST['utm_source']) : '';
    $tru_utm_generator_options['utm_medium'] = (isset($_POST['utm_medium']) && !empty($_POST['utm_medium'])) ? sanitize_text_field($_POST['utm_medium']) : '';
    $tru_utm_generator_options['publish_date'] = date('Y-m-d h:i:s a');

    $saveSettings = update_option('tru_utm_generator_options', $tru_utm_generator_options);


  } else {
    $saveSettings = false;  
  }
    if($saveSettings) {
        $this->redirect('?page=tru_utm_generator_settings&msg=1');
    } else {
        $this->redirect('?page=tru_utm_generator_settings&msg=2');
    }
endif;
$opt = get_option('tru_utm_generator_options');
?>
    <form action="admin.php?page=tru_utm_generator_settings" method="post">
    <?php  wp_nonce_field('tru_utm_action', 'tru_utm_nonce_field'); ?>
        <table class="form-table">
            <tbody>
            <tr>
            <th scope="row"><?php _e('UTM Domains', 'tru-utm-generator');?></th>
            <td><fieldset><legend class="screen-reader-text"><span><?php _e('UTM Domains', 'tru-utm-generator');?></span></legend>
            <p><label for="utm_domains"><?php _e('Enter multiple domains seprated by comma(,). It will show in shortcode domains list on frontend. <strong>Example: https:domain1.com,https:domain2.com</strong>', 'tru-utm-generator');?></label></p>
            <p>
            <textarea name="utm_domains" rows="6" cols="50" id="utm_domains" class="large-text code"><?php echo (isset($opt['utm_domains']) && !empty($opt['utm_domains'])) ? $opt['utm_domains'] : ''; ?></textarea>
            </p>
            </fieldset></td>
            </tr>

            <tr>
            <th scope="row"><?php _e('UTM Source', 'tru-utm-generator');?></th>
            <td><fieldset><legend class="screen-reader-text"><span><?php _e('UTM Source', 'tru-utm-generator');?></span></legend>
            <p><label for="utm_source"><?php _e('Enter multiple UTM Sources seprated by comma(,). It will show in shortcode UTM Source list on frontend. <strong>Example: utmsource1,utmsource2</strong>', 'tru-utm-generator');?></label></p>
            <p>
            <textarea name="utm_source" rows="6" cols="50" id="utm_source" class="large-text code"><?php echo (isset($opt['utm_source']) && !empty($opt['utm_source'])) ? $opt['utm_source'] : ''; ?></textarea>
            </p>
            </fieldset></td>
            </tr>

            <tr>
            <th scope="row"><?php _e('UTM Medium', 'tru-utm-generator');?></th>
            <td><fieldset><legend class="screen-reader-text"><span><?php _e('UTM Medium', 'tru-utm-generator');?></span></legend>
            <p><label for="utm_medium"><?php _e('Enter multiple UTM Mediums seprated by comma(,). It will show in shortcode UTM Medium list on frontend. <strong>Example: utm-medium1,utm-medium2</strong>', 'tru-utm-generator');?></label></p>
            <p>
            <textarea name="utm_medium" rows="6" cols="50" id="utm_medium" class="large-text code"><?php echo (isset($opt['utm_medium']) && !empty($opt['utm_medium'])) ? $opt['utm_medium'] : ''; ?></textarea>
            </p>
            </fieldset></td>
            </tr>

            </tbody>
        </table>
        <span class="setting_short_utm"><?php _e('Shortcode: <code>[tru_utm_generator]</code>, Copy the shortcode and paste in your page.', 'tru-utm-generator');?> </span>
        <p class="submit"><input type="submit" name="save_utm_settings" id="save_utm_settings" class="button button-primary" value="Save Changes"></p>
    </form>
    <!--form-->
  </div>
</div>
<!--tru_utm_settings_page-->