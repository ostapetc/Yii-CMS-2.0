<?php

class AdminPanelTest extends WebTestCase
{
    public function testAllPages()
    {
        $this->loginAdmin();

        $modules = AppManager::getModulesData();
        foreach ($modules as $module)
        {
            if (!$module["admin_menu"])
            {
                continue;
            }

            foreach ($module["admin_menu"] as $title => $url)
            {
                $this->open($url);
                $this->assertFalse($this->isTextPresent('Error'), "Error on page " . $url);
                $this->assertFalse($this->isTextPresent('Exception'), "Exception on page " . $url);
                $this->assertElementNotPresent('//body[@jserror]', "Javascript error on page " . $url);
            }
        }
    }


    public function loginAdmin()
    {
        $this->open('/admin/login');
        $this->type('User_email', 'admin@ya.ru');
        $this->type('User_password', '123456');
        $this->submitAndWait("user-login-form");
    }
}
