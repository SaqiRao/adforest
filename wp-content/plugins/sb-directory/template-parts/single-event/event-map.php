<?php 
global $adforest_theme ;
$event_id   =  get_the_ID();
$is_allow_map =  isset($adforest_theme['sb_pro_event_map'])  ?    $adforest_theme['sb_pro_event_map']  : "";
$map_type  =   $adforest_theme['map-setings-map-type']  ? $adforest_theme['map-setings-map-type']  :  'leafletjs_map';      //  leafletjs_map or google_map
$sb_pro_event_lat  =   get_post_meta($event_id , 'sb_pro_event_lat' , true);
$sb_pro_event_long  =   get_post_meta($event_id , 'sb_pro_event_long' , true);
$venue  =   get_post_meta($event_id , 'sb_pro_event_venue' , true);
if($is_allow_map  && $sb_pro_event_lat != ""  && $sb_pro_event_long != ""){  ?>
  <div class="location-box">
    <h4 class="sub-title">Location</h4>
    <div class="map-box">
         <input type="hidden" id="event_latt" value="<?php echo esc_attr($sb_pro_event_lat);?>" />
         <input type="hidden" id="event_long" value="<?php echo esc_attr
         ($sb_pro_event_long) ?>" />
        <div id="event_detail_map"></div>
    </div>
    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--subway" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512" data-icon="subway:location"><path fill="currentColor" d="M256 0C149.3 0 64 85.3 64 192c0 36.9 11 65.4 30.1 94.3l141.7 215c4.3 6.5 11.7 10.7 20.2 10.7s16-4.3 20.2-10.7l141.7-215C437 257.4 448 228.9 448 192C448 85.3 362.7 0 256 0zm0 298.6c-58.9 0-106.7-47.8-106.7-106.8S197.1 85 256 85c58.9 0 106.7 47.8 106.7 106.8S314.9 298.6 256 298.6z"></path></svg> <?php echo esc_html($venue ) ?></span>
</div>
    <?php }

