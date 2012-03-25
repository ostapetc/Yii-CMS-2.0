<?
class DeviceMappingFilter extends CFilter
{
    public $browserName;
    public $browserVersion;
    public $mobileDevice;
    public $profile;

    /**
     * Android devices like G1, Nexus etc
     *
     * @var string
     */
    public static $ANDROID = 'android';

    /**
     * Apple iPhone
     *
     * @var string
     */
    public static $IPHONE = 'iphone';

    /**
     * Apple ipad
     *
     * @var string
     */
    public static $IPAD = 'ipad';

    /**
     * Existing Profiles for devices
     *
     * @var array
     */
    public static $profiles = array(
        'mobile' => array(
            //change the layout
            'layout'  => '//layouts/main',
            //redirect controller to other controller
            'forward' => array('index' => 'mobile/default/index'),
        )
    );

    /**
     * Map devices to profiles
     *
     * @var array
     */
    public static $maps = array(
        'android' => 'mobile',
        'iphone'  => 'mobile',
        'ipad'    => 'mobile'
    );


    protected function preFilter($filterChain)
    {
        if (isset($_SERVER['HTTP_USER_AGENT']) || $device = Yii::app()->request->getParam('core_device'))
        {
            $this->detectBrowser($_SERVER['HTTP_USER_AGENT']);

            /** @var CController $controller */
            $controller = $filterChain->controller;

            if ($this->mobileDevice && isset(self::$maps[$this->mobileDevice]))
            {
                $this->profile = self::$profiles[self::$maps[$this->mobileDevice]];
            }
            elseif ($this->browserName && isset(self::$maps[$controller->browserName]))
            {
                $this->profile = self::$profiles[self::$maps[$this->browserName . $this->browserVersion]];
            }

            if ($this->profile)
            {
                if (isset($this->profile['forward']))
                {
                    $myKey = $controller->module->id . '/' . $controller->id . '/' . $controller->action->id;

                    foreach ($this->profile['forward'] as $key => $val)
                    {
                        if ($myKey == $key)
                        {
                            $controller->forward($val);
                            break;
                        }
                    }
                }
                if (isset($this->profile['layout']))
                {
                    $controller->layout = $this->profile['layout'];
                }
            }
        }
        return true;
    }


    /**
     * Detect the current browser
     * Attention: only supports some browsers
     *
     * @param string $agent
     */
    protected function detectBrowser($agent)
    {
        $agent = strtolower($agent);
        switch (true)
        {
            case strstr($agent, 'msie 6.'):
                $this->browserVersion = 6;
                $this->browserName    = 'MSIE';
                break;
            case strstr($agent, 'msie 7.'):
                $this->browserVersion = 7;
                $this->browserName    = 'MSIE';
                break;
            case strstr($agent, 'msie 8.'):
                $this->browserVersion = 8;
                $this->browserName    = 'MSIE';
                break;
            case strstr($agent, 'firefox/4.'):
                $this->browserVersion = 4;
                $this->browserName    = 'Firefox';
                break;
            case strstr($agent, 'firefox/3.'):
                $this->browserVersion = 3;
                $this->browserName    = 'Firefox';
                break;
            case strstr($agent, 'mobile safari'):
                $this->browserName = 'Mobile Safari';
                break;
            case strstr($agent, 'android'):
                $this->mobileDevice = self::$ANDROID;
                break;
            case strstr($agent, 'iphone'):
                $this->mobileDevice = self::$IPHONE;
                break;
            case strstr($agent, 'ipad'):
                $this->mobileDevice = self::$IPAD;
                break;
            default:
                $this->browserName = 'Other';
                break;
        }
    }


    /**
     * Check if its a minor browser that doesn't support
     * embedded data uris
     *
     * @return bool
     */
    protected function isMinorBrowser()
    {
        if ($this->browserName == 'MSIE' &&
            ($this->browserVersion == 6 || $this->browserVersion == 7 || $this->browserVersion == 8)
        )
        {
            return true;
        }
    }


    /**
     * Checks if current device is mobile
     *
     * @return bool
     */
    protected function isMobile()
    {
        return empty($this->mobileDevice) ? false : true;
    }
}