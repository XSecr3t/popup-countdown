<?php
if (!defined('ABSPATH')) exit;

// ===== Admin Page =====
add_action('admin_menu','ali_cdp_admin_menu');
function ali_cdp_admin_menu(){
    add_options_page('Countdown Popup','Countdown Popup','manage_options','ali-cdp','ali_cdp_settings_page');
}

add_action('admin_init','ali_cdp_register_settings');
function ali_cdp_register_settings(){
    register_setting('ali-cdp-group','ali_cdp_target_date');
    register_setting('ali-cdp-group','ali_cdp_title_color');
    register_setting('ali-cdp-group','ali_cdp_box_color');
    register_setting('ali-cdp-group','ali_cdp_custom_text');
    register_setting('ali-cdp-group','ali_cdp_display_mode'); // NEW
}

function ali_cdp_settings_page(){ ?>
<div class="wrap">
<h1>Countdown Popup Settings</h1>
<form method="post" action="options.php">
<?php settings_fields('ali-cdp-group'); ?>
<?php do_settings_sections('ali-cdp-group'); ?>
<table class="form-table">
<tr>
<th scope="row"><label for="ali_cdp_target_date">Tanggal Target</label></th>
<td><input type="datetime-local" id="ali_cdp_target_date" name="ali_cdp_target_date" 
value="<?php echo esc_attr(get_option('ali_cdp_target_date','2025-09-10T23:59')); ?>" class="regular-text" /></td>
</tr>
<tr>
<th scope="row"><label for="ali_cdp_custom_text">Teks Popup</label></th>
<td><textarea id="ali_cdp_custom_text" name="ali_cdp_custom_text" rows="3" class="large-text"><?php echo esc_textarea(get_option('ali_cdp_custom_text','SEBENTAR LAGI SIAP MENGUDARA INSYAA ALLAH!')); ?></textarea></td>
</tr>
<tr>
<th scope="row"><label for="ali_cdp_title_color">Warna Judul</label></th>
<td><input type="color" id="ali_cdp_title_color" name="ali_cdp_title_color"
value="<?php echo esc_attr(get_option('ali_cdp_title_color','#385444')); ?>" /></td>
</tr>
<tr>
<th scope="row"><label for="ali_cdp_box_color">Warna Kotak Countdown</label></th>
<td><input type="color" id="ali_cdp_box_color" name="ali_cdp_box_color"
value="<?php echo esc_attr(get_option('ali_cdp_box_color','#385444')); ?>" /></td>
</tr>
<tr>
<th scope="row"><label for="ali_cdp_display_mode">Mode Tampilkan</label></th>
<td>
<select id="ali_cdp_display_mode" name="ali_cdp_display_mode">
<option value="always" <?php selected(get_option('ali_cdp_display_mode','always'),'always'); ?>>Selalu Muncul</option>
<option value="session" <?php selected(get_option('ali_cdp_display_mode','always'),'session'); ?>>Sekali per Sesi/Tab</option>
<option value="day" <?php selected(get_option('ali_cdp_display_mode','always'),'day'); ?>>Sekali per Hari</option>
</select>
</td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<?php }
?>
