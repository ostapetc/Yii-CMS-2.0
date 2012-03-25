<?php
/**
* EGoogleAnalyticsWidget class file
* 
* @author Vitaliy Stepanenko <mail@vitaliy.in>
* @author Vitaliy Mashkov 
* @version 1.0.1
* @license BSD
* @created 08.11.2010
* @modifieded 22.11.2010 - Vitaliy Mashkov
* @modified 30.11.2010 - Vitaliy Stepanenko 
*/

/**
* =====Yii GoogleAnalytics widget=====
* 
* ===Usage:===
* Just place:
* <?$this->widget('ext.widgets.googleAnalytics.EGoogleAnalyticsWidget',
* 		array('account'=>'XX-XXXXXXX-XX','domainName'=>'.example.com')
* );
* ?>
* 
* ===TODO:===
* Add ecommerce tracking  (http://code.google.com/intl/ru-RU/apis/analytics/docs/tracking/gaTrackingEcommerce.html)
* 
*/
class EGoogleAnalyticsWidget extends CWidget {
    
	/**
	* Additional search systems
	* 
	* @var array('domainName'=>'queryParameter')
	*/
	public $searchSystems = array(
    	'mail.ru'=>'q',
		'rambler.ru'=>'words',
		'nigma.ru'=>'s',
		'aport.ru'=>'r',
		'blogs.yandex.ru'=>'text',
		'meta.ua'=>'q',
		'bigmir.net'=>'q',
		'i.ua'=>'q',
		'online.ua'=>'q',
		'ukr.net'=>'search_query',
		'liveinternet.ru'=>'q',
		'search.ua'=>'query',
    );
	
    /**
    * Google Analytics account Id (example: 'UA-7106016-38') 
    * 
    * @var string
    */
    public $account;
    
    /**
     * Current domain name (example: '.example.com' adding all sub-domains in domain example.com)
     * @var string
     */
    public $domainName = "";
    
    /**
     * Adding search systems filter
     * Default added Ukranian and Russian search systems:  
     *  - mail.ru 
     *  - rambler.ru
     *  - nigma.ru
     *  - aport.ru
     *  - blogs.yandex.ru
     *  - meta.ua
     *  - bigmir.net
     *  - i.ua
     *  - online.ua
     *  - ukr.net
     *  - liveinternet.ru
     *  - search.ua
     * 
     * @var array
     */    
    
    public function run() {
    	$gaq = "";    	
    	if (!empty($this->searchSystems)){   
    		
    		if (!is_array($this->searchSystems)){
				throw new Exception('Additional search systems in GoogleAnalytics widget must be specified as array(\'domainName\'=>\'queryParameter\')');	
    		} 		
    		
    		foreach ($this->searchSystems as $domain=>$queryParametr){    			
    			$gaq .= "_gaq.push(['_addOrganic','$domain', '$queryParametr']);\n";
    		}
    	}
    	if (!empty($this->domainName)){
    		$gaq .= "_gaq.push(['_setDomainName','$this->domainName']);\n";
    	}
        Yii::app()->clientScript->registerScript('GoogleAnalytics',
            "
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '$this->account']);
            $gaq
            _gaq.push(['_setAllowHash', false]);
            _gaq.push(['_setAllowLinker', true]); 
			_gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();                
            "    
            ,CClientScript::POS_END
        );   
        
    }
}