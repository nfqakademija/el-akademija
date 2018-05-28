<?php


class LectureBoxCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    	$I->amOnPage('/admin/schedule');
		$I->wait(10);
    	$I->waitForElement('#admin-schedule > div');
    	$I->click('#admin-schedule > div > div > div.rbc-toolbar > span:nth-child(1) > button:nth-child(3)');
    	$I->wait(5);
    }
}
