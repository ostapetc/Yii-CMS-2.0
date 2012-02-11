<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php foreach($list as $row): ?>
        <url>
        <loc><?php echo CHtml::encode($row['loc']); ?></loc>
        <changefreq><?php echo $row['frequency']?></changefreq>
        <priority><?php echo $row['priority'];?></priority>
        </url>
<?php endforeach; ?>

</urlset>
