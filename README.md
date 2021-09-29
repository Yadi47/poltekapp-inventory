0. Kita memiliki 2 bagian di system OEE dan MRP
1. Penulisan Route sesuai dengan bagian Masing masing OEE (oee_route),MRP (mrp_route)
2. Setiap route harus di beri name 
3. Jika route memiliki turunan masukkan kedalam route group
4. Pemanggilan url menggunakan Nama route
5. Pembuatan Controller menggunakan command artisan "php artisan make:controller Folder/namaController" 
ex:"php artisan make:controller Oee/OeeDashboardController"
6. Untuk Penamaan controller diawali dengan NamabagianNamacontrollerController ex:"MrpPlanningController" /"OeeTrendingController"
7. Penamaaan fungsi menggunakan camel case diawali huruf kecil ex:"readAllData,generatePlanning"
8. Rule Pembuatan model sama dengan controller disesuaikan dengan folder dan prefix name masing" bagian 
ex:"php artisan make:model Oee/OeeTrendingController"
9. pembuatan table menggunakan migration
10. Pembuatan nama table menggunakan pemisah undescore , lowercase, plural ex:mrp_productions,oee_log_values
11. Penulisan column pemisah undescore , lowercase, tidak perlu plural ex:name,created_at,id
12. Penulisan Primary Key only id
13. Penulisan foreign key tablename_id ex:role_id,production_id

HALLO IMAM => HALLO YADI => HALLO IKHSAN => 