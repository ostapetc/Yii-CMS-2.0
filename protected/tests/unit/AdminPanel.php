<?php

class AdminPanel extends CTestCase
{
    public function testAllPages()
    {
        $content = file_get_contents(TEST_BASE_URL . '/banners/bannerAdmin/manage?testing=');

        var_dump(preg_match('|CDbException|', $content));
        $this->assertFalse((bool) preg_match('|CDbException|', $content));
    }
}
