<style type="text/css">
	#yiiWebDebugToolbar {
		<?php if ($fixedPos): ?>
		position: fixed;
		<?php else: ?>
		position: absolute;
		<?php endif ?>
		
		<?php if ($alignLeft): ?>
		float: left;
		left: 0;
		border-right: solid 1px #000;
		border-bottom: solid 1px #000;
		<?php else: ?>
		float: right;
		right: 0;
		border-left: solid 1px #000;
		border-bottom: solid 1px #000;
		<?php endif ?>
		
		top: 0;
		height: 16px;
		background-color: #eef;
		color: #444;
		padding: 1px;
		z-index: 65535;
		font: normal 10px Arial, Helvetica, sans-serif;
	}
	
	.yiiWebDebugOpacity {
		opacity: 0.1;
		filter: alpha(opacity:10);
	}
	
	.yiiWebDebugOpacity:hover {
		opacity: 1;
		filter: alpha(opacity:100)
	}
	
	#yiiWebDebugToolbar ul {
		margin: 0;
		padding: 0;
		list-style: none;
		float: left;
	}
	
	#yiiWebDebugToolbar ul li {
		float: left;
	}
	
	#yiiWebDebugToolbar .yiiLink {
		background-color: #000;
		color: #fff;
		padding-left: 5px;
		padding-right: 5px;
		text-decoration: none;
		font-weight: bold;
	}
	
	#yiiWebDebugToolbar .yiiLinkItem {
		color: #444;
	}
	
	#yiiWebDebugToolbar .yiiLinkItem:hover {
		text-decoration: none;
		background: none;
	}
	
	ul#yiiWebDebugToolbarItems {
		<?php if ($alignLeft): ?>
		margin-right: 5px;
		<?php else: ?>
		margin-left: 5px;
		<?php endif ?>
	}
	
	ul#yiiWebDebugToolbarItems li {
		margin-top: 1px;
		font-size: 11px;
		font-weight: bold;
	}
	
	#yiiWebDebugPanel {
		background-color: #eee;
		color: #000;
		position: absolute;
		width: 100%;
		top: 0;
		left: 0;
		font: normal 10pt Arial, Helvetica, sans-serif;
		z-index:65534;
	}
	
	#yiiWebDebugPanel .panelHeadInfo {}
	
	#yiiWebDebugPanel .gridContainer {
		padding: 6px;
	}
	
	#yiiWebDebugPanel .panelTitle {
		background-color: #000;
		color: #fff;
		font-weight: bold;
		text-align: center;
	}
	
	#yiiWebDebugPanel .panelGrid {
		overflow: auto;
		padding: 1px;
	}
	
	#yiiWebDebugPanel .panelGrid table {
		width: 100%;
		margin-top: 6px;
		border-collapse: collapse;
		background-color: #fff;
	}
	
	#yiiWebDebugPanel .panelGrid table thead th {
		text-align: left;
		padding-right: 5px;
		padding-left: 5px;
		border: solid 1px #888;
		background-color: #ddd;
	}
	
	#yiiWebDebugPanel .panelGrid table tbody tr.odd {
		background-color: #f5f5ff;
	}
	
	#yiiWebDebugPanel .panelGrid table tbody td {
		text-align: left;
		padding-right: 5px;
		padding-left: 5px;
		border: solid 1px #888;
	}
	
	.yiiDebugInfoInline {
		list-style: none;
		margin: 5px;
		padding: 5px;
	}
	
	.yiiDebugInfoInline li {
		display: inline;
		border: solid 1px #444;
		padding: 3px;
		margin: 1px;
		background-color: #bbb;
	}
	
	.yiiDebugInfoInline li.ison {
		background-color: #4f4;
	}
	
	.yiiDebugInfoList {}
	
	.yiiDebugInfoList h2 {
		font-size: 11pt;
		margin: 0;
		border-bottom: solid 1px #bbb;
		color: #444;
	}
	
	.yiiDebugInfoList h2 a {
		text-decoration: none;
		color: #000;
	}
	
	.yiiDebugInfoList div {
		border-bottom: solid 1px #bbb;
	}

	.yiiDebugInfoList div pre {
		font-size: 10pt;
		margin: 0px;
		padding: 0px;
	}

	.yiiDebugInfoList div pre code {
		margin: 0px;
		padding: 0px;
	}

	.yiiDebugInfoList div pre code span {
		font-size: 1px;
	}

	.yiiDebugInfoList div pre code span span {
		font-size: 10pt;
	}
</style>

<div id="yiiWebDebugToolbar" onmouseover="yiiDebugMouse(true);" onmouseout="yiiDebugMouse(false);">
	<?php if (!$alignLeft): ?>
	<ul>
		<li><a href="#" class="yiiLink" onclick="return yiiWebDebugToggle('yiiWebDebugToolbarItems');">Yii</a></li>
	</ul>
	<?php endif ?>
	
	<ul id="yiiWebDebugToolbarItems">
		<?php $index = 0; foreach ($items as $item): ?>
		<li>[&nbsp;
			<?php echo (isset($item['content']) && !is_null($item['content'])) ? '<a href="#" class="yiiLinkItem" onclick="return yiiWebDebugToggle(\'__yiiWDP'.$index.'\');">'.$item['title'].'</a>' : $item['title'] ?>
			&nbsp;]
		</li>
		<?php if (isset($item['content']) && !is_null($item['content'])) $index++; endforeach ?>
	</ul>
	
	<?php if ($alignLeft): ?>
	<ul>
		<li><a href="#" class="yiiLink" onclick="return yiiWebDebugToggle('yiiWebDebugToolbarItems');">Yii</a></li>
	</ul>
	<?php endif ?>
</div>

<div id="yiiWebDebugPanel">
	<?php
	$index = 0;
	foreach ($items as $item): if (!isset($item['content']) || is_null($item['content'])) continue; ?>
	
	<div id="__yiiWDP<?php echo $index ?>" style="display: none">
		<div class="panelHeadInfo">
			<?php if ($alignLeft) echo "<br/>" ?> <?php echo (isset($item['headinfo']) && !is_null($item['headinfo'])) ? $item['headinfo'] : '<br/><br/>' ?>
		</div>
		
		<center>
			<div class="gridContainer">
				<div class="panelTitle">
					<?php if (isset($item['panelTitle']) && !is_null($item['panelTitle'])) echo $item['panelTitle'] ?>
				</div>
				
				<div class="panelGrid" id="panelGridH__yiiWDP<?php echo $index ?>">
					<div id="panelGH__yiiWDP<?php echo $index ?>">
						<?php echo $item['content'] ?>
					</div>
				</div>
			</div>
		</center>
	</div>
	
	<?php
		$index++;
		endforeach;
	?>
</div>

<script type="text/javascript">
	var _curPanel = '';
	var panelMaxHeight = 100;
	
	//Selector function
	function _$(element) { return document.getElementById(element); }
	
	function yiiWebDebugToggleVisible(element) { _$(element).style.display = (_$(element).style.display == 'block') ? 'none' : 'block'; }
	
	function yiiWebDebugToggle(element)
	{
		disp = _$(element).style.display == 'none' ? 'block' : 'none';
		if (element == 'yiiWebDebugToolbarItems')
		{
			if (_curPanel != '' && disp == 'none') _$(_curPanel).style.display = 'none';
			<?php if ($opaque): ?>
			_$('yiiWebDebugToolbar').className = (disp == 'none') ? 'yiiWebDebugOpacity' : '';
			<?php endif ?>
		}
		else
		{
			if (_curPanel != '') _$(_curPanel).style.display = 'none';
			_curPanel = element;
		}
		
		_$(element).style.display = disp;
		
		return false;
	}
	
	function yiiDebugMouse(over)
	{
		<?php if ($opaque): ?>
		_$('yiiWebDebugToolbar').className = (!over && _$('yiiWebDebugToolbarItems').style.display == 'none') ? 'yiiWebDebugOpacity' : '';
		<?php endif ?>
		
		return false;
	}
	
	<?php if ($collapsed): ?>
	yiiWebDebugToggle('yiiWebDebugToolbarItems');
	<?php endif ?>
</script>