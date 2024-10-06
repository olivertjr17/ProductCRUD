# ProductCRUD

## Installation

1. Clone the repository
2. cd to the project
3. create a copy of .env from env.example
4. Update the database connection 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ProductCRUD
    DB_USERNAME=root (Depending on your username)
    DB_PASSWORD=root (Depending on your password)
5. npm install && npm run dev
6. open a new terminal, 
7. composer install
8. php artisan key:generate
9. php artisan migrate, it will ask you to create Database ProductCRUD for you, choose yes.
10. run the seeders for users and products, php artisan db:seed
11. the users table will now have 1 user, the username is admin and the password is @admin123
12. php artisan serve, it will give a link like http://127.0.0.1:8000.
13. Copy it and paste to browser.
14. php artisan storage:link - so that the images and videos can be accessed.
15. For the video player to work, go to Laravel public folder, create a folder there videos. And inside it put 2 videos with file name video1.mp4 and video2.mp4.