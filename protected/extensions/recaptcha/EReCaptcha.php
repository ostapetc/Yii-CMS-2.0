<?php
/**
 * EReCaptcha class file.
 *
 * @author Rodolfo González <metayii.framework@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Rodolfo González
 * @license
 *
 * Copyright © 2008-2011 by Rodolfo González
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * - Neither the name of MetaYii nor the names of its contributors may
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 * Include the reCAPTCHA PHP wrapper.
 */
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'reCAPTCHA'.DIRECTORY_SEPARATOR.'recaptchalib.php');

/**
 * EReCaptcha generates a CAPTCHA using the service provided by reCAPTCHA {@link http://recaptcha.net/}.
 * See LICENCE.txt for the terms of use for this service.
 *
 * EReCaptcha should be used together with {@link EReCaptchaValidator}.
 *
 * @author MetaYii
 * @package application.extensions.recaptcha
 * @since 1.3
 */
class EReCaptcha extends CInputWidget
{
   //***************************************************************************
   // Configuration.
   //***************************************************************************

	/**
	 * reCAPTCHA public key
	 *
	 * @var string
	 */
	protected $publicKey = '';

   /**
    * The theme name for the widget. Valid themes are 'red', 'white', 'blackglass', 'clean', 'custom'
    *
    * @var string the theme name for the widget
    */
   protected $theme = 'red';

   /**
    * The language for the widget. Valid languages are 'en', 'nl', 'fr', 'de', 'pt', 'ru', 'es', 'tr'
    *
    * @var string the language suffix
    */
   protected $language = 'en';

   /**
    * @var string the tab index for the HTML tag
    */
   public $tabIndex = 0;

   /**
    * @var string the id for the HTML containing the custom theme
    */
   public $customThemeWidget = '';

   /**
    * @var boolean whether to use SSL for connections. If false, autodetection will be used.
    */
   public $useSsl = false;

   //***************************************************************************
   // Internal properties.
   //***************************************************************************

   /**
    * Valid languages
    *
    * @var array
    */
   protected $validLanguages = array('en','nl','fr','de','pt','ru','es','tr');

   /**
    * Valid themes
    *
    * @var array
    */
   protected $validThemes = array('red','white','blackglass','clean','custom');

   //***************************************************************************
   // Setters and getters.
   //***************************************************************************

   /**
    * Sets the public key.
    *
    * @param string $value
    * @throws CException if $value is not valid.
    */
   public function setPublicKey($value)
   {
      if (empty($value)||!is_string($value)) throw new CException(Yii::t('yii','EReCaptcha.publicKey must contain your reCAPTCHA public key.'));
      $this->publicKey = $value;
   }

   /**
    * Returns the reCAPTCHA protected key
    *
    * @return string
    */
   public function getPublicKey()
   {
      return $this->publicKey;
   }

   /**
    * Sets the language
    *
    * @param string $value the language string
    * @return string
    */
	public function setLanguage($value)
	{
	   $suffix = empty($value) ? 'en' : (($p=strpos($value,'_'))!==false) ? strtolower(substr($value,0,$p)) : strtolower($value);
      if (in_array($suffix, $this->validLanguages)) $this->language = $suffix;
	}

	/**
	 * Returns the language value
	 *
	 * @return string
	 */
	public function getLanguage()
	{
	   return $this->language;
	}

	/**
	 * Sets the theme
	 *
	 * @param string $value the theme
	 */
	public function setTheme($value)
	{
	   if (in_array($value, $this->validThemes)) $this->theme = $value;
	}

	/**
	 * Returns the theme
	 *
	 * @return string
	 */
	public function getTheme()
	{
	   return $this->theme;
	}

   //***************************************************************************
   // Run Lola Run
   //***************************************************************************

   public function init()
   {
      $customthemewidget = (($w = $this->customThemeWidget) != '') ? "'{$w}'" : 'null';
      $cs = Yii::app()->getClientScript();

      if (!$cs->isScriptRegistered(get_class($this).'_options')) {
         $script =<<<EOP
var RecaptchaOptions = {
   theme : '{$this->theme}',
   custom_theme_widget : {$customthemewidget},
   lang : '{$this->language}',
   tabindex : {$this->tabIndex}
};
EOP;
         $cs->registerScript(get_class($this).'_options', $script, CClientScript::POS_HEAD);
      }
   }

	/**
	 * Renders the widget.
	 */
	public function run()
	{
      $body = '';
      if ($this->hasModel()) {
         $body = CHtml::activeHiddenField($this->model, $this->attribute) . "\n";
      }
      echo $body . recaptcha_get_html($this->publicKey,
                                      null,
                                      ($this->useSsl ? true : Yii::app()->request->isSecureConnection));
	}
}