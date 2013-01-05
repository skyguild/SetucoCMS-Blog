<?php
/*
Plugin Name: G Analytics
Plugin URI: http://ivystar.jp/software/g-analytics/
Description: Information from Google Analytics WordPress plugin to manage the display screen.
Version: 1.3.2
Author: Ivystar
Author URI: http://ivystar.jp/
*/

/*  Copyright 2009 Ivystar (email : info@ivystar.jp)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/***************************************************
 * Loading file translation
 ***************************************************/
load_plugin_textdomain('g_analytics','wp-content/plugins/g_analytics/languages');

/***************************************************
 * Read the script file
 ***************************************************/
require_once('cipher.php');

/***************************************************
 * Read the script file
 ***************************************************/
define('GA_ENCRYPTING_KEY', 'ganalytics');


/***************************************************
 * Main function
 ***************************************************/
function ga_plugin_options() {

	// Module Check
	$arr_mc = ga_module_check();
	if ( count($arr_mc) > 0 ){
		ga_set_errmsg(implode("<br />\n", $arr_mc));
		return;
	}else{
		require_once('analytics_api.php');
	}

?>
<div class="wrap">
<h2>G Analytics</h2>

<ul class="subsubsub">
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php"><?php _e('Top', 'g_analytics'); ?></a> |</li>
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php&ga_page=daily_visitors"><?php _e('Daily Visitors', 'g_analytics'); ?></a> |</li>
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php&ga_page=accessed_page"><?php _e('Accessed by page number', 'g_analytics'); ?></a> |</li>
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php&ga_page=referrer"><?php _e('Referrer', 'g_analytics'); ?></a> |</li>
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php&ga_page=keyword"><?php _e('Keyword', 'g_analytics'); ?></a> |</li>
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php&ga_page=browser"><?php _e('Browser', 'g_analytics'); ?></a> |</li>
	<li><a href="<?php echo $PHP_SELF; ?>?page=g_analytics/g_analytics.php&ga_page=setup"><?php _e('Setup', 'g_analytics'); ?></a></li>
</ul>
<div style="clear:left;"></div>

<?php
	$ga_page = $_GET['ga_page'];

	// The indication of the setting form
	if ($ga_page == 'setup'){
		ga_get_set_form();
	}else{
	
		$request_url = $_SERVER["REQUEST_URI'"];
		
	    // It is acquired login information by a database
	    $optval_email    = get_option( 'ga_email' );
	    $optval_passwd   = ga_erypt_decode(get_option( 'ga_passwd' ));
	    $optval_id       = get_option( 'ga_id' );
		$optval_linkpath = get_option( 'ga_linkpath' );
	    
	    $optval_ga_id = 'ga:'.$optval_id;
		
		// Google Analytics Login
		$api = new analytics_api();
		
		if(!$api->login($optval_email, $optval_passwd)) {
			ga_set_errmsg(__('Login failure', 'g_analytics'));
		
		}else{
			
			if (!($ga_page == 'setup')){
				
				echo '<div class="clear"></div>';
				echo ga_set_period();
				echo '</div>';
				
			    $optval_period = get_option( 'ga_period' );
			    if (empty($optval_period)) $optval_period = '1month';
				$p_date = ga_get_date($optval_period);
				
				$metric = '';
				switch($ga_page){
					case 'daily_visitors':
						
						$h3_element = 'Daily Visitors';
						$first_title = 'Date';
						$element_link = false;
						$metric .= 'ga:visits,';
						$metric .= 'ga:pageviews,';
						$metric .= 'ga:visitors,';
						$metric .= 'ga:timeOnPage,';
						$metric .= 'ga:bounces,';
						$metric .= 'ga:entrances';
						
						$arr_data = @$api->data($optval_ga_id,
						                        'ga:date', 
						                        $metric, 
						                        'ga:date', 
						                        $p_date['start_date'], 
						                        $p_date['end_date'], 
						                        $p_date['max_results']);
						
						break;
						
					case 'accessed_page':
						
						$h3_element = 'Accessed by page number';
						$first_title = 'Title';
						$element_link = 'page_title';
						$metric .= 'ga:pageviews,';
						$metric .= 'ga:bounces,';
						$metric .= 'ga:entrances';
						
						$arr_data = @$api->data($optval_ga_id,
						                        'ga:pagePath',
						                        $metric,
						                        false,
						                        $p_date['start_date'],
						                        $p_date['end_date'],
						                        100);
						if (is_array($arr_data)){
							foreach($arr_data as $key => $val){
								$tmpPostID = url_to_postid($_SERVER["SERVER_NAME"].$key);
								if (intval($tmpPostID) > 0){
									$arr_data[$key]['page_title'] = get_the_title($tmpPostID);
									if (preg_match('/preview=true/', $key)){
										$arr_data[$key]['page_title'] .= "(".__('Preview', 'g_analytics').")";
									}
									
								}else{
									$arr_data[$key]['page_title'] = $key;
								}
							}
						}
						break;
						
					case 'referrer';
						
						$h3_element = 'Referrer';
						$first_title = 'Referrer';
						$element_link = false;
						$metric .= 'ga:visits,';
						$metric .= 'ga:pageviews';
						
						$arr_data = @$api->data($optval_ga_id,
						                        'ga:source',
						                        $metric,
						                        false, 
						                        $p_date['start_date'],
						                        $p_date['end_date'],
						                        100);
						
						break;
						
					case 'keyword';
						
						$h3_element = 'Keyword';
						$first_title = 'Keyword';
						$element_link = false;
						$metric .= 'ga:visits,';
						$metric .= 'ga:pageviews';
						
						$arr_data = @$api->data($optval_ga_id,
						                        'ga:keyword',
						                        $metric,
						                        false, 
						                        $p_date['start_date'],
						                        $p_date['end_date'],
						                        100);
						
						break;
						
					case 'browser';
						
						$h3_element = 'Browser';
						$first_title = 'Browser';
						$element_link = false;
						$metric .= 'ga:visits,';
						$metric .= 'ga:pageviews';
						
						$arr_data = @$api->data($optval_ga_id,
						                        'ga:browser',
						                        $metric,
						                        false, 
						                        $p_date['start_date'],
						                        $p_date['end_date'],
						                        100);
						
						break;
						
					default:	// Top page
						ga_get_top($api, $optval_ga_id, $optval_period);
						break;
				}
				
				if (!empty($ga_page)) {
					$arr_data = ga_get_make_analytics_data($arr_data, $first_title);
					
					echo '<h3>';
					_e($h3_element, 'g_analytics');
					echo '</h3>';
					echo '<p>';
					ga_set_table_form($arr_data, $element_link);
					echo '</p>';
				}
			}
		}
		
	    echo '<div class="clear"></div>';
	    echo '<p><a href="'.$optval_linkpath .'" target="_blank">Google Analytics</a></p>';
	}
    
    echo '</div>';
}

/***************************************************
 * Top of the page output
 *--------------------------------------------------
 * @param object $api
 * @param string $optval_ga_id
 * @param string $period
 ***************************************************/
function ga_get_top($api, $optval_ga_id, $period){

	$p_date = ga_get_date($period);
	$today = date('Y-m-d');
	
	// Chart data
	$arr_chart_data = @$api->data($optval_ga_id,
	                              'ga:date',
	                              'ga:visitors,ga:pageviews,ga:visits',
	                              'ga:date',
	                              $p_date['start_date'],
	                              $p_date['end_date'],
	                              $p_date['max_results']);
	
	// Top data
	$metric  = 'ga:bounces,';
	$metric .= 'ga:entrances,';
	$metric .= 'ga:pageviews,';
	$metric .= 'ga:timeOnPage,';
	$metric .= 'ga:timeOnSite,';
	$metric .= 'ga:visits,';
	$metric .= 'ga:uniquePageviews,';
	$metric .= 'ga:newVisits';
	
	$arr_metric_data = @$api->data($optval_ga_id,
	                              '',
	                              $metric,
	                              false,
	                              $p_date['start_date'],
	                              $p_date['end_date']);
	
	// Unique Users
	$metric = 'ga:visitors';
	$arr_metric_visitors_data = @$api->data($optval_ga_id,
	                                        'ga:date',
	                                        $metric,
	                                        'ga:date',
	                                        $p_date['start_date'],
	                                        $p_date['end_date'],
	                                        $p_date['max_results']);
	$cnt_visitors = 0;
	if (is_array($arr_metric_visitors_data)){
		foreach($arr_metric_visitors_data as $val){
			$cnt_visitors = $cnt_visitors + (integer)$val['ga:visitors'];
		}
	}
	
	//Accessed by page number';
	$metric  = 'ga:pageviews';
	$arr_metric_accpage_data = @$api->data($optval_ga_id,
	                                       'ga:pagePath',
	                                       $metric,
	                                       false,
	                                       $today,
	                                       $today,
	                                       10);
	
	// Referrer
	$metric = 'ga:pageviews';
	$arr_metric_referrer_data = @$api->data($optval_ga_id,
	                                        'ga:source',
	                                        $metric,
	                                        false, 
	                                        $today,
	                                        $today,
	                                        10);

	$p_date = ga_get_date($period, '/');
	
	$utime_start = strtotime($p_date['start_date']);
	$utime_end   = strtotime($p_date['end_date']);
	$uday_term   = ($utime_end - $utime_start) / ( 60 * 60 * 24 );
	
	echo '<h3>'.__('Top', 'g_analytics').'</h3>';
	
?>
<div style="width:200px;height:310px;float:left;">
	<table class="widefat">
		<tbody id="the-comment-list" class="list:comment">
		<thead>
			<tr>
				<th scope="col" rowspan="2"><?php _e('Date', 'g_analytics'); ?></th>
				<th scope="col"><?php _e('Start Date', 'g_analytics'); ?></th>
				<td><?php echo $p_date['start_date']; ?></td>
			</tr>
			<tr>
				<th scope="col"><?php _e('End Date', 'g_analytics'); ?></th>
				<td><?php echo $p_date['end_date']; ?></td>
			</tr>
			<tr>
				<th scope="col" rowspan="2"><?php _e('Visits', 'g_analytics'); ?></th>
				<th scope="col"><?php _e('Total', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
	if (is_array($arr_metric_data)){
		echo $arr_metric_data['ga:visits'];
	}
				?></td>
			</tr>
			<tr>
				<th scope="col"><?php _e('Average', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
	if (is_array($arr_metric_data) && $uday_term != 0){
		echo round( $arr_metric_data['ga:visits'] / $uday_term , 0 );
	}
				?></td>
			</tr>
			<tr>
				<th scope="col" rowspan="2"><?php _e('Pageviews', 'g_analytics'); ?></th>
				<th scope="col"><?php _e('Total', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
	if (is_array($arr_metric_data)){
		echo $arr_metric_data['ga:pageviews'];
	}
				?></td>
			</tr>
			<tr>
				<th scope="col"><?php _e('Average', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
	if (is_array($arr_metric_data) && $uday_term != 0){
		echo round( $arr_metric_data['ga:pageviews'] / $uday_term, 0 );
	}
				?></td>
			</tr>
			<tr>
				<th scope="col" rowspan="2"><?php _e('Unique Users', 'g_analytics'); ?></th>
				<th scope="col"><?php _e('Total', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
	if (!empty($cnt_visitors)){
		echo $cnt_visitors;
	}
				?></td>
			</tr>
			<tr>
				<th scope="col"><?php _e('Average', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
	if (!empty($cnt_visitors) && $uday_term != 0){
		echo round( $cnt_visitors / $uday_term, 0 );
	}
				?></td>
			</tr>
			<tr>
				<th scope="col" colspan="2"><?php _e('Bounce Rate', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
					$bounce_rate = '';
					if (is_array($arr_metric_data)){
						if (!empty($arr_metric_data['ga:bounces']) && !empty($arr_metric_data['ga:entrances'])){
							$bounce_rate = round( $arr_metric_data['ga:bounces'] / $arr_metric_data['ga:entrances'], 4 ) * 100;
						}
					}
					echo $bounce_rate;
				?></td>
			</tr>
			<tr>
				<th scope="col" colspan="2"><?php _e('Average Pageviews', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
					$average_ageviews = '';
					if (is_array($arr_metric_data)){
						if (!empty($arr_metric_data['ga:pageviews']) && !empty($arr_metric_data['ga:visits'])){
							$average_ageviews = round( $arr_metric_data['ga:pageviews'] / $arr_metric_data['ga:visits'], 2 );
						}
					}
					echo $average_ageviews;
				?></td>
			</tr>
			<tr>
				<th scope="col" colspan="2"><?php _e('Time on Site', 'g_analytics'); ?></th>
				<td style="text-align:right;"><?php
					$time_site = '';
					if (is_array($arr_metric_data)){
						if (!empty($arr_metric_data['ga:timeOnPage']) && !empty($arr_metric_data['ga:visits'])){
							$time_site = gmdate('H:i:s', $arr_metric_data['ga:timeOnPage'] / $arr_metric_data['ga:visits']);
						}
					}
					echo $time_site;
				?></td>
			</tr>
		</thead>
		</tbody>
	</table>
</div>

<script id="source" language="javascript" type="text/javascript">
jQuery(function () {
<?php
	$d_visitors  = array();
	$d_pageviews = array();
	$d_visits    = array();
	foreach($arr_chart_data as $date_key => $val){
		$date_key = (mktime(0, 0, 0, substr($date_key,4,2), substr($date_key,6,2), substr($date_key,0,4)) + date('Z')) * 1000;
		$d_pageviews[] = '['.$date_key.','.$val['ga:pageviews'].']';
		$d_visitors[]  = '['.$date_key.','.$val['ga:visitors'].']';
		$d_visits[] = '['.$date_key.','.$val['ga:visits'].']';
	}
	$d_visitors  = implode(', ', $d_visitors);
	$d_pageviews = implode(', ', $d_pageviews);
	$d_visits    = implode(', ', $d_visits);
	
?>
    var d1 = [<?php echo $d_pageviews;?>];
    var d2 = [<?php echo $d_visits;?>];
    var d3 = [<?php echo $d_visitors;?>];
    
    var plot = jQuery.plot(
           jQuery("#placeholder"),
           [ { color: "#EDC240", data: d1, label: "<?php _e('Pageviews', 'g_analytics'); ?>" },
             { color: "#AFD8F8", data: d2, label: "<?php _e('Visits', 'g_analytics'); ?>" },
             { color: "#BFFFCE", data: d3, label: "<?php _e('Unique Users', 'g_analytics'); ?>" } ],
           { lines: { show: true },
             points: { show: true },
             grid: { hoverable: true, autoHighlight: true },
             xaxis: { mode: 'time', timeformat: "%m/%d" },
             yaxis: { min: 0 },
             legend: { position: 'n', noColumns: 3, margin: -30 } }
           );

    function showTooltip(x, y, contents) {
        jQuery('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #AFFFFF',
            padding: '2px',
            'background-color': '#DFFFFF',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

	function GetDate(UnixTime){
		var datearray = new Array(3);
		var dd = new Date();
		dd.setTime(UnixTime * 1000);
		datearray[0] = dd.getYear();
		if(datearray[0] < 1900){ datearray[0] += 1900;}
		datearray[1] = dd.getMonth() + 1;
		datearray[2] = dd.getDate();
		for(var count = 3; count < 6; count++){
			if(datearray[count] < 10){ datearray[count] = "0"+datearray[count] }
		}
		return datearray;
	}

    var previousPoint = null;
    jQuery("#placeholder").bind("plothover", function (event, pos, item) {
        if (item) {
            if (previousPoint != item.datapoint) {
                previousPoint = item.datapoint;
                
                jQuery("#tooltip").remove();
                var x = item.datapoint[0];
                var y = item.datapoint[1];
				var dt = GetDate( x / 1000 );
                
                showTooltip(item.pageX, item.pageY,
                            item.series.label + " : " + dt[0] + "/" + dt[1] + "/" + dt[2] + " = " + y);
            }
        } else {
            jQuery("#tooltip").remove();
            previousPoint = null;            
        }
    });

});
</script>
<div style="width:610px;height:20px;margin-left:210px;background-color:#FFFFFF;"></div>
<div id="placeholder" style="width:610px;height:350px;margin-left:210px;background-color:#FFFFFF"></div>
<div class="clear"></div>

<div style="width:400px;float:left;">
	<h4><?php _e('Today\'s popularity article', 'g_analytics');?></h4>
	
	<table class="widefat">
		<thead>
			<tr>
				<th><?php _e('Title', 'g_analytics');?></th>
				<th style="width:80px;text-align:right;"><?php _e('Pageviews', 'g_analytics');?></th>
			</tr>
<?php
	if (is_array($arr_metric_accpage_data)){
		foreach($arr_metric_accpage_data as $key => $val){
			echo '<tr>';
			echo '<td><a href="'.$key.'">';
			
			$tmpPostID = url_to_postid($_SERVER["SERVER_NAME"].$key);
			if ($tmpPostID> 0){
				echo get_the_title($tmpPostID);
				
				if (preg_match('/preview=true/', $key)){
					echo "(".__('Preview', 'g_analytics').")";
				}
			}else{
				echo $key;
			}
			echo '</a></td>';
			echo '<td style="text-align:right;">'.$val['ga:pageviews'].'</td>';
			echo '</tr>';
		}
	}
?>
		</thead>
		</tbody>
	</table>
</div>

<div style="width:400px;margin-left:420px;">
	<h4><?php _e('Today\'s referrer', 'g_analytics');?></h4>
	
	<table class="widefat" style="clear:none">
		<tbody id="the-comment-list" class="list:comment">
		<thead>
			<tr>
				<th><?php _e('Referrer', 'g_analytics');?></th>
				<th style="width:80px;text-align:right;"><?php _e('Pageviews', 'g_analytics');?></th>
			</tr>
<?php
	if (is_array($arr_metric_referrer_data)){
		foreach($arr_metric_referrer_data as $key => $val){
			echo '<tr>';
			echo '<td>'.$key.'</td>';
			echo '<td style="text-align:right;">'.$val['ga:pageviews'].'</td>';
			echo '</tr>';
		}
	}
?>
		</thead>
		</tbody>
	</table>
</div>
<?php
}

/***************************************************
 * Tags period set
 ***************************************************/
function ga_set_period(){
	$tag_hidden    = 'ga_hidden_period';
	$option_period = 'ga_period';

    if ($_POST[ $tag_hidden ] == $option_period){
    	if ( !( empty( $_POST[$option_period] )) ){
    		update_option( $option_period, $_POST[$option_period] );
    	}else{
    		update_option( '1month', $_POST[$option_period] );
    	}
    }
	
    $period = get_option( $option_period );
    if (empty($period)) $period = '1month';
    
?>
<form name="period" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input name="<?php echo $tag_hidden; ?>" type="hidden" value="<?php echo $option_period; ?>">
<p style="text-align:right;">
	<select name="<?php echo $option_period; ?>" id="<?php echo $option_period; ?>" class="<?php echo $option_period; ?>" style="font-size:1.2em;" onchange="period.submit()">
		<option value="3month"<?php echo $period == '3month' ? 'selected' : ''; ?>>
			<?php
				echo __('3 Month ago', 'g_analytics').' : '.date('Y/m/d', strtotime('3 month ago')).' - '.date('Y/m/d');
			?>
		</option>
		<option value="1month"<?php echo $period == '1month' ? 'selected' : ''; ?>>
			<?php
				echo __('1 Month ago', 'g_analytics').' : '.date('Y/m/d', strtotime('1 month ago')).' - '.date('Y/m/d');
			?>
		</option>
		<option value="1week"<?php echo $period == '1week' ? 'selected' : ''; ?>>
			<?php
				echo _e('1 Week ago', 'g_analytics').' : '.date('Y/m/d', strtotime('1 week ago')).' - '.date('Y/m/d');
			?>
		</option>
		<option value="lastmonth"<?php echo $period == 'lastmonth' ? 'selected' : ''; ?>>
			<?php
				$lastmonth = strtotime(date('Y/m/01') . ' -1 day');
				echo _e('Last Month', 'g_analytics').' : '.date('Y/m/01', $lastmonth).'-'.date('Y/m/d', mktime(0, 0, 0, date('m', $lastmonth) + 1, 0, date('Y', $lastmonth)));
			?>
		</option>
		<option value="thismonth"<?php echo $period == 'thismonth' ? 'selected' : ''; ?>>
			<?php
				echo _e('This Month', 'g_analytics').' : '.date('Y/m/01').'-'.date('Y/m/d', mktime(0, 0, 0, date('m') + 1, 0, date('Y')));
			?>
		</option>
		<option value="yesterday"<?php echo $period == 'yesterday' ? 'selected' : ''; ?>>
			<?php
				echo _e('Yesterday', 'g_analytics').' : '.date('Y/m/d', strtotime('1 day ago'));
			?>
		</option>
		<option value="today"<?php echo $period == 'today' ? 'selected' : ''; ?>>
			<?php
				echo _e('Today', 'g_analytics').' : '.date('Y/m/d');
			?>
		</option>
	</select>
</p>
</form>
<?php
}

/***************************************************
 * 	Setting form
 ***************************************************/
function ga_get_set_form(){

	$tag_hidden       = 'ga_hidden_setup';
	$option_email     = 'ga_email';
	$option_passwd    = 'ga_passwd';
	$option_id        = 'ga_id';
	$option_cnt_sdate = 'ga_cnt_sdate';
	$option_linkpath  = 'ga_linkpath';
	$option_rd_auth   = 'ga_reading_authority';
	
	global $current_user;
	get_currentuserinfo();
	
	$user_level = (integer)$current_user->user_level;
//var_dump($user_level);exit;
	if ($user_level < 10){
		echo '<div style="background-color: rgb(255, 251, 204);color: rgb(255, 0, 0);" id="message" class="updated fade"><p><strong>';
		_e('"Setup" has no authority to change.', 'g_analytics');
		echo '<br />';
		_e('Have the authority to change only administrator.', 'g_analytics');
		echo '</strong></p></div>';
		
		return ;
	}
	
    if ($_POST[ $tag_hidden ] == "ga_setup"){
    	
		// Save Database
		update_option( $option_email,     $_POST[$option_email] );
		update_option( $option_id,        $_POST[$option_id] );
		update_option( $option_linkpath,  $_POST[$option_linkpath] );
		update_option( $option_rd_auth,   $_POST[$option_rd_auth] );
		
		// Save Password
		if (!empty($_POST[$option_passwd])){
			$pw = ga_erypt_encode($_POST[$option_passwd]);
			update_option( $option_passwd, $pw );
		}
		
		// A check of the start day of the counter
		$cnt_sdate = '';
		if( ereg("^([0-9]{4})[-/ \.]([01]?[0-9])[-/ \.]([0123]?[0-9])$", $_POST[$option_cnt_sdate], $parts) ) {
			if (checkdate($parts[2], $parts[3], $parts[1])){
				$cnt_sdate = date('Y-m-d', strtotime($parts[1].'-'.$parts[2].'-'.$parts[3]));
			}
		}
  		if (!empty($cnt_sdate)){
			update_option( $option_cnt_sdate, $cnt_sdate );
		}else{
			ga_set_errmsg(__('A date of the counter start day is unjust.', 'g_analytics'));
		}
		
		echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p><strong>';
		echo __('I save the settings.', 'g_analytics');
		echo '</strong></p></div>';
    }
	
    // Load settings from an existing database
    $optval_email     = get_option( $option_email );
    $optval_passwd    = ga_erypt_decode(get_option( $option_passwd ));
    $optval_id        = get_option( $option_id );
	$optval_cnt_sdate = get_option( $option_cnt_sdate );
    $optval_linkpath  = get_option( $option_linkpath );
    $optval_rd_auth   = get_option( $option_rd_auth );

	$api = new analytics_api();
	if(!$api->login($optval_email, $optval_passwd)) {
		ga_set_errmsg(__('Login failure', 'g_analytics'));
	}
	
	if (empty($optval_cnt_sdate)){
		$optval_cnt_sdate = date('Y-m-d');
	}
	
?>
<h3><?php _e('Setup', 'g_analytics'); ?></h3>
<form name="setup" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input name="<?php echo $tag_hidden; ?>" type="hidden" value="ga_setup">
<table class="form-table">
<tbody>
<tr>
	<th>E-Mail</th>
	<td>
		<input name="<?php echo $option_email; ?>" id="<?php echo $option_email; ?>" class="<?php echo $option_email; ?>" size="20" type="text" value="<?php echo $optval_email; ?>"><br />
		<?php _e('Google Analytics for E-Mail Please enter your address. (Required)', 'g_analytics');?>
	</td>
</tr>
<tr>
	<th>Password</th>
	<td>
		<input name="<?php echo $option_passwd; ?>" id="<?php echo $option_passwd; ?>" class="<?php echo $option_passwd; ?>" size="20" type="password" value=""><br />
		<?php _e('Google Analytics Please enter your password. (Required)', 'g_analytics');?>
	</td>
</tr>
<tr>
	<th><?php _e('Profile', 'g_analytics');?></th>
	<td>
		<select name="<?php echo $option_id; ?>" id="<?php echo $option_id; ?>">
		<?php
			@$api->load_accounts();
			if (count($api->accounts) > 0){
				foreach($api->accounts as $title => $profileId){
					echo '<option value="'.$profileId['profileId'].'"';
					if ($optval_id == $profileId['profileId']){
						echo " SELECTED";
					}
					echo ">";
					echo $title."</option>\n";
				}
			}
		?>
		</select><br>
		<?php _e('Please choose a profile. (Required)', 'g_analytics');?>
	</td>
</tr>
<tr>
	<th><?php _e('The start day of the counter', 'g_analytics');?></th>
	<td>
		<input name="<?php echo $option_cnt_sdate; ?>" id="<?php echo $option_cnt_sdate; ?>" class="<?php echo $option_cnt_sdate; ?>" size="20" type="text" value="<?php echo $optval_cnt_sdate; ?>"><br />
		<?php _e('Please input a day to start the total of the counter.', 'g_analytics');?>
		<?php _e('(example:2009-05-09)', 'g_analytics');?>
	</td>
</tr>
<tr>
	<th><?php _e('Reading authority', 'g_analytics');?></th>
	<td>
		<select name="<?php echo $option_rd_auth; ?>" id="<?php echo $option_rd_auth; ?>">
			<option value="10" <?php echo $optval_rd_auth == 10 ? "SELECTED" : ""; ?>><?php _e('Admin', 'g_analytics');?></option>
			<option value="7" <?php echo $optval_rd_auth == 7  ? "SELECTED" : ""; ?>><?php _e('Editor', 'g_analytics');?></option>
			<option value="2" <?php echo $optval_rd_auth == 2  ? "SELECTED" : ""; ?>><?php _e('Author', 'g_analytics');?></option>
			<option value="1" <?php echo $optval_rd_auth == 1  ? "SELECTED" : ""; ?>><?php _e('Contributor', 'g_analytics');?></option>
			<option value="0" <?php echo $optval_rd_auth == 0  ? "SELECTED" : ""; ?>><?php _e('Subscriber', 'g_analytics');?></option>
		</select>
	</td>
</tr>
<tr>
	<th><?php _e('Google Analytics link path', 'g_analytics');?></th>
	<td>
		<input name="<?php echo $option_linkpath; ?>" id="<?php echo $option_linkpath; ?>" class="<?php echo $option_linkpath; ?>" size="60" type="text" value="<?php echo $optval_linkpath; ?>"><br />
		<?php _e('Please enter the Google Analytics link path.', 'g_analytics');?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<p class="submit">
			<input type="submit" class="button-primary" name="Submit" value="<?php _e('Save Chenge', 'g_analytics');?>">
		</p>
	</td>
</tr>
<tbody>
</table>
</form>

<?php _e('I can display a counter on a theme in this plug in.', 'g_analytics'); ?><br />
<?php _e('It is necessary to set it up on <code>&lt;?php ga_counter(\'pv\'); ?&gt;</code> and a theme when I display it on a theme.', 'g_analytics'); ?><br />
<?php _e('I can change the kind of the counter by changing an argument.', 'g_analytics'); ?><br />
&nbsp; pv : <?php _e('Pageviews', 'g_analytics'); ?><br />
&nbsp; vs : <?php _e('Visits', 'g_analytics'); ?><br />
&nbsp; uu : <?php _e('Unique Users', 'g_analytics'); ?><br />
<?php
}

/***************************************************
 * The making of Analytics data
 *--------------------------------------------------
 * @param array  $arr_data
 * @param string $first_title
 ***************************************************/
function ga_get_make_analytics_data($arr_data, $first_title = ''){

	$arr_tile = array($first_title);
	$cnt = 0;
	$arr_result = array();
	if (is_array($arr_data)){
		foreach($arr_data as $row_key => $row_val){
			
			// Visits
			if (array_key_exists('ga:visits', $row_val)){
				$arr_result['data'][$row_key]['ga:visits'] = $row_val['ga:visits'];
				if ($cnt == 0) $arr_tile[] = __('Visits', 'g_analytics');
			}
			
			// Unique Users
			if (array_key_exists('ga:visitors', $row_val)){
				$arr_result['data'][$row_key]['ga:visitors'] = $row_val['ga:visitors'];
				if ($cnt == 0) $arr_tile[] = __('Unique Users', 'g_analytics');
			}
			
			// Pageviews
			if (array_key_exists('ga:pageviews', $row_val)){
				$arr_result['data'][$row_key]['ga:pageviews'] = $row_val['ga:pageviews'];
				if ($cnt == 0) $arr_tile[] = __('Pageviews', 'g_analytics');
			}
			
			// Average Pageviews
			if (array_key_exists('ga:visits', $row_val) && array_key_exists('ga:pageviews', $row_val)){
				if ($row_val['ga:pageviews'] == 0 || $row_val['ga:visits'] == 0){
					$arr_result['data'][$row_key]['ga:averagePageviews'] = 0;
				}else{
					$arr_result['data'][$row_key]['ga:averagePageviews'] = round( $row_val['ga:pageviews'] / $row_val['ga:visits'], 2 );
				}
				if ($cnt == 0) $arr_tile[] = __('Average Pageviews', 'g_analytics');
			}
			
			// Time on Site
			if (array_key_exists('ga:visits', $row_val) && array_key_exists('ga:timeOnPage', $row_val)){
				if ($row_val['ga:timeOnPage'] == 0 || $row_val['ga:visits'] == 0){
					$arr_result['data'][$row_key]['ga:timeOnSite'] = '00:00:00';
				}else{
					$arr_result['data'][$row_key]['ga:timeOnSite'] = gmdate('H:i:s', $row_val['ga:timeOnPage'] / $row_val['ga:visits']);
				}
				if ($cnt == 0) $arr_tile[] = __('Time on Site', 'g_analytics');
			}
			
			// Bounce Rate
			if (array_key_exists('ga:bounces', $row_val) && array_key_exists('ga:entrances', $row_val)){
				if ($row_val['ga:bounces'] == 0 || $row_val['ga:entrances'] == 0){
					$arr_result['data'][$row_key]['ga:bounceRate'] = 0;
				}else{
					$arr_result['data'][$row_key]['ga:bounceRate'] = round( $row_val['ga:bounces'] / $row_val['ga:entrances'], 4 ) * 100;
				}
				if ($cnt == 0) $arr_tile[] = __('Bounce Rate', 'g_analytics');
			}
			
			// Title
			if (array_key_exists('page_title', $row_val)){
				$arr_result['data'][$row_key]['page_title'] = $row_val['page_title'];
			}
			
			$cnt = 1;
		}
	}
	
	$arr_result['title'] = $arr_tile;
	
	return $arr_result;
	
}

/***************************************************
 * Making of the table HTML
 *--------------------------------------------------
 * @param array $arr_data
 * @param mix $element_link
 ***************************************************/
function ga_set_table_form($arr_data, $element_link = false){

	if (empty($arr_data)) return;
	
	$col_cnt = 0;
	$html_title = '';
	foreach($arr_data['title'] as $title_val){
		$html_title .= '<th scope="col"';
		if($col_cnt != 0){
			$html_title .= ' style="text-align:right;"';
		}
		$html_title .= '>'.__($title_val, 'g_analytics').'</th>';
		$col_cnt++;
	}
	
	$siteurl = get_option( 'siteurl' );
	$css = 'padding-top:2px;padding-bottom:2px;background-color:';
	$rowcnt = 1;
	$html_date = '';
	if (array_key_exists('data', $arr_data)){
		foreach ($arr_data['data'] as $rowkey => $rowval){
			if ($rowcnt % 2 == 0){
				$bgcolor = '#FFFFFF;';
			}else{
				$bgcolor = '#FFFFDF;';
			}
			
			$html_date .= '<tr><td style="'.$css.$bgcolor.'">';
			
			// Date Check
			$first_element = $rowkey;
			if(preg_match('/(\d{4})(\d{2}|\d)(\d{2}|\d)/', $rowkey, $match)){
				if(checkdate($match[2], $match[3], $match[1]))
				$first_element = substr($rowkey,0,4).'/'.substr($rowkey,4,2).'/'.substr($rowkey,6,2);
			}
			
			if ($element_link !== false){
				$html_date .= '<a href="'.$siteurl.$rowkey.'">';
				if (array_key_exists($element_link, $rowval)){
					$html_date .= $rowval[$element_link];
				}else{
					$html_date .= $first_element;
				}
				$html_date .= '</a>';
			}else{
				$html_date .= $first_element;
			}
			$html_date .= '</td>';
			
			$text_align = 'text-align:right';
			foreach($rowval as $key => $val){
				if ($element_link !== $key){
					$html_date .= '<td style="'.$css.$bgcolor.$text_align.'">'.$val.'</td>';
				}
			}
			
			$html_date .= '</tr>';
			$rowcnt++;
		}
	}
?>
<table class="widefat">
	<thead>
		<tr>
			<?php echo $html_title; ?>
		</tr>
	</thead>
	<tbody id="the-comment-list" class="list:comment">
		<?php echo $html_date; ?>
	</tbody>
</table>
<?php
}

/***************************************************
 * The acquisition of date data
 *--------------------------------------------------
 * @param string $period
 * @param string $pause
 * @return array
 ***************************************************/
function ga_get_date($period, $pause = "-"){

	$format = 'Y'.$pause.'m'.$pause.'d';

	switch($period){
		case '3month':
			$date_start = date($format, strtotime('3 month ago'));
			$date_end = date($format);
			$max_results = 93;
			break;
			
		case 'lastmonth':
			$lastmonth = strtotime(date('Y/m/1') . ' -1 day');
			$date_start = date($format, mktime(0, 0, 0, date('m', $lastmonth), 1, date('Y', $lastmonth)));
			$date_end = date($format, mktime(0, 0, 0, date('m', $lastmonth) + 1, 0, date('Y', $lastmonth)));
			$max_results = 32;
			break;
			
		case 'thismonth':
			$date_start = strtotime(date('Y/m/1'));
			$date_start = date($format, $date_start);
			$date_end = date($format , strtotime($date_start . ' 1 month - 1 day'));
			$max_results = 32;
			break;
			
		case '1week':
			$date_start = date($format, strtotime('1 week ago'));
			$date_end = date($format);
			$max_results = 8;
			break;
			
		case 'yesterday':
			$date_start = date($format, strtotime('1 day ago'));
			$date_end = date($format, strtotime('1 day ago'));
			$max_results = 1;
			break;
			
		case 'today':
			
			$date_start = date($format);
			$date_end = date($format);
			$max_results = 1;
			break;
		
		default:
		case '1month':
			$date_start = date($format, strtotime('1 month ago'));
			$date_end = date($format);
			$max_results = 32;
			break;
			
	}
	
	return array('start_date'  =>  $date_start,
	             'end_date'    => $date_end,
	             'max_results' => $max_results,
	            );
}

/***************************************************
 * The indication of a counter for templates
 *--------------------------------------------------
 * @param string $mode
 *               pv:Pageviews
 *               vs:Visits
 *               uu:Unique Users
 ***************************************************/
function ga_counter($mode){
	
	$ga_cnt = 0;
	
	// Module Check
	$arr_mc = ga_module_check();
	if ( count($arr_mc) > 0 ){
		ga_set_errmsg(implode("<br />\n", $arr_mc));
		return;
	}else{
		require_once('analytics_api.php');
	}
	
    // It is acquired login information by a database
    $optval_email     = get_option( 'ga_email' );
    $optval_passwd    = ga_erypt_decode(get_option( 'ga_passwd' ));
    $optval_id        = get_option( 'ga_id' );
	$optval_cnt_sdate = get_option( 'ga_cnt_sdate' );
    $optval_ga_id     = 'ga:'.$optval_id;
	
	// Google Analytics Login
	$api = new analytics_api();
	if(!$api->login($optval_email, $optval_passwd)) {
		$ga_cnt = __('Login failure', 'g_analytics');
	
	}else{
	
		// Unique Users
		if ($mode == 'uu'){
			
			$metric = 'ga:visitors';
			$max_results = strtotime(date('Y-m-d')) - strtotime($optval_cnt_sdate);
			$max_results = intval( $max_results / ( 24 * 60 * 60)) + 1;
			$arr_metric_visitors_data = @$api->data($optval_ga_id,
			                                        'ga:date',
			                                        $metric,
			                                        'ga:date',
			                                        $optval_cnt_sdate,
			                                        date('Y-m-d'),
			                                        $max_results);
			$cnt_visitors = 0;
			if (is_array($arr_metric_visitors_data)){
				foreach($arr_metric_visitors_data as $val){
					$cnt_visitors = $cnt_visitors + (integer)$val['ga:visitors'];
				}
			}
			$ga_cnt = $cnt_visitors;
			
		// Other
		}else{
			
			$metric  = 'ga:pageviews,';
			$metric .= 'ga:visits';
			$arr_metric_data = @$api->data($optval_ga_id,
			                              '',
			                              $metric,
			                              false,
			                              $optval_cnt_sdate,
			                              date('Y-m-d'));
			
			if (is_array($arr_metric_data)){
				switch ($mode){
					case 'pv':
						$ga_cnt = $arr_metric_data['ga:pageviews'];
						break;
					case 'vs':
						$ga_cnt = $arr_metric_data['ga:visits'];
						break;
				}
			}
		}
	}
	
	echo $ga_cnt;
}

/***************************************************
 * Error Messege
 *--------------------------------------------------
 * @param string $msg
 * @return string
 ***************************************************/
function ga_set_errmsg($msg){
	
	echo '<div style="background-color: rgb(255, 251, 204);color: rgb(255, 0, 0);" id="message" class="updated fade"><p><strong>';
	echo $msg;
	echo '</strong></p></div>';
	
}

/***************************************************
 * Coding and a double sign
 *--------------------------------------------------
 * @param string $str
 * @return string
 ***************************************************/
function ga_erypt_encode($str){
	
	$arc = new cipher();
	$arc->setKey( GA_ENCRYPTING_KEY );
	$rst = $arc->getCrypt($str);
	$rst = base64_encode($rst);
	
	return $rst;
}

/***************************************************
 * Coding and a double sign
 *--------------------------------------------------
 * @param string $str
 * @return string
 ***************************************************/
function ga_erypt_decode($str){
	
	$arc = new cipher();
	$arc->setKey( GA_ENCRYPTING_KEY );
	$rst = base64_decode ($str);
	$rst = $arc->getCrypt($rst);
	
	return $rst;
}

/***************************************************
 * Module Check
 *--------------------------------------------------
 * @return array
 ***************************************************/
function ga_module_check(){

	$arr_msg = array();
	
	if ( ! (function_exists('curl_init') && extension_loaded('curl')) ) {
		$arr_msg[] = __('"CURL" no module.', 'g_analytics');
	}

	if ( ! (class_exists('DOMDocument') && extension_loaded('dom')) ) {
		$arr_msg[] = __('"DOM" no module.', 'g_analytics');
	}
	
	return $arr_msg;
}


/***************************************************
 * Add Action
 ***************************************************/
add_action('admin_print_scripts', 'ga_script');
add_action('admin_menu', 'ga_menu');

/***************************************************
 * Loading external scripts
 ***************************************************/
function ga_script(){
	wp_enqueue_script( 'excanvas_pack', '/wp-content/plugins/g_analytics/js/flot/excanvas.min.js');
	wp_enqueue_script( 'flot',          '/wp-content/plugins/g_analytics/js/flot/jquery.flot.js');
}

/***************************************************
 * Add Options Page
 ***************************************************/
function ga_menu() {
	$optval_rd_auth  = get_option( 'ga_reading_authority' );
	if (empty($optval_rd_auth)){
		$optval_rd_auth = 8;
	}
	
	add_submenu_page('index.php', 'G Analytics', 'G Analytics', $optval_rd_auth, __FILE__, 'ga_plugin_options');
}

?>