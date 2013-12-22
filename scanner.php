<?php
/**
 * main scanner
 * downloads, parsing and import data
 */

// main include
include 'lib/init.php';

// logging
mlog(date('Y.m.d H:i:s', $time_start) . ' - check started');
// transaction
$dbh->beginTransaction();

$xlsfiles   = array();
$items      = array();
$items_prev = array();
$attr_keys  = array();
$attr_vals  = array();

$sections_added = 0;
$items_added    = 0;
$items_updated  = 0;
$amount_updates = 0;

// add new check start
$id_check = db_insert("insert into checks (time_start) values ($time_start)");
// fill dictionaries
$sections  = db_array(db_query('select * from sections'), 'name', 'id_src');
$items     = db_array(db_query('select id, id_src, id_shop, art from items'), 'id_shop', 'id_src');
$attr_keys = db_array(db_query('select id, name from attr_keys'), 'name');
$attr_vals = db_array(db_query('select id, name from attr_vals'), 'name');
$brands    = db_array(db_query('select id, name, lower(name) as lname from brands'), 'lname');

foreach ( db_array(db_query('select * from sources')) as $source ) {
	$xlsfiles = xls_get($source);
	foreach ( $xlsfiles as $xlsfile ) {
		xls_import($xlsfile['file'], $xlsfile['uid'], $source);
	}
	
	// in case of incoming recalculate totals and fill meta sections
	if ( $xlsfiles ) {
		$id_src = $source['id'];
		db_update("update sections set items_total = (select count(id) from items where items.id_section = sections.id) where id_src=$id_src");
		db_update("update sections set items_last = (select count(id) from items where items.id_section = sections.id and items.id_update = sections.id_update) where id_src=$id_src");
		db_update("update sections set items_new = (select count(id) from items where items.id_section = sections.id and items.is_new = 1 and items.id_update = sections.id_update) where id_src=$id_src");
		db_update("update sections set sum_inc = round((select sum(price_diff) from items where items.id_section = sections.id and items.price_diff > 0 and items.id_update = sections.id_update), 2) where id_src=$id_src");
		db_update("update sections set sum_dec = round((select sum(price_diff) from items where items.id_section = sections.id and items.price_diff < 0 and items.id_update = sections.id_update), 2) where id_src=$id_src");

		//fill_meta_sections();
		//fill_brands();
	}
}

if ( $xlsfiles ) {
	//fill_items_attrs_neo();
	//fill_items_attrs_ntc();
}

curl_logout('http://b2b.neologic.com.ua/');

db_update(sprintf('update checks set duration = %s, updates = %s where id = %s', time()-$time_start, $amount_updates, $id_check));

// transaction
$dbh->commit();
// logging
mlog(date('Y.m.d H:i:s') . ' - check ended' . EOL . EOL);

?>