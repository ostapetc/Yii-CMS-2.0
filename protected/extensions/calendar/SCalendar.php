<?php
/*
 * SCalendar is a calendar based on the Collest DHTML Calendar -
 * http://www.dynarch.com/projects/calendar/old/
 * Information and documentation can be found on this site
 *
 */
class SCalendar extends CWidget {

  /* @var $_language String */
  private $_language = "en";
  /* @var $_styleSheet String */
  private $_stylesheet = "blue";
  /* @var $inputField String */
  private $_inputField;
  /* @var $button String */
  private $_button;
  /* @var $ifFormat String */
  private $_ifFormat;
  /* @var $displayArea String */
  private $_displayArea;
  /* @var $_eventName String */
  private $_eventName;
  /* @var $_firstDay Integer */
  private $_firstDay;
  /* @var $daFormat String */
  private $_daFormat;
  /* @var $_singleClick boolean */
  private $_singleClick;
  /* @var $dateStatusFunc String */
  private $_dateStatusFunc;
  /* @var $_weekNumbers boolean */
  private $_weekNumbers;
  /* @var $_align String */
  private $_align;
  /* @var $_range array */
  private $_range;
  /* @var $flat String */
  private $_flat;
  /* @var $flatCallback String */
  private $_flatCallback;
  /* @var $onSelect String */
  private $_onSelect;
  /* @var $onClose String */
  private $_onClose;
  /* @var $onUpdate String */
  private $_onUpdate;
  /* @var $date String */
  private $_date;
  /* @var $_showsTime boolean */
  private $_showsTime;
  /* @var $_timeFormat Integer */
  private $_timeFormat;
  /* @var $_electric boolean */
  private $_electric;
  /* @var $_position String */
  private $_position;
  /* @var $_cache boolean */
  private $_cache;
  /* @var $_showOthers boolean */
  private $_showOthers;
  /* @var $_verAlign array */
  private $_verAlign = array("T","t","c","b","B");
  /* @var $_horAlign array */
  private $_horAlign = array("L","l","c","R","r");
  /* @var $skin String */
  private $_skin;
  /* @var $_step Integer  */
  private $_step;

/*** * @param integer $step */
  public function setStep($step) {
    if(is_numeric($step) && ($step > 0)) {
      $this->_step = $step; }
    else {
      $this->_step = 2;
    }
  }

  /**
   * Set the skin of the calendar (aqua, tiger)
   * If it's set the stylesheet will be ignored
   * @param String $skin
   */
  public function setSkin($skin) {
    $this->_skin = $skin;
  }

  /**
   * This allows you to setup an initial date where the calendar will be
   * positioned to. If absent then the calendar will open to the today date.
   * @param String $date
   */
  public function setDate($date) {
    $this->_date = $date;
  }

  /**
   * If you provide a function handler here then you have to manage the
   * "click-on-date" event by yourself. Look in the calendar-setup.js
   * and take as an example the onSelect handler that you can see there.
   * @param String $onSelect
   */
  public function setOnSelect($onSelect) {
    $this->_onSelect = $onSelect;
  }

  /**
   * This handler will be called when the calendar needs to close. You don't
   * need to provide one, but if you do it's your responsibility
   * to hide/destroy the calendar. You're on your own.
   * Check the calendar-setup.js file for an example.
   * @param String $onClose
   */
  public function setOnClose($onClose) {
    $this->_onClose = $onClose;
  }

  /**
   * If you supply a function handler here, it will be called right after
   * the target field is updated with a new date. You can use this to chain
   * 2 calendars, for instance to setup a default date in the second just
   * after a date was selected in the first.
   * @param String $onUpdate
   */
  public function setOnUpdate($onUpdate) {
    $this->_onUpdate = $onUpdate;
  }

  /**
   * You should provide this function if the calendar is flat. It will be called
   * when the date in the calendar is changed with a reference to the calendar
   *  object.
   * @param String $flatCallback
   */
  public function setFlatCallback($flatCallback) {
    $this->_flatCallback = $flatCallback;
  }

  /**
   * If you want a flat calendar, pass the ID of the parent object in this
   * property. If not, pass null here (or nothing at all as null is the default value).
   * @param String $flat
   */
  public function setFlat($flat) {
    $this->_flat = $flat;
  }

  /**
   * A function that receives a JS Date object and returns a boolean or a string.
   * This function allows one to set a certain CSS class to some date, therefore
   * making it look different. If it returns true then the date will be disabled.
   * If it returns false nothing special happens with the given date. If it
   * returns a string then that will be taken as a CSS class and appended to
   * the date element. If this string is ``disabled'' then the date is also
   * disabled (therefore is like returning true). For more information please
   * also refer to section
   * @param String $dateStatusFunc
   */
  public function setDateStatusFunc($dateStatusFunc) {
    $this->_dateStatusFunc = $dateStatusFunc;
  }

  /**
   * Format of the date displayed in the displayArea (if specified).
   * The format is the same as in setIfFormat
   * @param String $daFormat
   */
  public function setDaFormat($daFormat) {
    $this->_daFormat = $daFormat;
  }

  /**
   * This is the ID of a <span>, <div>, or any other element that you would like
   * to use to display the current date. This is generally useful only if the
   * input field is hidden, as an area to display the date.
   * @param String $displayArea
   */
  public function setDisplayArea($displayArea) {
    $this->_displayArea = $displayArea;
  }

  /**
   * The ID of your input field.
   * @param String $inputField
   */
  public function setInputField($inputField) {
    $this->_inputField = $inputField;
  }

  /**
   * The ID of the calendar "trigger". This is an element (ordinarily a
   * button or an image) that will dispatch a certain event (usually "click")
   * to the function that creates and displays the calendar.
   * @param String $button
   */
  public function setButton($button) {
    $this->_button = $button;
  }

  /**
   * The format string that will be used to enter the date in the input field.
   * This format will be honored even if the input field is hidden.<br>
   * %a : abbreviated weekday name<br>
   * %A : full weekday name<br>
   * %b : abbreviated month name<br>
   * %B : full month name<br>
   * %C : century number<br>
   * %d : the day of the month ( 00 .. 31 )<br>
   * %e : the day of the month ( 0 .. 31 )<br>
   * %H : hour ( 00 .. 23 )<br>
   * %I : hour ( 01 .. 12 )<br>
   * %j : day of the year ( 000 .. 366 )<br>
   * %k : hour ( 0 .. 23 )<br>
   * %l : hour ( 1 .. 12 )<br>
   * %m : month ( 01 .. 12 )<br>
   * %M : minute ( 00 .. 59 )<br>
   * %n : a newline character<br>
   * %p : "PM" or "AM"<br>
   * %P : "pm" or "am"<br>
   * %S : second ( 00 .. 59 )<br>
   * %s : number of seconds since Epoch (since Jan 01 1970 00:00:00 UTC)<br>
   * %t : a tab character<br>
   * %U, %W, %V : the week number<br>
   * %u : the day of the week ( 1 .. 7, 1 = MON )<br>
   * %w : the day of the week ( 0 .. 6, 0 = SUN )<br>
   * %y : year without the century ( 00 .. 99 )<br>
   * %Y : year including the century ( ex. 1979 )<br>
   * %% : a literal % character
   * @param String $ifFormat
   */
  public function setIfFormat($ifFormat) {
    $this->_ifFormat = $ifFormat;
  }

  /**
   * If set to true then days belonging to months overlapping with the
   * currently displayed month will also be displayed in the calendar
   * (but in a 'faded-out' color)
   * @param boolean $showOthers
   */
  public function setShowOthers($showOthers) {
    if(is_bool($showOthers)) {
      $this->_showOthers = $showOthers;
    } else {
      $this->_showOthers = false;
    }
  }

  /**
   * Set this to true if you want to cache the calendar object.
   * This means that a single calendar object will be used for all fields that
   * require a popup calendar
   * @param boolean $cache
   */
  public function setCache($cache) {
    if(is_bool($cache)) {
      $this->_cache = $cache;
    } else {
      $this->_cache = false;
    }
  }

  /**
   * Specifies the [x, y] position, relative to page's top-left corner,
   * where the calendar will be displayed. If not passed then the position
   * will be computed based on the 'align' parameter. Defaults to 'null'
   * (not used).
   * @param String $position
   */
  public function setPosition($position) {
    $this->_position = $position;
  }

  /**
   * Set this to "false" if you want the calendar to update the field only when
   * closed (by default it updates the field at each date change, even if the
   * calendar is not closed)
   * @param boolean $electric
   */
  public function setElectric($electric) {
    if(is_bool($electric)) {
      $this->_electric = $electric;
    } else {
      $this->_electric = false;
    }
  }

  /**
   * Set this to "12" or "24" to configure the way that the calendar will display
   * time.
   * @param String $timeFormat
   */
  public function setTimeFormat($timeFormat) {
    if($timeFormat == "12" || $timeFormat == "24") {
      $this->_timeFormat = $timeFormat;
    }
  }

  /**
   * If this is set to true then the calendar will also allow time selection.
   * @param boolean $showsTime
   */
  public function setShowsTime($showsTime) {
    if(is_bool($showsTime)) {
      $this->_showsTime = $showsTime;
    } else {
      $this->_showsTime = false;
    }
  }

  /**
   * A String in the form of [minYear,maxYear]The first element is
   * the minimum year that is available, and the second element is the
   * maximum year that the calendar will allow.
   * @param array $range
   */
  public function setRange($range) {
    $this->_range = $range;
  }


  /**
   * A two character string defining the align of the calendar<br><br>
   * The first character in "align" can take one of the following values:
   * <b>Vertical Alignment</b><br>
   * T -- completely above the reference element (bottom margin of the calendar<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;aligned to the top margin of the element).<br>
   * t -- above the element but may overlap it (bottom margin of the calendar<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;aligned to the bottom margin of the element).<br>
   * c -- the calendar displays vertically centered to the reference element.<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;It might overlap it (that depends on the horizontal alignment).<br>
   * b -- below the element but may overlap it (top margin of the calendar<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;aligned to the top margin of the element).<br>
   * B -- completely below the element (top margin of the calendar aligned to the<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bottom margin of the element).<br>
   * <b>Horizontal alignment</b><br>
   * The second character in "align" can take one of the following values:<br>
   * L -- completely to the left of the reference element (right margin of the<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;calendar aligned to the left margin of the element).<br>
   * l -- to the left of the element but may overlap it (left margin of the<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;calendar aligned to the left margin of the element).<br>
   * c -- horizontally centered to the element. Might overlap it, depending on<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the vertical alignment.<br>
   * r -- to the right of the element but may overlap it (right margin of the<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;calendar aligned to the right margin of the element).<br>
   * R -- completely to the right of the element (left margin of the calendar<br>
   * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;aligned to the right margin of the element).<br>
   * @param <type> $align
   */
  public function setAlign($align) {
    if(strlen($align) == 2) {
      $ver = substr($align, 0, 1);
      $hor = substr($align, 1, 1);
      if(in_array($ver, $this->_verAlign) && in_array($hor, $this->_horAlign)) {
        $this->_align = $align;
      }
    }
  }

  /**
   * Wether the calendar is in "single-click mode" or "double-click mode".
   * If true (the default) the calendar will be created in single-click mode.
   * @param boolean $singleClick
   */
  public function setSingleClick($singleClick) {
    if(is_bool($singleClick)) {
      $this->_singleClick = $singleClick;
    } else {
      $this->_singleClick = false;
    }
  }

  /**
   * If "true" then the calendar will display week numbers.
   * @param boolean $weekNumbers
   */
  public function setWeekNumbers($weekNumbers) {
    if(is_bool($weekNumbers)) {
      $this->_weekNumbers = $weekNumbers;
    } else {
      $this->_weekNumbers = false;
    }
  }

  /**
   * The calendar's language (af, al, bg, big5-utf8, big5, br, ca, cs-utf8,
   * cs-win, da, de, du, el, en, es, eu, fi, fr, he-utf8, hr-utf8, hr, hu,
   * it, jp, ko-utf8, ko, lt-utf8, lt, lv, nl, no, pl-utf8, pl, pt, ro,
   * ru-UTF, ru, ru_win_, si, sk, sp, sr-utf8, sr, sv, tr, zh, s )
   * @param String $language
   */
  public function setLanguage($language) {
    $this->_language = $language;
  }

  /**
   * Sets the calendars css (blue, blue2,brown,green,system,tas,win2k-1,win2k-2
   * win2k-cold-1, win2k-cold-2)
   * @param String $stylesheet
   */
  public function setStylesheet($stylesheet) {
    $this->_stylesheet = $stylesheet;
  }

  /**
   * The name of the event that will trigger the calendar. The name should be
   * without the "on" prefix, such as "click" instead of "onclick".
   * Virtually all users will want to let this have the default value
   * ("click"). Anyway, it could be useful if, say, you want the calendar
   * to appear when the input field is focused and have no trigger button
   * (in this case use "focus" as the event name).
   * @param String $eventName
   */
  public function setEventName($eventName) {
    $this->_eventName = $eventName;
  }

  /**
   * Specifies which day is to be displayed as the first day of week.
   * Possible values are 0 to 6; 0 means Sunday, 1 means Monday, ..., 6
   * means Saturday. The end user can easily change this too, by clicking
   * on the day name in the calendar header.
   * @param integer $firstDay
   */
  public function setFirstDay($firstDay) {
    if(is_numeric($firstDay) && ($firstDay >-1) && $firstDay < 7) {
      $this->_firstDay = $firstDay;
    } else {
      $this->_firstDay = 0;
    }
  }

  /**
   * Execute the widget
   */
  public function run() {
    $this->registerClientScripts();
    echo $this->createMarkup();
  }

  /**
   * Registers the clientside widget files (css & js)
   */
  private function registerClientScripts() {
  // Get the resources path
    $resources = dirname(__FILE__).DIRECTORY_SEPARATOR.'resources';

    // publish the files
    $baseUrl = Yii::app()->assetManager->publish($resources);

    // register the files
    Yii::app()->clientScript->registerScriptFile($baseUrl.'/calendar.js');
    Yii::app()->clientScript->registerScriptFile($baseUrl.'/calendar-setup.js');
    if(is_file($resources.'/lang/calendar-'.$this->_language.'.js')) {
      Yii::app()->clientScript->registerScriptFile($baseUrl.'/lang/calendar-'.$this->_language.'.js');
    } else {
      Yii::app()->clientScript->registerScriptFile($baseUrl.'/lang/calendar-en.js');
    }

    // If skin
    if(isset($this->_skin) && $this->_skin != "") {
    // register the Skin
      if(is_file($resources.'/skins/'.$this->_skin.'/theme.css')) {
        Yii::app()->clientScript->registerCssFile($baseUrl.'/skins/'.$this->_skin.'/theme.css');
      } else {
        Yii::app()->clientScript->registerCssFile($baseUrl.'/skins/aqua/theme.css');
      }
    } else {
    // register the Stylesheet
      if(is_file($resources.'/styles/calendar-'.$this->_stylesheet.'.css')) {
        Yii::app()->clientScript->registerCssFile($baseUrl.'/styles/calendar-'.$this->_stylesheet.'.css');
      } else {
        Yii::app()->clientScript->registerCssFile($baseUrl.'/styles/calendar-blue.css');
      }
    }
  }

  /**
   * Creates markup (html) required for the current mode.
   */
  private function createMarkup() {
    $html = "";
    $prop = "inputField       : '$this->_inputField',\n";
    if(isset ($this->_flat))          $prop .= "flat            : '$this->_flat',\n";
    if(isset ($this->_button))        $prop .= "button          : '$this->_button',\n";
    if(isset ($this->_ifFormat))      $prop .= "ifFormat        : '$this->_ifFormat',\n";
    if(isset ($this->_eventName))     $prop .= "eventName       : '$this->_eventName',\n";
    if(isset ($this->_firstDay))      $prop .= "firstDay        :  $this->_firstDay,\n";
    if(isset ($this->_daFormat))      $prop .= "daFormat        : '$this->_daFormat',\n";
    if(isset ($this->_displayArea))   $prop .= "displayArea     : '$this->_displayArea',\n";
    if(isset ($this->_singleClick))   $prop .= "singleClick     :  '$this->_singleClick',\n";
    if(isset ($this->dateStatusFunc)) $prop .= "dateStatusFunc  : $this->dateStatusFunc,\n";
    if(isset ($this->_weekNumbers))   $prop .= "weekNumbers     :  '$this->_weekNumbers',\n";
    if(isset ($this->_align))         $prop .= "align           : '$this->_align',\n";
    if(isset ($this->_range))         $prop .= "range           :  $this->_range,\n";
    if(isset ($this->_flatCallback))  $prop .= "flatCallback    : $this->_flatCallback,\n";
    if(isset ($this->_onSelect))      $prop .= "onSelect        : $this->_onSelect,\n";
    if(isset ($this->_onClose))       $prop .= "onClose         : $this->_onClose,\n";
    if(isset ($this->_onUpdate))      $prop .= "onUpdate        : $this->_onUpdate,\n";
    if(isset ($this->_date))          $prop .= "date            : '$this->_date',\n";
    if(isset ($this->_showsTime))     $prop .= "showsTime       :  '$this->_showsTime',\n";
    if(isset ($this->_timeFormat))    $prop .= "timeFormat      :  $this->_timeFormat,\n";
    if(isset ($this->_electric))      $prop .= "electric        :  '$this->_electric',\n";
    if(isset ($this->_position))      $prop .= "position        :  $this->_position,\n";
    if(isset ($this->_cache))         $prop .= "cache           :  '$this->_cache',\n";
    if(isset ($this->_showOthers))    $prop .= "showOthers      :  '$this->_showOthers',\n";
    if(isset ($this->_step))          $prop .= "step            : $this->_step,\n";
    $prop = substr($prop,0,-2);

    $html = "<script type='text/javascript'>
  Calendar.setup(
    {
      ".$prop."
    }
  )
  </script>";
    return $html;
  }
}
?>
