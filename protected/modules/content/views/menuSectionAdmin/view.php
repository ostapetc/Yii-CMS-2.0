<link rel="stylesheet" type="text/css" href="/css/admin/view_table.css"/>

<? if ($links): ?>

	<table class='view_table'>
		<tr class='odd'>
	    	<th><? echo $meta['title']['Comment'] ?></th>
	    	<th><? echo $meta['url']['Comment'] ?></th>
	    	<th><? echo $meta['parent_id']['Comment'] ?></th>
	    	<th><? echo $meta['page_id']['Comment'] ?></th>
	    	<th><? echo $meta['is_published']['Comment'] ?></th>
	  	</tr>
	  	<? foreach ($links as $link): ?>
	  		<tr>
	  			<td><? echo $link->title ?></td>
	  			<td><? echo $link->url ?></td>
	  			<td><? echo $link->parent_id ?></td>
	  			<td><? echo $link->page_id ?></td>
	  			<td align="center"><? echo $link->is_published ? 'Да' : 'Нет' ?></td>
	  		</tr>
	  	<? endforeach ?>
	</table>
	
<? else: ?>
	<div class='warning_box'>У данного отсутствуют разделы.</div>
<? endif ?>
