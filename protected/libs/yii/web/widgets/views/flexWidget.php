<?
/**
 * The view file for CFlexWidget.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @version $Id: flexWidget.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.web.widgets.views
 * @since 1.0
 */
?>
<script type="text/javascript">
/*<![CDATA[*/
// Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
var hasProductInstall = DetectFlashVer(6, 0, 65);

// Version check based upon the values defined in globals
var hasRequestedVersion = DetectFlashVer(9, 0, 0);

// Check to see if a player with Flash Product Install is available and the version does not meet the requirements for playback
if ( hasProductInstall && !hasRequestedVersion ) {
	// MMdoctitle is the stored document.title value used by the installation process to close the window that started the process
	// This is necessary in order to close browser windows that are still utilizing the older version of the player after installation has completed
	// DO NOT MODIFY THE FOLLOWING FOUR LINES
	// Location visited after installation is complete if installation is required
	var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
	var MMredirectURL = window.location;
	document.title = document.title.slice(0, 47) + " - Flash Player Installation";
	var MMdoctitle = document.title;

	AC_FL_RunContent(
		"src", "<? echo $this->baseUrl ?>/playerProductInstall",
		"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
		"width", "<? echo $this->width; ?>",
		"height", "<? echo $this->height; ?>",
		"align", "<? echo $this->align; ?>",
		"id", "<? echo $this->name; ?>",
		"quality", "<? echo $this->quality; ?>",
		"bgcolor", "<? echo $this->bgColor; ?>",
		"name", "<? echo $this->name; ?>",
		"allowScriptAccess","<? echo $this->allowScriptAccess ?>",
		"allowFullScreen","<? echo $this->allowFullScreen ?>",
		"type", "application/x-shockwave-flash",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
} else if (hasRequestedVersion) {
	// if we've detected an acceptable version
	// embed the Flash Content SWF when all tests are passed
	AC_FL_RunContent(
		"src", "<? echo $this->baseUrl ?>/<? echo $this->name ?>",
		"width", "<? echo $this->width ?>",
		"height", "<? echo $this->height ?>",
		"align", "<? echo $this->align ?>",
		"id", "<? echo $this->name ?>",
		"quality", "<? echo $this->quality ?>",
		"bgcolor", "<? echo $this->bgColor ?>",
		"name", "<? echo $this->name ?>",
		"flashvars","<? echo $this->flashVarsAsString; ?>",
		"allowScriptAccess","<? echo $this->allowScriptAccess ?>",
		"allowFullScreen","<? echo $this->allowFullScreen ?>",
		"type", "application/x-shockwave-flash",
		"pluginspage", "http://www.adobe.com/go/getflashplayer"
	);
} else {  // flash is too old or we can't detect the plugin
	var alternateContent = '<? echo CJavaScript::quote($this->altHtmlContent); ?>';
	document.write(alternateContent);  // insert non-flash content
}
/*]]>*/
</script>
<noscript>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
		id="<? echo $this->name ?>"
		width="<? echo $this->width ?>"
		height="<? echo $this->height ?>"
		codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="<? echo $this->baseUrl ?>/<? echo $this->name ?>.swf" />
			<param name="quality" value="<? echo $this->quality ?>" />
			<param name="bgcolor" value="<? echo $this->bgColor ?>" />
			<param name="flashVars" value="<? echo $this->flashVarsAsString ?>" />
			<param name="allowScriptAccess" value="<? echo $this->allowScriptAccess ?>" />
			<param name="allowFullScreen" value="<? echo $this->allowFullScreen ?>" />
			<embed src="<? echo $this->baseUrl ?>/<? echo $this->name ?>.swf"
				quality="<? echo $this->quality ?>"
				bgcolor="<? echo $this->bgColor ?>"
				width="<? echo $this->width ?>"
				height="<? echo $this->height ?>"
				name="<? echo $this->name ?>"
				align="<? echo $this->align ?>"
				play="true"
				loop="false"
				quality="<? echo $this->quality ?>"
				allowScriptAccess="<? echo $this->allowScriptAccess ?>"
				allowFullScreen="<? echo $this->allowFullScreen ?>"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
	</object>
</noscript>