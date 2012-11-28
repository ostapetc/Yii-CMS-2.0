<?

/*
 * Контроллер для всяких вспомогательных функций,
 * экшены можно добавить в него один раз, вместо того, что бы добавлять их во все контроллеры
 */
class HelpAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'sortable'         => 'Изменение позиции',
            'manyManySortable' => 'Изменение позиции для отношений ManyMany',
            'console'          => 'Консоль',
            'saveAttribute'    => 'Сохранение Атрибута'
        );
    }

    public function actions()
    {
        return array(
            'sortable'         => array(
                'class' => 'ext.sortable.SortableAction',
            ),
            'console'         => array(
                'class' => 'main.components.ConsoleAction',
            ),
            'manyManySortable' => array(
                'class' => 'ext.sortable.ManyManySortableAction',
            ),
            'saveAttribute'    => array(
                'class' => 'main.components.SaveAttributeAction',
            )
        );
    }
}
