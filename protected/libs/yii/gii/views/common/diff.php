<? if($diff===false): ?>
	<div class="error">Diff is not supported for this file type.</div>
<? elseif(empty($diff)): ?>
	<div class="error">No changes.</div>
<? else: ?>
	<div class="content">
		<pre class="diff"><? echo $diff; ?></pre>
	</div>
<? endif; ?>
