**ComponentInModuleBehavior**

По умолчанию это поведение имеют классы InputWidget, JuiInputWidget, Portlet, JuiWidget

После того как отработает `parent::init();` станут доступны следующие поля:

- Путь до ассетов модуля: `$this->assets`
- Модуль в котором находится видежт: `$this->module`
- Метод `$this->createUrl()` алиас `Yii::app()->controller->createUrl()`
