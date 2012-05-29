<?

class MenuSectionController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            "view"   => "Просмотр страницы",
        );
    }


    public function actionView($id)
    {
        $model = $this->loadModel($id, array('published'));
        $model->checkAccess();
        $children = array();
        foreach ($model->children()->findAll() as $child)
        {
            if ($child->checkAccess())
            {
                $children[] = $child;
            }
        }

        $this->render("view", array(
            "children"    => $children,
            "section"    => $model
        ));
    }
}
