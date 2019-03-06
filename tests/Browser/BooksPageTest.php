<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BooksPageTest extends DuskTestCase
{
    use WithFaker;

    public function testVisitPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/books')->assertSee('Books');
        });
    }

    public function testAddBookValidInput()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/books')
                ->waitUntilMissing('.dimmer.active')
                ->click('#addBook')
                ->waitForText('Add new Book')
                ->type('title', $this->faker->sentence(rand(5, 10), $variableNbWords = true))
                ->type('author', $this->faker->name)
                ->press('Save')
                ->waitForText('Done!')
                ->assertSee('Book Created!');
        });
    }

    public function testAddBookInValidInput()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/books')
                ->waitUntilMissing('.dimmer.active')
                ->click('#addBook')
                ->waitForText('Add new Book')
                ->type('title', 'a')
                ->type('author', 'a')
                ->press('Save')
                ->waitForText('The title must be at least 3 characters.')
                ->assertSee('The title must be at least 3 characters.')
                ->assertSee('The author must be at least 2 characters.')
                ->click('.dismiss')
                ->assertSee('Books');
        });
    }

}
