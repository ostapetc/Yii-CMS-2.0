<?php
/**
 * BootTabs class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.BootMenu');
Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap JavaScript tabs widget.
 * @since 0.9.8
 * @todo Fix event support. http://twitter.github.com/bootstrap/javascript.html#tabs
 */
class BootTabbed extends BootWidget
{
	/**
	 * @var string the type of tabs to display. Defaults to 'tabs'.
	 * Valid values are 'tabs' and 'pills'.
	 */
    public $type = BootMenu::TYPE_TABS;
	/**
	 * @var array the tab configuration.
	 */
    public $tabs = array();
	/**
	 * @var boolean whether to encode item labels.
	 */
	public $encodeLabel = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Yii::app()->bootstrap->registerTabs();

		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();
    }

    /**
     * Run this widget.
     */
    public function run()
    {
	    $panes = array();
	    $items = $this->normalizeTabs($this->tabs, $panes);

	    echo CHtml::openTag('div', $this->htmlOptions);

	    $this->controller->widget('bootstrap.widgets.BootMenu', array(
			'type'=>$this->type,
			'encodeLabel'=>$this->encodeLabel,
		    'items'=>$items,
	    ));

	    echo '<div class="tab-content">';
		echo implode('', $panes);
	    echo '</div></div>';

	    Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id, "jQuery('{$this->id}').tab('show');");

	    /*
        // Register the "show" event-handler.
        if (isset($this->events['show']))
        {
            $fn = CJavaScript::encode($this->events['show']);
            Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.show',
	                "jQuery('#{$id} a[data-toggle=\"tab\"').on('show', {$fn});");
        }

        // Register the "shown" event-handler.
        if (isset($this->events['shown']))
        {
            $fn = CJavaScript::encode($this->events['shown']);
            Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.shown',
	                "jQuery('#{$id} a[data-toggle=\"tab\"').on('shown', {$fn});");
        }
	    */
    }

	/**
	 * Normalizes the tab configuration.
	 * @param array $tabs the tab configuration
	 * @param array $panes a reference to the panes array
	 * @param integer $i the current index
	 * @return array the items
	 */
	protected function normalizeTabs($tabs, &$panes, &$i = 0)
	{
		$id = $this->getId();
		$transitions = Yii::app()->bootstrap->isPluginRegistered(Bootstrap::PLUGIN_TRANSITION);

		$items = array();

	    foreach ($tabs as $tab)
	    {
		    $i++;
			$item = $tab;

			if (!isset($item['id']))
				$item['id'] = $id.'_tab_'.$i;

			if (!isset($item['label']))
				$item['label'] = '';

			$item['url'] = '#'.$item['id'];

			if (!isset($item['itemOptions']))
				$item['itemOptions'] = array();

		    if ($i === 1)
		    {
			    if (isset($item['itemOptions']['class']))
	                $item['itemOptions']['class'] .= ' active';
	            else
		            $item['itemOptions']['class'] = 'active';
		    }

			$item['linkOptions']['data-toggle'] = 'tab';

		    if (isset($tab['items']))
			{
				$item['items'] = $this->normalizeTabs($item['items'], $panes, $i);
				unset($item['url']);
			}

		    if (!isset($item['content']))
			    $item['content'] = '';

			$content = $item['content'];
			unset($item['content']);

		    if (!isset($item['paneOptions']))
				$item['paneOptions'] = array();

			$paneOptions = $item['paneOptions'];
			unset($item['paneOptions']);

			$paneOptions['id'] = $item['id'];

		    if (isset($tab['paneOptions']['class']))
				$paneOptions['class'] .= ' tab-pane';
		    else
				$paneOptions['class'] = 'tab-pane';

		    if ($transitions)
				$paneOptions['class'] .= ' fade';

		    if ($i === 1)
		    {
			    if ($transitions)
					$paneOptions['class'] .= ' in';

				$paneOptions['class'] .= ' active';
		    }

		    $panes[] = CHtml::tag('div', $paneOptions, $content);
			$items[] = $item;
	    }

		return $items;
	}
}
