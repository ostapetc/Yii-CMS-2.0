<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 10.07.12
 * Time: 20:42
 * To change this template use File | Settings | File Templates.
 */
class PageSectionsSidebar extends Portlet
{
    public function renderContent()
    {
        $sql = "SELECT pages_sections.id,
                       COUNT(pages_sections_rels.id) AS pages_count
                       FROM pages_sections,
                       pages_sections_rels
                       WHERE pages_sections_rels.section_id = pages_sections.id
                       GROUP BY pages_sections.id";

        $pages_count = Yii::app()->db->createCommand($sql)->queryAll();
        $pages_count = CHtml::listData($pages_count, 'id', 'pages_count');

        $sections = PageSection::model()->optionsTree();

        $this->render('PageSectionsSidebar', array(
            'pages_count' => $pages_count,
            'sections'    => $sections

        ));
    }
}
