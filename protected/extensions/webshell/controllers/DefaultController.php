<?php
class DefaultController extends CController {
    public $layout='webshell';
    public $pageTitle = 'Yii web shell';

    function actionError(){
        echo "Error.";
    }

    function actionLogin(){

    }

    function actionIndex(){
        $this->registerAssets();

        $commands = $this->getModule()->commands;
        $commandsConfig = array();
        foreach($commands as $name => $command){
            if(is_array($command[0])){
                if(isset($command[0]['DISPATCH'])){
                    $command[0]['DISPATCH'] = $this->normalizeUrl($command[0]['DISPATCH']);

                    if(isset($command[0]['START_HOOK']))
                        $command[0]['START_HOOK'] = $this->normalizeUrl($command[0]['START_HOOK']);

                    if(isset($command[0]['EXIT_HOOK']))
                        $command[0]['EXIT_HOOK'] = $this->normalizeUrl($command[0]['EXIT_HOOK']);
                }
                else {
                    $command[0] = $this->normalizeUrl($command[0]);
                }
            }


            $commandsConfig[$name] = $command[0];
        }

        $config = array(
            'wtermOptions' => $this->getModule()->wtermOptions,
            'commands' => $commandsConfig,
            'helpText' => $this->getHelpText(),
            'exitUrl' => $this->createAbsoluteUrl($this->getModule()->exitUrl),
        );

        Yii::app()->clientScript->registerScript('webshell.config', 'var webshell = '.CJavaScript::encode($config).';', CClientScript::POS_HEAD);

		$this->render('index');
	}

    protected function normalizeUrl($url){
        if(is_array($url))
            return $this->createAbsoluteUrl($url[0]);

        return $url;
    }

    /**
     * Yiic proxy action
     *
     * @return void
     */
    function actionYiic(){
        $tokens = explode(" ", $_GET['tokens']);
        $commandPath = Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'commands';

        $runner=new CConsoleCommandRunner();
        $runner->commands=$this->getModule()->yiicCommandMap;
        $runner->addCommands($commandPath);

//        ob_start();
//        try{
            $runner->run($tokens);
//        }catch(Exception $e)
//        {
//            echo $e->getMessage();
//            echo '<br/>';
//            echo $e->getTrace();
//        }
//        echo htmlentities(ob_get_clean(), null, Yii::app()->charset);
    }

    /**
     * Forms message for a 'help' command
     * @return string
     */
    protected function getHelpText(){
        $out = array();
        $commands = $this->getModule()->commands;
        foreach($commands as $name => $command){
            $out[] = $name."\t".$command[1];
        }
        $out[] = "clear\tClear screen.";
        $out[] = "exit\tExit console.";
        return implode("\n", $out);
    }

    /**
     * Registers required assets
     * @return void
     */
    private function registerAssets(){
        Yii::app()->clientScript->registerCssFile(
			Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('webshell.assets').'/wterm.css'
			)
		);

        Yii::app()->clientScript->registerCoreScript('jquery');

        Yii::app()->clientScript->registerScriptFile(
			Yii::app()->assetManager->publish(
				Yii::getPathOfAlias('webshell.assets').'/wterm.jquery.js'
			),
            CClientScript::POS_END
		);

        Yii::app()->clientScript->registerScriptFile(
			Yii::app()->assetManager->publish(
				Yii::getPathOfAlias('webshell.assets').'/webshell.js'
			),
            CClientScript::POS_END
		);
    }
}
