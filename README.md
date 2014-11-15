# litchi

A light-weight & easy-to-learn Model-View-Controller framework built to simplify and speed up the production process of your PHP applications. It takes care of the logic and helps you maintain consistency throughout your projects.

## Installation and setup

### Prerequisites

First off, please make sure that you have the latest node.js (http://nodejs.org/) installed on your machine, as to run litchi's SASS and JS compilation on save, gulp.js (http://gulpjs.com/) is required:

**sudo npm install gulp -g**

To run litchi, you will need an Apache server with PHP 5.4.0+ running.

It is recommended that you use the **git clone** command to install litchi, thus, make sure you have git installed on your machine.

### Installation

To install, use the **git clone** command:

**git clone https://github.com/slavomirvojacek/litchi.git**

All resources should be located in the *www root* of your project. Once done, you are ready to launch litchi in your browser.

To deploy all *.sass* and *.js* assets on filechange you need to install gulp and litchi's dependencies locally. To do this, run the following commands once you have navigated into your *www root* (where *gulpfile.js* is located):

**sudo npm install gulp**

**sudo npm install gulp-ruby-sass gulp-autoprefixer gulp-uglify gulp-concat gulp-notify**

After you have installed gulp and all the dependencies, you are ready to run:

**gulp**

every time you start progress on your project (NOTE: this command watches both assets/css/_src and assets/js/_src files and once it detects a change, it automatically compiles these assets into assets/css and assets/js folders.

## Documentation

### Creating your first litchi application

#### What is MVC?
#### What is Model?
#### What is Controller?
#### What is View?

### Deploying your application

#### Application Assets and Dependencies