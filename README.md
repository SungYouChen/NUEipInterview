環境：
1. Laravel 10
2. php 8
3. MariaDB 10.4.11

套件名稱：
1. mavinoo/laravel-batch
2. maatwebsite/excel
3. datacreativa/laravel-presentable
4. yajra/laravel-datatables-oracle

Github 連結：
1. https://github.com/SungYouChen/NUEipInterview

需附用到的資料庫匯入檔(.sql)
1. 若不想匯入也可以在設定好後，至專案目錄下 php artisan migrate

復原步驟：
1. git clone https://github.com/SungYouChen/NUEipInterview.git
2. 至專案目錄下 composer install
3. 至專案目錄下 npm install
4. 設定 .env (DB 連線設定)
5. 至專案目錄下 npm run dev (需持續運行)
6. 至專案目錄下 php artisan serve (需持續運行)
7. 根據步驟 6. 所得網址 + /account 即可前往功能頁面做測試