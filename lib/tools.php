<?php
/**
 * Useful functions
 */

$meta_sections_defn = array(
	'GPS' => array('gps'),
	'TV тюнеры' => array('tv'),
	'Зарядки, батареи, фонарики' => array('фонарики', 'элементы питания', 'батареи'),
	'Беспроводное оборудование' => array('беспр.', 'беспроводные'),
	'Блоки питания' => array('блоки питания'),
	'Бумага' => array('бумага'),
	'Вентиляторы' => array('вентиляторы'),
	'Видеокарты' => array('видеоадаптеры'),
	'Накопители' => array('жесткие диски', 'жёсткие диски', 'ssd', 'flash'),
	'Накопители - аксессуары' => array('карманы для hdd', 'аксессуары для жестких дисков'),
	'Диски и дискеты' => array('диски', 'дискеты'),
	'Звуковые карты' => array('звуковык карты'),
	'Источники бесперебойного питания' => array('ибп'),
	'Игровые манипуляторы и приставки' => array('игровые манипуляторы', 'игровые приставки', 'джойстики', 'рули'),
	'Кабели и переходники' => array('кабели', 'кабель', 'переходники', 'удлинители', 'организаторы кабеля'),
	'Карманные ПК' => array('кпк', 'аксессуары к карманным компьют'),
	'Клавиатуры' => array(),
	'Факсы' => array('факсимильные аппараты', 'расх. материалы для факсов'),
	'Принтеры и МФУ' => array('принтеры', 'мфу', 'зип для принтеров', 'зип к принтерам', 'картриджи для принтеров', 'тонер для принтеров', 'заправки', 'расх. материалы'),
	'Мыши' => array(),
	'Колонки/наушники/микрофоны' => array('колонки', 'наушники', 'микрофоны'),
	'Контроллеры' => array(),
	'Корпуса' => array(),
	'Материнские платы' => array('материнская плата'),
	'Оперативная память' => array('модули памяти'),
	'Мониторы' => array(),
	'Нетбуки' => array(),
	'Ноутбуки' => array('зип к ноутбукам'),
	'Ноутбуки - аксессуары' => array('аксессуары к ноутбукам', 'аксессуары для ноутбуков'),
	'Ноутбуки - сумки' => array('сумки для ноутбуков', 'сумки-кейсы для ноутбуков', 'рюкзаки для ноутбуков', 'чехлы для ноутбуков'),
	'Оптические приводы и плееры' => array('оптические приводы', 'оптический привод', 'приводы dvd', 'dvd плееры', 'плееры dvd'),
	'Програмное обеспечение' => array('программное обеспечение'),
	'Проекторы' => array(),
	'Процессоры' => array(),
	'Телевизоры' => array(),
	'Цифровые камеры' => array('цифровые фотокамеры', 'аксессуары для цифровых фото'),
	'Телефоны' => array(),
	'Шкафы и стойки' => array('стойки', 'шкафы', 'аксессуары для шкафов', 'полки для шкафов'),
	'Сканеры' => array(),
	'Инструмент' => array('наборы интструментов', 'тестеры'),
	'Сетевое оборудование' => array('аксессуары сетевое'),
	'Розетки и патч-корды/панели' => array('розетки', 'подрозетники', 'розеточные модули', 'патч-корды', 'патч-панели'),
	'Маршрутизаторы' => array(),
	'Факс/Модемы' => array(),
	'Коммутаторы' => array(),
	'Коннекторы/стяжки/клипсы' => array('конекторы', 'коннекторы', 'стяжки', 'клипсы', 'скобы'),
	'Коробы' => array('короб'),
	'Оборудование USB' => array('разветвители usb'),
	'Оборудование кроссовое' => array('кроссовое оборудование'),
	'Оборудование оптическое' => array('оптическое сварочное'),
	'Оборудование POE' => array('оборудование power over ethern'),
	'Карты памяти и ридеры' => array('карты памяти', 'устройства для чтения карт памяти'),
	'СНПЧ и чернила' => array('чернила'),
	'Медиаконверторы/SFP/оптические компоненты' => array('медиаконверторы', 'модули sfp для коммутаторов'),
	'Плинты/кронштейны/магазины защиты' => array('плинты', 'кронштейны'),
	'Оборудование IP' => array('камеры ip'),
	'Аксессуары' => array('чистящие средства', 'салфетки', 'боксы и футляры для cd', 'маркеры'),
	'Проигрыватели MP3/CD' => array('проигрыватели mp3'),
	'Мини-АТС' => array('мини - атс'),
);

/**
 * Site authentication
 * store cookies in the temp dir by host name
 * @param string $url
 */
function curl_login ( $url ) {
	global $curl_auth;
	if ( $url ) {
		$url_parts = parse_url($url);
		$cookie    = app_path_temp . $url_parts['host'] . '.cookie';
		// create cURL resource
		$ch = curl_init();
		// set options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ( $curl_auth && is_array($curl_auth) ) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_auth);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:2.0) Gecko/20100101 Firefox/4.0');
		curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie);
		curl_exec($ch);
		//fb(curl_getinfo($ch));
		// close cURL resource, and free up system resources
		curl_close($ch);
	}
}

/**
 * Get the url content with the cookies authenticaton
 * @param string $url
 * @return string
 */
function curl_get ( $url ) {
	global $curl_auth;
	if ( $url ) {
		$url_parts = parse_url($url);
		$cookie    = app_path_temp . $url_parts['host'] . '.cookie';
		// no cookie file then need to start session
		if ( !is_file($cookie) ) {
			curl_login($url, $curl_auth);
		}
		// create cURL resource
		$ch = curl_init();
		// set options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:2.0) Gecko/20100101 Firefox/4.0');
		if ( is_file($cookie) ) {
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		}
		// grab URL and pass it to the browser
		$result = curl_exec($ch);
		//fb(curl_getinfo($ch));
		// close cURL resource, and free up system resources
		curl_close($ch);
		return $result;
	}
}

function curl_logout ( $url ) {
	if ( $url ) {
		$url_parts = parse_url($url);
		$cookie    = app_path_temp . $url_parts['host'] . '.cookie';
		// no cookie file then need to start session
		if ( is_file($cookie) ) {
			unlink($cookie);
		}
	}
}


/**
 * Message logging to file and screen
 * @param string $line 
 */
function mlog ( $line = null ) {
	if (is_array($line) ) {
		$line = print_r($line, true);
	}
	$line = $line . EOL;
	echo $line;
	file_put_contents(app_log_file, $line, FILE_APPEND);
}

/**
 * Extracts the zip file
 * @param string $filename
 * @return string
 */
function ezip ( $filename ) {
	//echo "$filename\n";
    $zip = zip_open($filename);
    if ( is_resource($zip) ) {
        $zip_entry = zip_read($zip);
        if ( zip_entry_open($zip, $zip_entry, "r") ) {
            $data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
			$name = zip_entry_name($zip_entry);
            $name = dirname($filename) . DIRECTORY_SEPARATOR . microtime(true) . '.' .  $name;
            if ( file_put_contents($name, $data) !== false ) {
                return $name;
            }
        }
        zip_close($zip);
    }
}

/**
 * Downloads the xls files
 * @global int $amount_updates
 * @global int $id_check
 * @param array $data
 * @return array
 */
function xls_get ( & $data ) {
	global $amount_updates, $id_check;
	$xlsfiles = array();
	// check mail
	//print_r($data);
	if ( ($mbox = imap_open($data['uri'], $data['user'], $data['pass'])) ) {
		// get old updates ids
		$updates = db_array(db_query('select id, id_message from updates'), 'id_message');
		// iterate messages
		for ( $i = 1; $i <= imap_num_msg($mbox); ++$i ) {
		//	echo "$i ";
		//for ( $i = 1; $i <= 85; ++$i ) {
			$header   = imap_header($mbox, $i);
			$id_msg   = trim($header->message_id, '<>');
			$msg_time = $header->udate;

			// if not an old one
			if ( !isset($updates[$id_msg]) ) {
				$structure = imap_fetchstructure($mbox, $i);
				if ( isset($structure->parts) && $structure->parts ) {
					foreach ( $structure->parts as $part_num => $part ) {
						if ( in_array($part->subtype, array('X-ZIP-COMPRESSED', 'OCTET-STREAM')) ) {
							$filename = $part->parameters[0]->value;
							// need to make sure it's a price
							if ( stripos($filename, '.zip') !== false ) {
								$amount_updates++;
								mlog("File: $filename");
								mlog("\tid :: " . $id_msg);

								$id_update = db_insert(sprintf("insert into updates (id_src, id_check, id_message, file, time) values (%s, %s, '%s', '%s', %s)", $data['id'], $id_check, $id_msg, $filename, $msg_time));

								$filename = app_path_temp . $filename;
								$body = imap_fetchbody($mbox, $i, $part_num+1);
								if ( file_put_contents($filename, imap_base64($body)) === false ) {
									mlog("\tsaved :: fail");
								} else {
									mlog("\tsaved :: ok");
									if ( ($xlsfile = ezip($filename)) ) {
										mlog("\textracted :: ok");
										unlink($filename);
									} else {
										mlog("\textracted :: fail");
									}
									// fill xls files query
									if ( isset($xlsfile) && is_file($xlsfile) ) {
										$xlsfiles[] = array(
											'file' => $xlsfile,
											'uid'  => $id_update
										);
									}
								}
							}
						}
					}
				}
			}
		} 
		imap_close($mbox);
	} else {
		mlog("Can't connect: " . imap_last_error());
	}
	return $xlsfiles;
}

/**
 * Get the existing section id or creates a new one
 * @global PDO $dbh
 * @global array $list_sections
 * @param string $sname
 * @return int 
 */
function get_section_id ( $sname, $id_update, $id_src ) {
	global $sections, $sections_added;
	
	if ( isset($sections[$id_src][$sname]) ) {
		return $sections[$id_src][$sname]['id'];
	} else {
		$id = db_insert(sprintf("insert into sections (name, id_update, id_src) values ('%s', %s, %s)", db_escape($sname), $id_update, $id_src));
		if ( $id ) {
			$sections[$id_src][$sname] = array(
				'id' => $id,
				'name' => $sname,
				'id_update' => $id_update
			);
			$sections_added++;
			return $id;
		}
	}
}

function get_brand_id ( $name ) {
	global $brands;
	
	$bid   = null;
	$name  = trim($name);
	$lname = strtolower($name);
	if ( $lname ) {
		if ( isset($brands[$lname]) ) {
			$bid = $brands[$lname]['id'];
		} else {
			$bid = db_insert("insert into brands (name) values('" . db_escape($name) . "')");
			$brands[$lname]['id']   = $bid;
			$brands[$lname]['name'] = $name;
		}
	}
	return $bid;
}

function get_item_id ( $id_shop, $sid, $uid, $art, $name, $price, $warranty, $id_src, $access ) {
	global $items, $items_prev, $items_added, $items_updated;
	
	$id = null;
	if ( !isset($items[$id_src][$id_shop]) ) {
		$id = db_insert(sprintf("insert into items (id_shop, id_src, id_section, id_update, art, name, price, price_diff, warranty, is_new, access) values (%s, %s, %s, %s, '%s', '%s', %s, 0, %s, 1, %s)", $id_shop, $id_src, $sid, $uid, db_escape($art), db_escape($name), $price, $warranty, $access));
		$items_added++;
		$items[$id_src][$id_shop]['id'] = $id;
	} else {
		$is_new = isset($items_prev[$id_src][$id_shop]) ? 0 : 1;
		if ( $items[$id_src][$id_shop]['art'] != '' && $art != $items[$id_src][$id_shop]['art'] ) {
			mlog("\tart changed: {$items[$id_src][$id_shop]['art']} -> $art");
		}
		db_update(sprintf("update items set id_section = %s, art = '%s', name = '%s', price = %s, price_diff = round('%s' - price, 2), id_update = %s, warranty = '%s', is_new = %s, access = %s where id_shop = %s and id_src = %s", $sid, db_escape($art), db_escape($name), $price, $price, $uid, $warranty, $is_new, $access, $id_shop, $id_src));
		$items_updated++;
		$id = $items[$id_src][$id_shop]['id'];
	}
	$items[$id_src][$id_shop]['art'] = $art;
	return $id;
}

function get_attr_key_id ( $name ) {
	global $attr_keys;
	
	$name = trim($name);
	if ( $name ) {
		if ( isset($attr_keys[$name]) ) {
			return $attr_keys[$name]['id'];
		} else {
			$id = db_insert(sprintf("insert into attr_keys (name) values ('%s')", db_escape($name)));
			if ( $id ) {
				$attr_keys[$name]['id'] = $id;
				return $id;
			}
		}
	}
}

function get_attr_val_id ( $name ) {
	global $attr_vals;
	
	$name = trim($name);
	if ( isset($attr_vals[$name]) ) {
		return $attr_vals[$name]['id'];
	} else {
		$id = db_insert(sprintf("insert into attr_vals (name) values ('%s')", db_escape($name)));
		if ( $id ) {
			$attr_vals[$name]['id'] = $id;
			return $id;
		}
	}
}

function & neologic_xls_import ( $filename ) {
	include_once app_path_lib . 'excel/reader.php';

	$xls      = new Spreadsheet_Excel_Reader();
	$xls_data = array();

	// Set output Encoding.
	$xls->setOutputEncoding('UTF-8');

	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED );
	
	$xls->read($filename);
	
	for ( $i = 6; $i <= $xls->sheets[0]['numRows']; $i++ ) {
		$row = $xls->sheets[0]['cells'][$i];
		if ( $row[1] && $row[2] && $row[4] ) {
			$amain = strtolower(trim($row[6]));
			$amain = $amain == 'ок' ? 1 : ( $amain == 'заказ' ? 2 : 0 );
			$ashop = strtolower(trim($row[7]));
			$ashop = $ashop == 'ок' ? 1 : ( $ashop == 'заказ' ? 2 : 0 );
			$sname = trim($row[1]);
			$xls_data[$sname][intval(trim($row[2]))] = array(
				'art'      => strtolower(trim($row[3])),
				'name'     => trim($row[4]),
				'price'    => floatval(trim($row[5])),
				'warranty' => intval(trim($row[8])),
				'access'   => "$amain$ashop"
			);
			if ( $sname == 'Процессоры' ) {
				foreach ( $xls_data[$sname] as $sid => & $item ) {
					if ( strpos($item['art'], 'AW') === 0 ) {
						$item['art'] = substr($item['art'], 2);
					}
				}
			}
		}
	}
	unset($xls);
	return $xls_data;
}

function & ntcom_xls_import ( $filename ) {
	include_once app_path_lib . 'excel/reader.php';

	$xls      = new Spreadsheet_Excel_Reader();
	$xls_data = array();

	// Set output Encoding.
	$xls->setOutputEncoding('UTF-8');

	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED );
	
	$xls->read($filename);
	
	//print_r($xls->sheets[0]);
	$section = '';
	for ( $i = 8; $i <= $xls->sheets[0]['numRows']; $i++ ) {
		$row = $xls->sheets[0]['cells'][$i];
		if ( count($row) == 1 ) {
			$section = trim($row[1]);
		} else {
			if ( $row[1] && $row[3] ) {
				$amain = strtolower(trim($row[9]));
				$amain = $amain == '+' ? 1 : ( $amain == 'под заказ' ? 2 : ( $amain == '+/-' ? 3 : ( $amain == 'в пути' ? 3 : 0 ) ) );
				$ashop = strtolower(trim($row[10]));
				$ashop = $ashop == '+' ? 1 : ( $ashop == 'под заказ' ? 2 : ( $amain == '+/-' ? 3 : ( $amain == 'в пути' ? 3 : 0 ) ) );
				$xls_data[$section][intval(trim($row[1]))] = array(
					'art'      => strtolower(trim($row[2])),
					'name'     => trim($row[3]),
					'price'    => floatval(trim($row[5])),
					'warranty' => intval(trim($row[4])),
					'access'   => intval("$amain$ashop")
				);
			}
		}
	}
	unset($xls);
	return $xls_data;
}

function fill_brands () {
	global $brands;
	
	$html = new simple_html_dom(curl_get('http://b2b.neologic.com.ua/products/'));
	$data = array();
	foreach ( $html->find('form select#select-brand option') as $option ) {
		if ( $option->value ) {
			$data[] = $option->plaintext;
		}
	}

	if ( $data ) {
		foreach ( $data as $name ) {
			get_brand_id($name);
		}
	}
	
	db_exec("update sections set id_brand = (select ifnull(id_main, id) from (select * from brands order by length(name) desc) as brands where lower(sections.name) like '%' || lower(brands.name) || '%' limit 1)");
	db_exec("update items set id_brand = (select id_brand from sections where items.id_section = sections.id)");

	return $brands;
}

function fill_meta_sections () {
	global $dbh, $meta_sections_defn;

	//$meta_sections_defn = array('Источники бесперебойного питания'=>$meta_sections_defn['Источники бесперебойного питания']);
	
	// reset sections and meta_sections
	db_exec("update sections set id_meta = null; delete from meta_sections; delete from sqlite_sequence where name='meta_sections';");
	
	$sections = db_array(db_query('select id, name, lower(name) as lname from sections order by name'), 'id');
	// add lowered field lname
	foreach ( $sections as & $section ) $section['lname'] = mb_strtolower($section['name'], 'UTF-8');

	// add to the $meta_sections_defn the double names
	foreach ( array_keys(db_array(db_query('select name from (select name, count(*) as count from sections group by name) where count > 1'), 'name')) as $sname ) {
		if ( !isset($meta_sections_defn[$sname]) ) {
			$meta_sections_defn[$sname] = array();
		}
	}

	foreach ( $meta_sections_defn as $sname => $sfilters ) {
		$mid = db_insert("insert or ignore into meta_sections (name) values ('" . db_escape($sname) . "')");
		$sfilters = array_merge(array(mb_strtolower($sname, 'UTF-8')), $sfilters);
		//print_r($sfilters);
		foreach ( $sfilters as $sfilter ) {
			foreach ( $sections as $sid => & $section ) {
				if ( !isset($section['meta']) && strpos($section['lname'], $sfilter) !== false ) {
					$sections[$sid]['meta'] = $mid;
				} else {
					//unset($sections[$sid]);
				}
			}
		}
	}
	//print_r($sections);
	$sql = '';
	foreach ( $sections as $id => $section ) {
		if ( isset($section['meta']) && is_numeric($section['meta']) ) {
			$sql .= "update sections set id_meta = {$section['meta']} where id = $id;\n";
		}
	}
	db_exec($sql);
	db_exec('insert into meta_sections (name) select name from sections where id_meta is null');
	db_exec('update sections set id_meta = (select id from meta_sections where meta_sections.name = sections.name ) where id_meta is null;');
	db_exec('update meta_sections set items_child = (select count(*) from sections where id_meta = meta_sections.id);');
	db_exec('update meta_sections set items_total = (select sum(items_total) from sections where id_meta = meta_sections.id);');
	db_exec('update meta_sections set items_last  = (select sum(items_last)  from sections where id_meta = meta_sections.id);');
	db_exec('update meta_sections set items_new   = (select sum(items_new)   from sections where id_meta = meta_sections.id);');
	db_exec('update meta_sections set sum_inc = round((select sum(sum_inc) from sections where id_meta = meta_sections.id), 2);');
	db_exec('update meta_sections set sum_dec = round((select sum(sum_dec) from sections where id_meta = meta_sections.id), 2);');
}

function neologic_fill_items_attrs () {
	$items = db_array(db_query('select id, id_shop, art from items where id_src = 1 and is_new = 1'), 'id_shop');
	foreach ( $items as $iid => $item ) {
		echo "$iid => {$item['id']}\n";
		
	}
}

function ntcom_fill_items_attrs () {
	
}

function xls_import ( $filename, $id_update, $src ) {
	global $sections, $items, $items_prev, $sections_added, $items_added, $items_updated;
	
	$func     = $src['name'] . '_xls_import';
	$xls_data = $func($filename);
	
	mlog('File: ' . basename($filename));
	if ( $xls_data ) {
		mlog("\tparsed :: ok");

		$sections_added = 0;
		$items_added    = 0;
		$items_updated  = 0;

		$items_prev = db_array(db_query("select id, id_src, id_shop from items where id_update = (select id from updates where id != $id_update and id_src={$src['id']} order by id desc limit 1)"), 'id_shop', 'id_src');
		// reset all is_new flags
		db_update('update items set is_new = 0 where id_src=' . $src['id']);

		foreach ( $xls_data as $section_name => $section_items ) {
			$section_id = get_section_id($section_name, $id_update, $src['id']);
			if ( $section_items ) {
				foreach ( $section_items as $item_id => $item_data ) {
					$item_id = get_item_id($item_id, $section_id, $id_update, $item_data['art'], $item_data['name'], $item_data['price'], $item_data['warranty'], $src['id'], $item_data['access']);
					if ( $item_id ) {
						db_insert(sprintf("insert into info (id_update, id_item, price) values (%s, %s, %s)", $id_update, $item_id, $item_data['price']));
					}
				}
			}
		}

		mlog("\tsections added :: $sections_added");
		mlog("\titems added    :: $items_added");
		mlog("\titems updated  :: $items_updated");

		db_update('update sections set is_active = 0 where id_src=' . $src['id']);
		$section_order = array_keys($xls_data);
		foreach ( $section_order as $order => $section_name ) {
			db_update(sprintf('update sections set is_active = 1, id_update = %s, "order" = %s where id = %s', $id_update, $order, get_section_id($section_name, $id_update, $src['id'])));
		}
	} else {
		mlog("\tparsed :: fail");
	}

	rename($filename, app_path_pub . 'xls' . DIRECTORY_SEPARATOR . $src['name'] . '.xls');
	
//	$func = $src['name'] . '_fill_items_attrs';
//	$func();
}

function fill_items_attrs_neo () {
	$html = new simple_html_dom(curl_get('http://b2b.neologic.com.ua/products/'));
	$data = array();
	foreach ( $html->find('div.b-catmenu ul.b-catmenu-menu li i') as $item ) {
		if ( isset($item->rel) && is_numeric($item->rel) ) {
			$data[] = $item->rel;
		}
	}
	$html->clear();
	unset($html);
	
	$count_page = 0;
	$count_item = 0;
	$count_attr = 0;
	$count_imgs = 0;
	if ( $data ) {
		$brands = db_array(db_query('select id, name, lower(name) as lname from brands'), 'lname');
		foreach ( $data as $sid ) {
			$spage = new simple_html_dom(curl_get("http://b2b.neologic.com.ua/products/$sid"));
			$count_page++;
			if ( $spage ) {
				foreach ( $spage->find('div.b-catalogue table.tb-catalogue tbody tr') as $item ) {
					$iid = $item->find('td', 0);
					$iid = $iid ? trim($iid->plaintext) : null;
					$brand = '';
					if ( $iid && is_numeric($iid) ) {
						$brand = $item->find('td', 1);
						$brand = $brand ? trim($brand->plaintext) : '';
						$bid   = get_brand_id($brand);
						$iiddb = db_array(db_query("select id, id_shop from items where id_shop = $iid and id_src=1"), 'id_shop');
						$iiddb = isset($iiddb[$iid]) ? $iiddb[$iid]['id'] : null;
						//echo("$iid\t$iiddb\t$bid\t$brand\n");
						if ( $iiddb && $bid && is_numeric($bid) ) {
							db_update("update items set id_brand = $bid, id_section_neo = $sid where id=$iiddb");
						}

						$spec = curl_get("http://b2b.neologic.com.ua/products/$sid?Id=$iid&ajax=getSpecifications");
						$spec = json_decode($spec, true);
						$count_page++;
						if ( strtolower(trim($spec['status'])) == 'success' ) {
							$count_item++;
							$spec = new simple_html_dom($spec['html']);
							$tbl = $spec->find('table.tb-catalogue', 0);
							if ( $tbl ) {
								$img = $tbl->find('td.dw img', 0);
								if ( $img && isset($img->src) && strpos($img->src, 'blank.gif') === false ) {
									$img_path = app_path_db . 'neo' . DIRECTORY_SEPARATOR . $sid . DIRECTORY_SEPARATOR;
									$img_file = $img_path . $iid . '.jpg';
									if ( !is_file($img_file) || (date('j') == 1) ) {
										$img = curl_get($img->src);
										$count_page++;
										if ( $img ) {
											$count_imgs++;
											if ( !is_dir($img_path) ) {
												umask(0);
												mkdir($img_path, 0777);
											}
											file_put_contents($img_path . $iid . '.jpg' , $img);
										}
									}
								}
								$attrind = 0;
								$sql = '';
								foreach ( $tbl->find('tr') as $attr ) {
									$attrind++;
									if ( $attrind > 2 ) {
										$attr_key = $attr->find('td', 0);
										$attr_val = $attr->find('td', 1);
										if ( $attr_key && isset($attr_key->plaintext) ) {
											$count_attr++;
											$attr_key = $attr_key->plaintext;
											$attr_val = $attr_val->plaintext;
											$attr_key_id = get_attr_key_id($attr_key);
											$attr_val_id = get_attr_val_id($attr_val);
											//echo "\t$attr_key_id:$attr_key :: $attr_val_id:$attr_val\n";
											$sql .= "insert into items_attrs (id_item,id_attr_key,id_attr_val) values ($iiddb, $attr_key_id, $attr_val_id);\n";
										}
									}
								}
								if ( $sql ) {
									// reset items attrs
									$sql = "delete from items_attrs where id_item = $iiddb;\n" . $sql;
									db_exec($sql);
								}
							}
							$spec->clear();
							unset($spec);
						}
					}
					usleep(100000);
				}
			}
			$spage->clear();
			unset($spage);
			usleep(100000);
		}
	}
	mlog('Filling items attributes (Neologic)');
	mlog("\tcount page :: $count_page");
	mlog("\tcount attr :: $count_item/$count_attr");
	mlog("\tcount imgs :: $count_imgs");
}

function fill_items_attrs_ntc () {
	$items = db_array(db_query('select id, name, id_shop from items where id_src=2'), 'id_shop');
	
	$count_page = 0;
	$count_item = 0;
	$count_attr = 0;
	$count_imgs = 0;
	foreach ( $items as $iid => $item ) {
		$id = $item['id'];
		//echo "$id\t$iid\t{$item['name']}\n";
		$spage = new simple_html_dom(curl_get("http://www.ntcom.com.ua/product.php?art=$iid"));
		$count_page++;
		if ( $spage ) {
			$tbl = $spage->find('div#s2 table', 0);
			if ( $tbl ) {
				$count_item++;
				$sql = '';
				foreach ( $tbl->find('tr') as $tr ) {
					$key = $tr->find('td', 0);
					$val = $tr->find('td', 1);
					if ( $key && $val ) {
						$count_attr++;
						$key = trim(trim($key->plaintext), ':');
						$val = trim($val->plaintext);
						$key_id = get_attr_key_id($key);
						$val_id = get_attr_val_id($val);
						//echo "\t$key_id:$key :: $val_id:$val\n";
						$sql .= "insert into items_attrs (id_item,id_attr_key,id_attr_val) values ($id, $key_id, $val_id);\n";
					}
				}
				if ( $sql ) {
					$sql = "delete from items_attrs where id_item = $id;\n" . $sql;
					db_exec($sql);
					//echo "$sql\n";
				}
			}

			$img_path = app_path_db . 'ntc' . DIRECTORY_SEPARATOR;
			$img_file = $img_path . $iid . '.jpg';
			if ( !is_file($img_file) || (date('j') == 1) ) {
				$img_data = curl_get("http://www.ntcom.com.ua/images-out.php?type=b1&art=$iid&wd=250&ht=250");
				$count_page++;
				if ( $img_data && hash('md5', $img_data) != 'de5e800400786639de93ca59000067bc' ) {
					$count_imgs++;
					file_put_contents($img_file, $img_data);
				}
			}
		}
		$spage->clear();
		unset($spage);
		usleep(100000);
	}
	mlog('Filling items attributes (NTCom)');
	mlog("\tcount page :: $count_page");
	mlog("\tcount attr :: $count_item/$count_attr");
	mlog("\tcount imgs :: $count_imgs");
}

?>