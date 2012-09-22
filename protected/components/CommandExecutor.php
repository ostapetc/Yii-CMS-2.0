<?php
class CommandExecutor extends CApplicationComponent
{
    /**
     * @var CConsoleCommandRunner
     */
    public $runner;


    public function init()
    {
        $this->runner = new CConsoleCommandRunner();
        $this->addCommands('system.cli.commands');
        $this->addCommandsFromModules(Yii::app()->getModules());
        $this->addCommandsFromConfig('console');
        parent::init();
    }


    public function __call($name, $params)
    {
        $args = array(
            'yiic',
            $name
        );
        if (isset($params[0]))
        {
            $params = explode(' ', $params[0]);
        }

        foreach ($params as $item)
        {
            array_push($args, $item);
        }
        try
        {
            ob_start();
            ob_implicit_flush(false);
            array_push($args, '--interactive=0');
            $this->runner->run($args);
            $result = ob_get_clean();
        } catch (Exception $e)
        {
            ob_clean();
            $result = $e->getMessage();
        }

        return $result;
    }


    public function addCommands($alias)
    {
        $path = Yii::getPathOfAlias($alias);
        if (is_dir($path))
        {
            $this->runner->addCommands($path);
        }
    }


    public function addCommandsFromModules($modules)
    {
        foreach ($modules as $id => $data)
        {
            $this->runner->addCommands($id . '.commands');
        }
    }


    public function addCommandsFromConfig($config)
    {
        $config = new CConfiguration(Yii::getPathOfAlias('application.config') . '/' . $config . '.php');
        foreach ($config['commandMap'] as $id => $conf)
        {
            $this->runner->commands[$id] = $conf;
        }
    }


}