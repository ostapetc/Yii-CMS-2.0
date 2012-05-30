<?
class FileList extends BaseFileListView
{
    public $header = 'Файлы для скачивания';
    public $emptyText = '';

    public $itemsTagName = 'span';
    public $tagName = 'p';

    public $template = "{header}\n{items}";

    public $enablePagination = false;
    public $itemView ='fileManager.portlets.views.filesListItem';

    public $htmlOptions = array(
        'class' => 'file-list'
    );

    public function init()
    {
        parent::init();
        $this->cssFile = $this->assets.'/css/filesList.css';
    }

    public function renderHeader()
    {
        if($this->dataProvider->getItemCount() > 0)
        {
            echo CHtml::tag('div', array('class' => 'header'), $this->header);
        }
    }
}