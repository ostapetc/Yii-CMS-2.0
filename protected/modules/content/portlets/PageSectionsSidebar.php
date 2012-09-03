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
        $sections = PageSection::model()->optionsTree();
        foreach ($sections as $id => $name)
        {
            $sections[$id] = array(
                'label' => preg_replace('|^[\.]+|', '- ', $name),
                'url'   => 'e',
                'type'  => 'raw'
            );
        }

        $this->render('PageSectionsSidebar', array(
            'sections' => $sections
        ));
    }
}
