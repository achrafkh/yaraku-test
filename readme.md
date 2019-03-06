
### Install : 
- First step after cloning the repo : `composer install`
- Create a database, and the a .env file and write the DB credentials & generate a key `php artisan key:generate` (Make sure you have a valid APP_URL or else Dusk test won't work) 
- Execute `php artisan db:seed`  to seed DB with 1500 book, if that's too much just `php artisan tinker` and paste `factory(\App\Models\Book::class, 50)->create()`
- Visit '/' or /books


### Running Tests : 
- To run unit tests : `php vendor/phpunit/phpunit/phpunit` 
- To run Dusk test (browser) : `php artisan dusk`


### Notes :

- I used Datatables (with server side processing), since i think it's a good solution for such purpose and it's a battle tested library.
- There are two export functions, the first is manual, the second relies on a package.
- The modals part can be Better ( add `.modal-btn` to an a or button, add `data-href` to each and `data-method` & `data-options` to each and then a generic function that listens for clicks on `.modal-btn` will make an ajax call to the backend with the specified data-attributes params which will render the desired modal content (which is more flexible since you can use blade) and then returns the html that will be appended in modal body) but i thought that this is a stretch

- For the font end i used a template that uses bootstrap 4
- I don't think that the test cases are not Solid enough and i might lack experience when it comes to this matter
- In the Notes , you mentioned that user can update Author name, in this code he can update both title & author but it's a simple change, remove title from the form & in the controller only get the author rather than the whole request 
