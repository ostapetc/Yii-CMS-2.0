<?php

/**
 *
 *
 *
 *
 * This parser may be used as the basis for a variety of secondary tools, including
 * a reflection-based API generator, a code metrics analyzer, and various other code or structural
 * analysis tools.
 * Autogeneratable
 *
 *
 *
 *
 *
 * sdfadsfasdfklj  sdfj asdf <dsa>sdfas</a>
 * sdfalkjfal
 *
 *
 *
 *
 * @param  $scenario
 *
 * @property  $class
 * @property  $genetive
 * @property  $instrumental
 * @property  $accusative
 * @property  $attributes
 * @property  $scenario
 *
 * @return string
 */

class Crud extends FormModel
{
    /**
     * @var string sd
     */
    public $class;

    public $genetive;

    public $instrumental;

    public $accusative;


    public function rules()
    {
        return array(
            array('class, genetive, instrumental, accusative', 'required')
        );
    }

}























