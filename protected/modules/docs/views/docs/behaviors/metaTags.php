**MetaTagBehavior**

Сохарняет метатеги и предоставляет к ним доступ

##Испольование:

Конфигурация модели:

~~~
[php]
'MetaTagBehavior' => array(
    'class' => 'application.components.activeRecordBehaviors.MetaTagBehavior'
)
~~~

Конфигурация формы:

~~~
[php]
'meta_tags'    => array('type' => 'MetaTags'),
~~~

Также каждый контроллер имеет метод `public function setMetaTags($modelOrConfig)`
который принимает модель либо ассоциативный массив `название тега => значение`
Мета теги будут подключены через `CClientScript::registerMetaTag`

`setMetaTags` - не поддерживает 3 и 4 параметры `CClientScript::registerMetaTag`,
для более сложного поведения используйте `CClientScript::registerMetaTag` напрямую

##MetaTagsFilter
Так же обратите внимание на `MetaTagsFilter` который старается выставить метатеги автоматически,
он довольно глуп и поэтому использовать его нужно с осторожностью.

Он имеет 2 параметра: `findAttribute` и `getParam` пытаясь найти модель по `findByAttributes(array($this->findAttribute => request->getParam($this->getParam)))`
и применяет метатеги связанные с этой моделью