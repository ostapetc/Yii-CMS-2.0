<?php

class MailerModule extends WebModule
{	
    const SETTING_LETTERS_PART_COUNT = 'letters_part_count';
    const SETTING_REPLY_ADDRESS      = 'reply_address';
    const SETTING_DISPATCH_TIME      = 'dispatch_time';
    const SETTING_FROM_EMAIL         = 'from_email';
    const SETTING_SIGNATURE          = 'signature';
    const SETTING_FROM_NAME          = 'from_name';   
    const SETTING_ENCODING           = 'encoding';   
    const SETTING_PASSWORD           = 'password';
    const SETTING_TIMEOUT            = 'timeout';
    const SETTING_LOGIN              = 'login'; 
    const SETTING_HOST               = 'host';
    const SETTING_PORT               = 'port';	
	
	
	public static $active = true;


    public static function name()
    {
        return 'Рассылка';
    }


    public static function description()
    {
        return 'Email рассылка';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'mailer.models.*',
			'mailer.components.*',
		));
	}

    public static function adminMenu()
    {
        return array(
        	'Отчеты'            => '/mailer/MailerLetterAdmin/manage',
            'Создать рассылку'  => '/mailer/MailerLetterAdmin/create',
        	'Шаблоны'           => '/mailer/MailerTemplateAdmin/manage',
            'Добавить шаблон'   => '/mailer/MailerTemplateAdmin/create',
            'Генерируемые поля' => '/mailer/MailerFieldAdmin/manage',
            'Добавить поле'     => '/mailer/MailerFieldAdmin/create',
        );
    }


    public static function sendMail($email_to, $subject, $body, $from_name = null, $from_email = null, $host = null, $port = null, $login = null, $password = null, $encoding = null, $hidden_copy = false)
    {
        require_once LIBRARY_PATH . 'PHPMailer_v5.1/class.phpmailer.php';

        $settings = Setting::model()->findCodesValues(self::getShortId());

        $reflection = new ReflectionMethod(__CLASS__, 'sendMail');
        $parameters = (array) $reflection->getParameters();
        $parameters = array_flip(ArrayHelper::extract($parameters, 'name'));

        foreach ($parameters as $name => $value)
        {
            $value = $$name;

            if (is_null($value) && isset($settings[$name]))
            {
                $value = $settings[$name];
            }

            $parameters[$name] = $value;
        }

        $inner_encoding = "UTF-8";

        $encoding = $parameters["encoding"];

        $subject = iconv($inner_encoding, "{$encoding}//IGNORE", $parameters["subject"]);

        $from_name  = iconv($inner_encoding, "{$encoding}//IGNORE", $parameters["from_name"]);
        $from_email = iconv($inner_encoding, "{$encoding}//IGNORE", $parameters["from_email"]);

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet       = $encoding;
        $mail->SMTPDebug     = 1;
        $mail->Host          = $parameters["host"];
        $mail->SMTPAuth      = true;
        $mail->SMTPKeepAlive = true;
        $mail->Port          = $parameters["port"];
        $mail->Username      = $parameters["login"];
        $mail->Password      = $parameters["password"];

        try
        {
            $mail->AddReplyTo($from_email, $from_name);

            $add_address_method = $hidden_copy ? 'AddBCC' : 'AddAddress';

            $email_to = $parameters["email_to"];

            if (is_array($email_to))
            {
                foreach ($email_to as $ind => $email)
                {
                    $mail->$add_address_method($email, $email);
                }
            }
            else
            {
                $mail->$add_address_method($email_to, $email_to);
            }

            $mail->SetFrom($from_email, $from_name);
            $mail->Subject = "=?koi8-r?B?".base64_encode($subject)."?=";
            $mail->MsgHTML(iconv($inner_encoding,"{$encoding}//IGNORE", $body));
            $mail->Send();

            return true;
        }
        catch (phpmailerException $e)
        {
            echo $e->errorMessage();
            $mail->SmtpClose();
            $mail->SmtpConnect();
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }

        $mail->ClearAttachments();
        $mail->ClearBCCs();
        $mail->ClearAddresses();
    }

    public static function getShortId()
    {
        return strtolower(str_replace('Module', '', get_called_class()));
    }

}
