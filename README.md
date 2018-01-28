# Symfony Step By Step Tutorial

This repository is linked to [this course](https://docs.google.com/presentation/d/1ZhjHsnr5ItrDmTUCDQmkaJ3nl1ZQcc6hFhSYKhpo0wE/edit?usp=sharing "presentation"). 
Feel free to contribute.

## requirements

- PHP 7.1
- [composer - PHP dependencies management](https://getcomposer.org/)




## Steps

Each end of steps are linked to a symfony tag. You can checkout the tag you want using:
```bash
$ git fetch --all --tags --prune
$ git checkout tags/step_xxx
$ composer update

```

Where xxx stands for the number of the step.


### Part 1 - Hello World

#### step 101 - installing the project

Install composer if it's not already done.
```bash
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
$ sudo chmod a+x /usr/local/bin/composer
```

Now that composer is installed, you can create your project

```bash
$ composer create-project symfony/skeleton helloWorld
$ cd helloWorld
```

_optional_ if you don't want to install the symfony server, just start,
```bash
$ php -S 127.0.0.1:8000 -t public
```

otherwise install the dev server

```bash
$ composer require server --dev
```

Now go to [http://localhost:8000](http://localhost:8000), if everything is cool you should see: 


![Welcome to Symfony](./tutorial/step_101/welcome.png "Welcome to symfony.")


**From now, don't forget to start the server**
 
#### step 102 - First page

First, you have to create your first Controller. 

Create a class named `App\Controller\HelloWorldController` in `/src/Controller/HelloWorldController.php` extending 
`Symfony\Bundle\FrameworkBundle\Controller\Controller`.

In this class, add a method called `hello`. this method will return a new `Symfony\Component\HttpFoundation\Response` 
object with a string as first argument of the object. 

Your class should look like:
```php
<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HelloWorldController extends Controller
{

    public function hello()
    {
        $name = "World";

        return new Response(
            "<html><body>Hello " . $name . "</body></html>"
        );
    }

}
```
Then, in `config/routes.yaml` add the following lines 

```yaml
# the "app_hello_world" route name is not important yet
app_hello_world:
    path: /hello/world
    controller: App\Controller\HelloWorldController::hello
```

Now go to [http://localhost:8000/hello/world](http://localhost:8000/hello/world) and if everything is good,
you will see: ![Hello World](./tutorial/step_102/hello_world_result.png hello world screenshot)

