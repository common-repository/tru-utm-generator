<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$opt = get_option('tru_utm_generator_options');
$domainOpt = (isset($opt['utm_domains']) && !empty($opt['utm_domains'])) ? $opt['utm_domains'] : '';
$domains = explode(',', $domainOpt);
$sourceOpt = (isset($opt['utm_source']) && !empty($opt['utm_source'])) ? $opt['utm_source'] : '';
$sources = explode(',', $sourceOpt);
$mediumOpt = (isset($opt['utm_medium']) && !empty($opt['utm_medium'])) ? $opt['utm_medium'] : '';
$mediums = explode(',', $mediumOpt);
?>
<div class="tru_utm_form_shortcode">
    <div class="frm_col_grp">
      <div class="col_div_3 frm_col_left_label">
        <label for="utm_fname"><?php _e('Full Name', 'tru-utm-generator');?></label>
      </div>
      <div class="col_div_3 frm_col_input">
        <input type="text" id="utm_fname" name="utm_fname">
      </div>
      <div class="col_div_3 frm_col_right_label">
        <label><?php _e('Enter your name here', 'tru-utm-generator');?></label>
      </div>
    </div>
    
    <div class="frm_col_grp">
      <div class="col_div_3 frm_col_left_label">
        <label for="utm_email"><?php _e('Email Address', 'tru-utm-generator');?></label>        
      </div>
      <div class="col_div_3 frm_col_input">
        <input type="email" id="utm_email" name="utm_email">
      </div>
      <div class="col_div_3 frm_col_right_label">
        <?php _e('Enter your email here', 'tru-utm-generator');?>
      </div>
	  </div>
    
  <div class="frm_col_grp">
    <div class="col_div_3 frm_col_left_label">
      <label for="utm_domain"><?php _e('Select Domain', 'tru-utm-generator');?></label>
    </div>
    <div class="col_div_3 frm_col_input">
      <select id="utm_domain" name="utm_domain">
      <option value=""><?php _e('--- Select Domain ---', 'tru-utm-generator');?></option> 
      <?php if(!empty($domains) && is_array($domains)) { 
          foreach($domains as $domain) { ?>  
        <option value="<?php echo $domain;?>"><?php echo $domain;?></option> 
      <?php } }  ?>
      </select>
    </div>
    <div class="col_div_3 frm_col_right_label">
      <?php _e('Choose the campaign domain', 'tru-utm-generator');?>
    </div>
  </div>

  <div class="frm_col_grp">
    <div class="col_div_3 frm_col_left_label">
      <label for="utm_selected_domain"><?php _e('Enter Domain', 'tru-utm-generator');?></label>
    </div>
    <div class="col_div_3 frm_col_input">
      <input type="text" id="utm_selected_domain" name="utm_selected_domain" value="">
    </div>
    <div class="col_div_3 frm_col_right_label"></div>
  </div>

  <div class="frm_col_grp">
    <div class="col_div_3 frm_col_left_label">
      <label for="utm_source"><?php _e('Select UTM Source', 'tru-utm-generator');?></label>
    </div>
    <div class="col_div_3 frm_col_input">
      <select id="utm_source" name="utm_source">
      <?php if(!empty($sources) && is_array($sources)) { 
          foreach($sources as $source) { ?>  
        <option value="<?php echo $source;?>"><?php echo $source;?></option> 
      <?php } }  ?>
      </select>
    </div>
    <div class="col_div_3 frm_col_right_label">
      <?php _e('Use utm_source to identify a search engine, newsletter name, or other source', 'tru-utm-generator');?>
    </div>
  </div>

  <div class="frm_col_grp">
    <div class="col_div_3 frm_col_left_label">
      <label for="utm_medium"><?php _e('Select UTM Medium', 'tru-utm-generator');?></label>
    </div>
    <div class="col_div_3 frm_col_input">
      <select id="utm_medium" name="utm_medium">
      <?php if(!empty($mediums) && is_array($mediums)) { 
          foreach($mediums as $medium) { ?>  
        <option value="<?php echo $medium;?>"><?php echo $medium;?></option> 
      <?php } }  ?>
      </select>
    </div>
    <div class="col_div_3 frm_col_right_label">
      <?php _e('Use utm_medium to identify a search engine, newsletter name, or other source', 'tru-utm-generator');?>
    </div>
  </div>

  <div class="frm_col_grp">
    <div class="col_div_3 frm_col_left_label">
      <label for="utm_campaign"><?php _e('Enter the UTM campaign', 'tru-utm-generator');?></label>
    </div>
    <div class="col_div_3 frm_col_input">
      <input type="text" id="utm_campaign" name="utm_campaign">
    </div>
    <div class="col_div_3 frm_col_right_label">
      <?php _e('Used for keyword analysis. Use utm_campaign to identify a specific product promotion or strategic campaign.', 'tru-utm-generator');?>
    </div>
  </div>
  <div class="frm_col_grp">
    <div class="col_div_3 frm_col_left_label">
      <label for="utm_date"><?php _e('UTM Date - Optional', 'tru-utm-generator');?></label>
    </div>
    <div class="col_div_3 frm_col_input">
      <input type="text" id="utm_date" name="utm_date">
    </div>
      <div class="col_div_3 frm_col_right_label"></div>
  </div>

  <div class="frm_col_grp">
    <div class="frm_col_btn">
      <button id="tru_generate_utm" class="tru_generate_utm"><?php _e('Generate', 'tru-utm-generator');?></button>
    </div>
  </div>

     <div id="tru_generated_utm" style="display:none;"></div>

</div>