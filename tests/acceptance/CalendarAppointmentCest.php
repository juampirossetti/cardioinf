<?php


class CalendarAppointmentCest
{
    public function _before(\AcceptanceTester $I)
    {
        
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests\Step\Acceptance\
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantTo('login to the site with role secretary');
        $I->amOnPage('/');
        $I->wait(5);
        $I->seeElement('#navigation');
    }
}
