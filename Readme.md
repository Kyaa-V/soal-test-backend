
# Project Test - Backend Developer

dibawah ini pertama kali untuk melakukan setup di project ini



## Authors

- [@Kyaa-V](https://www.github.com/Kyaa-V)


## Installation

Install my-project with git clone

```bash
  git clone https://github.com/Kyaa-V/soal-test-backend.git
  cd soal-test-backend
```

Sebelum Lanjut ke tahap selanjutnya buat file `.env` di dalam folder `test-backend` copy file `.env.example` tempel ke file `.env`

pastikan konfigurasi Redis dan Koneksi Mysql sama dengan file `.env` di root project 
## Environment Variables

To run this project, you will need to add the following environment variables to your `.env` file

`DB_CONNECTION`
`DB_HOST`
`DB_PORT`
`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`
`DB_CONNECTION`
`DB_HOST`
`DB_PORT`
`DB_DATABASE`
`DB_USERNAME`
`DB_PASSWORD`

pastikan konfigurasi atas sama dengan konfigurasi .env di root project jika anda memulai menggunakan `docker`
## Konfigurasi

pertama jalankan MYSQL anda atau yang lain 
jika tidak punya MYSQL jalankan MYSQL yang ada di container dengan 

```bash
  docker-compose -f compose.dev.yml up -d --build mysql
```

jangan lupa konfigurasi `user` `password` nya di file test-backend laravel dengan file `.env` di root project

Jika anda memulai tanpa `docker` jalankan perintah ini

```bash
  cd test-backend
  composer install
  composer update
  php artisan key:generate
  php artisan migrate
  php artisan serve
```
jika anda mendapatkan error saat menginstall `composer install` hapus `"laravel/horizon": "*",` di `composer.json` jalankan ulang perintah `composer install` dst

jika anda ingin menggunakan docker tinggal jalankan perintah ini dan tunngu sekitar 10 - 15 menit

```bash
  docker-compose -f compose.dev.yml up -d --build
```

jika gagal me running container jalankan ini

```bash
  docker-compose -f compose.dev.yml restart
```

untuk melihat logs dari laravel menggunakan perintah ini

```bash
  docker logs -f test-laravel 
```
<!-- ## Running Tests

untuk testing aplikasi kamu bisa menggunakan k6 untuk load tesing yang sudah disediakan di container docker

```bash
  k6 run k6/k6-test.js
```

jika anda mengalami error install k6 dulu di pc anda karena k6 berjalan secara global -->

## API Reference
  anda bisa melihat route di laravel dengan perintah
```bash
  php artisan route:list
```

```bash
  GET|HEAD   / ............................................................................................................. 
  GET|HEAD   api/health .................................................................................................... 
  GET|HEAD   api/user ...................................................................................................... 
  POST       api/v1/forgot-password ..................................................... Auth\AuthController@forgotPassword
  GET|HEAD   api/v1/item/get-all-item ...................................................... Item\ItemController@getAllItems
  GET        api/v1/item/get-item ......................................................... Item\ItemController@getOrderItem
  POST       api/v1/login ........................................................................ Auth\AuthController@login
  POST       api/v1/logout ...................................................................... Auth\AuthController@logout
  POST       api/v1/order/create-order ................................................... Order\OrderController@createOrder
  POST       api/v1/order/create-order-item ......................................... Order\OrderController@createOrderItems
  GET|HEAD   api/v1/order/get-all-order-item ........................................ Order\OrderController@getAllOrderitems
  POST       api/v1/register .................................................................. Auth\AuthController@register
  POST       api/v1/vendor/create-vendor .............................................. Vendor\VendorController@createVendor
  GET|HEAD   api/v1/vendor/get-all-vendors ........................................... Vendor\VendorController@getAllVendors

```


untuk sekarang kamu hanya fokus ke route
```bash
  POST       api/v1/register .................................................................. Auth\AuthController@register
  POST       api/v1/login ........................................................................ Auth\AuthController@login
  POST       api/v1/vendor/create-vendor .............................................. Vendor\VendorController@createVendor
  GET|HEAD   api/v1/vendor/get-all-vendors ..........................
  POST       api/v1/order/create-order ................................................... Order\OrderController@createOrder
  POST       api/v1/order/create-order-item ......................................... Order\OrderController@createOrderItems
  GET|HEAD   api/v1/order/get-all-order-item ........................................ Order\OrderController@getAllOrderitems
  GET|HEAD   api/v1/item/get-all-item ...................................................... Item\ItemController@getAllItems
  GET        api/v1/item/get-item ......................................................... Item\ItemController@getOrderItem
```
## Usage/Examples

url `http://localhost:8000/api/v1/...`

#### POST /api/v1/register

```json
  {
    "name" : "karina1",
    "email": "karina1@gmail.com",
    "password": "rahasiaku"
}
```
#### POST /api/v1/login

```json
  {
    "email": "karina1@gmail.com",
    "password": "rahasiaku"
}
```
#### POST api/v1/vendor/create-vendor

```json
  No required langsung jalankan API
```
#### POST api/v1/order/create-order
```json
  {
    "total_order" : 100000 
}

```
#### POST api/v1/order/create-order-item
```json
{
    "id_order": 1,
    "items": [
        {
            "id_item": 1,
            "jumlah_item": 2,
            "harga_item": 50000
        },
        {
            "id_item": 2,
            "jumlah_item": 1,
            "harga_item": 50000
        }
    ]
}
```

untuk METHOD `GET` seperti biasa 

untuk `get-item` tambahan `order=DESC

`GET api/v1/item/get-item?order=DESC`


## Tech Stack

**Server:** Laravel

**Databases:** MYSQL

**Load Testing:** K6, REDIS


## Support

For support, email fake@fake.com or join our Slack channel.

