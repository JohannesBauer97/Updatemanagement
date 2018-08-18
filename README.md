# Updatemanagement

The update management is a German PHP web application in which projects can be created and different versions of the projects can be offered for download. The goal is to provide an interface for application updates.

![Frontend](https://github.com/Waterfront97/Updatemanagement/blob/master/screenshots/2018-08-18_13h29_26.png)
[More Screenshots](https://github.com/Waterfront97/Updatemanagement/tree/master/screenshots)

## Features

* User System
* Multiple projects per user
* Version history with rollback

## Installation

A web server with PHP and MySQL access is required for the installation.
The web server focus (DocumentRoot for Apache) must be placed on the frontend folder.

1. Import the database `updatemanagement.sql`
2. Set Apache2 DocumentRoot to the `frontend` dir
3. Setup database config in `backend/Config.php
4. Replace hard coded file pathes in code with your pathes ;P

## License

Licensed under the MIT License.
