<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap tru_utm_email_page">
<?php $this->load_help_desk(); ?>
    <div class="utm_email_container">
<?php if (isset($_GET['msg']) && $_GET['msg'] == '1'):?>
<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('Settings saved.', 'tru-utm-generator'); ?></strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'tru-utm-generator'); ?></span></button></div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] == '2'):?>
<div class="error updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('Settings not saved.', 'tru-utm-generator'); ?></strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'tru-utm-generator'); ?></span></button></div>
<?php endif; ?>
    <div class="email_heading">
    <span class="dash_utm_icon">
        <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/mail settings.svg'; ?>">
        </span>
        <h3><?php _e('Email Settings', 'tru-utm-generator');?></h3>
  </div>
<?php if (isset($_POST['save_utm_settings']) && wp_verify_nonce($_POST['tru_utm_nonce_field'], 'tru_utm_action')):
  _e('<strong>Saving Please wait...</strong>', 'tru-utm-generator');

    $tru_utm_generator_email_options = array();

    $tru_utm_generator_email_options['utm_email_from'] = (isset($_POST['utm_email_from']) && !empty($_POST['utm_email_from'])) ? sanitize_text_field($_POST['utm_email_from']) : '';

    $tru_utm_generator_email_options['utm_email_subject'] = (isset($_POST['utm_email_subject']) && !empty($_POST['utm_email_subject'])) ? sanitize_text_field($_POST['utm_email_subject']) : '';

    $tru_utm_generator_email_options['utm_email_reply_to'] = (isset($_POST['utm_email_reply_to']) && !empty($_POST['utm_email_reply_to'])) ? sanitize_text_field($_POST['utm_email_reply_to']) : '';

    $tru_utm_generator_email_options['utm_email_body'] = (isset($_POST['utm_email_body']) && !empty($_POST['utm_email_body'])) ? $_POST['utm_email_body'] : '';

    $saveSettings = update_option('tru_utm_generator_email_options', $tru_utm_generator_email_options);

    if($saveSettings) {
        $this->redirect('?page=tru_utm_generator_email_settings&msg=1');
    } else {
        $this->redirect('?page=tru_utm_generator_email_settings&msg=2');
    }
endif;
$opt = get_option('tru_utm_generator_email_options'); ?>
    <form action="admin.php?page=tru_utm_generator_email_settings" method="post">
        <?php wp_nonce_field('tru_utm_action', 'tru_utm_nonce_field'); ?>
        <table class="form-table">
            <tbody>
            <tr>
            <th scope="row"><label for="utm_email_from"><?php _e('From', 'tru-utm-generator'); ?></label></th>
            <td><input name="utm_email_from" type="email" id="utm_email_from" value="<?php echo (isset($opt['utm_email_from']) && !empty($opt['utm_email_from'])) ? $opt['utm_email_from'] : get_option('admin_email'); ?>" class="regular-text"></td>
            </tr>
            <tr>
            <th scope="row"><label for="utm_email_subject"><?php _e('Subject', 'tru-utm-generator'); ?></label></th>
            <td><input name="utm_email_subject" type="text" id="utm_email_subject" value="<?php echo (isset($opt['utm_email_subject']) && !empty($opt['utm_email_subject'])) ? $opt['utm_email_subject'] : ''; ?>" class="regular-text"></td>
            </tr>
            <tr>
            <th scope="row"><label for="utm_email_reply_to"><?php _e('Reply To', 'tru-utm-generator'); ?></label></th>
            <td><input name="utm_email_reply_to" type="email" id="utm_email_reply_to" value="<?php echo (isset($opt['utm_email_reply_to']) && !empty($opt['utm_email_reply_to'])) ? $opt['utm_email_reply_to'] : ''; ?>" class="regular-text"></td>
            </tr>
            <tr>
            <th scope="row"><?php _e('Body', 'tru-utm-generator');?></th>
            <td><fieldset><legend class="screen-reader-text"><span><?php _e('Body', 'tru-utm-generator');?></span></legend>
            <p><label for="utm_email_body"><?php _e('Email body text.', 'tru-utm-generator');?></label></p>
            <p>
            <textarea name="utm_email_body" rows="10" cols="50" id="utm_email_body" class="large-text code"><?php echo (isset($opt['utm_email_body']) && !empty($opt['utm_email_body'])) ? stripslashes($opt['utm_email_body']) : ''; ?></textarea>
            </p>
            <p><?php _e('Use: {{name}} -> Client Name, {{email}} -> Client Email, {{link}} -> UTM Link , HTML tags are allowed.', 'tru-utm-generator'); ?></p>
            </fieldset></td>
            </tr>

            </tbody>
        </table>
        <p class="submit"><input type="submit" name="save_utm_settings" id="save_utm_settings" class="button button-primary" value="Save Changes"></p>
    </form>
</div><!---utm_setting_container-->
</div><!--tru_utm_email_page-->