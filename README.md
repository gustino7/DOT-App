# DOT-APP

## Deskripsi Project
Project ini merupakan aplikasi berbasis web yang dibangun menggunakan Laravel 8. Aplikasi ini memungkinkan pengguna untuk mengelola data dosen/lecturer dan mata kuliah/course dengan fitur CRUD (Create, Read, Update, Delete). Selain itu, aplikasi ini dilengkapi dengan otentikasi API menggunakan Laravel Sanctum dan validasi data yang kuat.

## Desain Database
Data lecturer terdiri dari:
    1. ID
    2. Name
    3. Registrasi Number
    4. Phone
    5. Birth

Data course terdiri dari:
    1. ID
    2. Name
    3. Credits
    4. Class

Relasi untuk database tersebut yaitu **one to many**. Dimana lecturer dapat mengajar di banyak kelas. Desain database dapat dilihat di bawah ini:

![DB DOT-app](https://github.com/user-attachments/assets/cd57383e-72c1-4b0b-95f5-cff26ad290c3)

## Dependency
Dependency yang digunakan yaitu :
    - **Laravel 8**
    - **PHP 7.3.9**
    - **My SQL 8.0.30**
    - **Node.js 20.16.0**
    - **Laravel Sanctum**
    - **npm**

## Panduan API
Dokumentasi API dapat dilihat di link https://documenter.getpostman.com/view/25915347/2sAXxP9svn

## Instalasi
Cara instalasi adalah sebagai berikut:
1. Clone repository
```bash
git clone https://github.com/gustino7/DOT-App.git
cd ./DOT-App
```
2. Install Dependency
```bash
composer install
```
3. Copy enviroment file
```bash
cp .env.example .env
```
4. Konfigurasikan database di file .env
5. Migrasi database
```bash
php artisan migrate
```
6. Jalankan aplikasi
```bash
php artisan serve
```
