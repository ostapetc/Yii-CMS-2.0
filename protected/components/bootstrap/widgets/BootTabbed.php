<?php
/**
 * BootTabs class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap JavaScript tabs widget.
 * @since 0.9.6
 */
class BootTabbed extends BootWidget
{
	/**
	 * @var string the type of tabs to display. Defaults to 'tabs'.
	 * Valid values are 'tabs' and 'pills'.
	 */
    public $type = 'tabs';
	/**
	 * @var array the tab configuration.
	 */
    public $tabs = array();
	/**
	 * @var string the name of the container element that contains all panels. Defaults to 'div'.
	 */
    public $tagName = 'div';
	/**
	 * @var string the template to use for displaying the header.
	 */
    public $headerTemplate = '<li class="{class}"><a href="{url}">{title}</a></li>';
	/**
	 * @var string the template to use for displaying the content.
	 */
    public $contentTemplate = '<div class="tab-pane {class}" id="{id}">{content}</div>';
	/**
	 * @var string the CSS selector to use for selecting the tabs elements.
	 */
    public $selector = '.nav-tabs > li > a, .nav-pills > li > a';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->registerScriptFile('jquery.ui.boot-tabs.js');
    }

    /**
     * Run this widget.
     */
    public function run()
    {
        $id = $this->getId();
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        echo CHtml::openTag($this->tagName, $this->htmlOptions);

        $tabsOut = '';
        $contentOut = '';
        $tabCount = 0;

        foreach ($this->tabs as $title => $content)
        {
            $tabId = (is_array($content) && isset($content['id'])) ? $content['id'] : $id.'_tab_'.$tabCount++;

            if (!is_array($content))
            {
                $tabsOut .= strtr($this->headerTemplate, array(
                    '{title}'=>$title,
                    '{url}'=>'#'.$tabId,
                    '{id}'=>'#'.$tabId,
                    '{class}'=>$tabCount === 1 ? 'active' : '',
                ));

                $contentOut .= strtr($this->contentTemplate, array(
                    '{content}'=>$content,
                    '{id}'=>$tabId,
                    '{class}'=>$tabCount === 1 ? 'active' : '',
                ));
            }
            elseif (isset($content['ajax']))
            {
                $tabsOut .= strtr($this->headerTemplate, array(
                    '{title}'=>$title,
                    '{url}'=>CHtml::normalizeUrl($content['ajax']),
                    '{id}'=>'#'.$tabId,
                    '{class}'=>$tabCount === 1 ? 'active' : '',
                ));
            }
            else
            {
                $tabsOut .= strtr($this->headerTemplate, array(
                    '{title}'=>$title,
                    '{url}'=>'#'.$tabId,
                    '{class}'=>$tabCount === 1 ? 'active' : '',
                ));

                if(isset($content['content']))
                {
                    $contentOut .= strtr($this->contentTemplate, array(
                        '{content}'=>$content['content'],
                        '{id}'=>$tabId,
                        '{class}'=>$tabCount === 1 ? 'active' : '',
                    ));
                }
            }
        }

        echo CHtml::openTag('ul', array('class'=>'nav nav-'.$this->type, 'data-'.$this->type=>$this->type));
        echo $tabsOut;
        echo '</ul>';

        echo CHtml::openTag('div', array('class'=>$this->type === 'tabs' ? 'tab-content' : 'pill-content'));
        echo $contentOut;
        echo '</div>';

        echo CHtml::closeTag($this->tagName);

        $options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
        $this->registerScript(__CLASS__.'#'.$id,"jQuery('{$this->selector}').bootTabs({$options});");
    }
}
