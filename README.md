# Sample PrestaShop module checkboform

## About

This module give some example to integrate Symfony and PrestaShop form type with modern tools.

This project is usefull to understand all tickets mentionned on https://github.com/PrestaShop/PrestaShop/issues/19537

## Module version guide

| PrestaShop version | Module version |  Repo               | Doc                |  PHP Version |
|--------------------|----------------|---------------------|--------------------|--------------|
|  1.7.7             | 1.0.0          |  [develop]          |                    |   7.1 or greater    |

## Requirements

PHP version (check Module version guide)


## Installation

To install this module on PrestaShop, download zip package form [product page on PrestaShop Addons][addons].

This module contain composer.json file. If you clone or download the module from github
repository, run the ```composer install``` from the root module folder.

See the [composer documentation][composer-doc] to learn more about the composer.json file.


## Compiling assets
**For development**

We use _Webpack_ to compile our javascript and scss files.
In order to compile those files, you must :
1. have _Node 10+_ installed locally
2. run `npm install` in the root folder to install dependencies
3. then run `npm run watch` to compile assets and watch for file changes

**For production**

Run `npm run build` to compile for production.
Files are minified, `console.log` and comments dropped.

## Contributing

PrestaShop modules are open-source extensions to the PrestaShop e-commerce solution. Everyone is welcome and even encouraged to contribute with their own improvements.


### Requirements

Contributors **must** follow the following rules:

* **Make your Pull Request on the "develop" branch**, NOT the "master" branch.
* Do not update the module's version number.
* Follow [the coding standards][1].

### Process in details

Contributors wishing to edit a module's files should follow the following process:

1. Create your GitHub account, if you do not have one already.
2. Fork the stripe_offical project to your GitHub account.
3. Clone your fork to your local machine in the ```/modules``` directory of your PrestaShop installation.
4. Create a branch in your local clone of the module for your changes.
5. Change the files in your branch. Be sure to follow [the coding standards][1]!
6. Push your changed branch to your fork in your GitHub account.
7. Create a pull request for your changes **on the _'develop'_ branch** of the module's project. Be sure to follow [the commit message norm][2] in your pull request. If you need help to make a pull request, read the [Github help page about creating pull requests][3].
8. Wait for one of the core developers either to include your change in the codebase, or to comment on possible improvements you should make to your code.

That's it: you have contributed to this open-source project! Congratulations!

[1]: https://devdocs.prestashop.com/1.7/development/coding-standards/
[2]: http://doc.prestashop.com/display/PS16/How+to+write+a+commit+message
[3]: https://help.github.com/articles/using-pull-requests
[4]: https://support.stripe.com/questions/upgrade-your-stripe-integration-from-tls-1-0-to-tls-1-2
[composer-doc]: https://getcomposer.org/doc/04-schema.md
