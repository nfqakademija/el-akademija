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
    	$I->amOnPage('/schedule');
    	$I->waitForElement('#schedule > div');

    	$menesiai = [
    		'01' => 'Sausis',
    		'02' => 'Vasaris',
    		'03' => 'Kovas',
    		'04' => 'Balandis',
    		'05' => 'Gegužė',
    		'06' => 'Birželis',
    		'07' => 'Liepa',
    		'08' => 'Rugpjūtis',
    		'09' => 'Rugsėjis',
    		'10' => 'Spalis',
    		'11' => 'Lapkritis',
    		'12' => 'Gruodis'
		];
    	$menuo = $menesiai[date('m')];

    	$I->see($menuo . ' ' . date('Y'), '#schedule > div > div > div.rbc-toolbar > span.rbc-toolbar-label');
    }
}
