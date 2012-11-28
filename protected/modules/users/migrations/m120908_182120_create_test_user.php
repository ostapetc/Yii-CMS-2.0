<?php

class m120908_182120_create_test_user extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO `users` (`id`, `name`, `email`, `password`, `birthdate`, `gender`, `status`, `photo`, `about_self`, `rating`, `activate_code`, `activate_date`, `password_recover_code`, `password_recover_date`, `date_create`) VALUES
            (1, 'Test user', 'test@mail.ru', '\$2a\$12\$mA1YtUOYgwT1NYht1EVtduH6mXinA2fqSpT9jdNppUnOrp2LmA79.', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:17'),
            (2, 'Test2 user', 'test2@mail.ru', '\$2a\$12\$X.9vCmnp24DVd3kAC4Hze.yrAz258w1laM4twz.ZH6B.NN8ivefNC', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:18'),
            (10, 'Test user 10', 'tes10t@mail.ru', '\$2a\$12\$mGrWYPMz34/nyFje81YBE.mVu4s.fGlS7mFswdCGx3Alt0VpffisC', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:19'),
            (11, 'Test user 11', 'tes11t@mail.ru', '\$2a\$12\$xPS/3rerzgV3e1FQ4CjUbewnII588yBDKudAHSpE42TQO8jSGUcBO', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:19'),
            (12, 'Test user 12', 'tes12t@mail.ru', '\$2a\$12\$kzbdl2cfmZr0pKXX82I4juenObPu9hwJL58vnBc8WMp4J3MSAZY6i', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:19'),
            (13, 'Test user 13', 'tes13t@mail.ru', '\$2a\$12\$Lqa7dApwpXG2RQHpJkAtqOZ7xz9GctW.gzNGob7EAjdLAhtQ/tToa', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:20'),
            (14, 'Test user 14', 'tes14t@mail.ru', '\$2a\$12\$VjdzbMKoeHiqdkK2tgk6TOEZnVxMhUXCfLgwztPQ1U5omz3L01o5y', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:20'),
            (15, 'Test user 15', 'tes15t@mail.ru', '\$2a\$12\$mAqhyYqSQkWohy5Gg9FEdeYsEeuhWqBaiOB1UER1iuMB9yZDorPnK', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:20'),
            (16, 'Test user 16', 'tes16t@mail.ru', '\$2a\$12\$9RsoSWNe26AJRE95y9HNEuAwKkFSCvoB0jHYWDHhvCZj6ik4f1vHe', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:21'),
            (17, 'Test user 17', 'tes17t@mail.ru', '\$2a\$12\$50UZnLp1TjJIGuaFpxp8suSoM08mIkfZpTys/E2zFXYDnGLclTtvG', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:21'),
            (18, 'Test user 18', 'tes18t@mail.ru', '\$2a\$12\$Ga0zOjaIh4Y1qBbTdfYaHOueYVtuT7hg2mZEqkCwHOlJ5mWjQwjQC', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:21'),
            (19, 'Test user 19', 'tes19t@mail.ru', '\$2a\$12\$lH9fX02a0Sw4BJwmIrEcpus2yY6Sl7D//UptncbsEBEaDQxCoui.y', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:22'),
                (20, 'Test user 20', 'tes20t@mail.ru', '\$2a\$12\$88OyiDRsTxLRMHSqFqm2TeauTmPnUx4SWKT3RQ0sCIG7S63IzlIFq', NULL, NULL, 'active', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2012-10-17 09:21:22'),
            (555, 'Robot', 'robot@factory.com', 'Robot', '1900-01-01', 'man', 'blocked', NULL, '', 0, NULL, NULL, NULL, NULL, '2012-10-22 11:56:24');

        ");
	}


	public function down()
	{
		echo "m120908_182118_create_test_user does not support migration down.\n";
		return false;
	}
}