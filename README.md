# Staff All-In-One App

Intended to use for Inspirazs staff only.

## Installation

Install like always.

```bash
cd directory
git clone https://github.com/muhd-iqbal/staff-app.git
composer install
cp .env.example .env
php artisan key:generate
```

Then create database, edit config in .env and run migration with seeder.
```bash
php artisan migrate --seed
```
Or use existing one.


## Contributing
Pull requests from company's IT person / developer are welcome. 

## License
For internal use only. Heavily catered to the company.
