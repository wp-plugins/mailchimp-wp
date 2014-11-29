<?php
if ( 'eoi-mailchimp' == $plugin_slug ) {
	$edition = 'mailchimp';
}
else if ( 'eoi-campaignmonitor' == $plugin_slug ) {
	$edition = 'campaignmonitor';
}
else if ( 'eoi-aweber' == $plugin_slug ) {
	$edition = 'aweber';
}
else if ( 'eoi-premium' == $plugin_slug ) {
	$edition = 'premium';
}


$filter_file = "$tmp_dir/filter";

`cat "$build_dir/filter-all" "$build_dir/filter-$edition" > "$filter_file"`;
