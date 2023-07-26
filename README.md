1. clone the project: https://github.com/priyankamackwan/document-management.git

2. Run cp .env.example .env file to copy example file to .env
Then edit your .env file with DB credentials and other settings.

3. Run composer install command

4. Run php artisan migrate --seed command.
Notice: seed is important, because it will create the first admin user for you.

5. Run php artisan key:generate command.

6. Run php artisan storage:link command.

7. And that's it, go to your domain and login:
Username:	admin@admin.com
Password:	password

=====================================================================================================================

TO RUN API ENDPOINTS FOLLOW THESE STEPS

1. Run php artisan passport:install

2. Run php artisan passport:client --password
Note down Client ID and Password you got from this command
in our case use below values
client-id = 3
client-secret = WuGK8znJ6fvGndKRb8OdUXaXNgHoQQUiXeILxlfj

3. Get access token. Make below api call in postman
url: http://127.0.0.1:8000/oauth/token //replace http://127.0.0.1:8000 with your domain
type: POST
Form data:
	'grant_type' => 'password',
	'client_id' => 'client-id', // Client ID from passport:client above.
	'client_secret' => 'client-secret', // Client Secret from passport:client above
	'username' => 'admin@admin.com', // username and password are email and password of actual DB user
	'password' => 'password', 
	'scope' => '', // empty in our case

You will get ACCESS_TOKEN in this API call return. Note down that

3. Make api endpoint in postman to get document types
url: http://127.0.0.1:8000/api/v1/document-types
type: GET
header: Authorization => Bearer ACCESS_TOKEN //place ACCESS_TOKEN here that you got from above API

// local client key
1
c0ZDnDomfL2mbNQGoefnuJlto2v95GL4pL0Je4c0
2
d2xTXcuCwetfYsa7mzwLd3XcYunOSZ4ZIhvJrEIo

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
