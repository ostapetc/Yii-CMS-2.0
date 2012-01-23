<?php

class DocumentFile extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

	const FILES_DIR = 'upload/documents_files/';


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'documents_files';
	}


    public function name()
    {
        return 'Файлы документа';
    }


	public function rules()
	{
		return array(
			array('document_id, title, file', 'required'),
			array('document_id', 'length', 'max' => 11),
			array('title', 'length', 'max' => 250),
			array(
				'file',
				'file',
                'types'      => 'docx, xls, xlsx, ptt, pptx, pdf, jpg, jpeg, gif, png, bmp, tif, txt, rtf',
				'allowEmpty' => true,
				'maxSize'    => 1024 * 1024 * 25,
				'tooLarge'   => 'Максимальный размер файла 25 Мб'
			),
			array('id, document_id, title, file, created_at', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'document' => array(self::BELONGS_TO, 'Document', 'document_id'),
		);
	}


	public function search($document_id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('document_id', $this->document_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('file', $this->file, true);
		$criteria->compare('created_at', $this->created_at, true);
        $criteria->condition = "document_id = {$document_id}";

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


	public function uploadFiles()
	{
		return array(
			'file' => array('dir' => self::FILES_DIR)
		);
	}
}
