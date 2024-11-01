<?php if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
$table_name = $wpdb->prefix . "tru_utm_generator";
$allEnties = $wpdb->get_results("select * from ".$table_name." order by id desc");
?>
<div class="wrap tru_utm_records utm_outer_common">
<?php $this->load_help_desk(); ?>
    <div class="utm_common_container">
<?php if (isset($_GET['msg']) && $_GET['msg'] == '1'):?>
<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('UTM record deleted successfully.', 'tru-utm-generator'); ?></strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'tru-utm-generator'); ?></span></button></div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] == '2'):?>
<div class="error updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong><?php _e('Unable to delete UTM record.', 'tru-utm-generator'); ?></strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'tru-utm-generator'); ?></span></button></div>
<?php endif; ?>

    <div class="common_heading">
    <span class="dash_utm_icon">
        <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/details.svg'; ?>">
        </span>
        <h3><?php _e('UTM Details', 'tru-utm-generator'); ?></h3>
    </div>

        

        <?php if(isset($_GET['action']) && $_GET['action'] == 'trash' && wp_verify_nonce( isset($_GET['nonce']) ? $_GET['nonce'] : '', 'tru_utm_record_delete' ) && isset($_GET['id'])) {
            _e('Deleting please wait...', 'tru-utm-generator');
            $delete = $wpdb->delete($table_name, array('id' => $_GET['id']));
            if($delete) {
                $this->redirect('?page=tru_utm_generator&msg=1');
            } else {
                $this->redirect('?page=tru_utm_generator&msg=2');
            }
        } ?>
        <table id="tru_utm_records" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th width="10%"><?php _e('Name', 'tru-utm-generator'); ?></th>
                    <th width="20%"><?php _e('Email', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Domain', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Source', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Medium', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Campaign', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Date', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Published', 'tru-utm-generator'); ?></th>
                    <th width="10%"><?php _e('Action', 'tru-utm-generator'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($allEnties) && isset($allEnties)) { 
                foreach($allEnties as $utm) { ?>
                <tr>
                    <td><?php echo $utm->client_name;?></td>
                    <td><?php echo $utm->client_email;?></td>
                    <td><?php echo $utm->client_domain;?></td>
                    <td><?php echo $utm->utm_source;?></td>
                    <td><?php echo $utm->utm_medium;?></td>
                    <td><?php echo $utm->utm_campaign;?></td>
                    <td><?php echo $utm->utm_date;?></td>
                    <td><?php echo $utm->publish_date;?></td>
                    <th><a href="#" class="view_utm_link" data-link="<?php echo $utm->client_domain;?>?utm_medium=<?php echo $utm->utm_medium;?>&utm_source=<?php echo $utm->utm_source;?>&utm_campaign=<?php echo $utm->utm_campaign;?><?php echo !empty($utm->utm_date) ? '&utm_date='.$utm->utm_date : ''; ?>"><?php _e(' <img src="'.plugin_dir_url( dirname( __FILE__ ) ) . 'images/search.png">', 'tru-utm-generator'); ?></a> | <a href="admin.php?page=tru_utm_generator&action=trash&id=<?php echo $utm->id;?>&nonce=<?php echo wp_create_nonce( 'tru_utm_record_delete' )?>" onclick="return confirm('Are You sure want to delete?');"><?php _e(' <img src="'.plugin_dir_url( dirname( __FILE__ ) ) . 'images/delete.png">', 'tru-utm-generator'); ?></a></th>
                </tr> 
            <?php } } ?>         
            </tbody>
        </table>
    </div>
</div><!--tru_utm_records-->

<div class="utm_view_popup_wrap">
    <div class="utm_view_popup_tbl">
        <div class="utm_view_popup_cel">
        	<div class="utm_view_popup_inner">
            <a href="javascript:void(0)" class="close_utm_view_popup">&times;</a>
            <h3><?php _e('UTM URL', 'tru-utm-generator'); ?></h3>
            <code id="view_utm_link">  </code>
            <p class="description"><?php _e('Copy Link and Share', 'tru-utm-generator'); ?></p>
            </div>        
        </div>
    </div>
</div><!---->