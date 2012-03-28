<?php

class ModelAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create'      => 'Генерация модели',
            'CodePreview' => 'Превью кода'
        );
    }


    public function actionCreate()
    {
        $model = new Model();
        $form  = new Form('codegen.ModelForm', $model);

        $this->performAjaxValidation($model);

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionCodePreview()
    {
        if (isset($_POST['Model']))
        {
            try
            {
                $params = array_merge($_POST['Model'], array(
                    'rules'     => "",
                    "constants" => array(),
                ));

                $meta = Yii::app()->db->createCommand("SHOW FUll columns FROM " . $params['table'])->queryAll();

                $length = array();

                foreach ($meta as $data)
                {
                    if (preg_match("|enum\((.*)\)|", $data['Type'], $values))
                    {
                        $constants = array();

                        $values = explode(',', $values[1]);
                        foreach ($values as $value)
                        {
                            $value = trim($value, "'");
                            $constants[] = strtoupper($data['Field']) . '_' . strtoupper($value)  . " = '{$value}'";
                        }

                        $params['constants'][$data['Field']] = $constants;
                    }
                }

                $params['rules'].=  $this->_addRequiredRules($meta);
                $params['rules'].=  $this->_addLengthRules($meta);

                $code = $this->renderPartial('application.modules.codegen.views.templates.model', $params, true);

                $highlighter = new CTextHighlighter();
                $highlighter->language = 'php';

                echo $highlighter->highlight($code);
            }
            catch (CException $e)
            {
                echo $e->getMessage();
            }
        }
    }


    public function _addRequiredRules($meta)
    {
        $required = array();

        foreach ($meta as $data)
        {
            if ($data['Null'] == 'NO')
            {
                $required[] = $data['Field'];
            }
        }

        $required = implode(', ', $required);

        return  "array('{$required}', 'required'),\n";
    }


    private function _addLengthRules($meta)
    {
        $types = array('char', 'varchar');
        $rules = "";

        $length = array();

        foreach ($types as $type)
        {
            foreach ($meta as $data)
            {
                if (preg_match("|{$type}\((.*)\)|", $data['Type'], $max_length))
                {
                    $max_length = $max_length[1];
                    if (!isset($length[$max_length]))
                    {
                        $length[$max_length] = array();
                    }

                    $length[$max_length][] = $data['Field'];
                }
            }
        }

        foreach ($length as $length => $attributes)
        {
            $rules.= str_repeat(' ', 12);
            $rules.= "array(" . "'" . implode(", ", $attributes) . "'" . ", 'length', 'max' => {$length}),\n";
        }

        return $rules;
    }
}
