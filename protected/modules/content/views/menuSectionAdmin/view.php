<link rel="stylesheet" type="text/css" href="/css/admin/view_table.css"/>

<?php if ($links): ?>

	<table class='view_table'>
		<tr class='odd'>
	    	<th><?php echo $meta['title']['Comment'] ?></th>
	    	<th><?php echo $meta['url']['Comment'] ?></th>
	    	<th><?php echo $meta['parent_id']['Comment'] ?></th>
	    	<th><?php echo $meta['page_id']['Comment'] ?></th>
	    	<th><?php echo $meta['is_visible']['Comment'] ?></th>
	  	</tr>
	  	<?php foreach ($links as $link): ?>
	  		<tr>
	  			<td><?php echo $link->title ?></td>
	  			<td><?php echo $link->url ?></td>
	  			<td><?php echo $link->parent_id ?></td>
	  			<td><?php echo $link->page_id ?></td>
	  			<td align="center"><?php echo $link->is_visible ? 'Да' : 'Нет' ?></td>
	  		</tr>
	  	<?php endforeach ?>
	</table>
	
<?php else: ?>
	<div class='warning_box'>У данного отсутствуют разделы.</div>
<?php endif ?>
