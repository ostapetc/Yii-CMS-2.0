<?php
/**
 * BootButtonColumn class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * Bootstrap button column widget.
 * Used to set buttons to use Glyphicons instead of the defaults.
 * @since 0.9.8
 */
class BootButtonColumn extends CButtonColumn
{
	public $viewButtonIconCssClass = 'icon-search';
	public $updateButtonIconCssClass = 'icon-pencil';
	public $deleteButtonIconCssClass = 'icon-trash';

	/**
	 * Initializes the default buttons (view, update and delete).
	 */
	protected function initDefaultButtons()
	{
		parent::initDefaultButtons();

		if ($this->viewButtonIconCssClass !== false)
			$this->buttons['view']['iconCssClass'] = $this->viewButtonIconCssClass;
		if ($this->updateButtonIconCssClass !== false)
			$this->buttons['update']['iconCssClass'] = $this->updateButtonIconCssClass;
		if ($this->deleteButtonIconCssClass !== false)
			$this->buttons['delete']['iconCssClass'] = $this->deleteButtonIconCssClass;
	}

	/**
	 * Renders a link button.
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data object associated with the row
	 */
	protected function renderButton($id,$button,$row,$data)
	{
		if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data)))
			return;

		$label=isset($button['label']) ? $button['label'] : $id;
		$url=isset($button['url']) ? $this->evaluateExpression($button['url'],array('data'=>$data,'row'=>$row)) : '#';
		$options=isset($button['options']) ? $button['options'] : array();

		if (!isset($options['title']))
			$options['title']=$label;

		if (isset($button['iconCssClass']))
			$linkContent = '<i class="'.$button['iconCssClass'].'"></i>';
		else if (isset($button['imageUrl']) && is_string($button['imageUrl']))
			$linkContent = CHtml::image($button['imageUrl'],$label);
		else
			$linkContent = $label;

		echo CHtml::link($linkContent,$url,$options);
	}
}
