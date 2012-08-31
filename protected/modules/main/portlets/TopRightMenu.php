<?

class TopRightMenu extends Portlet
{
    const CODE = "TopRightMenu";


    public function renderContent()
    {
        $query = "";
        if (isset($_GET['query']))
        {
            $query = trim(strip_tags($_GET['query']));
        }

        $items = array(
            '',
            array(
                'label' => self::searchFormHtml($query)
            ),
        );

        if (Yii::app()->user->isGuest)
        {
            $items = array_merge($items, array(
                array(
                    'label'       => t('Войти'),
                    'url'         => $this->createUrl('login?redirect=' . $_SERVER['REQUEST_URI']),
                    'htmlOptions' => array(
                        'class'         => 'show-modal-link',
                        'data-modal-id' => 'login-modal'
                    )
                ),
                array(
                    'label'       => t('Регистрация'),
                    'url'         => $this->createUrl('/registration'),
                    'htmlOptions' => array(
                        'class'         => 'show-modal-link',
                        'data-modal-id' => 'registration-modal'
                    )
                )
            ));
        }
        else
        {
            $items = array_merge($items, array(
                array(
                    'label' => CHtml::image('/img/icons/user.gif'),
                    'items' => array(
                        array(
                            'label' => '',
                            'url'   => ''
                        ),
                        array(
                            'label' => 'Выйти',
                            'url'   => array('users/user/logout')
                        )
                    )
                )
            ));
        }

        $this->render('TopRightMenu', array(
            'query' => $query,
            'items' => $items
        ));
    }


    public static function searchFormHtml($query)
    {
        $form = CHtml::beginForm(
            Yii::app()->createUrl('/search'),
            'GET',
            array(
                'class' => 'navbar-search pull-left'
            )
        );

        $form.= CHtml::textField(
            'query',
            $query,
            array(
                'class' => 'search-query',
                'placeholder' => t('Поиск')
            )
        );

        $form.= CHtml::endForm();
        return $form;
    }
}
