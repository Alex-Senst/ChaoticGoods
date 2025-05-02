This is our e-commerce website project Chaotic Goods! It is a Dungeons & Dragons merchandise website where users can buy or sell DnD-related items such as dice. 

Main Features:
- User registration & login
- Product page with search and filter functionality
- Shopping cart and order placement system
- Admin panel for product & order management
  
Tech Stack:
- PHP
- MySQL (phpMyAdmin)
- HTML/CSS (Bootstrap 4)

Database: The schema.sql file is included to set up your database tables. There is some data already stored within the file, so only keep what is desired.
Make sure to import this into phpMyAdmin before running the app.

Setup Instructions:
1. Clone this repository: https://github.com/Alex-Senst/ChaoticGoods.git
2. Open phpMyAdmin
3. Create a new database
4. Import the provided schema.sql file to create the tables
5. Configure the database connection in db.php by editing the line
   $con = new mysqli("localhost", "your_username", "your_password", "chaoticgoods");
6. If using XAMPP, start Apache and MySQL.
   Or use PHP's built-in server:
   php -S localhost:8000
   Then visit:
   http://localhost/chaoticgoods/

Built by Alex Senst and Shan Peck for educational purposes.

Instructor: Hasan Jamil

Course: CS360: Database Systems

Semester: Spring 2025
