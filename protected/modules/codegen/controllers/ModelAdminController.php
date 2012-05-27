<?php

class ModelAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create'  => 'Генерация модели',
            'GetCode' => 'Получить код'
        );
    }


    public function actionCreate()
    {
        $model = new Model();
        $form  = new Form('codegen.ModelForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->validate())
        {
            file_put_contents($model->path, $this->actionGetCode($model->attributes, false));
            chmod($model->path, 0777);

            Yii::app()->user->setFlash(Controller::MSG_SUCCESS, 'Модель создана!');
            $this->redirect($_SERVER['REQUEST_URI']);
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionGetCode($attributes = array(), $preview = true)
    {
        if (!$attributes)
        {
            $attributes = $_POST['Model'];
        }

        try
        {
            $params = array_merge($attributes, array(
                'rules'     => "",
                "constants" => array(),

            ));

            $meta = Yii::app()->db->createCommand("SHOW FUll columns FROM " . $params['table'])->queryAll();

            $params['meta'] = $meta;

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

            $params['rules'].= $this->addRequiredRules($meta);
            $params['rules'].= $this->addLengthRules($meta);
            $params['rules'].= $this->addInRangeRules($meta);
            $params['rules'].= $this->addUniqueRules($meta);
            $params['rules'].= $this->addCoreValidatorRules($meta);

            $code = $this->renderPartial('codegen.views.templates.model', $params, true);

            //file_put_contents($_SERVER['DOCUMENT_ROOT'] . 'model.php', $code);

            if ($preview)
            {
                $highlighter = new CTextHighlighter();
                $highlighter->language = 'php';

                echo $highlighter->highlight($code);
            }
            else
            {
                return $code;
            }
        }
        catch (CException $e)
        {
            echo $e->getMessage();
        }
    }


    public function addUniqueRules($meta)
    {
        $rules = array();

        foreach ($meta as $data)
        {
            if ($data['Key'] == 'UNI')
            {
                $rules[] = $data['Field'];
            }
        }

        return "            array(
                '" . implode(', ', $rules) . "',
                'unique'
            ),\n";
    }


    public function addCoreValidatorRules($meta)
    {
        $rules = "";

        foreach ($meta as $data)
        {
            if (in_array($data['Field'], array('phone', 'fax')))
            {
                $rules.= "            array(
                '{$data['Field']}',
                'PhoneValidator'
            ),\n";
            }
        }

        return $rules;
    }


    public function addInRangeRules($meta)
    {
        $rules = array();

        foreach ($meta as $data)
        {
            if (preg_match("|enum\((.*)\)|", $data['Type']))
            {
                $rules[] = "            array(
                '{$data['Field']}',
                'in',
                'range' => self::" . '$' . "{$data['Field']}_options
            ),";
            }
        }

        return  implode("\n", $rules) . "\n";
    }


    public function addRequiredRules($meta)
    {
        $required = array();

        foreach ($meta as $data)
        {
            if ($data['Null'] == 'NO' && !in_array($data['Field'], Model::$not_required_attributes))
            {
                $required[] = $data['Field'];
            }
        }

        $required = implode(', ', $required);

        return  "array(
                '{$required}',
                'required'
            ),\n";
    }


    private function addLengthRules($meta)
    {
        $types = array('char', 'varchar');
        $rules = "";

        $length = array();

        foreach ($types as $type)
        {
            foreach ($meta as $data)
            {
                if (preg_match("|^{$type}\((.*)\)$|", $data['Type'], $max_length))
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
            $rules.= "array(
                " . "'" . implode(", ", $attributes) . "'" . ",
                'length',
                'max' => {$length}
             ),\n";
        }

        return $rules;
    }
}
