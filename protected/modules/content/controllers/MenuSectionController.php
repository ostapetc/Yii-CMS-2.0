<?

class MenuSectionController extends ClientController
{
    public static function actionsTitles()
    {
        return [
            "view"   => "Просмотр страницы",
        ];
    }


    public function actionView($id)
    {
        $model = $this->loadModel($id, ['published']);
        $model->checkAccess();
        $children = [];
        foreach ($model->children()->findAll() as $child)
        {
            if ($child->checkAccess())
            {
                $children[] = $child;
            }
        }

        $this->render("view", [
            "children"    => $children,
            "section"    => $model
        ]);
    }
}
