<?php
/**
 * ESitemapBehavior.php File
 *
 * @package ESitemap
 */

/**
 * Description of ESitemapBehavior
 *
 * @author  Dana Luther <dluther@internationalstudent.com>
 * @version 1.1
 */
class ESitemapBehavior extends CBehavior
{

    /**
     * Populate the array of site links
     *
     * @param array[]         &$list         The array which holds the array of link information: loc, frequency, priority
     * @param ESitemapModel[] $classesConfig Array of class configuration Models
     * @param string          $default_scope The default scope to use if one is not defined in the class. Defaults to 'sitemap'
     *
     * @return array[]
     */
    public function populateSitemap($list, $classes, $default_scope = 'sitemap')
    {
        // Loop through each of the classes, setting the defaults for all models
        // of that type and then setting the specific model attributes into the
        // listing for the class type
        foreach ($classes as $modelType)
        {
            $esm             = new ESitemapModel;
            $esm->attributes = $modelType;
            if (!$esm->validate())
            {
                Yii::log('Impropertly configured sitemap class object: ' .
                    print_r($esm->errors, true), 'warning', 'ext.sitemap.ESitemapBeahvior');
                continue;
                //throw new CException('Improperly configured sitemap class object: '.print_r($esm->errors, true));
            }

            $models = $esm->models;
            foreach ($models as $model)
            {
                $list[] = array(
                    // replace model slugs with model attribute values
                    'loc'      => $esm->loc($model),
                    'frequency'=> $esm->frequency,
                    'priority' => $esm->priority,
                    'title'    => $model->{$esm->title},
                );
            }
        }

        return $list;
    }

}

?>
