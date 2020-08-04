# 3D-Printer-Scheduler-System

## 📅 About The Project
Created a new web application to schedule 3D printing events, add/update printers and accounts, and capture statistics about printing jobs for Technology Sandbox.

Pervious web application: [Website](https://sandbox-ui.firebaseapp.com/) and [Github Link](https://github.com/wittechsandbox/printer-queue)

## 🎨 Features
* Separate public and administrative interfaces
* A responsive, intuitive, and user-friendly front-end designed with Bootstrap 4
* Create, read, update, and delete (CRUD) operations for managing accounts, printers, and events
* Autocomplete form input fields using JQuery, AJAX, and PHP
* Enabled DataTable Server-side processing to handle large dataset efficiently
* Combined front-end and back-end validations to improve user experiences while maintaining data security. 
* Enhanced password security by encrypting password column in MySQL database

## 🔧 Built With
* Languages
    * HTML
    * CSS
    * JavaScript
    * PHP
    * SQL
* Libraries
    * [Bootstrap 4](https://getbootstrap.com)
    * [JQuery](https://jquery.com)

## 🚩 Installation
Install Apache, MySQL, and PHP or XAMPP Control Panel Version 3.2.4

## 🤖 How to Use
1.	Import 'database/database.sql' file to MySQL database
2.	Change MySQL database name and password to yours in database/dbconfig.php
```sh
define('DBNAME','Your_database_name');
```
```sh
define('DBPASS','your_database_password');
```
3.	To run on local devices or on server: save extracted files into htdocs and run user_index.html (You will be auto directed to this page if you run other php files)
4.	Default admin username and password: test@wit.edu/test 

##  🚀 Future Work
Create an API for connecting to the slicer software directly.

## 😺 Acknowledgements
* [FullCalendar]( https://fullcalendar.io/)
* [DataTable](https://datatables.net/)
* [Plotly.js](https://plotly.com/javascript/)
* [SB Admin 2](https://startbootstrap.com/templates/sb-admin/)

##  📜 License
Copyright 2020 Wentworth Institute of Technology.
Licensed under the Apache License, Version 2.0 (the "License"); You may not use this file except in compliance with the License. You may obtain a copy of the License at https://www.apache.org/licenses/LICENSE-2.0. 
Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and limitations under the License.


