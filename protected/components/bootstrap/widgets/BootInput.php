<?php
/**
 * BootInputBlock class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 
class BootInput extends CInputWidget
{
	// The different input types.
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_CHECKBOXES = 'checkboxlist';
	const TYPE_CHECKBOXES_INLINE = 'checkboxlist_inline';
	const TYPE_DROPDOWN = 'dropdownlist';
	const TYPE_FILE = 'filefield';
	const TYPE_PASSWORD = 'password';
	const TYPE_RADIO = 'radiobutton';
	const TYPE_RADIOS = 'radiobuttonlist';
	const TYPE_RADIOS_INLINE = 'radiobuttonlist_inline';
	const TYPE_TEXTAREA = 'textarea';
	const TYPE_TEXT = 'textfield';
	const TYPE_CAPTCHA = 'captcha';
	const TYPE_UNEDITABLE = 'uneditable';

	/**
	 * @var BootActiveForm the associated form widget.
	 */
	public $form;
	/**
	 * @var string the input label text.
	 */
	public $label;
	/**
	 * @var string the input type.
	 * Following types are supported: checkbox, checkboxlist, dropdownlist, filefield, password,
	 * radiobutton, radiobuttonlist, textarea, textfield, captcha and uneditable.
	 */
	public $type;
	/**
	 * @var array the data for list inputs.
	 */
	public $data = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if ($this->form === null)
			throw new CException(__CLASS__.': Failed to initialize widget! Form is not set.');

		if ($this->model === null)
			throw new CException(__CLASS__.': Failed to initialize widget! Model is not set.');

		if ($this->type === null)
			throw new CException(__CLASS__.': Failed to initialize widget! Input type is not set.');
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$errorCss = $this->model->hasErrors($this->attribute) ? ' '.CHtml::$errorCss : '';
		echo CHtml::openTag('div', array('class'=>'control-group'.$errorCss));

		switch ($this->type)
		{
			case self::TYPE_CHECKBOX:
				$this->checkBox();
				break;

			case self::TYPE_CHECKBOXES:
				$this->checkBoxList();
				break;

			case self::TYPE_CHECKBOXES_INLINE:
				$this->checkBoxListInline();
				break;

			case self::TYPE_DROPDOWN:
				$this->dropDownList();
				break;

			case self::TYPE_FILE:
				$this->fileField();
				break;

			case self::TYPE_PASSWORD:
				$this->passwordField();
				break;

			case self::TYPE_RADIO:
				$this->radioButton();
				break;

			case self::TYPE_RADIOS:
				$this->radioButtonList();
				break;

			case self::TYPE_RADIOS_INLINE:
				$this->radioButtonListInline();
				break;

			case self::TYPE_TEXTAREA:
				$this->textArea();
				break;

			case self::TYPE_TEXT:
				$this->textField();
				break;

			case self::TYPE_CAPTCHA:
				$this->captcha();
				break;

			case self::TYPE_UNEDITABLE:
				$this->uneditableField();
				break;

			default:
				throw new CException(__CLASS__.': Failed to run widget! Type is invalid.');
		}

		echo '</div>';
	}

	/**
	 * Renders a checkbox.
	 * @return string the rendered content
	 */
	protected function checkBox()
	{
		echo '<div class="controls">';
		echo '<label class="checkbox" for="'.CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute)).'">';
		echo $this->form->checkBox($this->model, $this->attribute, $this->htmlOptions).PHP_EOL;
		echo $this->model->getAttributeLabel($this->attribute);
		echo $this->getError().$this->getHint();
		echo '</label></div>';
	}

	/**
	 * Renders a list of checkboxes.
	 * @return string the rendered content
	 */
	protected function checkBoxList()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->checkBoxList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a list of inline checkboxes.
	 * @return string the rendered content
	 */
	protected function checkBoxListInline()
	{
		$this->htmlOptions['inline'] = true;
		$this->checkBoxList();
	}

	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 */
	protected function dropDownList()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a file field.
	 * @return string the rendered content
	 */
	protected function fileField()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->fileField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 */
	protected function passwordField()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a radio button.
	 * @return string the rendered content
	 */
	protected function radioButton()
	{
		echo '<div class="controls">';
		echo '<label class="radio" for="'.CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute)).'">';
		echo $this->form->radioButton($this->model, $this->attribute, $this->htmlOptions).PHP_EOL;
		echo $this->model->getAttributeLabel($this->attribute);
		echo $this->getError().$this->getHint();
		echo '</label></div>';
	}

	/**
	 * Renders a list of radio buttons.
	 * @return string the rendered content
	 */
	protected function radioButtonList()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->radioButtonList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a list of inline radio buttons.
	 * @return string the rendered content
	 */
	protected function radioButtonListInline()
	{
		$this->htmlOptions['inline'] = true;
		$this->radioButtonList();
	}

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 */
	protected function textArea()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function textField()
	{
		echo $this->getLabel().'<div class="controls">';
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a CAPTCHA.
	 * @return string the rendered content
	 */
	protected function captcha()
	{
		echo $this->getLabel().'<div class="controls"><div class="captcha">';
		echo '<div class="widget">'.$this->widget('CCaptcha', array('showRefreshButton'=>false), true).'</div>';
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div></div>';
	}

	/**
	 * Renders an uneditable field.
	 * @return string the rendered content
	 */
	protected function uneditableField()
	{
		echo $this->getLabel().'<div class="controls">';
		echo '<span class="uneditable-input">'.$this->model->{$this->attribute}.'</span>';
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Returns the label for this block.
	 * @return string the label
	 */
	protected function getLabel()
	{
		if ($this->label !== false && !in_array($this->type, array('checkbox', 'radio')) && $this->hasModel())
			return $this->form->labelEx($this->model, $this->attribute);
		else if ($this->label !== null)
			return $this->label;
		else
			return '';
	}

	/**
	 * Returns the hint text for this block.
	 * @return string the hint text
	 */
	protected function getHint()
	{
		if (isset($this->htmlOptions['hint']))
		{
			$hint = $this->htmlOptions['hint'];
			unset($this->htmlOptions['hint']);
			return '<p class="help-block">'.$hint.'</p>';
		}
		else
			return '';
	}

	/**
	 * Returns the error text for this block.
	 * @return string the error text
	 */
	protected function getError()
	{
		return $this->form->error($this->model, $this->attribute);
	}
}
