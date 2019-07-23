USE HoshiLe;

-- Insert data for Product table
insert into Products(name, brand, price, imageUrl) values ('MacBook Air', 'Apple', 574.55, 'https://images-na.ssl-images-amazon.com/images/I/81UdIMh89YL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Gamer Xtreme', 'Cyberpower', 1071.68, 'https://images-na.ssl-images-amazon.com/images/I/71DvG2FjM%2BL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Galaxy A70', 'Samsung', 485.18, 'https://images-na.ssl-images-amazon.com/images/I/61Ygdf5VvoL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('VGA Card', 'VisionTek', 50.99, 'https://images-na.ssl-images-amazon.com/images/I/41A%2BW0v5m-L.jpg');
insert into Products(name, brand, price, imageUrl) values ('Gaming Laptop', 'Asus', 1649.00, 'https://images-na.ssl-images-amazon.com/images/I/91pZKrNVBAL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Mouse', 'VicTsing', 15.13, 'https://images-na.ssl-images-amazon.com/images/I/61y5xxDVavL._SL1280_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Desktop PC', 'MSI', 1156.99, 'https://images-na.ssl-images-amazon.com/images/I/811Umzw-suL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('VGA Card', 'ZOTAC', 59.99, 'https://images-na.ssl-images-amazon.com/images/I/71Gg09aXz0L._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Mouse', 'ASUS', 119.35, 'https://images-na.ssl-images-amazon.com/images/I/81b0Lkw-HgL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Desktop Monitor', 'LG', 209.24, 'https://images-na.ssl-images-amazon.com/images/I/81MzNtSWWQL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Wi-Fi System', 'Google', 159.00, 'https://images-na.ssl-images-amazon.com/images/I/31iN8Vrt2XL.jpg');
insert into Products(name, brand, price, imageUrl) values ('Keyboard', 'Redragon', 45.99, 'https://images-na.ssl-images-amazon.com/images/I/71FYqRS9YSL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('VGA Card', 'Dell', 2761.62, 'https://images-na.ssl-images-amazon.com/images/I/51lFI1XHcwL.jpg');
insert into Products(name, brand, price, imageUrl) values ('Keyboard', 'Google', 25.88, 'https://images-na.ssl-images-amazon.com/images/I/719A7-TRCkL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Mini PC', 'ASUS', 366.70, 'https://images-na.ssl-images-amazon.com/images/I/81IZyYzzIiL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Keyboard case', 'LG', 21.95, 'https://images-na.ssl-images-amazon.com/images/I/81K45ouTjjL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('VGA Cable', 'Logitech', 79.99, 'https://images-na.ssl-images-amazon.com/images/I/61nSC3ikFQL._SL1001_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Trackball', 'Logitech', 16.99, 'https://images-na.ssl-images-amazon.com/images/I/71ILgBHzCnL._SL1200_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Tablet PC', 'HP', 525.00, 'https://images-na.ssl-images-amazon.com/images/I/71lIIz6IztL._SL1500_.jpg');
insert into Products(name, brand, price, imageUrl) values ('Smart Watch', 'Mobvoi', 297.99, 'https://images-na.ssl-images-amazon.com/images/I/614-CpmlaHL._UL1000_.jpg');

-- Insert data for User table
-- All users have password 1234
insert into Users(name, email, password, shoppingCart) values ('Karil Lyddy', 'klyddy0@360.cn', '$2y$10$KwQ93uY6Iqiq9vjYlVDrf.I4hkRUQHg9m3ig9o1NkM8r8izK/xkDe', '');
insert into Users(name, email, password, shoppingCart) values ('Josiah Ridehalgh', 'jridehalgh1@tripod.com', '$2y$10$KwQ93uY6Iqiq9vjYlVDrf.I4hkRUQHg9m3ig9o1NkM8r8izK/xkDe', '');
insert into Users(name, email, password, shoppingCart) values ('Ailey Meader', 'ameader2@constantcontact.com', '$2y$10$KwQ93uY6Iqiq9vjYlVDrf.I4hkRUQHg9m3ig9o1NkM8r8izK/xkDe', '');
insert into Users(name, email, password, shoppingCart) values ('Halimeda Varcoe', 'hvarcoe3@amazon.com', '$2y$10$KwQ93uY6Iqiq9vjYlVDrf.I4hkRUQHg9m3ig9o1NkM8r8izK/xkDe', '');
insert into Users(name, email, password, shoppingCart) values ('Normand Skypp', 'nskypp4@wsj.com', '$2y$10$KwQ93uY6Iqiq9vjYlVDrf.I4hkRUQHg9m3ig9o1NkM8r8izK/xkDe', '');