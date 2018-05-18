# SYMFONY BLOG DEMO

# TABLE OF CONTENT

  1. [Requirements](#requirements)
  2. [Vagrant setup](#vagrant)
  3. [Local env setup](#local)
  4. [Getting started](#start)
  5. [Documentation](#docs)
  6. [Screens](#screens)

[![Symfony 3.4](https://img.shields.io/badge/Powered_by-Symfony_3_Framework-green.svg?style=flat)](http://symfony.com/doc/3.4/setup.html)

## <a name="requirements"></a>Requirements

Project general requirements are
* [PHP 7.1+](http://php.net/)
* [MySQL 5.x+](http://www.mysql.com/)
* [Composer](https://getcomposer.org/)

## <a name="vagrant"></a>Vagrant server setup instructions

    This repo comes with a full LAMP server used for development.
    You can use your own development server [setup](#local), but the provided Vagrant server setup is recommended since it
    matches the production server's setup.

### Vagrant requirements

   * [Vagrant 1.9.4](http://www.vagrantup.com/) on Win7+ skip 1.9.5 because of bug.
   * [Virtualbox latest](https://www.virtualbox.org/) or some other Vagrant provider
   * Optional: **NFS share** is activated by default for better performance and must me installed on host machine

### Init Vagrant

    1. Map `symfony-blog-demo.loc` domain to local server's IP `127.0.0.1` using your systems `hosts` file
    2. Clone this repo: `git clone git@github.com:dpotocic/symfony-blog-demo.git`
    3. Run `vagrant up` from project root (symfony-blog-demo) to get the provided Vagrant server up & running

#### Common Vagrant commands

   * `vagrant up` - start server
   * `vagrant halt` - stop server
   * `vagrant ssh` - SSH into server

#### VagrantBox contains

   * Virtual Box Guest Additions 5.1.18
   * Apache httpd 2.4.6
   * MySQL 5.7.18
   * PHP 7.2
   * SSH port is 2222
   * The password of ROOT is: password
   * The password of vagrant is: vagrant
   * The password of ROOT for MySQL is: password

## <a name="local"></a>Local environment setup

    1. Clone this repo: `git clone git@github.com:dpotocic/symfony-blog-demo.git`
    2. Move into newly created directory: `cd symfony-blog-demo/`
    3. Install dependencies using [Composer](https://getcomposer.org/): `composer install`
    4. Create an Apache VirtualHost and `ServerName symfony-blog-demo.loc:8080` and `DocumentRoot` pointing to [`public/`](public/)
    5. Adjust your `hosts` file accordingly

    After cloning the repo and installing Composer dependencies, initialize the app:

    1.


## <a name="start"></a>Getting started

    Your web app is now available:
    * Frontend: http://symfony-blog-demo.loc:8080/
    * Backend: http://symfony-blog-demo.loc:8080/admin
    * Api:
        ** http://symfony-blog-demo.loc:8080/api/blogs
        ** http://symfony-blog-demo.loc:8080/api/blogs/{id}

    Admin account:    admin/admin

## <a name="docs"></a>Swagger API documentation

### Docs

