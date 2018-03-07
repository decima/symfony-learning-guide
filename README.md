# Symfony Step By Step Tutorial

This repository is linked to [this course (in progress)](https://docs.google.com/presentation/d/1ZhjHsnr5ItrDmTUCDQmkaJ3nl1ZQcc6hFhSYKhpo0wE/edit?usp=sharing "presentation"). 
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
and then start the server using

```bash
$ bin/console server:run
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
you will see: 
![Hello World](./tutorial/step_102/hello_world_result.png "hello world screenshot")

#### Step 103 - Routing

For this step, we will not explain how to manage routing with yaml notations.

First, you will need annotations package.
```bash
$ composer require annotations
```

Now, in routes.yaml, you can remove your config and add in your controller class some annotations :
```php
<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; //add this line to add usage of Route class.

class HelloWorldController extends Controller
{

    /**
     * @Route("/hello/{name}", name="app_hello") //add this comment to annotations
     */
    public function hello($name="World")
    {

        return new Response(
            "<html><body>Hello " . $name . "</body></html>"
        );
    }

}

```

When you go back to [http://localhost:8000/hello/world](http://localhost:8000/hello/world) nothing has changed,
so the changes work.

And more, if you go to [http://localhost:8000/hello/john](http://localhost:8000/hello/john) you will see:

![Hello John](./tutorial/step_103/hello_john_result.png "hello john screenshot")

-------------------------------------------------------------------
#### Step 103.5 - Other controller
**Before next step, You have to create another controller**

The name of the controller should be MainController and implement a method named homeAction pointing on route / 
and named app_home.
This is the content to return.
```html
<!doctype html>
<html>
    <body>
        <h1>Welcome to my website.</h1>
    </body>
</html>
```

#### Step 104 - Twig - Templating
> A template is simply a text file that can generate any text-based format (HTML, XML, CSV, LaTeX ...).
>
>The most familiar type of template is a PHP template - a text file parsed by PHP that contains a mix of text
 and PHP code.
 
Symfony use its own templating language named twig. Next is the difference between a PHP template, and a TWIG template.

```php
<!DOCTYPE html>
<html>
    <head>
        <title>PHP Page</title>
    </head>
    <body>
        <h1><?php echo $page_title ?></h1>

        <table>
            <?php foreach ($items as $key=>$item): ?>
                <tr>
                    <td>
                        <?php echo $key + 1; ?>
                    </td>
                    <td>
                        <?php echo $item; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </body>
</html>

```
is more like:
```twig
<!DOCTYPE html>
<html>
    <head>
        <title>Twig Page</title>
    </head>
    <body>
        <h1>{{ page_title }}</h1>
        <table>
            {% for item in items %}
                <tr>
                    <td>
                        {{ loop.index }}
                    </td>
                    <td>
                        {{ item }}
                    </td>
                </tr>
            {% endfor %}
        </table>
    </body>
</html>
```

To enable Twig support in our project, first add the needed composer package.

```bash
$ composer require twig
```

A `templates` folder has been created with only one file named `base.html.twig`. Let's first have a look at the 
structure of this file.
```twig
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        {% block stylesheets %}{% endblock %}
    </head>
    <body>
        {% block body %}{% endblock %}
        {% block javascripts %}{% endblock %}
    </body>
</html>
```
This template has 4 calls to a *twig function* block. This is one of the main functions in templating.
Their main purpose is to be replaced with other content from sub templates included using extends function.
Without removing this code, we will add a footer between block body and block javascripts. 
```twig
...
        {% block body %}{% endblock %}
        <footer>
            <hr/>
            &copy; YourName
        </footer>
        {% block javascripts %}{% endblock %}
...
```

Next we will create a new template `templates\main\home.html.twig`. 
```twig
{% extends "base.html.twig" %}
{% block body %}
    <h1>Welcome to {{ project_name|upper }}.</h1>
{% endblock %}
```

Then modify your homeAction from MainController to look like this : 
```php
...
 /**
  * @Route("/", name="app_home")
  */
 public function homeAction()
    {
        return $this->render("main/home.html.twig", ["project_name" => "yourProject"]);
        
    }
...
```

or if you want less code in your action method, you can do it as :
```php
...
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
...
 
 
    /**
     * @Route("/", name="app_home")
     * @Template("main/home.html.twig")
     */
    public function homeAction()
    {
        return ["project_name" => "yourProject"];
    }

```
Now go to [localhost:8000](http://localhost:8000/) and you can see your project name and the footer previously added.

With the help of extend you have extended the base template and replaced the body block. 

More details on what you can do with twig can be find on [the documentation](https://twig.symfony.com/doc/2.x/)


#### Step 104.5 - Other template
Now your turn. First add a menu to switch between pages using the twig "path function" and then add a template for 
helloAction in HelloWorldController.

### Part 2 - Forms and Data
In the next part, we will handle data.

#### Step 201 - Forms
First install the Symfony Flex formula 
```
composer require form
```

Now let's begin by creating a new Controller named ProductController.
You can add a route annotation on a controller and this route will prefix the whole controller.
For this, simple add on the top of your class.
```
/**
 * @Route("/product")
 */
```
And then in your ProductController, create a route named add, on path `/product/add`,
name it `product.add` and make it render a template `product/add.html.twig` witch
extends `base.html.twig`. The add method should have a Request parameter. 

In your add Method add:
```php
$form = $this->createFormBuilder()
    ->add("name", TextType::class)
    ->add("releaseOn", DateType::class, [
        "widget" => "single_text"
    ])
    ->add("save", SubmitType::class, ["label" => "create Product"])
    ->getForm();
    
return ["form" => $form->createView()];
```


Now in your twig add the following lines in you body block
```twig
{% extends "base.html.twig" %}
{% block body %}
    {{ form(form) }}
{% endblock %}
```

You can check now on [localhost:8000/product/add](http://localhost:8000/product/add).

We will customize the form now.  You can generate form line by line using 
```twig
    {{ form_start(form) }}
    {{ form_row(form.name) }}
    {{ form_row(form.releaseOn) }}
    {{ form_end(form) }}
```
the form_end will generate the missing fields. You can either generate more specific:
```twig
    <div>
    {{ form_label(form.name) }}
    {{ form_errors(form.name) }}
    {{ form_widget(form.name) }}
    </div>
```

this will generate 
```html
    <div>
        <label for="form_name">Name</label>
        <ul>
            <li>This field is required</li>
        </ul>
        <input type="text" id="form_name" name="form[name]" />
    </div>
```

You can also add theme to your form. You can create it yourself or use predefined themes:
- form_div_layout.html.twig 
- form_table_layout.html.twig
- bootstrap_3_layout.html.twig
- bootstrap_3_horizontal_layout.html.twig
- bootstrap_4_layout.html.twig
- bootstrap_4_horizontal_layout.html.twig
- foundation_5_layout.html.twig

You can select your theme directly inside your twig file : 
```twig
{% form_theme form 'bootstrap_4_layout.html.twig' %}
```
Or add it to the global twig configuration.
```yaml
#config/twig.yaml
twig:
    form_themes: ['bootstrap_4_layout.html.twig']
```
For the next step we will use the global twig configuration and add bootstrap_4_layout.
Don't forget to add bootstrap 4 in your project.
your form should now have changed and be bootstrap style.

#### Step 201.5 - The varDumper Component

For the next steps, we will add debug tools for symfony: 
```bash
composer require debug

```

This bundle offers a set of useful functions:

- the `dump` function, an alternative to `var_dump` and `print_r`. With its twig function. 
- The debug toolbar.

#### Step 202 - Handle data

Now we will handle the form post.
first change the add method to handle the request.

```php
$result = [];
$form->handleRequest($request);
if ($form->isValid() && $form->isSubmitted()) {
    $result = $form->getData();
}
return ["form" => $form->createView(), "result" => $result];
```

In this first version, we will just show the result of the form in twig. In your add.html.twig add `{{ dump(result) }}`.

Now try to post again your form and you will see the dump output.

We will save the data later. 



#### Step 203 - Doctrine - Configuration

Doctrine Project is a set of PHP libraries primarily focused on providing persistence services and related functionality. The two main projects are the Object Relationship Mapper (ORM) and the Database Abstraction Layer (DBAL).


Symfony was shipped with Doctrine until version 3.4. But Since version 4, it is shipped separately, but can be added simply using flex formula.

First, install Doctrine, as well as the MakerBundle, which will help generate some code:

```bash
composer require doctrine maker
```

Now in your .env file you can see a line.
```
# to use mysql: 
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

# to use sqlite:
DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"
```
Now you can create your database it the database doesn't exists using
```bash
php bin/console doctrine:database:create
```

#### Step 204 - Doctrine - Entity

Doctrine works with entities. An Entity is an object linked to a database row.

First we will create an Entity linked to Product. 
```bash
 php bin/console make:entity Product
```
A new file has been create in `src/Entity/Product.php`.
```php
<?php

namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
 
    // add your own fields
}
 
```

Now we will add the fields from our previously created form.
```php
/**
 * @ORM\Column(type="text", length=255)
 */
private $name;

/**
 * @ORM\Column(type="datetime")
 */
private $releaseOn;

```

Add also the getters and the setters for the two new fields and a getter for the id field.
Now Doctrine is ready to handle your database but the database itself is not created. execute the following line : 
```bash
 php bin/console doctrine:migrations:diff
```
it will create a new migrations file in `src/Migrations`.
Then to run the migration use
```bash
 php bin/console doctrine:migrations:migrate
```

Now in your ProductController you will create a set of routes: 

 - /product/all => function all() with a all.html.twig
 - /product/show/{product} => function show(Product $product) with a show.html.twig
 - /product/update/{product} => function update(Product $product) with a update.html.twig
 - /product/delete/{product} => function delete(Product $product)


in your all method add the following code:
```php
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        return ["products" => $products];

```
and point to the following twig
```php
{% extends "base.html.twig" %}
{% block body %}
    <a href="{{ url("product.add") }}">Add</a>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Release On</th>
            <th>Action</th>
        </tr>
        {% for product in products %}
            <tr>
                <td>{{ product.name }}</td>
                <td>{{ product.releaseOn|date }}</td>
                <td>
                    <a onclick="return confirm('are you sure?');" href="{{ url("product.delete", {"product":product.id}) }}">Delete</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan="3">No content available</td>
            </tr>
        {% endfor %}
    </table>
{% endblock %}
```

In your delete method add the following code:
```php
$em = $this->getDoctrine()->getManager();
$em->remove($product);
$em->flush();
return $this->redirectToRoute("product.all");
```

And update your add method the following:
```php
$product = new Product();
$form = $this->createFormBuilder($product)
    ->add("name", TextType::class)
    ->add("releaseOn", DateType::class, [
        "widget" => "single_text"
    ])
    ->add("save", SubmitType::class, ["label" => "create Product"])
    ->getForm();
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
    $em = $this->getDoctrine()->getManager();

    $em->persist($product);
    $em->flush();
    return $this->redirectToRoute("product.all");

}

return ["form" => $form->createView()];
```
Then go to /product/all and have a look at the result.

You have now to implement the code for the show and update methods. 

### Part 3 - Security
In the new part, we will handle security.

Security is composed of 4 parts.

 - providers      : Users definition
 - encoders       : How to encode users and passwords
 - firewalls      : Bases access and authentications
 - access_control : limit access to certain roles and pages

In the next steps you will set up each steps one by one.

First thing to do is to add the `security` composer package.

#### Step 301 - Encoders

First, we will create a User entity linked to a table 
```sql
    users(
        id:       integer, 
        username: string(255), 
        email:    string(255),
        password: string(255),
        roles:    json_array
    )
```
Your entity should implements `Symfony\Component\Security\Core\User\UserInterface` interface. Implement now the getters/setters for each fields and the requested fields by the interface. In the getSalt() method, just return `null`. Leave the eraseCredentials method empty for now. Add two more methods :
```php
    public function addRole($role) {
        $this->roles[] = $role;
    }
    
    public function removeRole($role) {
        $index = array_search($role, $this->roles, true);
        if ($index !== false) {
            array_splice($this->roles, $index, 1);
        }
    }
```

This is the definition of your user. create a migration and execute it. 

Then edit your security.yaml adding :
```yaml
security:
    # ...
    encoders:
        App\Entity\User:
            algorithm: bcrypt
```

The encoder specify how the user class is encrypted.
















