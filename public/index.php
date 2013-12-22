<?php
/**
 * Main html generating file
 * @author DarkPark, Urkaine Odessa 2009
 */

// main include
include '../lib/init.php';

function ajax_get_items () {
	$sid    = $_REQUEST['sid'];
	$filter = $_REQUEST['filter'];
	$group  = $_REQUEST['group'];
	$where  = '';
	switch ( $group ) {
		case 'all' :
			break;
		case 'new' :
			$where = ' and i.is_new = 1';
			break;
		case 'latest' :
			$where = ' and u.id in (select max(id) from updates group by id_src)';
			break;
		case 'week' :
			$where = ' and u.time > ' . (time() - 7*24*60*60);
			break;
		case 'month' :
			$where = ' and u.time > ' . (time() - 30*24*60*60);
			break;
	}
	
	if ( $filter ) {
		$filter = strtolower($filter);
		$filter = explode(' ', $filter);
		if ( $filter ) {
			foreach ( $filter as $npart ) {
				$npart = trim($npart);
				if ( $npart ) {
					if ( $npart[0] == '-' ) {
						$npart  = ltrim($npart, '-');
						$where .= " and lower(i.name) not like lower('%$npart%')";
					} else {
						$where .= " and lower(i.name) like lower('%$npart%')";
					}
				}
			}
		}
	}
	
	$sql = "select i.*, u.time, b.name as bname from items i, updates u left join brands b on i.id_brand = b.id where u.id = i.id_update and i.id_section in (select id from sections where id_meta = $sid)" . $where . ' order by lower(i.name)';
	$items = db_array(db_query($sql));
	fb($sql);
	$list  = array();
	if ( $items ) {
		foreach ( $items as $item ) {
//			$list[] = array(
//				'id'       => $item['id_src'] . ':' . $item['id_shop'],
//				//'art'      => trim($item['art']),
//				'name'     => $item['name'],
//				'price'    => (float)$item['price'],
//				//'diff'     => (float)$item['price_diff'],
//				'warranty' => $item['warranty'],
//				//'is_new'   => (int)$item['is_new'],
//				'time'     => date('Y-m-d', $item['time'])
//			);
			$list[] = array(
				$item['id'],
				$item['id_src'] . ':' . $item['id_shop'],
				$item['art'],
				$item['bname'],
				$item['name'],
				number_format($item['price'], 2, '.', ''),
				//'diff'     => (float)$item['price_diff'],
				$item['warranty'],
				//'is_new'   => (int)$item['is_new'],
				date('Y-m-d', $item['time'])
			);
		}
	}
	
	//fb($sql);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($list);
	exit;
}

if ( isset($_REQUEST['action']) ) {
	switch ( $_REQUEST['action'] ) {
		case 'get_items': ajax_get_items(); break;
	}
}

$sections = db_array(db_query('select * from meta_sections where is_active = 1 order by "name"'));

?>
<html>
	<head>
		<title>Pricemon</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="shortcut icon" href="images/icon.ico"/>
		<link rel="stylesheet" type="text/css" href="re-set.css"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script type="text/javascript" src="jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="jquery.highlight-3.yui.js"></script>
		<script type="text/javascript" src="jquery.dataTables.min.js"></script>
	</head>
<body>
	<?php
	foreach ( $sections as $section ) {
		$section['items_last'] = $section['items_last'] ? $section['items_last'] : 0;
		?>
		<div class="section" id="<?php echo $section['id'] ?>">
			<div class="section-title">
				<table class="maxw" style="height:25px">
					<tr>
						<td style="width:5px; vertical-align: top"><div class="angcorn"></div></td>
						<td style="width:25px; text-align: right;">
							<span id="counter" class="orange" title="<?php echo $section['items_total'] . '/' . $section['items_last']; ?>"><?php echo $section['items_last'] ? $section['items_last'] : 0 ?></span>
						</td>
						<td style="width:20px; color: gray; text-align: center"> :: </td>
						<td>
							<span class="bold"><?php echo $section['name']; ?></span>
							<span class="orange" title="поступление новых товаров"><?php echo $section['items_new'] ? '+'.$section['items_new'] : '' ?></span>
						</td>
						<td width="65" align="left">динамика:</td>
						<td width="50" align="right">
							<span class="orange" title="суммарное понижение стоимости"><?php echo $section['sum_dec'] ? number_format($section['sum_dec'], 2, '.', '') : '' ?></span>
						</td>
						<td width="50" align="right">
							<span class="-range" title="суммарное повышение стоимости"><?php echo $section['sum_inc'] ? '+'.number_format($section['sum_inc'], 2, '.', '') : '' ?></span>
						</td>
						<td width="120" align="right">
							<select style="background-color: white; width:110px" class="control" id="group" onchange="UpdateItemList($('div.section#' + <?php echo $section['id'] ?>))">
								<option value="all">Все</option>
								<option value="new">Новые</option>
								<option value="latest" selected>Самые свежие</option>
								<option value="week">За неделю</option>
								<option value="month">За месяц</option>
							</select>&nbsp;
						</td>
						<td width="80" align="right">
							<table style="background-color:white;">
								<tr>
									<td><span title="ключевые слова через пробел, символ минус для исключения" style="background-color:#ddd; color:#666">&nbsp;фильтр&nbsp;</span></td>
									<td><input id="filter" type="edit" class="control" style="width:150px" onKeyPress="return OnFilterEditEnter(this,event, <?php echo $section['id'] ?>)"/></td>
									<td><div id="reset" title="сброс фильтров" class="divbtn" style="width:10px;" onclick="return OnFilterReset(this,event, <?php echo $section['id'] ?>)">X</div></td>
								</tr>
							</table>
							<span style="background-color:white"><span style="background-color:white; width:50px"></span></span>
						</td>
						<td style="width:5px;">&nbsp;</td>
					</tr>
				</table>
			</div>
			<div class="section-body hidden">
				<table cellpadding="0" cellspacing="0" border="1" class="itemgrid maxw">
					<tbody></tbody>
					<tfoot>
						<tr>
<!--							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>
							<th><input class="search" type="text" value="" name="search_engine"></th>-->
							<th>id</th>
							<th>номер</th>
							<th>артикул</th>
							<th>бренд</th>
							<th>наименование</th>
							<th>цена</th>
							<th>war</th>
							<th>дата</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<?php
	}
	?>
</body>
<script type="text/javascript">
	function fb ( data ) {
		if ( console && console.info ) {
			console.info(data);
		}
	}
	
	function trim ( str ) {
		var	str = str.replace(/^\s\s*/, ''),
			 ws = /\s/,
			  i = str.length;
		while ( ws.test(str.charAt(--i)) );
		return str.slice(0, i + 1);
	}

	$('div.section-title').click(function(info) {
		//fb(info.target);
		if ( info.target.nodeName != 'INPUT' && info.target.nodeName != 'SELECT' && info.target.id != 'reset' ) {
			section = this.parentNode;
			if ( !$(section).data('updated') ) {
				UpdateItemList(this.parentNode);
			}
			$('div.section-body', section).toggleClass('hidden');
		}
	});
	
	function OnFilterEditEnter ( obj, event, sectid ) {
		if ( event && event.keyCode == 13 ) {
			section = $('div.section#' + sectid);
			UpdateItemList(section);
			$('div.section-body', section).toggleClass('hidden', false);
			return false;
		}
		return true;
	}
	
	function OnFilterReset( obj, event, sectid) {
		section = $('div.section#' + sectid);
		$('input#filter', section).val('');
		UpdateItemList(section);
	}
	
	function OnBrandFilter( section, filter ) {
		//fb(filter);
		filter = trim(filter.toLowerCase());
		curflt = trim($('input#filter', section).val());
		ifused = false;
		if ( curflt ) {
			$.each(curflt.split(' '), function(index, item) {
				if ( trim(item.toLowerCase()) == filter ) {
					ifused = true;
				}
			});
		}
		if ( !ifused ) {
			$('input#filter', section).val(curflt + (curflt ? ' ' : '') + filter);
			UpdateItemList(section);
		}
		$('input#filter', section).focus();
	}
	
	function dataTableGetSelected ( oTableLocal ) {
		var aReturn = new Array();
		var aTrs = oTableLocal.fnGetNodes();
		for ( var i=0 ; i<aTrs.length ; i++ ) {
			if ( $(aTrs[i]).hasClass('row_selected') ) {
				aReturn.push( aTrs[i] );
			}
		}
		return aReturn;
	}
	
	function UpdateItemList ( section ) {
		sid    = $(section).attr('id');
		filter = $('input#filter', section).val();
		if ( sid ) {
			$('td span#counter', section).html('<img src="images/loader-square.gif"/>');
			$.getJSON('index.php?action=get_items&sid=' + sid + '&filter=' + filter + '&group=' + $('select#group', section).val(), function(data) {
				dtable = $('div.section-body table.itemgrid', section).dataTable({
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": false,
					"bSort": true,
					"bInfo": false,
					"bAutoWidth": false,
					"bDestroy": true,
					"aaSorting": [[4, "asc"]],
					"aaData": data,
					"aoColumns": [
						{ "sTitle": "id", "bVisible": false },
						{ "sTitle": "номер", "fnRender": function(obj) {
								return '<a class="link" href="javascript:OnBrandFilter(this.section, \''+obj.aData[obj.iDataColumn]+'\');">' + obj.aData[obj.iDataColumn] + '</a>';
							} },
						{ "sTitle": "артикул" },
						{ "sTitle": "бренд", "sClass":"nowrap",
							"fnRender": function(obj) {
								var sReturn = obj.aData[obj.iDataColumn];
								if ( sReturn ) {
									sReturn = '<a class="link" href="javascript:OnBrandFilter(this.section, \''+obj.aData[obj.iDataColumn]+'\');">' + sReturn + '</a>';
								}
								return sReturn;
							} },
						{ "sTitle": "наименование", "sClass": "iname" },
						{ "sTitle": "цена", "sClass" : "right" },
						{ "sTitle": "war", "sClass": "center" },
						{ "sTitle": "дата" }
					]
				});
				// add a click handler to the rows
				$('tr', dtable).click( function(info) {
					if ( info.target.nodeName != 'A' ) {
						if ($(this).hasClass('row_selected'))
							$(this).removeClass('row_selected');
						else
							$(this).addClass('row_selected');
					}
				});
				
				//fb(dtable.fnSettings());
				if ( filter ) {
					$.each(filter.split(' '), function(index, item) {
						$('td.iname', dtable).highlight(item);
					});
				}
				$(section).data('updated', true);
				$('td span#counter', section).html(data.length);
			});
		}
	}
</script>
</html>