drop table Deliver;
drop table Delivery cascade constraints;
drop table Purchase;
drop table Supplier;
drop table ListToppings;
drop table ListCream;
drop table ListSweetener;
drop table ShoppingList cascade constraints;
drop table Sales cascade constraints;
drop table AddToppings cascade constraints;
drop table Toppings cascade constraints;
drop table AddCream cascade constraints;
drop table Cream cascade constraints;
drop table AddSweetener cascade constraints;
drop table Sweetener cascade constraints;
drop table ListCoffee1 cascade constraints;
drop table ListCoffee2 cascade constraints;
drop table Decaf cascade constraints;
drop table Caffeinated cascade constraints;
drop table IcedCoffee cascade constraints;
drop table Coffee cascade constraints;

create table Delivery (
    trackingNum	int	not null,
    expectedDate date not null,
    primary key (trackingNum));
grant select on Delivery to public;

create table Supplier (
    supName varchar(50)	not null,
    address varchar(30)	not null,
    primary key (supName));
grant select on Supplier to public;

create table Deliver (
    supName varchar(50)	not null,
    trackingNum int	not null,
    primary key (supName, trackingNum),
    foreign key (supName) references Supplier (supName) ON DELETE CASCADE,
    foreign key (trackingNum) references Delivery (trackingNum) ON DELETE CASCADE);
grant select on Deliver to public;

create table ShoppingList (
    listDate date not null,
    funds int not null,
    primary key (listDate));
grant select on ShoppingList to public;

create table Purchase (
    trackingNum int not null,
    listDate date not null,
    price int not null,
    primary key (trackingNum, listDate),
    foreign key (trackingNum) references Delivery (trackingNum) ON DELETE CASCADE,
    foreign key (listDate) references ShoppingList (listDate) ON DELETE CASCADE);
grant select on Purchase to public;

create table Sales (
    salesDate date not null,
    employeePay int not null,
    cafeFunds int not null,
    primary key (salesDate));
grant select on Sales to public;

drop table Fund;
create table Fund (
    listDate date not null,
    salesDate date not null,
    primary key (listDate, salesDate),
    foreign key (listDate) references ShoppingList (listDate) ON DELETE CASCADE,
    foreign key (salesDate) references Sales (salesDate) ON DELETE CASCADE);
grant select on Fund to public;

create table Coffee (
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    primary key (coffeeName, coffeeSize));
grant select on Coffee to public;

create table Toppings (
    toppingName varchar(30) not null,
    toppingInv varchar(20) not null,
    primary key (toppingName));
grant select on Toppings to public;

create table ListToppings (
    listDate date not null,
    toppingName varchar(30) not null,
    toppingQuant varchar(20) not null,
    primary key (listDate, toppingName),
    foreign key (listDate) references ShoppingList (listDate) ON DELETE CASCADE,
    foreign key (toppingName) references Toppings (toppingName) ON DELETE CASCADE);
grant select on ListToppings to public;

create table AddToppings (
    toppingName varchar(30) not null,
    toppingAmount varchar(20) not null,
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    primary key (toppingName, coffeeName, coffeeSize),
    foreign key (toppingName) references Toppings (toppingName) ON DELETE CASCADE,
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on AddToppings to public;

create table Cream (
    creamName varchar(30) not null,
    creamInv varchar(20) not null,
    primary key (creamName));
grant select on Cream to public;

create table ListCream (
    listDate date not null,
    creamName varchar(30) not null,
    creamQuant varchar(20) not null,
    primary key (listDate, creamName),
    foreign key (listDate) references ShoppingList (listdate) ON DELETE CASCADE,
    foreign key (creamName) references Cream (creamName) ON DELETE CASCADE);
grant select on ListCream to public;

create table AddCream (
    creamName varchar(30) not null,
    cupAmount varchar(20) not null,
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    primary key (creamName, coffeeName, coffeeSize),
    foreign key (creamName) references Cream (creamName) ON DELETE CASCADE,
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on AddCream to public;

create table Sweetener (
    sweetName varchar(30) not null,
    sweetenerInv varchar(20) not null,
    primary key (sweetName));
grant select on Sweetener to public;

create table ListSweetener (
    listDate date not null,
    sweetName varchar(30) not null,
    sweetenerQuant varchar(20) not null,
    primary key (listDate, sweetName),
    foreign key (listDate) references ShoppingList (listDate) ON DELETE CASCADE,
    foreign key (sweetName) references Sweetener (sweetName) ON DELETE CASCADE);
grant select on ListSweetener to public;

create table AddSweetener (
    sweetName varchar(30) not null,
    sweetenerAmount varchar(20) not null,
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    primary key (sweetName, coffeeName, coffeeSize),
    foreign key (sweetName) references Sweetener (sweetName) ON DELETE CASCADE,
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on AddSweetener to public;

create table ListCoffee1 (
    listDate date not null,
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    primary key (listDate, coffeeName, coffeeSize),
    foreign key (listDate) references ShoppingList (listDate) ON DELETE CASCADE,
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on ListCoffee1 to public;

create table ListCoffee2 (
    listDate date not null,
    coffeeQuant varchar(20) not null,
    primary key (listDate),
    foreign key (listDate) references ShoppingList (listDate) ON DELETE CASCADE);
grant select on ListCoffee2 to public;

create table Decaf (
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    coffeeInv varchar(20) not null,
    roastLevel varchar(20) not null,
    primary key (coffeeName, coffeeSize),
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on Decaf to public;

create table Caffeinated (
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    coffeeInv varchar(20) not null,
    roastLevel varchar(20) not null,
    numShots int not null,
    primary key (coffeeName, coffeeSize),
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on Caffeinated to public;

create table IcedCoffee (
    coffeeName varchar(30) not null,
    coffeeSize varchar(20) not null,
    method varchar(30) not null,
    iceAmount varchar(20) not null,
    primary key (coffeeSize, coffeeName),
    foreign key (coffeeName, coffeeSize) references Coffee (coffeeName, coffeeSize) ON DELETE CASCADE);
grant select on IcedCoffee to public;


insert into Delivery values (1234, to_date('2024-09-01','YYYY-MM-DD'));
insert into Delivery values (2345, to_date('2024-07-10','YYYY-MM-DD'));
insert into Delivery values (3456, to_date('2024-06-01','YYYY-MM-DD'));
insert into Delivery values (1235, to_date('2024-09-10','YYYY-MM-DD'));
insert into Delivery values (1236, to_date('2024-09-20','YYYY-MM-DD'));
insert into Delivery values (1237, to_date('2024-09-30','YYYY-MM-DD'));
insert into Delivery values (1238, to_date('2024-10-15','YYYY-MM-DD'));
insert into Delivery values (4567, to_date('2024-07-29','YYYY-MM-DD'));

insert into Supplier values ('COSTCO', '1234 Main St.');
insert into Supplier values ('Blenz Beans', '1234 Arbutus St.');
insert into Supplier values ('Kona Beans', '1234 Kailua St.');
insert into Supplier values ('Superstore', '317 Cambie St.');
insert into Supplier values ('The Bean Shop', '9288 Oak St.');

insert into Deliver  values ('COSTCO', 1234);
insert into Deliver  values ('COSTCO', 2345);
insert into Deliver  values ('COSTCO', 3456);
insert into Deliver  values ('Blenz Beans', 1235);
insert into Deliver  values ('Kona Beans', 1236);
insert into Deliver  values ('Superstore', 1237);
insert into Deliver  values ('The Bean Shop', 1238);
insert into Deliver  values ('The Bean Shop', 4567);

insert into ShoppingList values (to_date('2024-08-01','YYYY-MM-DD'), 500);
insert into ShoppingList values (to_date('2024-06-18','YYYY-MM-DD'), 900);
insert into ShoppingList values (to_date('2024-05-22','YYYY-MM-DD'), 300);
insert into ShoppingList values (to_date('2024-08-11','YYYY-MM-DD'), 650);
insert into ShoppingList values (to_date('2024-08-15','YYYY-MM-DD'), 420);
insert into ShoppingList values (to_date('2024-08-20','YYYY-MM-DD'), 399);
insert into ShoppingList values (to_date('2024-08-10','YYYY-MM-DD'), 800);
insert into ShoppingList values (to_date('2024-07-19','YYYY-MM-DD'), 110);

insert into Purchase values (1234, to_date('2024-08-01','YYYY-MM-DD'), 150);
insert into Purchase values (2345, to_date('2024-06-18','YYYY-MM-DD'), 452);
insert into Purchase values (3456, to_date('2024-05-22','YYYY-MM-DD'), 220);
insert into Purchase values (1235, to_date('2024-08-11','YYYY-MM-DD'), 300);
insert into Purchase values (1236, to_date('2024-08-15','YYYY-MM-DD'), 275);
insert into Purchase values (1237, to_date('2024-08-20','YYYY-MM-DD'), 399);
insert into Purchase values (1238, to_date('2024-08-10','YYYY-MM-DD'), 200);
insert into Purchase values (4567, to_date('2024-07-19','YYYY-MM-DD'), 60);

insert into Sales values (to_date('2024-07-30','YYYY-MM-DD'), 500, 1200);
insert into Sales values (to_date('2024-08-10','YYYY-MM-DD'), 590, 1300);
insert into Sales values (to_date('2024-08-14','YYYY-MM-DD'), 700, 1250);
insert into Sales values (to_date('2024-08-19','YYYY-MM-DD'), 600, 1350);
insert into Sales values (to_date('2024-08-09','YYYY-MM-DD'), 800, 1100);

insert into Fund values (to_date('2024-08-01','YYYY-MM-DD'), to_date('2024-07-30','YYYY-MM-DD'));
insert into Fund values (to_date('2024-08-11','YYYY-MM-DD'), to_date('2024-08-10','YYYY-MM-DD'));
insert into Fund values (to_date('2024-08-15','YYYY-MM-DD'), to_date('2024-08-14','YYYY-MM-DD'));
insert into Fund values (to_date('2024-08-20','YYYY-MM-DD'), to_date('2024-08-19','YYYY-MM-DD'));
insert into Fund values (to_date('2024-08-10','YYYY-MM-DD'), to_date('2024-08-09','YYYY-MM-DD'));

insert into Coffee values ('latte', 'extra large');
insert into Coffee values ('macchiato', 'medium');
insert into Coffee values ('cappuccino', 'small');
insert into Coffee values ('drip coffee', 'large');
insert into Coffee values ('flat white', 'short');
insert into Coffee values ('decaf latte', 'extra large');
insert into Coffee values ('decaf macchiato', 'medium');
insert into Coffee values ('decaf cappuccino', 'small');
insert into Coffee values ('decaf drip coffee', 'large');
insert into Coffee values ('decaf flat white', 'short');

insert into Toppings values ('whipped cream', 'low');
insert into Toppings values ('caramel drizzle', 'low');
insert into Toppings values ('cinnamon', 'high');
insert into Toppings values ('icing sugar', 'low');
insert into Toppings values ('cocoa powder', 'high');

insert into ListToppings values (to_date('2024-08-01','YYYY-MM-DD'), 'whipped cream', '4 bottles');
insert into ListToppings values (to_date('2024-08-11','YYYY-MM-DD'), 'caramel drizzle', '2 bottles');
insert into ListToppings values (to_date('2024-08-15','YYYY-MM-DD'), 'cinnamon', '1 bottle');
insert into ListToppings values (to_date('2024-08-20','YYYY-MM-DD'), 'icing sugar', '3 bottles');
insert into ListToppings values (to_date('2024-08-10','YYYY-MM-DD'), 'cocoa powder', '4 bottles');

insert into AddToppings values ('whipped cream', '5 tsp', 'latte', 'extra large');
insert into AddToppings values ('caramel drizzle', '3 tsp', 'macchiato', 'medium');
insert into AddToppings values ('cinnamon', '2 tsp', 'cappuccino', 'small');
insert into AddToppings values ('icing sugar', '4 tsp', 'drip coffee', 'large');
insert into AddToppings values ('cocoa powder', '1 tsp', 'flat white', 'short');
insert into AddToppings values ('caramel drizzle', '5 tsp', 'latte', 'extra large');
insert into AddToppings values ('cinnamon', '5 tsp', 'latte', 'extra large');
insert into AddToppings values ('icing sugar', '5 tsp', 'latte', 'extra large');
insert into AddToppings values ('cocoa powder', '5 tsp', 'latte', 'extra large');

insert into Cream values ('half and half', 'low');
insert into Cream values ('coconut', 'low');
insert into Cream values ('oat', 'low');
insert into Cream values ('almond', 'high');
insert into Cream values ('soy', 'high');

insert into ListCream values (to_date('2024-08-01','YYYY-MM-DD'), 'half and half', '10 cartons');
insert into ListCream values (to_date('2024-08-11','YYYY-MM-DD'), 'coconut', '5 cartons');
insert into ListCream values (to_date('2024-08-15','YYYY-MM-DD'), 'oat', '4 cartons');
insert into ListCream values (to_date('2024-08-20','YYYY-MM-DD'), 'almond', '3 cartons');
insert into ListCream values (to_date('2024-08-10','YYYY-MM-DD'), 'soy', '2 cartons');

insert into AddCream values ('half and half', '2 cups', 'latte', 'extra large');
insert into AddCream values ('coconut', '1 cup', 'macchiato', 'medium');
insert into AddCream values ('oat', '1/2  cup', 'cappuccino', 'small');
insert into AddCream values ('almond', '1.5 cups', 'drip coffee', 'large');
insert into AddCream values ('soy', '1/3 cup', 'flat white', 'short');
insert into AddCream values ('soy', '1/3 cup', 'latte', 'extra large');
insert into AddCream values ('coconut', '1/3 cup', 'latte', 'extra large');
insert into AddCream values ('oat', '1/3 cup', 'latte', 'extra large');
insert into AddCream values ('almond', '1/3 cup', 'latte', 'extra large');

insert into Sweetener values ('honey', 'high');
insert into Sweetener values ('cane sugar', 'low');
insert into Sweetener values ('stevia', 'low');
insert into Sweetener values ('vanilla syrup', 'high');
insert into Sweetener values ('chocolate syrup', 'low');

insert into ListSweetener values (to_date('2024-08-01','YYYY-MM-DD'), 'honey', '5 bottles');
insert into ListSweetener values (to_date('2024-08-11','YYYY-MM-DD'), 'cane sugar', '5 bottles');
insert into ListSweetener values (to_date('2024-08-15','YYYY-MM-DD'), 'stevia', '2 bottles');
insert into ListSweetener values (to_date('2024-08-20','YYYY-MM-DD'), 'vanilla syrup', '4 bottles');
insert into ListSweetener values (to_date('2024-08-10','YYYY-MM-DD'), 'chocolate syrup', '1 bottle');

insert into AddSweetener values ('honey', '2 pump', 'latte', 'extra large');
insert into AddSweetener values ('cane sugar', '3 spoons', 'macchiato', 'medium');
insert into AddSweetener values ('stevia', '2 pumps', 'cappuccino', 'small');
insert into AddSweetener values ('vanilla syrup', '1 pump', 'drip coffee', 'large');
insert into AddSweetener values ('chocolate syrup', '3 pumps', 'flat white', 'short');
insert into AddSweetener values ('honey', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('cane sugar', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('vanilla syrup', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('chocolate syrup', '2 pumps', 'decaf cappuccino', 'small');

insert into ListCoffee1 values (to_date('2024-08-01','YYYY-MM-DD'), 'latte', 'extra large');
insert into ListCoffee1 values (to_date('2024-08-11','YYYY-MM-DD'), 'macchiato', 'medium');
insert into ListCoffee1 values (to_date('2024-08-15','YYYY-MM-DD'), 'cappuccino', 'small');
insert into ListCoffee1 values (to_date('2024-08-20','YYYY-MM-DD'), 'drip coffee', 'large');
insert into ListCoffee1 values (to_date('2024-08-10','YYYY-MM-DD'), 'flat white', 'short');

insert into ListCoffee2 values (to_date('2024-08-01','YYYY-MM-DD'), '5 bottles');
insert into ListCoffee2 values (to_date('2024-08-11','YYYY-MM-DD'), '5 bottles');
insert into ListCoffee2 values (to_date('2024-08-15','YYYY-MM-DD'), '2 bottles');
insert into ListCoffee2 values (to_date('2024-08-20','YYYY-MM-DD'), '4 bottles');
insert into ListCoffee2 values (to_date('2024-08-10','YYYY-MM-DD'), '1 bottle');

insert into Decaf values ('decaf latte', 'extra large', 'low', 'light');
insert into Decaf values ('decaf macchiato', 'medium', 'low', 'light');
insert into Decaf values ('decaf cappuccino', 'small', 'low','medium');
insert into Decaf values ('decaf drip coffee', 'large', 'low', 'dark');
insert into Decaf values ('decaf flat white', 'short', 'low', 'dark');

insert into Caffeinated values ('latte', 'extra large', 'high', 'light', 3);
insert into Caffeinated values ('macchiato', 'medium', 'high', 'light', 2);
insert into Caffeinated values ('cappuccino', 'small', 'high', 'medium', 1);
insert into Caffeinated values ('drip coffee', 'large', 'high', 'dark', 3);
insert into Caffeinated values ('flat white', 'short', 'high', 'dark', 0);

insert into IcedCoffee values ('latte', 'extra large', 'iced', '1 scoop');
insert into IcedCoffee values ('macchiato', 'medium', 'ice cap', '2 scoops');
insert into IcedCoffee values ('cappuccino', 'small', 'iced', 'half scoop');
insert into IcedCoffee values ('drip coffee', 'large', 'cold brew', '2 scoops');
insert into IcedCoffee values ('flat white', 'short','ice cap', 'half scoop');

commit;