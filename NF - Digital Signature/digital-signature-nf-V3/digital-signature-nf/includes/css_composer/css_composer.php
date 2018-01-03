<?php
function get_page_css($id){

    $css = "@page { margin: 0px; }body{margin:0px;} .vc_row .vc_col-sm-1, .vc_row .vc_col-sm-10, .vc_row .vc_col-sm-11, .vc_row .vc_col-sm-12, .vc_row .vc_col-sm-2, .vc_row .vc_col-sm-3, .vc_row .vc_col-sm-4, .vc_row .vc_col-sm-5, .vc_row .vc_col-sm-7, .vc_row .vc_col-sm-8, .vc_row .vc_col-sm-9{float:left; margin-right:0px;}
	.vc_parallax-inner iframe,.vc_video-bg iframe{max-width:1000%}
	.vc_clearfix:after,.vc_column-inner::after,.vc_el-clearfix,.vc_row:after{clear:both}
	.vc-composer-icon,[class*=' vc_arrow-icon-'],[class^=vc_arrow-icon-]{speak:none;font-variant:normal;text-transform:none;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
	.vc_row:after,.vc_row:before{content:' ';display:table}
	 .vc_row .vc_col-sm-1{position:relative;width:8.33333333%;min-height:1px}
	 .vc_row .vc_col-sm-2{position:relative;width:16.66666667%;min-height:1px}
	 .vc_row .vc_col-sm-3{position:relative;width:25%;min-height:1px}
	 .vc_row .vc_col-sm-4{position:relative;width:33.33333333%;min-height:1px}
	 .vc_row .vc_col-sm-5{position:relative;width:41.66666667%;min-height:1px}
	 .vc_row .vc_col-sm-6{position:relative;float:left;width:50%;min-height:1px;}
	 .vc_row .vc_col-sm-7{position:relative;width:58.33333333%;min-height:1px}
	 .vc_row .vc_col-sm-8{position:relative;width:66.66666667%;min-height:1px}
	 .vc_row .vc_col-sm-9{position:relative;width:75%;min-height:1px}
	 .vc_row .vc_col-sm-10{position:relative;width:83.33333333%;min-height:1px}
	 .vc_row .vc_col-sm-11{position:relative;width:91.66666667%;min-height:1px}
	.vc_col-xs-12,.vc_column_container{width:100%}
	 .vc_row .vc_col-sm-12{position:relative;width:100%;min-height:1px}
	 .vc_row .vc_col-sm-offset-12{margin-left:100%}
	 .vc_row .vc_col-sm-offset-11{margin-left:91.66666667%}
	 .vc_row .vc_col-sm-offset-10{margin-left:83.33333333%}
	 .vc_row .vc_col-sm-offset-9{margin-left:75%}
	 .vc_row .vc_col-sm-offset-8{margin-left:66.66666667%}
	 .vc_row .vc_col-sm-offset-7{margin-left:58.33333333%}
	 .vc_row .vc_col-sm-offset-6{margin-left:50%}
	 .vc_row .vc_col-sm-offset-5{margin-left:41.66666667%}
	 .vc_row .vc_col-sm-offset-4{margin-left:33.33333333%}
	 .vc_row .vc_col-sm-offset-3{margin-left:25%}
	 .vc_row .vc_col-sm-offset-2{margin-left:16.66666667%}
	 .vc_row .vc_col-sm-offset-1{margin-left:8.33333333%}
	 .vc_row .vc_col-sm-offset-0{margin-left:0}
	 .vc_row .vc_hidden-sm{display:none!important}
	.vc_col-lg-1,.vc_col-lg-10,.vc_col-lg-11,.vc_col-lg-12,.vc_col-lg-2,.vc_col-lg-3,.vc_col-lg-4,.vc_col-lg-5,.vc_col-lg-6,.vc_col-lg-7,.vc_col-lg-8,.vc_col-lg-9,.vc_col-md-1,.vc_col-md-10,.vc_col-md-11,.vc_col-md-12,.vc_col-md-2,.vc_col-md-3,.vc_col-md-4,.vc_col-md-5,.vc_col-md-6,.vc_col-md-7,.vc_col-md-8,.vc_col-md-9,.vc_col-sm-1,.vc_col-sm-10,.vc_col-sm-11,.vc_col-sm-12,.vc_col-sm-2,.vc_col-sm-3,.vc_col-sm-4,.vc_col-sm-5,.vc_col-sm-6,.vc_col-sm-7,.vc_col-sm-8,.vc_col-sm-9,.vc_col-xs-1,.vc_col-xs-10,.vc_col-xs-11,.vc_col-xs-12,.vc_col-xs-2,.vc_col-xs-3,.vc_col-xs-4,.vc_col-xs-5,.vc_col-xs-6,.vc_col-xs-7,.vc_col-xs-8,.vc_col-xs-9{position:relative;min-height:1px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
	.vc_col-xs-1,.vc_col-xs-10,.vc_col-xs-11,.vc_col-xs-12,.vc_col-xs-2,.vc_col-xs-3,.vc_col-xs-4,.vc_col-xs-5,.vc_col-xs-6,.vc_col-xs-7,.vc_col-xs-8,.vc_col-xs-9{float:left}
	.vc_col-xs-11{width:91.66666667%}
	.vc_col-xs-10{width:83.33333333%}
	.vc_col-xs-9{width:75%}
	.vc_col-xs-8{width:66.66666667%}
	.vc_col-xs-7{width:58.33333333%}
	.vc_col-xs-6{width:50%}
	.vc_col-xs-5{width:41.66666667%}
	.vc_col-xs-4{width:33.33333333%}
	.vc_col-xs-3{width:25%}
	.vc_col-xs-2{width:16.66666667%}
	.vc_col-xs-1{width:8.33333333%}
	.vc_col-xs-pull-12{right:100%}
	.vc_col-xs-pull-11{right:91.66666667%}
	.vc_col-xs-pull-10{right:83.33333333%}
	.vc_col-xs-pull-9{right:75%}
	.vc_col-xs-pull-8{right:66.66666667%}
	.vc_col-xs-pull-7{right:58.33333333%}
	.vc_col-xs-pull-6{right:50%}
	.vc_col-xs-pull-5{right:41.66666667%}
	.vc_col-xs-pull-4{right:33.33333333%}
	.vc_col-xs-pull-3{right:25%}
	.vc_col-xs-pull-2{right:16.66666667%}
	.vc_col-xs-pull-1{right:8.33333333%}
	.vc_col-xs-pull-0{right:auto}
	.vc_col-xs-push-12{left:100%}
	.vc_col-xs-push-11{left:91.66666667%}
	.vc_col-xs-push-10{left:83.33333333%}
	.vc_col-xs-push-9{left:75%}
	.vc_col-xs-push-8{left:66.66666667%}
	.vc_col-xs-push-7{left:58.33333333%}
	.vc_col-xs-push-6{left:50%}
	.vc_col-xs-push-5{left:41.66666667%}
	.vc_col-xs-push-4{left:33.33333333%}
	.vc_col-xs-push-3{left:25%}
	.vc_col-xs-push-2{left:16.66666667%}
	.vc_col-xs-push-1{left:8.33333333%}
	.vc_col-xs-push-0{left:auto}
	.vc_col-xs-offset-12{margin-left:100%}
	.vc_col-xs-offset-11{margin-left:91.66666667%}
	.vc_col-xs-offset-10{margin-left:83.33333333%}
	.vc_col-xs-offset-9{margin-left:75%}
	.vc_col-xs-offset-8{margin-left:66.66666667%}
	.vc_col-xs-offset-7{margin-left:58.33333333%}
	.vc_col-xs-offset-6{margin-left:50%}
	.vc_col-xs-offset-5{margin-left:41.66666667%}
	.vc_col-xs-offset-4{margin-left:33.33333333%}
	.vc_col-xs-offset-3{margin-left:25%}
	.vc_col-xs-offset-2{margin-left:16.66666667%}
	.vc_col-xs-offset-1{margin-left:8.33333333%}
	.vc_col-xs-offset-0{margin-left:0}
	.vc_el_width_100,.vc_el_width_50,.vc_el_width_60,.vc_el_width_70,.vc_el_width_80,.vc_el_width_90{margin-left:auto!important;margin-right:auto!important}
	.vc_pull-right{float:right!important}
	.vc_pull-left{float:left!important}
	.vc_clearfix:after,.vc_clearfix:before{content:' ';display:table}
	.vc_visible{display:block}
	.vc_table{width:100%;margin-bottom:20px;border-collapse:collapse}
	.vc_table>tbody>tr>td,.vc_table>tbody>tr>th,.vc_table>tfoot>tr>td,.vc_table>tfoot>tr>th,.vc_table>thead>tr>td,.vc_table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}
	.vc_table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}
	.vc_button-2-wrapper,.vc_pixel_icon{display:inline-block;vertical-align:middle}
	.vc_table>caption+thead>tr:first-child>td,.vc_table>caption+thead>tr:first-child>th,.vc_table>colgroup+thead>tr:first-child>td,.vc_table>colgroup+thead>tr:first-child>th,.vc_table>thead:first-child>tr:first-child>td,.vc_table>thead:first-child>tr:first-child>th{border-top:0}
	.vc_table>tbody+tbody{border-top:2px solid #ddd}
	.vc_table .table{background-color:#fff}
	.vc_table-bordered,.vc_table-bordered>tbody>tr>td,.vc_table-bordered>tbody>tr>th,.vc_table-bordered>tfoot>tr>td,.vc_table-bordered>tfoot>tr>th,.vc_table-bordered>thead>tr>td,.vc_table-bordered>thead>tr>th{border:1px solid #ddd}
	.vc_table-bordered>thead>tr>td,.vc_table-bordered>thead>tr>th{border-bottom-width:2px}
	.vc-composer-icon{font-family:vcpb-plugin-icons!important;font-style:normal;font-weight:400;line-height:1}
	.vc_txt_align_left{text-align:left}
	.vc_txt_align_right{text-align:right}
	.vc_txt_align_center{text-align:center}
	.vc_txt_align_justify{text-align:justify;text-justify:inter-word}
	.vc_el_width_50{width:50%}
	.vc_el_width_60{width:60%}
	.vc_el_width_70{width:70%}
	.vc_el_width_80{width:80%}
	.vc_el_width_90{width:90%}
	.vc_el_width_100{width:100%}
	.vc_message_box{border:1px solid transparent;display:block;overflow:hidden;margin:0 0 21.74px;padding:1em 1em 1em 4em;position:relative;font-size:1em;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
	.vc_row.vc_row-flex,.vc_row.vc_row-flex>.vc_column_container{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox}
	#content .wpb_alert p:last-child,#content .wpb_text_column :last-child,#content .wpb_text_column p:last-child,.vc_message_box>p:last-child,.wpb_alert p:last-child,.wpb_text_column :last-child,.wpb_text_column p:last-child{margin-bottom:0}
	.vc_message_box-icon,.vc_message_box-icon>*{position:absolute;font-weight:400;font-style:normal}
	.vc_message_box>p:first-child{margin-top:0}
	.vc_message_box-icon{bottom:0;font-size:1em;left:0;top:0;width:4em}
	.vc_message_box-icon>*,.vc_message_box-icon>.fa{font-size:1.7em;line-height:1}
	.vc_color-blue.vc_message_box{color:#364a8a;border-color:#c5cff0;background-color:#edf1fa}
	.vc_color-blue.vc_message_box .vc_message_box-icon{color:#5472D2}
	.vc_color-blue.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#5472D2}
	.vc_color-blue.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-blue.vc_message_box-outline,.vc_color-blue.vc_message_box-solid-icon{color:#364a8a;border-color:#5472D2;background-color:transparent}
	.vc_color-blue.vc_message_box-outline .vc_message_box-icon,.vc_color-blue.vc_message_box-solid-icon .vc_message_box-icon{color:#5472D2}
	.vc_color-blue.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#5472D2}
	.vc_color-blue.vc_message_box-3d{box-shadow:0 5px 0 #9daee5}
	.vc_color-turquoise.vc_message_box{color:#085b61;border-color:#c6ecee;background-color:#ebfcfd}
	.vc_color-turquoise.vc_message_box .vc_message_box-icon{color:#00C1CF}
	.vc_color-turquoise.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#00C1CF}
	.vc_color-turquoise.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-turquoise.vc_message_box-outline,.vc_color-turquoise.vc_message_box-solid-icon{color:#085b61;border-color:#00C1CF;background-color:transparent}
	.vc_color-turquoise.vc_message_box-outline .vc_message_box-icon,.vc_color-turquoise.vc_message_box-solid-icon .vc_message_box-icon{color:#00C1CF}
	.vc_color-turquoise.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#00C1CF}
	.vc_color-turquoise.vc_message_box-3d{box-shadow:0 5px 0 #9fdee3}
	.vc_color-pink.vc_message_box{color:#d82e21;border-color:#ffd8d6;background-color:#fff0ef}
	.vc_color-pink.vc_message_box .vc_message_box-icon{color:#FE6C61}
	.vc_color-pink.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#FE6C61}
	.vc_color-pink.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-pink.vc_message_box-outline,.vc_color-pink.vc_message_box-solid-icon{color:#d82e21;border-color:#FE6C61;background-color:transparent}
	.vc_color-pink.vc_message_box-outline .vc_message_box-icon,.vc_color-pink.vc_message_box-solid-icon .vc_message_box-icon{color:#FE6C61}
	.vc_color-pink.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#FE6C61}
	.vc_color-pink.vc_message_box-3d{box-shadow:0 5px 0 #fea9a3}
	.vc_color-violet.vc_message_box{color:#5e4a81;border-color:#d4c8e9;background-color:#f0ecf7}
	.vc_color-violet.vc_message_box .vc_message_box-icon{color:#8D6DC4}
	.vc_color-violet.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#8D6DC4}
	.vc_color-violet.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-violet.vc_message_box-outline,.vc_color-violet.vc_message_box-solid-icon{color:#5e4a81;border-color:#8D6DC4;background-color:transparent}
	.vc_color-violet.vc_message_box-outline .vc_message_box-icon,.vc_color-violet.vc_message_box-solid-icon .vc_message_box-icon{color:#8D6DC4}
	.vc_color-violet.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#8D6DC4}
	.vc_color-violet.vc_message_box-3d{box-shadow:0 5px 0 #b8a3da}
	.vc_color-peacoc.vc_message_box{color:#366a79;border-color:#c2e3ec;background-color:#e9f5f8}
	.vc_color-peacoc.vc_message_box .vc_message_box-icon{color:#4CADC9}
	.vc_color-peacoc.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#4CADC9}
	.vc_color-peacoc.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-peacoc.vc_message_box-outline,.vc_color-peacoc.vc_message_box-solid-icon{color:#366a79;border-color:#4CADC9;background-color:transparent}
	.vc_color-peacoc.vc_message_box-outline .vc_message_box-icon,.vc_color-peacoc.vc_message_box-solid-icon .vc_message_box-icon{color:#4CADC9}
	.vc_color-peacoc.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#4CADC9}
	.vc_color-peacoc.vc_message_box-3d{box-shadow:0 5px 0 #9ad1e1}
	.vc_color-chino.vc_message_box{color:#978258;border-color:#e5ded2;background-color:#f7f5f2}
	.vc_color-chino.vc_message_box .vc_message_box-icon{color:#CEC2AB}
	.vc_color-chino.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#CEC2AB}
	.vc_color-chino.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-chino.vc_message_box-outline,.vc_color-chino.vc_message_box-solid-icon{color:#978258;border-color:#CEC2AB;background-color:transparent}
	.vc_color-chino.vc_message_box-outline .vc_message_box-icon,.vc_color-chino.vc_message_box-solid-icon .vc_message_box-icon{color:#CEC2AB}
	.vc_color-chino.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#CEC2AB}
	.vc_color-chino.vc_message_box-3d{box-shadow:0 5px 0 #d2c7b1}
	.vc_color-mulled_wine.vc_message_box{color:#1e1b22;border-color:#d0ccd6;background-color:#eae8ed}
	.vc_color-mulled_wine.vc_message_box .vc_message_box-icon{color:#50485B}
	.vc_color-mulled_wine.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#50485B}
	.vc_color-mulled_wine.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-mulled_wine.vc_message_box-outline,.vc_color-mulled_wine.vc_message_box-solid-icon{color:#1e1b22;border-color:#50485B;background-color:transparent}
	.vc_color-mulled_wine.vc_message_box-outline .vc_message_box-icon,.vc_color-mulled_wine.vc_message_box-solid-icon .vc_message_box-icon{color:#50485B}
	.vc_color-mulled_wine.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#50485B}
	.vc_color-mulled_wine.vc_message_box-3d{box-shadow:0 5px 0 #b6afc0}
	.vc_color-vista_blue.vc_message_box{color:#3e8e5e;border-color:#bcebcf;background-color:#e3f7eb}
	.vc_color-vista_blue.vc_message_box .vc_message_box-icon{color:#75D69C}
	.vc_color-vista_blue.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#75D69C}
	.vc_color-vista_blue.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-vista_blue.vc_message_box-outline,.vc_color-vista_blue.vc_message_box-solid-icon{color:#3e8e5e;border-color:#75D69C;background-color:transparent}
	.vc_color-vista_blue.vc_message_box-outline .vc_message_box-icon,.vc_color-vista_blue.vc_message_box-solid-icon .vc_message_box-icon{color:#75D69C}
	.vc_color-vista_blue.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#75D69C}
	.vc_color-vista_blue.vc_message_box-3d{box-shadow:0 5px 0 #94dfb3}
	.vc_color-orange.vc_message_box{color:#c3811c;border-color:#fbe1ba;background-color:#fef6eb}
	.vc_color-orange.vc_message_box .vc_message_box-icon{color:#F7BE68}
	.vc_color-orange.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#F7BE68}
	.vc_color-orange.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-orange.vc_message_box-outline,.vc_color-orange.vc_message_box-solid-icon{color:#c3811c;border-color:#F7BE68;background-color:transparent}
	.vc_color-orange.vc_message_box-outline .vc_message_box-icon,.vc_color-orange.vc_message_box-solid-icon .vc_message_box-icon{color:#F7BE68}
	.vc_color-orange.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#F7BE68}
	.vc_color-orange.vc_message_box-3d{box-shadow:0 5px 0 #f9cd8a}
	.vc_color-sky.vc_message_box{color:#2a6194;border-color:#bedaf4;background-color:#eaf3fb}
	.vc_color-sky.vc_message_box .vc_message_box-icon{color:#5AA1E3}
	.vc_color-sky.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#5AA1E3}
	.vc_color-sky.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-sky.vc_message_box-outline,.vc_color-sky.vc_message_box-solid-icon{color:#2a6194;border-color:#5AA1E3;background-color:transparent}
	.vc_color-sky.vc_message_box-outline .vc_message_box-icon,.vc_color-sky.vc_message_box-solid-icon .vc_message_box-icon{color:#5AA1E3}
	.vc_color-sky.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#5AA1E3}
	.vc_color-sky.vc_message_box-3d{box-shadow:0 5px 0 #93c1ed}
	.vc_color-green.vc_message_box{color:#3e562b;border-color:#c2e1a9;background-color:#eaf5e2}
	.vc_color-green.vc_message_box .vc_message_box-icon{color:#6DAB3C}
	.vc_color-green.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#6DAB3C}
	.vc_color-green.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-green.vc_message_box-outline,.vc_color-green.vc_message_box-solid-icon{color:#3e562b;border-color:#6DAB3C;background-color:transparent}
	.vc_color-green.vc_message_box-outline .vc_message_box-icon,.vc_color-green.vc_message_box-solid-icon .vc_message_box-icon{color:#6DAB3C}
	.vc_color-green.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#6DAB3C}
	.vc_color-green.vc_message_box-3d{box-shadow:0 5px 0 #a7d484}
	.vc_color-juicy_pink.vc_message_box{color:#a3231f;border-color:#fbc7c5;background-color:#fef5f5}
	.vc_color-juicy_pink.vc_message_box .vc_message_box-icon{color:#F4524D}
	.vc_color-juicy_pink.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#F4524D}
	.vc_color-juicy_pink.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-juicy_pink.vc_message_box-outline,.vc_color-juicy_pink.vc_message_box-solid-icon{color:#a3231f;border-color:#F4524D;background-color:transparent}
	.vc_color-juicy_pink.vc_message_box-outline .vc_message_box-icon,.vc_color-juicy_pink.vc_message_box-solid-icon .vc_message_box-icon{color:#F4524D}
	.vc_color-juicy_pink.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#F4524D}
	.vc_color-juicy_pink.vc_message_box-3d{box-shadow:0 5px 0 #f89895}
	.vc_color-sandy_brown.vc_message_box{color:#c3501c;border-color:#fbceba;background-color:#fef1eb}
	.vc_color-sandy_brown.vc_message_box .vc_message_box-icon{color:#F79468}
	.vc_color-sandy_brown.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#F79468}
	.vc_color-sandy_brown.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-sandy_brown.vc_message_box-outline,.vc_color-sandy_brown.vc_message_box-solid-icon{color:#c3501c;border-color:#F79468;background-color:transparent}
	.vc_color-sandy_brown.vc_message_box-outline .vc_message_box-icon,.vc_color-sandy_brown.vc_message_box-solid-icon .vc_message_box-icon{color:#F79468}
	.vc_color-sandy_brown.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#F79468}
	.vc_color-sandy_brown.vc_message_box-3d{box-shadow:0 5px 0 #f9ac8a}
	.vc_color-purple.vc_message_box{color:#886389;border-color:#e3cbe3;background-color:#f5ecf5}
	.vc_color-purple.vc_message_box .vc_message_box-icon{color:#B97EBB}
	.vc_color-purple.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#B97EBB}
	.vc_color-purple.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-purple.vc_message_box-outline,.vc_color-purple.vc_message_box-solid-icon{color:#886389;border-color:#B97EBB;background-color:transparent}
	.vc_color-purple.vc_message_box-outline .vc_message_box-icon,.vc_color-purple.vc_message_box-solid-icon .vc_message_box-icon{color:#B97EBB}
	.vc_color-purple.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#B97EBB}
	.vc_color-purple.vc_message_box-3d{box-shadow:0 5px 0 #d1a9d2}
	.vc_color-black.vc_message_box{color:#fff;border-color:#2A2A2A;background-color:#3c3c3c}
	.vc_color-black.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#2A2A2A}
	.vc_color-black.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-black.vc_message_box-outline,.vc_color-black.vc_message_box-solid-icon{border-color:#2A2A2A;background-color:transparent}
	.vc_color-black.vc_message_box-outline .vc_message_box-icon,.vc_color-black.vc_message_box-solid-icon .vc_message_box-icon{color:#2A2A2A}
	.vc_color-black.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#2A2A2A}
	.vc_color-black.vc_message_box-3d{box-shadow:0 5px 0 #101010}
	.vc_color-grey.vc_message_box{color:#858585;border-color:#d2d2d2;background-color:#EBEBEB}
	.vc_color-grey.vc_message_box-solid{color:#858585;border-color:transparent;background-color:#EBEBEB}
	.vc_color-grey.vc_message_box-solid .vc_message_box-icon{color:#858585}
	.vc_color-grey.vc_message_box-outline,.vc_color-grey.vc_message_box-solid-icon{color:#858585;border-color:#EBEBEB;background-color:transparent}
	.vc_color-grey.vc_message_box-outline .vc_message_box-icon,.vc_color-grey.vc_message_box-solid-icon .vc_message_box-icon{color:#EBEBEB}
	.vc_color-grey.vc_message_box-solid-icon .vc_message_box-icon{color:#858585;background-color:#EBEBEB}
	.vc_color-grey.vc_message_box-3d{box-shadow:0 5px 0 #b8b8b8}
	.vc_color-white.vc_message_box{color:#b3b3b3;border-color:#e6e6e6;background-color:#FFF}
	.vc_color-white.vc_message_box-solid{color:#b3b3b3;border-color:transparent;background-color:#FFF}
	.vc_color-white.vc_message_box-solid .vc_message_box-icon{color:#b3b3b3}
	.vc_color-white.vc_message_box-outline,.vc_color-white.vc_message_box-solid-icon{border-color:#FFF;background-color:transparent}
	.vc_color-white.vc_message_box-outline .vc_message_box-icon,.vc_color-white.vc_message_box-solid-icon .vc_message_box-icon{color:#FFF}
	.vc_color-white.vc_message_box-solid-icon .vc_message_box-icon{color:#b3b3b3;background-color:#FFF}
	.vc_color-white.vc_message_box-3d{box-shadow:0 5px 0 #ccc}
	.vc_color-info.vc_message_box-3d,.vc_color-success.vc_message_box-3d{box-shadow:0 5px 0 #9dd6fd}
	.vc_color-info.vc_message_box{color:#5e7f96;border-color:#cfebfe;background-color:#dff2fe}
	.vc_color-info.vc_message_box .vc_message_box-icon{color:#56b0ee}
	.vc_color-info.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#56b0ee}
	.vc_color-info.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-info.vc_message_box-outline,.vc_color-info.vc_message_box-solid-icon{color:#5e7f96;border-color:#56b0ee;background-color:transparent}
	.vc_color-info.vc_message_box-outline .vc_message_box-icon,.vc_color-info.vc_message_box-solid-icon .vc_message_box-icon{color:#56b0ee}
	.vc_color-info.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#56b0ee}
	.vc_color-success.vc_message_box{color:#5e7f96;border-color:#cfebfe;background-color:#e6fdf8}
	.vc_color-success.vc_message_box .vc_message_box-icon{color:#1bbc9b}
	.vc_color-success.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#1bbc9b}
	.vc_color-success.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-success.vc_message_box-outline,.vc_color-success.vc_message_box-solid-icon{color:#5e7f96;border-color:#1bbc9b;background-color:transparent}
	.vc_color-success.vc_message_box-outline .vc_message_box-icon,.vc_color-success.vc_message_box-solid-icon .vc_message_box-icon{color:#1bbc9b}
	.vc_color-success.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#1bbc9b}
	.vc_color-warning.vc_message_box{color:#9d8967;border-color:#ffeccc;background-color:#fff4e2}
	.vc_color-warning.vc_message_box .vc_message_box-icon{color:#fcb53f}
	.vc_color-warning.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#fcb53f}
	.vc_color-warning.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-warning.vc_message_box-outline,.vc_color-warning.vc_message_box-solid-icon{color:#9d8967;border-color:#fcb53f;background-color:transparent}
	.vc_color-warning.vc_message_box-outline .vc_message_box-icon,.vc_color-warning.vc_message_box-solid-icon .vc_message_box-icon{color:#fcb53f}
	.vc_color-warning.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#fcb53f}
	.vc_color-warning.vc_message_box-3d{box-shadow:0 5px 0 #ffd999}
	.vc_color-danger.vc_message_box{color:#a85959;border-color:#fedede;background-color:#fdeaea}
	.vc_color-danger.vc_message_box .vc_message_box-icon{color:#ff7877}
	.vc_color-danger.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#ff7877}
	.vc_color-danger.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-danger.vc_message_box-outline,.vc_color-danger.vc_message_box-solid-icon{color:#a85959;border-color:#ff7877;background-color:transparent}
	.vc_color-danger.vc_message_box-outline .vc_message_box-icon,.vc_color-danger.vc_message_box-solid-icon .vc_message_box-icon{color:#ff7877}
	.vc_color-danger.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#ff7877}
	.vc_color-danger.vc_message_box-3d{box-shadow:0 5px 0 #fdacac}
	.vc_color-alert-info.vc_message_box{color:#31708f;border-color:#bce8f1;background-color:#d9edf7}
	.vc_color-alert-info.vc_message_box .vc_message_box-icon{color:#67CCE0}
	.vc_color-alert-info.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#67CCE0}
	.vc_color-alert-info.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-alert-info.vc_message_box-outline,.vc_color-alert-info.vc_message_box-solid-icon{color:#31708f;border-color:#67CCE0;background-color:transparent}
	.vc_color-alert-info.vc_message_box-outline .vc_message_box-icon,.vc_color-alert-info.vc_message_box-solid-icon .vc_message_box-icon{color:#67CCE0}
	.vc_color-alert-info.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#67CCE0}
	.vc_color-alert-info.vc_message_box-3d{box-shadow:0 5px 0 #91d9e8}
	.vc_color-alert-success.vc_message_box{color:#3c763d;border-color:#d6e9c6;background-color:#dff0d8}
	.vc_color-alert-success.vc_message_box .vc_message_box-icon{color:#9AD36A}
	.vc_color-alert-success.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#9AD36A}
	.vc_color-alert-success.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-alert-success.vc_message_box-outline,.vc_color-alert-success.vc_message_box-solid-icon{color:#3c763d;border-color:#9AD36A;background-color:transparent}
	.vc_color-alert-success.vc_message_box-outline .vc_message_box-icon,.vc_color-alert-success.vc_message_box-solid-icon .vc_message_box-icon{color:#9AD36A}
	.vc_color-alert-success.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#9AD36A}
	.vc_color-alert-success.vc_message_box-3d{box-shadow:0 5px 0 #bbdba1}
	.vc_color-alert-warning.vc_message_box{color:#8a6d3b;border-color:#faebcc;background-color:#fcf8e3}
	.vc_color-alert-warning.vc_message_box .vc_message_box-icon{color:#F9CF79}
	.vc_color-alert-warning.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#F9CF79}
	.vc_color-alert-warning.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-alert-warning.vc_message_box-outline,.vc_color-alert-warning.vc_message_box-solid-icon{color:#8a6d3b;border-color:#F9CF79;background-color:transparent}
	.vc_color-alert-warning.vc_message_box-outline .vc_message_box-icon,.vc_color-alert-warning.vc_message_box-solid-icon .vc_message_box-icon{color:#F9CF79}
	.vc_color-alert-warning.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#F9CF79}
	.vc_color-alert-warning.vc_message_box-3d{box-shadow:0 5px 0 #f5d89e}
	.vc_color-alert-danger.vc_message_box{color:#a94442;border-color:#ebccd1;background-color:#f2dede}
	.vc_color-alert-danger.vc_message_box .vc_message_box-icon{color:#EF8495}
	.vc_color-alert-danger.vc_message_box-solid{color:#fff;border-color:transparent;background-color:#EF8495}
	.vc_color-alert-danger.vc_message_box-solid .vc_message_box-icon{color:#fff}
	.vc_color-alert-danger.vc_message_box-outline,.vc_color-alert-danger.vc_message_box-solid-icon{color:#a94442;border-color:#EF8495;background-color:transparent}
	.vc_color-alert-danger.vc_message_box-outline .vc_message_box-icon,.vc_color-alert-danger.vc_message_box-solid-icon .vc_message_box-icon{color:#EF8495}
	.vc_color-alert-danger.vc_message_box-solid-icon .vc_message_box-icon{color:#fff;background-color:#EF8495}
	.vc_color-alert-danger.vc_message_box-3d{box-shadow:0 5px 0 #dca7b0}
	.vc_color-black.vc_message_box .vc_message_box-icon{color:#fff}
	.vc_color-black.vc_message_box-outline,.vc_color-black.vc_message_box-outline .vc_message_box-icon,.vc_color-black.vc_message_box-solid-icon{color:#2A2A2A}
	.vc_color-grey.vc_message_box .vc_message_box-icon{color:#858585}
	.vc_color-white.vc_message_box .vc_message_box-icon{color:#b3b3b3}
	.vc_color-white.vc_message_box-outline,.vc_color-white.vc_message_box-outline .vc_message_box-icon,.vc_color-white.vc_message_box-solid-icon{color:#FFF}
	.vc_message_box-outline,.vc_message_box-solid-icon{border-width:2px}
	.vc_message_box-solid-icon .vc_message_box-icon{width:3.25em}
	.vc_message_box-rounded{border-radius:5px}
	.vc_message_box-round{border-radius:4em}
	.entry-content .twitter-share-button,.fb_like,.twitter-share-button,.wpb_accordion .wpb_content_element,.wpb_googleplus,.wpb_pinterest,.wpb_tab .wpb_content_element{margin-bottom:21.74px}
	.vc_row.vc_row-no-padding .vc_column-inner{padding-left:0;padding-right:0}
	.vc_row[data-vc-full-width]{-webkit-transition:opacity .5s ease;-o-transition:opacity .5s ease;transition:opacity .5s ease;overflow:hidden}
	.vc_row[data-vc-full-width].vc_hidden{opacity:0}
	.vc_row-no-padding .vc_inner{margin-left:0;margin-right:0}
	.vc_row.vc_row-o-full-height{min-height:100vh}
	.vc_row.vc_row-flex{box-sizing:border-box;display:flex;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap}
	.vc_row.vc_row-flex>.vc_column_container{display:flex}
	.vc_ie-flexbox-fixer,.vc_row.vc_row-flex>.vc_column_container>.vc_column-inner{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;-webkit-box-orient:vertical;-webkit-box-direction:normal}
	.vc_row.vc_row-flex>.vc_column_container>.vc_column-inner{-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1;display:flex;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;z-index:1}
	.vc_row.vc_row-flex::after,.vc_row.vc_row-flex::before{display:none}
	.vc_row.vc_row-o-columns-stretch{-webkit-align-content:stretch;-ms-flex-line-pack:stretch;align-content:stretch}
	.vc_row.vc_row-o-columns-top{-webkit-align-content:flex-start;-ms-flex-line-pack:start;align-content:flex-start}
	.vc_row.vc_row-o-columns-bottom{-webkit-align-content:flex-end;-ms-flex-line-pack:end;align-content:flex-end}
	.vc_row.vc_row-o-columns-middle{-webkit-align-content:center;-ms-flex-line-pack:center;align-content:center}
	.vc_row.vc_row-o-columns-bottom::after,.vc_row.vc_row-o-columns-middle::after,.vc_row.vc_row-o-columns-top::after{content:'';width:100%;height:0;overflow:hidden;visibility:hidden;display:block}
	.vc_row.vc_row-o-content-top>.vc_column_container>.vc_column-inner{-webkit-box-pack:start;-webkit-justify-content:flex-start;-ms-flex-pack:start;justify-content:flex-start}
	.vc_row.vc_row-o-content-top:not(.vc_row-o-equal-height)>.vc_column_container{-webkit-box-align:start;-webkit-align-items:flex-start;-ms-flex-align:start;align-items:flex-start}
	.vc_row.vc_row-o-content-bottom>.vc_column_container>.vc_column-inner{-webkit-box-pack:end;-webkit-justify-content:flex-end;-ms-flex-pack:end;justify-content:flex-end}
	.vc_row.vc_row-o-content-bottom:not(.vc_row-o-equal-height)>.vc_column_container{-webkit-box-align:end;-webkit-align-items:flex-end;-ms-flex-align:end;align-items:flex-end}
	.vc_row.vc_row-o-content-middle>.vc_column_container>.vc_column-inner{-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center}
	.vc_row.vc_row-o-content-middle:not(.vc_row-o-equal-height)>.vc_column_container{-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center}
	.vc_column-inner::after,.vc_column-inner::before{content:' ';display:table}
	.vc_ie-flexbox-fixer{display:flex;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column}
	.vc_ie-flexbox-fixer>.vc_row{-webkit-box-flex:1;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto}
	.vc_row.vc_column-gap-1{margin-left:-15.5px;margin-right:-15.5px}
	.vc_row.vc_column-gap-1>.vc_column_container{padding:.5px}
	.vc_row.vc_column-gap-2{margin-left:-16px;margin-right:-16px}
	.vc_row.vc_column-gap-2>.vc_column_container{padding:1px}
	.vc_row.vc_column-gap-3{margin-left:-16.5px;margin-right:-16.5px}
	.vc_row.vc_column-gap-3>.vc_column_container{padding:1.5px}
	.vc_row.vc_column-gap-4{margin-left:-17px;margin-right:-17px}
	.vc_row.vc_column-gap-4>.vc_column_container{padding:2px}
	.vc_row.vc_column-gap-5{margin-left:-17.5px;margin-right:-17.5px}
	.vc_row.vc_column-gap-5>.vc_column_container{padding:2.5px}
	.vc_row.vc_column-gap-10{margin-left:-20px;margin-right:-20px}
	.vc_row.vc_column-gap-10>.vc_column_container{padding:5px}
	.vc_row.vc_column-gap-15{margin-left:-22.5px;margin-right:-22.5px}
	.vc_row.vc_column-gap-15>.vc_column_container{padding:7.5px}
	.vc_row.vc_column-gap-20{margin-left:-25px;margin-right:-25px}
	.vc_row.vc_column-gap-20>.vc_column_container{padding:10px}
	.vc_row.vc_column-gap-25{margin-left:-27.5px;margin-right:-27.5px}
	.vc_row.vc_column-gap-25>.vc_column_container{padding:12.5px}
	.vc_row.vc_column-gap-30{margin-left:-30px;margin-right:-30px}
	.vc_row.vc_column-gap-30>.vc_column_container{padding:15px}
	.vc_row.vc_column-gap-35{margin-left:-32.5px;margin-right:-32.5px}
	.vc_row.vc_column-gap-35>.vc_column_container{padding:17.5px}
	.vc_column_container{padding-left:0;padding-right:0}
	.vc_column_container>.vc_column-inner{box-sizing:border-box;width:100%}
	.vc_section[data-vc-stretch-content]{padding-left:0;padding-right:0}
	.vc_section.vc_row-o-full-height{min-height:100vh}
	.vc_section.vc_section-flex{box-sizing:border-box;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-ms-flex-flow:column nowrap;flex-flow:column nowrap}
	.vc_section.vc_section-flex .vc_vc_row{width:100%}
	.vc_section.vc_section-flex::after,.vc_section.vc_section-flex::before{display:none}
	.vc_section.vc_section-o-content-top{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}
	.vc_section.vc_section-o-content-bottom{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end}
	.vc_section.vc_section-o-content-middle{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}
	.vc_row.vc_column-gap-1>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-1>.vc_vc_column_inner>.vc_column_container{padding-left:.5px;padding-right:.5px}
	.vc_row.vc_column-gap-2>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-2>.vc_vc_column_inner>.vc_column_container{padding-left:1px;padding-right:1px}
	.vc_row.vc_column-gap-3>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-3>.vc_vc_column_inner>.vc_column_container{padding-left:1.5px;padding-right:1.5px}
	.vc_row.vc_column-gap-4>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-4>.vc_vc_column_inner>.vc_column_container{padding-left:2px;padding-right:2px}
	.vc_row.vc_column-gap-5>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-5>.vc_vc_column_inner>.vc_column_container{padding-left:2.5px;padding-right:2.5px}
	.vc_row.vc_column-gap-10>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-10>.vc_vc_column_inner>.vc_column_container{padding-left:5px;padding-right:5px}
	.vc_row.vc_column-gap-15>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-15>.vc_vc_column_inner>.vc_column_container{padding-left:7.5px;padding-right:7.5px}
	.vc_row.vc_column-gap-20>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-20>.vc_vc_column_inner>.vc_column_container{padding-left:10px;padding-right:10px}
	.vc_row.vc_column-gap-25>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-25>.vc_vc_column_inner>.vc_column_container{padding-left:12.5px;padding-right:12.5px}
	.vc_row.vc_column-gap-30>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-30>.vc_vc_column_inner>.vc_column_container{padding-left:15px;padding-right:15px}
	.vc_row.vc_column-gap-35>.vc_vc_column>.vc_column_container,.vc_row.vc_column-gap-35>.vc_vc_column_inner>.vc_column_container{padding-left:17.5px;padding-right:17.5px}
	.vc_vc_column,.vc_vc_column_inner{padding-left:0;padding-right:0}
	.vc_row.vc_row-flex>.vc_vc_column,.vc_row.vc_row-flex>.vc_vc_column_inner{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex}
	.vc_row.vc_row-flex>.vc_vc_column>.vc_column_container,.vc_row.vc_row-flex>.vc_vc_column_inner>.vc_column_container{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;width:100%}
	.vc_row.vc_row-flex>.vc_vc_column>.vc_column_container>.vc_column-inner,.vc_row.vc_row-flex>.vc_vc_column_inner>.vc_column_container>.vc_column-inner{-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column}
	.vc_row.vc_row-o-equal-height>.vc_column_container{-webkit-box-align:stretch;-webkit-align-items:stretch;-ms-flex-align:stretch;align-items:stretch}
	.vc_row.vc_row-o-content-top>.vc_vc_column>.vc_column_container>.vc_column-inner,.vc_row.vc_row-o-content-top>.vc_vc_column_inner>.vc_column_container>.vc_column-inner{-webkit-box-pack:start;-webkit-justify-content:flex-start;-ms-flex-pack:start;justify-content:flex-start}
	.vc_row.vc_row-o-content-top:not(.vc_row-o-equal-height)>.vc_vc_column>.vc_column_container,.vc_row.vc_row-o-content-top:not(.vc_row-o-equal-height)>.vc_vc_column_inner>.vc_column_container{-webkit-box-align:start;-webkit-align-items:flex-start;-ms-flex-align:start;align-items:flex-start}
	.vc_row.vc_row-o-content-bottom>.vc_vc_column>.vc_column_container>.vc_column-inner,.vc_row.vc_row-o-content-bottom>.vc_vc_column_inner>.vc_column_container>.vc_column-inner{-webkit-box-pack:end;-webkit-justify-content:flex-end;-ms-flex-pack:end;justify-content:flex-end}
	.vc_row.vc_row-o-content-bottom:not(.vc_row-o-equal-height)>.vc_vc_column>.vc_column_container,.vc_row.vc_row-o-content-bottom:not(.vc_row-o-equal-height)>.vc_vc_column_inner>.vc_column_container{-webkit-box-align:end;-webkit-align-items:flex-end;-ms-flex-align:end;align-items:flex-end}
	.vc_row.vc_row-o-content-middle>.vc_vc_column>.vc_column_container>.vc_column-inner,.vc_row.vc_row-o-content-middle>.vc_vc_column_inner>.vc_column_container>.vc_column-inner{-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center}
	.vc_row.vc_row-o-content-middle:not(.vc_row-o-equal-height)>.vc_vc_column>.vc_column_container,.vc_row.vc_row-o-content-middle:not(.vc_row-o-equal-height)>.vc_vc_column_inner>.vc_column_container{-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center}
	.vc_empty-element>.vc_column-inner{min-height:100px}
	.vc_custom_heading a,.vc_custom_heading a:focus,.vc_custom_heading a:hover,.vc_custom_heading a:visited{border:none;text-decoration:inherit;color:inherit}
	.vc_custom_heading a{-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out;opacity:1}
	.vc_custom_heading a:hover{opacity:.85}
	.wpb_call_to_action{position:relative;background-color:#f7f7f7;padding:35px;border:1px solid #F0F0F0;box-sizing:border-box}
	.wpb_call_to_action .wpb_button{margin:0;box-sizing:border-box}
	#content .wpb_call_to_action .wpb_call_text,.wpb_call_to_action .wpb_call_text{margin:0;padding-top:0}
	.wpb_column .wpb_wrapper .wpb_teaser_grid{float:none}
	body ul.wpb_thumbnails-fluid li{padding:0;margin-left:0;background-image:none;list-style:none!important}
	body ul.wpb_thumbnails-fluid li:after,body ul.wpb_thumbnails-fluid li:before{display:none!important}
	.wpb_row .wpb_filtered_grid ul.wpb_thumbnails-fluid,.wpb_row .wpb_grid ul.wpb_thumbnails-fluid{padding:0;overflow:visible!important}
	.wpb_teaser_grid .entry-content{margin:0;padding:0;width:100%}
	.grid_layout-thumbnail .post-thumb img{max-width:100%}
	.vc_separator{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-flex-wrap:nowrap;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center}
	.vc_separator h4{line-height:1em;font-size:100%;margin:0;word-wrap:break-word;-webkit-box-flex:0;-webkit-flex:0 1 auto;-ms-flex:0 1 auto;flex:0 1 auto}
	.vc_separator h4 .normal{font-size:12px;font-weight:400}
	.vc_separator .vc_sep_holder{height:1px;position:relative;-webkit-box-flex:1;-webkit-flex:1 1 auto;-ms-flex:1 1 auto;flex:1 1 auto;min-width:10%}
	.vc_separator .vc_sep_holder .vc_sep_line{height:1px;border-top:1px solid #EBEBEB;display:block;position:relative;top:1px;width:100%}
	.vc_separator.vc_separator_align_left .vc_sep_holder.vc_sep_holder_l,.vc_separator.vc_separator_align_right .vc_sep_holder.vc_sep_holder_r{display:none}
	.vc_separator.vc_separator_align_center h4{padding:0 .8em}
	.vc_separator.vc_separator_align_left h4{padding:0 .8em 0 0}
	.vc_separator.vc_separator_align_right h4{padding:0 0 0 .8em;margin:0!important}
	.vc_separator.vc_sep_double{height:3px}
	.vc_separator.vc_sep_double .vc_sep_line{border-bottom:1px solid #EBEBEB;border-top:1px solid #EBEBEB;height:3px}
	.vc_separator.vc_sep_dashed .vc_sep_line{border-top-style:dashed}
	.vc_separator.vc_sep_dotted .vc_sep_line{border-top-style:dotted}
	.vc_separator.vc_sep_shadow .vc_sep_line{border:none;position:relative;height:20px;top:0;overflow:hidden}
	.vc_separator.vc_sep_shadow .vc_sep_line::after{content:'';display:block;position:absolute;left:0;top:-20px;right:0;height:10px;border-radius:100%}
	.vc_separator.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{right:-100%;box-shadow:10px 10px 10px 1px}
	.vc_separator.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{left:-100%;box-shadow:-10px 10px 10px 1px}
	.vc_separator.vc_separator_no_text:not(.vc_sep_shadow) .vc_sep_holder_l{width:100%}
	.vc_separator.vc_separator_no_text:not(.vc_sep_shadow) .vc_sep_holder_r{display:none}
	.vc_separator .vc_icon_element{margin-bottom:0}
	.vc_separator .vc_icon_element:not(.vc_icon_element-have-style)+h4{padding-left:0}
	.vc_separator .vc_icon_element:not(.vc_icon_element-have-style) .vc_icon_element-size-xl{margin-left:.8em;margin-right:.8em}
	.vc_separator.vc_separator-has-text.vc_separator_align_center .vc_icon_element.vc_icon_element-have-style,.vc_separator.vc_separator-has-text.vc_separator_align_right .vc_icon_element.vc_icon_element-have-style{margin-left:.8em}
	.vc_separator.vc_separator_align_left .vc_icon_element.vc_icon_element-have-style+h4{padding-left:.8em}
	.vc_separator.vc_sep_border_width_1 .vc_sep_holder .vc_sep_line{border-top-width:1px}
	.vc_separator.vc_sep_border_width_1.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:1px;top:0}
	.vc_separator.vc_sep_border_width_1.vc_sep_shadow .vc_sep_line{top:0}
	.vc_separator.vc_sep_border_width_1.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 1px}
	.vc_separator.vc_sep_border_width_1.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 1px}
	.vc_separator.vc_sep_border_width_2 .vc_sep_holder .vc_sep_line{border-top-width:2px}
	.vc_separator.vc_sep_border_width_2.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:2px;top:-1px}
	.vc_separator.vc_sep_border_width_2.vc_sep_shadow .vc_sep_line{top:-1px}
	.vc_separator.vc_sep_border_width_2.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 2px}
	.vc_separator.vc_sep_border_width_2.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 2px}
	.vc_separator.vc_sep_border_width_3 .vc_sep_holder .vc_sep_line{border-top-width:3px}
	.vc_separator.vc_sep_border_width_3.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:3px;top:-1px}
	.vc_separator.vc_sep_border_width_3.vc_sep_shadow .vc_sep_line{top:-1px}
	.vc_separator.vc_sep_border_width_3.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 3px}
	.vc_separator.vc_sep_border_width_3.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 3px}
	.vc_separator.vc_sep_border_width_4 .vc_sep_holder .vc_sep_line{border-top-width:4px}
	.vc_separator.vc_sep_border_width_4.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:4px;top:-2px}
	.vc_separator.vc_sep_border_width_4.vc_sep_shadow .vc_sep_line{top:-2px}
	.vc_separator.vc_sep_border_width_4.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 4px}
	.vc_separator.vc_sep_border_width_4.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 4px}
	.vc_separator.vc_sep_border_width_5 .vc_sep_holder .vc_sep_line{border-top-width:5px}
	.vc_separator.vc_sep_border_width_5.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:5px;top:-2px}
	.vc_separator.vc_sep_border_width_5.vc_sep_shadow .vc_sep_line{top:-2px}
	.vc_separator.vc_sep_border_width_5.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 5px}
	.vc_separator.vc_sep_border_width_5.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 5px}
	.vc_separator.vc_sep_border_width_6 .vc_sep_holder .vc_sep_line{border-top-width:6px}
	.vc_separator.vc_sep_border_width_6.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:6px;top:-3px}
	.vc_separator.vc_sep_border_width_6.vc_sep_shadow .vc_sep_line{top:-3px}
	.vc_separator.vc_sep_border_width_6.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 6px}
	.vc_separator.vc_sep_border_width_6.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 6px}
	.vc_separator.vc_sep_border_width_7 .vc_sep_holder .vc_sep_line{border-top-width:7px}
	.vc_separator.vc_sep_border_width_7.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:7px;top:-3px}
	.vc_separator.vc_sep_border_width_7.vc_sep_shadow .vc_sep_line{top:-3px}
	.vc_separator.vc_sep_border_width_7.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 7px}
	.vc_separator.vc_sep_border_width_7.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 7px}
	.vc_separator.vc_sep_border_width_8 .vc_sep_holder .vc_sep_line{border-top-width:8px}
	.vc_separator.vc_sep_border_width_8.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:8px;top:-4px}
	.vc_separator.vc_sep_border_width_8.vc_sep_shadow .vc_sep_line{top:-4px}
	.vc_separator.vc_sep_border_width_8.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 8px}
	.vc_separator.vc_sep_border_width_8.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 8px}
	.vc_separator.vc_sep_border_width_9 .vc_sep_holder .vc_sep_line{border-top-width:9px}
	.vc_separator.vc_sep_border_width_9.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:9px;top:-4px}
	.vc_separator.vc_sep_border_width_9.vc_sep_shadow .vc_sep_line{top:-4px}
	.vc_separator.vc_sep_border_width_9.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 9px}
	.vc_separator.vc_sep_border_width_9.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 9px}
	.vc_separator.vc_sep_border_width_10 .vc_sep_holder .vc_sep_line{border-top-width:10px}
	.vc_separator.vc_sep_border_width_10.vc_sep_double .vc_sep_holder .vc_sep_line{border-bottom-width:10px;top:-5px}
	.vc_separator.vc_sep_border_width_10.vc_sep_shadow .vc_sep_line{top:-5px}
	.vc_separator.vc_sep_border_width_10.vc_sep_shadow .vc_sep_holder_l .vc_sep_line::after{box-shadow:10px 10px 10px 10px}
	.vc_separator.vc_sep_border_width_10.vc_sep_shadow .vc_sep_holder_r .vc_sep_line::after{box-shadow:-10px 10px 10px 10px}
	.vc_separator.vc_sep_color_blue .vc_sep_line{border-color:#5472D2}
	.vc_separator.vc_sep_color_blue.vc_sep_shadow .vc_sep_holder{color:#5472D2}
	.vc_separator.vc_sep_color_turquoise .vc_sep_line{border-color:#00C1CF}
	.vc_separator.vc_sep_color_turquoise.vc_sep_shadow .vc_sep_holder{color:#00C1CF}
	.vc_separator.vc_sep_color_pink .vc_sep_line{border-color:#FE6C61}
	.vc_separator.vc_sep_color_pink.vc_sep_shadow .vc_sep_holder{color:#FE6C61}
	.vc_separator.vc_sep_color_violet .vc_sep_line{border-color:#8D6DC4}
	.vc_separator.vc_sep_color_violet.vc_sep_shadow .vc_sep_holder{color:#8D6DC4}
	.vc_separator.vc_sep_color_peacoc .vc_sep_line{border-color:#4CADC9}
	.vc_separator.vc_sep_color_peacoc.vc_sep_shadow .vc_sep_holder{color:#4CADC9}
	.vc_separator.vc_sep_color_chino .vc_sep_line{border-color:#CEC2AB}
	.vc_separator.vc_sep_color_chino.vc_sep_shadow .vc_sep_holder{color:#CEC2AB}
	.vc_separator.vc_sep_color_mulled_wine .vc_sep_line{border-color:#50485B}
	.vc_separator.vc_sep_color_mulled_wine.vc_sep_shadow .vc_sep_holder{color:#50485B}
	.vc_separator.vc_sep_color_vista_blue .vc_sep_line{border-color:#75D69C}
	.vc_separator.vc_sep_color_vista_blue.vc_sep_shadow .vc_sep_holder{color:#75D69C}
	.vc_separator.vc_sep_color_black .vc_sep_line{border-color:#2A2A2A}
	.vc_separator.vc_sep_color_black.vc_sep_shadow .vc_sep_holder{color:#2A2A2A}
	.vc_separator.vc_sep_color_grey .vc_sep_line{border-color:#EBEBEB}
	.vc_separator.vc_sep_color_grey.vc_sep_shadow .vc_sep_holder{color:#EBEBEB}
	.vc_separator.vc_sep_color_orange .vc_sep_line{border-color:#F7BE68}
	.vc_separator.vc_sep_color_orange.vc_sep_shadow .vc_sep_holder{color:#F7BE68}
	.vc_separator.vc_sep_color_sky .vc_sep_line{border-color:#5AA1E3}
	.vc_separator.vc_sep_color_sky.vc_sep_shadow .vc_sep_holder{color:#5AA1E3}
	.vc_separator.vc_sep_color_green .vc_sep_line{border-color:#6DAB3C}
	.vc_separator.vc_sep_color_green.vc_sep_shadow .vc_sep_holder{color:#6DAB3C}
	.vc_separator.vc_sep_color_juicy_pink .vc_sep_line{border-color:#F4524D}
	.vc_separator.vc_sep_color_juicy_pink.vc_sep_shadow .vc_sep_holder{color:#F4524D}
	.vc_separator.vc_sep_color_sandy_brown .vc_sep_line{border-color:#F79468}
	.vc_separator.vc_sep_color_sandy_brown.vc_sep_shadow .vc_sep_holder{color:#F79468}
	.vc_separator.vc_sep_color_purple .vc_sep_line{border-color:#B97EBB}
	.vc_separator.vc_sep_color_purple.vc_sep_shadow .vc_sep_holder{color:#B97EBB}
	.vc_separator.vc_sep_color_white .vc_sep_line{border-color:#FFF}
	.vc_separator.vc_sep_color_white.vc_sep_shadow .vc_sep_holder{color:#FFF}
	.vc_text_separator,.wpb_separator{border-bottom:1px solid #EBEBEB;clear:both;height:1px}
	.vc_sep_width_10{width:10%}
	.vc_sep_width_20{width:20%}
	.vc_sep_width_30{width:30%}
	.vc_sep_width_40{width:40%}
	.vc_sep_width_50{width:50%}
	.vc_sep_width_60{width:60%}
	.vc_sep_width_70{width:70%}
	.vc_sep_width_80{width:80%}
	.vc_sep_width_90{width:90%}
	.vc_sep_width_100,.wpb_single_image img.vc_img-placeholder{width:100%}
	.vc_sep_pos_align_center{margin-left:auto;margin-right:auto}
	.vc_sep_pos_align_left{margin-left:0;margin-right:auto}
	.vc_sep_pos_align_right{margin-left:auto;margin-right:0}
	.vc_text_separator div{display:inline-block;background-color:#FFF;padding:1px 1em;position:relative;top:-9px}
	.separator_align_left{text-align:left}
	.separator_align_right{text-align:right}
	.wpb_single_image a{border:none;outline:0}
	.wpb_single_image img{height:auto;max-width:100%;vertical-align:top}
	.wpb_single_image .vc_single_image-wrapper{vertical-align:top;max-width:100%}
	.wpb_single_image .vc_single_image-wrapper.vc_box_rounded,.wpb_single_image .vc_single_image-wrapper.vc_box_rounded img{border-radius:4px;-webkit-box-shadow:none;box-shadow:none}
	.wpb_single_image .vc_single_image-wrapper.vc_box_outline,.wpb_single_image .vc_single_image-wrapper.vc_box_outline_circle{border-radius:0;-webkit-box-shadow:none;box-shadow:none;padding:6px;border:1px solid #EBEBEB}
	.wpb_single_image .vc_single_image-wrapper.vc_box_outline img,.wpb_single_image .vc_single_image-wrapper.vc_box_outline_circle img{border-radius:0;-webkit-box-shadow:none;box-shadow:none;border:1px solid #EBEBEB}
	.wpb_single_image .vc_single_image-wrapper.vc_box_border,.wpb_single_image .vc_single_image-wrapper.vc_box_border_circle{border-radius:0;-webkit-box-shadow:none;box-shadow:none;padding:6px;border:none}
	.wpb_single_image .vc_single_image-wrapper.vc_box_border img,.wpb_single_image .vc_single_image-wrapper.vc_box_border_circle img{border-radius:0;-webkit-box-shadow:none;box-shadow:none;border:none}
	.wpb_single_image .vc_single_image-wrapper.vc_box_shadow,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow img,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border img,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle img,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_circle img{border-radius:0;-webkit-box-shadow:0 0 5px rgba(0,0,0,.1);box-shadow:0 0 5px rgba(0,0,0,.1)}
	.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle{padding:6px}
	.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_3d{border-radius:0;-webkit-box-shadow:none;box-shadow:none;margin-bottom:15px}
	.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_3d img{border-radius:0;-webkit-box-shadow:none;box-shadow:none}
	.wpb_single_image .vc_single_image-wrapper.vc_box_border_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_border_circle img,.wpb_single_image .vc_single_image-wrapper.vc_box_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_circle img,.wpb_single_image .vc_single_image-wrapper.vc_box_outline_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_outline_circle img,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle img,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_circle img{border-radius:50%;-webkit-box-shadow:none;box-shadow:none;overflow:hidden}
	.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_border_circle img,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_circle,.wpb_single_image .vc_single_image-wrapper.vc_box_shadow_circle img{-webkit-box-shadow:0 0 5px rgba(0,0,0,.1);box-shadow:0 0 5px rgba(0,0,0,.1)}
	.wpb_single_image.vc_align_center{text-align:center !important;}
	.wpb_single_image.vc_align_center img{text-align:center !important;}
	.wpb_single_image.vc_align_right{text-align:right}
	.wpb_single_image.vc_align_left{text-align:left}
	.wpb_single_image .vc_box_shadow_3d{position:relative;z-index:0;display:inline-block;max-width:100%}
	.wpb_single_image .vc_figure{vertical-align:top;margin:0;max-width:100%}
	.wpb_single_image .vc_figure-caption{margin-top:.2em;font-size:.8em}
	.wpb_single_image .vc_box_outline.vc_box_border_blue,.wpb_single_image .vc_box_outline_circle.vc_box_border_blue{border-color:#5472D2}
	.wpb_single_image .vc_box_border.vc_box_border_blue,.wpb_single_image .vc_box_border_circle.vc_box_border_blue{background-color:#5472D2}
	.wpb_single_image .vc_box_outline.vc_box_border_turquoise,.wpb_single_image .vc_box_outline_circle.vc_box_border_turquoise{border-color:#00C1CF}
	.wpb_single_image .vc_box_border.vc_box_border_turquoise,.wpb_single_image .vc_box_border_circle.vc_box_border_turquoise{background-color:#00C1CF}
	.wpb_single_image .vc_box_outline.vc_box_border_pink,.wpb_single_image .vc_box_outline_circle.vc_box_border_pink{border-color:#FE6C61}
	.wpb_single_image .vc_box_border.vc_box_border_pink,.wpb_single_image .vc_box_border_circle.vc_box_border_pink{background-color:#FE6C61}
	.wpb_single_image .vc_box_outline.vc_box_border_violet,.wpb_single_image .vc_box_outline_circle.vc_box_border_violet{border-color:#8D6DC4}
	.wpb_single_image .vc_box_border.vc_box_border_violet,.wpb_single_image .vc_box_border_circle.vc_box_border_violet{background-color:#8D6DC4}
	.wpb_single_image .vc_box_outline.vc_box_border_peacoc,.wpb_single_image .vc_box_outline_circle.vc_box_border_peacoc{border-color:#4CADC9}
	.wpb_single_image .vc_box_border.vc_box_border_peacoc,.wpb_single_image .vc_box_border_circle.vc_box_border_peacoc{background-color:#4CADC9}
	.wpb_single_image .vc_box_outline.vc_box_border_chino,.wpb_single_image .vc_box_outline_circle.vc_box_border_chino{border-color:#CEC2AB}
	.wpb_single_image .vc_box_border.vc_box_border_chino,.wpb_single_image .vc_box_border_circle.vc_box_border_chino{background-color:#CEC2AB}
	.wpb_single_image .vc_box_outline.vc_box_border_mulled_wine,.wpb_single_image .vc_box_outline_circle.vc_box_border_mulled_wine{border-color:#50485B}
	.wpb_single_image .vc_box_border.vc_box_border_mulled_wine,.wpb_single_image .vc_box_border_circle.vc_box_border_mulled_wine{background-color:#50485B}
	.wpb_single_image .vc_box_outline.vc_box_border_vista_blue,.wpb_single_image .vc_box_outline_circle.vc_box_border_vista_blue{border-color:#75D69C}
	.wpb_single_image .vc_box_border.vc_box_border_vista_blue,.wpb_single_image .vc_box_border_circle.vc_box_border_vista_blue{background-color:#75D69C}
	.wpb_single_image .vc_box_outline.vc_box_border_black,.wpb_single_image .vc_box_outline_circle.vc_box_border_black{border-color:#2A2A2A}
	.wpb_single_image .vc_box_border.vc_box_border_black,.wpb_single_image .vc_box_border_circle.vc_box_border_black{background-color:#2A2A2A}
	.wpb_single_image .vc_box_outline.vc_box_border_grey,.wpb_single_image .vc_box_outline_circle.vc_box_border_grey{border-color:#EBEBEB}
	.wpb_single_image .vc_box_border.vc_box_border_grey,.wpb_single_image .vc_box_border_circle.vc_box_border_grey{background-color:#EBEBEB}
	.wpb_single_image .vc_box_outline.vc_box_border_orange,.wpb_single_image .vc_box_outline_circle.vc_box_border_orange{border-color:#F7BE68}
	.wpb_single_image .vc_box_border.vc_box_border_orange,.wpb_single_image .vc_box_border_circle.vc_box_border_orange{background-color:#F7BE68}
	.wpb_single_image .vc_box_outline.vc_box_border_sky,.wpb_single_image .vc_box_outline_circle.vc_box_border_sky{border-color:#5AA1E3}
	.wpb_single_image .vc_box_border.vc_box_border_sky,.wpb_single_image .vc_box_border_circle.vc_box_border_sky{background-color:#5AA1E3}
	.wpb_single_image .vc_box_outline.vc_box_border_green,.wpb_single_image .vc_box_outline_circle.vc_box_border_green{border-color:#6DAB3C}
	.wpb_single_image .vc_box_border.vc_box_border_green,.wpb_single_image .vc_box_border_circle.vc_box_border_green{background-color:#6DAB3C}
	.wpb_single_image .vc_box_outline.vc_box_border_juicy_pink,.wpb_single_image .vc_box_outline_circle.vc_box_border_juicy_pink{border-color:#F4524D}
	.wpb_single_image .vc_box_border.vc_box_border_juicy_pink,.wpb_single_image .vc_box_border_circle.vc_box_border_juicy_pink{background-color:#F4524D}
	.wpb_single_image .vc_box_outline.vc_box_border_sandy_brown,.wpb_single_image .vc_box_outline_circle.vc_box_border_sandy_brown{border-color:#F79468}
	.wpb_single_image .vc_box_border.vc_box_border_sandy_brown,.wpb_single_image .vc_box_border_circle.vc_box_border_sandy_brown{background-color:#F79468}
	.wpb_single_image .vc_box_outline.vc_box_border_purple,.wpb_single_image .vc_box_outline_circle.vc_box_border_purple{border-color:#B97EBB}
	.wpb_single_image .vc_box_border.vc_box_border_purple,.wpb_single_image .vc_box_border_circle.vc_box_border_purple{background-color:#B97EBB}
	.wpb_single_image .vc_box_outline.vc_box_border_white,.wpb_single_image .vc_box_outline_circle.vc_box_border_white{border-color:#FFF}
	.wpb_single_image .vc_box_border.vc_box_border_white,.wpb_single_image .vc_box_border_circle.vc_box_border_white{background-color:#FFF}
	.vc_icon_element{line-height:0;font-size:14px;margin-bottom:35px}
	.vc_icon_element.vc_icon_element-outer{box-sizing:border-box;text-align:center}
	.vc_icon_element.vc_icon_element-outer.vc_icon_element-align-left{text-align:left}
	.vc_icon_element.vc_icon_element-outer.vc_icon_element-align-center{text-align:center}
	.vc_icon_element.vc_icon_element-outer.vc_icon_element-align-right{text-align:right}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner{text-align:center;display:inline-block;border:2px solid transparent;width:4em;height:4em;box-sizing:content-box;position:relative}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner .vc_icon_element-icon:before{font-style:normal;font-weight:400;display:inline-block;text-decoration:inherit;width:inherit;height:inherit;font-size:1em;text-align:center;text-rendering:optimizelegibility}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner .vc_gitem-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner .vc_icon_element-link{width:100%;height:100%;display:block;position:absolute;top:0;box-sizing:content-box;border:none}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xs{max-width:100%!important;line-height:1.2em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xs.vc_icon_element-have-style-inner{width:2.5em!important;height:2.5em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xs .vc_icon_element-icon{font-size:1.2em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-sm{max-width:100%!important;line-height:1.6em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-sm.vc_icon_element-have-style-inner{width:3.15em!important;height:3.15em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-sm .vc_icon_element-icon{font-size:1.6em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-md{max-width:100%!important;line-height:2.15em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-md.vc_icon_element-have-style-inner{width:4em!important;height:4em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-md .vc_icon_element-icon{font-size:2.15em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-lg{max-width:100%!important;line-height:2.85em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-lg.vc_icon_element-have-style-inner{width:5em!important;height:5em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-lg .vc_icon_element-icon{font-size:2.85em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xl{max-width:100%!important;line-height:5em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xl.vc_icon_element-have-style-inner{width:7.15em!important;height:7.15em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-size-xl .vc_icon_element-icon{font-size:5em!important}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded .vc_gitem-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded .vc_icon_element-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-outline,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-outline .vc_gitem-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-outline .vc_icon_element-link{border-radius:50%}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-less,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-less .vc_gitem-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-less .vc_icon_element-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-less-outline,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-less-outline .vc_gitem-link,.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-style-rounded-less-outline .vc_icon_element-link{border-radius:5px}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-blue .vc_icon_element-icon{color:#5472D2}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-turquoise .vc_icon_element-icon{color:#00C1CF}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-pink .vc_icon_element-icon{color:#FE6C61}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-violet .vc_icon_element-icon{color:#8D6DC4}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-peacoc .vc_icon_element-icon{color:#4CADC9}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-chino .vc_icon_element-icon{color:#CEC2AB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-mulled_wine .vc_icon_element-icon{color:#50485B}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-vista_blue .vc_icon_element-icon{color:#75D69C}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-black .vc_icon_element-icon{color:#2A2A2A}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-grey .vc_icon_element-icon{color:#EBEBEB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-orange .vc_icon_element-icon{color:#F7BE68}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-sky .vc_icon_element-icon{color:#5AA1E3}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-green .vc_icon_element-icon{color:#6DAB3C}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-juicy_pink .vc_icon_element-icon{color:#F4524D}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-sandy_brown .vc_icon_element-icon{color:#F79468}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-purple .vc_icon_element-icon{color:#B97EBB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-white .vc_icon_element-icon{color:#FFF}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-blue.vc_icon_element-outline{border-color:#5472D2}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-blue.vc_icon_element-background{background-color:#5472D2}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-turquoise.vc_icon_element-outline{border-color:#00C1CF}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-turquoise.vc_icon_element-background{background-color:#00C1CF}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-pink.vc_icon_element-outline{border-color:#FE6C61}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-pink.vc_icon_element-background{background-color:#FE6C61}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-violet.vc_icon_element-outline{border-color:#8D6DC4}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-violet.vc_icon_element-background{background-color:#8D6DC4}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-peacoc.vc_icon_element-outline{border-color:#4CADC9}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-peacoc.vc_icon_element-background{background-color:#4CADC9}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-chino.vc_icon_element-outline{border-color:#CEC2AB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-chino.vc_icon_element-background{background-color:#CEC2AB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-mulled_wine.vc_icon_element-outline{border-color:#50485B}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-mulled_wine.vc_icon_element-background{background-color:#50485B}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-vista_blue.vc_icon_element-outline{border-color:#75D69C}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-vista_blue.vc_icon_element-background{background-color:#75D69C}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-black.vc_icon_element-outline{border-color:#2A2A2A}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-black.vc_icon_element-background{background-color:#2A2A2A}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-grey.vc_icon_element-outline{border-color:#EBEBEB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-grey.vc_icon_element-background{background-color:#EBEBEB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-orange.vc_icon_element-outline{border-color:#F7BE68}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-orange.vc_icon_element-background{background-color:#F7BE68}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-sky.vc_icon_element-outline{border-color:#5AA1E3}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-sky.vc_icon_element-background{background-color:#5AA1E3}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-green.vc_icon_element-outline{border-color:#6DAB3C}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-green.vc_icon_element-background{background-color:#6DAB3C}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-juicy_pink.vc_icon_element-outline{border-color:#F4524D}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-juicy_pink.vc_icon_element-background{background-color:#F4524D}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-sandy_brown.vc_icon_element-outline{border-color:#F79468}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-sandy_brown.vc_icon_element-background{background-color:#F79468}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-purple.vc_icon_element-outline{border-color:#B97EBB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-purple.vc_icon_element-background{background-color:#B97EBB}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-white.vc_icon_element-outline{border-color:#FFF}
	.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-white.vc_icon_element-background{background-color:#FFF}
	.wpb_single_image .wpb_wrapper .vc_single_image-wrapper .zoomImg{border-radius:0}
	.wpb_single_image [class*='_circle'] .vc-zoom-wrapper{border-radius:50%}
	.wpb_single_image [class*='_rounded'] .vc-zoom-wrapper{border-radius:4px}";
	return $css;
}

?>