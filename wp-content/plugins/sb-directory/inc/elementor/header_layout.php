<?php
/* Header Layouts */
extract(shortcode_atts(array(
    'section_bg' => '', 'bg_img' => '', 'header_style' => '', 'section_title' => '', 'section_title_regular' => '','section_title_fancy' => '','view_link_fancy' => '', 'section_description' => '', 'ad_left' => '', 'ad_right' => '', 'cat_link_page' => '', 'sub_limit' => '', 'max_limit' => '', 'p_cols' => '', 'main_heading' => '', 'main_description' => '', 'main_image' => '', 'main_link' => '', 'ad_720_90' => '', 'woo_products' => '', 'woo_products' => '', 'all_products' => '','section_title_modern'=>'','section_tagline'=>''), $atts));
$header = '';
if (isset($header_style)) {
    $main_title = '';  
    if ($header_style == 'classic') {
        $main_title = $section_title;
    } else if ($header_style == 'fancy') {
        $main_title = $section_title_fancy;
    } else if ($header_style == 'modern') {
        $main_title = $section_title_modern;
    }
    else if ($header_style == 'new') {
        $main_title = $section_title;
    }
    else {
        $main_title = $section_title_regular;
    }  


    $tagline   =  isset($section_tagline)   ?   $section_tagline  :  "";
    $header = adforest_getHeader($main_title, $section_description, $header_style , $view_link_fancy ,$tagline  );
}

$style = '';
$bg_color = '';
if ($section_bg == 'img') {
    $bgImageURL = adforest_returnImgSrc($bg_img);
    if (isset($bg_bootom)) {
        $style = ( $bgImageURL != "" ) ? ' style="background:#fff url(' . $bgImageURL . ') repeat-x scroll center bottom; "' : "";
    } else {
        $style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
    }
} else {
    $bg_color = $section_bg;
}