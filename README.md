# 3D-Printer-Scheduler-System


## 📅 About The Project
Created a new web application to schedule 3D printing events, add/update printers and accounts, and capture statistics about printing jobs for Technology Sandbox.

Pervious web application: [Website](https://sandbox-ui.firebaseapp.com/) and [Github Link](https://github.com/wittechsandbox/printer-queue)

![scheduler](https://github.com/wittechsandbox/3D-Printer-Scheduler-System/blob/master/img/demo.gif)


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
1.	Create a new MySQL database and then import database/database.sql file to your database
2. In database/dbconfig.php, change MySQL database name and password (if you have one) to yours 
```sh
define('DBNAME','Your_database_name');
```
```sh
define('DBPASS','your_database_password');
```
3.	To run on local devices or on server: 
    * save extracted files into xampp/htdocs
    * run user_index.html on your browser (You will be auto directed to this page if you run other php files)
4.	Default admin username and password: test@wit.edu/test  
   NOTE: if you are unable to login, run the following query in your MySQL database to change the password
```sh
UPDATE account SET password=AES_ENCRYPT('test', UNHEX(SHA2('TechnologySandbox',512))) WHERE accountId= '1'
```


## 🌏 Browser Support
Recommended browser versions. The HTML datalist element may not be compatible with older versions of browsers.  
| <img src="https://user-images.githubusercontent.com/1215767/34348387-a2e64588-ea4d-11e7-8267-a43365103afe.png" alt="Chrome" width="16px" height="16px" /> Chrome | <img src="https://user-images.githubusercontent.com/1215767/34348590-250b3ca2-ea4f-11e7-9efb-da953359321f.png" alt="IE" width="16px" height="16px" /> Internet Explorer | <img src="https://user-images.githubusercontent.com/1215767/34348380-93e77ae8-ea4d-11e7-8696-9a989ddbbbf5.png" alt="Edge" width="16px" height="16px" /> Edge | <img src="https://user-images.githubusercontent.com/1215767/34348394-a981f892-ea4d-11e7-9156-d128d58386b9.png" alt="Safari" width="16px" height="16px" /> Safari | <img src="https://user-images.githubusercontent.com/1215767/34348383-9e7ed492-ea4d-11e7-910c-03b39d52f496.png" alt="Firefox" width="16px" height="16px" /> Firefox |
| :---------: | :---------: | :---------: | :---------: | :---------: |
| 20 | 10 | 12 | 12.1 | 4 |


##  🚀 Future Work
Create an API for connecting to the slicer software directly.


## 😺 Acknowledgements
* [FullCalendar]( https://fullcalendar.io/)
* [DataTable](https://datatables.net/)
* [Plotly.js](https://plotly.com/javascript/)
* [SB Admin 2](https://startbootstrap.com/templates/sb-admin/)


##  📜 License
Copyright 2020 Wentworth Institute of Technology.  
Licensed under the Apache License, Version 2.0 (the "License"); You may not use this file except in compliance with the License. You may obtain a copy of the License at https://www.apache.org/licenses/LICENSE-2.0. Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  
See the License for the specific language governing permissions and limitations under the License.


