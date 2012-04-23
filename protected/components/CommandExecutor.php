<?php
class CommandExecutor extends CApplicationComponent
{
    private $runner;

    public function init()
    {
        $this->runner = new CConsoleCommandRunner();

        $this->addCommands('system.cli.commands');
        foreach (Yii::app()->getModules() as $id => $conf)
        {
            $this->addCommands($id.'.commands');
        }
        $this->addCommands('ext.migrate');

        parent::init();
    }

    public function __call($name, $params)
    {
        $args = array('yiic', $name);
        if (isset($params[0]))
        {
            $params = explode(' ', $params[0]);
        }

        foreach ($params as $item)
        {
            array_push($args, $item);
        }
        ob_start();
        array_push($args, '--interactive=0');
        $this->runner->run($args);
        return htmlentities(ob_get_clean(), null, Yii::app()->charset);
    }

    public function addCommands($alias)
    {
        $path = Yii::getPathOfAlias($alias);
        if (is_dir($path))
        {
            $this->runner->addCommands($path);
        }
    }
}