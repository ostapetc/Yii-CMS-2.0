<?php
class ParserRunnerCommand extends CConsoleCommand
{
    public $parsers = array();

    public function run()
    {
        foreach ($this->parsers as $parser)
        {
            $parser = Yii::createComponent($parser);
            $parser->init();
            $parser->parse();
        }
    }
}
