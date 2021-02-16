<?php 

namespace  App\Tests\acceptance;

use AcceptanceTester;

class ProductPageCest
{
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Products List');
    }
}
