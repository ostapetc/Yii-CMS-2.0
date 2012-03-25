<?
include_once "includes/header.php";
include_once "includes/navbar.php";
?>
<p>
Source Listing:
</p>
<ul>
  <?
  chdir("../");
  $files = glob("*.php");
  $files = array_merge($files, glob("util/*.php"));
  foreach ($files as $fileName) {
    ?>
  	<li><a href="package.php?view=<? echo sha1($fileName);?>"><? echo $fileName;?></a>&nbsp;-&nbsp;<? echo date ("F d Y - g:i a", filemtime($fileName));?></li>
    <?
  }
  ?>
</ul>
<?
if( isset($_REQUEST['view']) ) {
	$hash = $_REQUEST['view'];
	$n = array_search($hash, array_map(sha1, $files));
	$fileName = $files[$n];
  ?>
  <hr />  
	Viewing: <? echo $fileName;?>
	<hr />
	<?
	highlight_file($fileName);
	?>
	<hr />
<?
}
include_once "includes/footer.php";	
?>

