<?

class CaptchaValidator extends CCaptchaValidator
{
    public function validateC($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : !strcasecmp($input, $code);

        // Следующей строчки кода и не хватает
        // Эта строчка проверяет что запрос на проверку - аякс, и не нужно перегенерировать капчу.

        if (Yii::app()->request->isAjaxRequest)
        {
            return $valid;
        }

        $session = Yii::app()->session;
        $session->open();

        $name = $this->getSessionKey() . 'count';
        $session[$name] = $session[$name] + 1;

        if ($session[$name] > $this->testLimit && $this->testLimit > 0)
        {
            $this->getVerifyCode(true);
        }

        return $valid;
    }
}
