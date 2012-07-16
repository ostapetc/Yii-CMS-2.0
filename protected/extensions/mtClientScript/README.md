#mintao ClientScript

Script to combine and shrink js and css files.
Using **Google's closure compiler** for js and **Yahoo's YUI compressor** for css files
It's mandatory to have java available

#Usage
Put *mtClientScript* into your extensions folder. To enable it, make this addition to your configuration file:

<pre>
'components' => array(
    ...
    'clientScript' =>array(
        'class' => 'ext.mtClientScript.mtClientScript',
    ),
    ...
),
</pre>

This is the minimal configuration.

You also can define your Java-, YUI compressor- and Google Closure path:

<pre>
'components' => array(
    ...
    'clientScript' =>array(
        'class' => 'ext.mtClientScript.mtClientScript',
        'javaPath' => 'path/to/your/java',
        'yuicPath' => 'path/to/your/yui/compressor.jar',
        'closurePath' => 'path/to/your/closure/compiler.jar',
        'closureConfig' => 'WHITESPACE_ONLY' | 'SIMPLE_OPTIMIZATIONS' | 'ADVANCED_OPTIMIZATIONS',
    ),
    ...
),
</pre>


#ATTENTION:
* Java must be installed
* Always use **relative paths** in your javascript and css files because the location will be replaced (eg. *background:url(../icon.png)*).
* Ensure, that your **protected/runtime directory is writable** (as it always should be)