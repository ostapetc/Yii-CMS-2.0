<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>

    <style type="text/css">
        body {
            background: #EFEFEF;
            color: #555;
            font: normal normal normal 10pt/normal Arial, Helvetica, sans-serif;
            margin: 0px;
            padding: 0px;
        }

        #header {
            border-top: 3px solid #C9E0ED;
            margin: 0px;
            padding: 0px;
        }

        #logo {
            font-size: 200%;
            padding: 10px 20px;
        }

        #page {
            width: 950px;
            background: white;
            border: 1px solid #C9E0ED;
            margin: 5px auto;
        }

        #message {
            padding: 20px;
        }

        #footer {
            border-top: 1px solid #C9E0ED;
            font-size: 0.8em;
            margin: 10px 20px;
            padding: 10px;
            text-align: center;
        }

    </style>
</head>

<body>

<div id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div>

    <div id="message">
        <?php echo Yii::app()->maintenanceMode->message; ?>
    </div>

    <div id="footer">
        <?php echo Yii::powered(); ?>
    </div>

</div>

</body>
</html>