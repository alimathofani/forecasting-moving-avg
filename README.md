# Forecasting Moving Average

This is ScriptSweets

##### 1. Clone this project from git and install dependencies:
```sh
# clone repo
git clone https://github.com/alimathofani/forecasting-moving-avg.git

# masuk kedalam foldernya
cd forecasting-moving-avg 

# install dependencies
composer install 
```
##### Prepare the .env file:
```sh
# copy config
cp .env.example .env
```
##### Set-up encripted key:
```sh
# generate the key 
php artisan key:generate
```
##### Set-up database:
```sh
### buka .env untuk konfigurasi
APP_NAME="Forecasting Moving Average"  # masukan judul programnya
DB_DATABASE=forecasting                # nama database
DB_USERNAME=root                       # username database
DB_PASSWORD=                           # password if required

# migration
php artisan migrate --seed
```

##### Start the service:
```sh
# run server
php artisan serve # akses di domain 
```
access link <http://127.0.0.1:8000>


##### Note *
` # ` tanda ini untuk command prompt

` ### `tanda ini untuk isian config 

User Login
```sh
# Owner Role
Email : owner@gmail.com
password : secret

# Admin Role
Email : admin@gmail.com
password : secret

# sales Role
Email : sales@gmail.com
password : secret
```

