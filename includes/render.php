<?php
if (!defined('ABSPATH')) exit;

// ===== Render Popup =====
add_action('wp_footer','ali_cdp_render_popup',99);
function ali_cdp_render_popup(){
    if(is_admin()) return;

    $target_date_raw = get_option('ali_cdp_target_date','2025-09-10T23:59');
    $target_date_js  = date('Y-m-d\TH:i:s', strtotime($target_date_raw));
    $title_color     = get_option('ali_cdp_title_color','#385444');
    $box_color       = get_option('ali_cdp_box_color','#385444');
    $custom_text     = get_option('ali_cdp_custom_text','blank');
    $display_mode    = get_option('ali_cdp_display_mode','always');

    ?>
<style>
#ali-cdp-overlay{display:none;justify-content:center;align-items:center;position:fixed;inset:0;background:rgba(0,0,0,0.8);z-index:99999}
#ali-cdp-popup{background:#fff;padding:30px;border-radius:15px;text-align:center;max-width:500px;width:90%;box-shadow:0 8px 20px rgba(0,0,0,0.3);position:relative}
#ali-cdp-title{color: <?php echo esc_attr($title_color); ?>; font-size:1.3rem;margin-bottom:20px}
#ali-cdp-countdown{display:flex;justify-content:center;gap:15px}
#ali-cdp-countdown .ali-cdp-item{background: <?php echo esc_attr($box_color); ?>; color:#fff; padding:15px;border-radius:10px; min-width:70px; font-size:1.2rem; font-weight:700}
#ali-cdp-countdown .ali-cdp-item span{display:block; font-size:0.8rem; font-weight:400; margin-top:5px; color:#eee}
#ali-cdp-close{position:absolute;top:8px;right:12px;font-size:18px;font-weight:700;color:#333;cursor:pointer;line-height:1;background:none;border:none;padding:0}
#ali-cdp-close:hover{color:#385444}
@media(max-width:480px){#ali-cdp-countdown{gap:10px}#ali-cdp-countdown .ali-cdp-item{min-width:60px;padding:12px;font-size:1.05rem}}
</style>

<div id="ali-cdp-overlay">
  <div id="ali-cdp-popup">
    <button id="ali-cdp-close" aria-label="close popup" type="button">&times;</button>
    <h2 id="ali-cdp-title"><?php echo esc_html($custom_text); ?></h2>
    <div id="ali-cdp-countdown">
      <div class="ali-cdp-item"><div id="ali-cdp-days">0</div><span>days</span></div>
      <div class="ali-cdp-item"><div id="ali-cdp-hours">0</div><span>hours</span></div>
      <div class="ali-cdp-item"><div id="ali-cdp-minutes">0</div><span>minutes</span></div>
      <div class="ali-cdp-item"><div id="ali-cdp-seconds">0</div><span>seconds</span></div>
    </div>
  </div>
</div>

<script>
(function(){
  var overlay=document.getElementById('ali-cdp-overlay');
  if(!overlay) return;

  var displayMode = "<?php echo esc_js($display_mode); ?>";

  // cek mode tampil
  if(displayMode === 'session'){
    if(sessionStorage.getItem('ali_cdp_closed')==='1') return;
  } else if(displayMode === 'day'){
    var today=new Date().toISOString().slice(0,10);
    if(localStorage.getItem('ali_cdp_closed_day')===today) return;
  }

  overlay.style.display='flex';

  var targetDate = new Date("<?php echo esc_js($target_date_js); ?>").getTime();

  var d=document.getElementById('ali-cdp-days');
  var h=document.getElementById('ali-cdp-hours');
  var m=document.getElementById('ali-cdp-minutes');
  var s=document.getElementById('ali-cdp-seconds');

  function tick(){
    var now = Date.now();
    var distance = targetDate - now;

    if(distance <= 0){
      var box = document.getElementById('ali-cdp-countdown');
      if(box) box.innerHTML = '<strong>Times Out!</strong>';
      clearInterval(iv);
      return;
    }

    var days = Math.floor(distance / 86400000);
    var hours = Math.floor((distance % 86400000) / 3600000);
    var minutes = Math.floor((distance % 3600000) / 60000);
    var seconds = Math.floor((distance % 60000) / 1000);

    if(d) d.textContent = days;
    if(h) h.textContent = hours;
    if(m) m.textContent = minutes;
    if(s) s.textContent = seconds;
  }

  var iv = setInterval(tick,1000);
  tick();

  var closeBtn=document.getElementById('ali-cdp-close');
  if(closeBtn){
    closeBtn.addEventListener('click', function(){
      overlay.style.display='none';
      if(displayMode==='session'){
        sessionStorage.setItem('ali_cdp_closed','1');
      } else if(displayMode==='day'){
        var today=new Date().toISOString().slice(0,10);
        localStorage.setItem('ali_cdp_closed_day',today);
      }
      clearInterval(iv);
    });
  }
})();
</script>
<?php
}
?>
