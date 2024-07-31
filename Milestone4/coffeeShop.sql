drop table Delivery;
drop table Supplier;
drop table Deliver;
drop table Purchase;
drop table ShoppingList;
drop table Fund;
drop table Sales;
drop table ListToppings;
drop table AddToppings1;
drop table AddToppings3;
drop table AddToppings4;
drop table Toppings;
drop table ListCream;
drop table AddCream1;
drop table AddCream3;
drop table AddCream4;
drop table Cream;
drop table ListSweetener;
drop table AddSweetener1;
drop table AddSweetener3;
drop table AddSweetener4;
drop table Sweetener;
drop table ListCoffee;
drop table Decaf;
drop table Caffeinated;
drop table AddEspresso1;
drop table AddEspresso2;
drop table Espresso;
drop table IcedCoffee1;
drop table IcedCoffee3;
drop table IcedCoffee4;


create table Delivery (
    trackingNum	int	primary key,
    expectedDate date);
grant select on Delivery to public;

create table Supplier (
    supName char(50) primary key,
    address char(30));
grant select on Supplier to public;

create table Deliver (
    supName char(50),
    trackingNum int,
    primary key (supName, trackingNum),
    foreign key (supName) references Supplier (supName),
    foreign key (trackingNum) references Delivery (trackingNum));
grant select on Deliver to public;

create table Purchase (
    supName char(50),
    listDate date,
    price int,
    primary key (supName, listDate),
    foreign key (supName) references upplier (supName),
    foreign key (listDate) references ShoppingList (listDate));
grant select on Purchase to public;

create table ShoppingList (
    listDate date primary key ,
    funds int);
grant select on ShoppingList to public;

create table Fund (
    listDate date,
    salesDate date,
    primary key (listDate, salesDate),
    foreign key (listDate) references ShoppingList (listDate),
    foreign key (salesDate) references Sales (salesDate));
grant select on Fund to public;

create table Sales (
    salesDate date primary key ,
    employeePay int,
    cafeFunds int);
grant select on Sales to public;

create table ListToppings (
    listDate date,
    toppingName char(30),
    toppingQuant char(20),
    primary key (listDate, toppingName),
    foreign key (listDate) references ShoppingList (listDate),
    foreign key (toppingName) references Topping (toppingName));
grant select on ListToppings to public;

create table AddToppings1 (
    toppingName char(30),
    coffeeName char(30),
    primary key (toppingName, coffeeName),
    foreign key (toppingName) references Toppings (toppingName),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on AddToppings1 to public;

create table AddToppings3 (
    size char(20),
    coffeeName char(30),
    primary key (size, coffeeName),
    foreign key (size) references Coffee (size),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on AddToppings3 to public;

create table AddToppings4 (
    size char(20) primary key ,
    toppingAmount char(20),
    foreign key (size) references Coffee (size));
grant select on AddToppings4 to public;

create table Toppings (
    toppingName char(30) primary key ,
    toppingInv char(20));
grant select on Toppings to public;

create table ListCream (
    listDate date,
    creamName char(30),
    creamQuant char(20),
    primary key (listDate, creamName),
    foreign key (listDate) references ShoppingList (listdate),
    foreign key (creamName) references Cream (creamName));
grant select on ListCream to public;

create table AddCream1 (
    creamName char(30),
    coffeeName char(30),
    primary key (creamName, coffeeName),
    foreign key (creamName) references Cream (creamName),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on AddCream1 to public;

create table AddCream3 (
    size char(20),
    coffeeName char(30),
    primary key (size, coffeeName),
    foreign key (size) references Coffee (size),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on AddCream3 to public;

create table AddCream4 (
    size char(20) primary key ,
    cupAmount char(20),
    foreign key (size) references Coffee (size));
grant select on AddCream4 to public;

create table Cream (
    creamName char(30)  primary key ,
    creamInv char(20));
grant select on Cream to public;

create table ListSweetener (
    listDate date,
    sweetName char(30),
    sweetenerQuant char(20),
    primary key (listDate, sweetName),
    foreign key (listDate) references ShoppingList (listDate),
    foreign key (sweetName) references Sweetener (sweetName));
grant select on ListSweetener to public;

create table AddSweetener1 (
    sweetName char(30),
    coffeeName char(30),
    primary key (sweetName, coffeeName),
    foreign key (sweetName) references Sweetener (sweetName),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on AddSweetener1 to public;

create table AddSweetener3 (
    size char(20),
    coffeeName char(30),
    primary key (size, coffeeName),
    foreign key (size) references Coffee (size),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on AddSweetener3 to public;

create table AddSweetener4 (
    size char(20) primary key ,
    sweetenerAmount char(20),
    foreign key (size) references Coffee (size));
grant select on AddSweetener4 to public;

create table Sweetener (
    sweetName char(30) primary key ,
    sweetenerInv char(20));
grant select on Sweetener to public;

create table ListCoffee (
    listDate date,
    coffeeName char(30),
    size char(20),
    coffeeQuant char(20),
    primary key (listDate, coffeeName, size),
    foreign key (listDate) references ShoppingList (listDate),
    foreign key (coffeeName) references Coffee (coffeeName),
    foreign key (size) references Coffee (size));
grant select on ListCoffee to public;

create table Decaf (
    coffeeName char(30),
    size char(20),
    coffeeInv char(20),
    beanType char(20),
    roastLevel char(20),
    primary key (coffeeName, size));
grant select on Decaf to public;

create table Caffeinated (
    coffeeName char(30),
    size char(20),
    coffeeInv char(20),
    beanType char(20),
    roastLevel char(20),
    primary key (coffeeName, size));
grant select on Caffeinated to public;

create table AddEspresso1 (
    coffeeName char(30),
    numShots int,
    strength char(20),
    primary key (coffeeName, strength),
    foreign key (coffeeName) references Coffee (coffeeName),
    foreign key (strength) references Espresso (strength));
grant select on AddEspresso1 to public;

create table AddEspresso2 (
    coffeeName char(30),
    size char(20),
    primary key (coffeeName, size),
    foreign key (coffeeName) references Coffee (coffeeName),
    foreign key (size) references Coffee (size));
grant select on AddEspresso2 to public;

create table Espresso (
    strength char(20) primary key ,
    type char(30));
grant select on Espresso to public;

create table IcedCoffee1 (
    coffeeName char(30) primary key ,
    method char(30),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on IcedCoffee1 to public;

create table IcedCoffee3 (
    size char(20) primary key ,
    iceAmount char(20),
    foreign key (size) references Coffee (size));
grant select on IcedCoffee3 to public;

create table IcedCoffee4 (
    size char(20),
    iceAmount char(20),
    primary key (size, coffeeName),
    foreign key (size) references Coffee (size),
    foreign key (coffeeName) references Coffee (coffeeName));
grant select on IcedCoffee4 to public;


insert into Delivery values (1234, 2024-09-01);
insert into Delivery values (1235, 2024-09-10);
insert into Delivery values (1236, 2024-09-20);
insert into Delivery values (1237, 2024-09-30);
insert into Delivery values (1238, 2024-10-15);

insert into Supplier values (‘COSTCO’, ‘1234 Main St.’);
insert into Supplier values (‘Blenz Beans’, ‘1234 Arbutus St.’);
insert into Supplier values (‘Kona Beans, ‘1234 Kailua St.’);
insert into Supplier values (‘Superstore’, 317 Cambie St.’);
insert into Supplier values (‘The Bean Shop’, ‘9288 Oak St.’);

insert into Deliver  values (‘COSTCO’, 1234);
insert into Deliver  values (‘Blenz Beans’, 1235);
insert into Deliver  values (‘Kona Beans’, 1236);
insert into Deliver  values (‘Superstore’, 1237);
insert into Deliver  values (‘The Bean Shop’, 1238);

insert into Purchase values (‘COSTCO’, 2024-08-01, 150);
insert into Purchase values (‘Blenz Beans’, 2024-08-11, 300);
insert into Purchase values (‘Kona Beans’, 2024-08-15, 275);
insert into Purchase values (‘Superstore’, 2024-08-20, 399);
insert into Purchase values (‘The Bean Shop’, 2024-08-10, 200);

insert into ShoppingList values (2024-08-01, 500);
insert into ShoppingList values (2024-08-11, 650);
insert into ShoppingList values (2024-08-15, 420);
insert into ShoppingList values (2024-08-20, 399);
insert into ShoppingList values (2024-08-10, 800);

insert into Fund values (2024-08-01, 2024-07-30);
insert into Fund values (2024-08-11, 2024-08-10);
insert into Fund values (2024-08-15, 2024-08-14);
insert into Fund values (2024-08-20, 2024-08-19);
insert into Fund values (2024-08-10, 2024-08-09);

insert into Sales values (2024-07-30, 500, 1200);
insert into Sales values (2024-08-10, 590, 1300);
insert into Sales values (2024-08-14, 700, 1250);
insert into Sales values (2024-08-19, 600, 1350);
insert into Sales values (2024-08-09, 800, 1100);

insert into ListToppings values (2024-08-01, ‘whipped cream’, ‘4 bottles’);
insert into ListToppings values (2024-08-11, ‘caramel drizzle’, ‘2 bottles’);
insert into ListToppings values (2024-08-15, ‘cinnamon’, ‘1 bottle’);
insert into ListToppings values (2024-08-20, ‘icing sugar’, ‘3 bottles’);
insert into ListToppings values (2024-08-10, ‘cocoa powder’, ‘4 bottles’);

insert into AddToppings1 values (‘whipped cream’, ‘latte’);
insert into AddToppings1 values (‘caramel drizzle’, ‘macchiato’);
insert into AddToppings1 values (‘cinnamon’, ‘cappuccino’);
insert into AddToppings1 values (‘icing sugar’, ‘drip coffee’);
insert into AddToppings1 values (‘cocoa powder’ ‘flat white’);

insert into AddToppings3 values (‘extra large’, ‘latte’);
insert into AddToppings3 values (‘medium’, ‘macchiato’);
insert into AddToppings3 values (‘small’, ‘cappuccino’);
insert into AddToppings3 values (‘large’, ‘drip coffee’);
insert into AddToppings3 values (‘short’, ‘flat white’);

insert into AddToppings4 values (‘extra large’, ’5 tsp’);
insert into AddToppings4 values (‘medium’, ‘3 tsp’);
insert into AddToppings4 values (‘small’, ‘2 tsp’);
insert into AddToppings4 values (‘large’, ‘4 tsp’);
insert into AddToppings4 values (‘short’, ‘1 tsp’);

insert into Toppings values (‘whipped cream’, ‘low’);
insert into Toppings values (‘caramel drizzle’, ‘low’);
insert into Toppings values (‘cinnamon’, ‘high’);
insert into Toppings values (‘icing sugar’, ‘low’);
insert into Toppings values (‘cocoa powder’ ‘high’);

insert into ListCream values (2024-08-01, ‘half and half’, ’10 cartons’);
insert into ListCream values (2024-08-11, ‘coconut’, ‘5 cartons’);
insert into ListCream values (2024-08-15, ‘oat’, ‘4 cartons’);
insert into ListCream values (2024-08-20, ‘almond’, ‘3 cartons’);
insert into ListCream values (2024-08-10, ‘soy’ ‘2 cartons’);

insert into AddCream1 values (‘half and half’, ‘latte’);
insert into AddCream1 values (‘coconut’, ‘macchiato’);
insert into AddCream1 values (‘oat’, ‘cappuccino’);
insert into AddCream1 values (‘almond’, ‘drip coffee’);
insert into AddCream1 values (‘soy’, ‘flat white’);

insert into AddCream3 values (‘extra large’, ‘latte’);
insert into AddCream3 values (‘medium’, ‘macchiato’);
insert into AddCream3 values (‘small’, ‘cappuccino’);
insert into AddCream3 values (‘large’, ‘drip coffee’);
insert into AddCream3 values (‘short’, ‘flat white’);

insert into AddCream4 values (‘extra large’, ‘2 cups’);
insert into AddCream4 values (‘medium’, ‘1 cup’);
insert into AddCream4 values (‘small’, ‘½  cup’);
insert into AddCream4 values (‘large’, ‘1.5 cups’);
insert into AddCream4 values (‘short’, ‘⅓ cup’);

insert into Cream values (‘half and half’, ‘low’);
insert into Cream values (‘coconut’, ‘low’);
insert into Cream values (‘oat’, ‘low’);
insert into Cream values (‘almond’, ‘high’);
insert into Cream values (‘soy’, ‘high’);

insert into ListSweetener values (2024-08-01, ‘honey’, ‘5 bottles’);
insert into ListSweetener values (2024-08-11, ‘cane sugar’, ‘5 bottles’);
insert into ListSweetener values (2024-08-15, ‘stevia’, ‘2 bottles’);
insert into ListSweetener values (2024-08-20, ‘vanilla syrup’, ‘4 bottles’);
insert into ListSweetener values (2024-08-10, ‘chocolate syrup’ ‘1 bottle’);

insert into AddSweetener1 values (‘honey’, ‘latte’);
insert into AddSweetener1 values (‘cane sugar’, ‘macchiato’);
insert into AddSweetener1 values (‘stevia’, ‘cappuccino’);
insert into AddSweetener1 values (‘vanilla syrup’, ‘drip coffee’);
insert into AddSweetener1 values (‘chocolate syrup’, ‘flat white’);

insert into AddSweetener3 values (‘extra large’, ‘latte’);
insert into AddSweetener3 values (‘medium’, ‘macchiato’);
insert into AddSweetener3 values (‘small’, ‘cappuccino’);
insert into AddSweetener3 values (‘large’, ‘drip coffee’);
insert into AddSweetener3 values (‘short’, ‘flat white’);

insert into AddSweetener4 values (‘extra large’, ‘latte’);
insert into AddSweetener4 values (‘medium’, ‘macchiato’);
insert into AddSweetener4 values (‘small’, ‘cappuccino’);
insert into AddSweetener4 values (‘large’, ‘drip coffee’);
insert into AddSweetener4 values (‘short’, ‘flat white’);

insert into Sweetner values (‘honey’, ‘high’);
insert into Sweetner values (‘cane sugar’, ‘low’);
insert into Sweetner values (‘stevia’, ‘low’);
insert into Sweetner values (‘vanilla syrup’, ‘high’);
insert into Sweetner values (‘chocolate syrup’, ‘low’);

insert into ListCoffee values (2024-08-01, ‘latte’, ‘5 bottles’);
insert into ListCoffee values (2024-08-11, ‘macchiato’, ‘5 bottles’);
insert into ListCoffee values (2024-08-15, ‘cappuccino’, ‘2 bottles’);
insert into ListCoffee values (2024-08-20, ‘drip coffee’, ‘4 bottles’);
insert into ListCoffee values (2024-08-10, ‘flat white’ ‘1 bottle’);

insert into Decaf values (‘latte’, ‘extra large’, ‘low’, ‘Arabica’, ‘light’);
insert into Decaf values (‘macchiato’, ‘medium’, ‘high’, ‘Liberica’, ‘light’);
insert into Decaf values (‘cappuccino’, ‘small’, ‘low’, ‘Arabica’, ‘medium’);
insert into Decaf values (‘drip coffee’, ‘large’, ‘high’, ‘Robusta’, ‘dark’);
insert into Decaf values (‘flat white’ ‘short’, ‘low’, ‘Arabica’, ‘dark’);

insert into Caffeinated values (‘latte’, ‘extra large’, ‘low’, ‘Arabica’, ‘light’);
insert into Caffeinated values (‘macchiato’, ‘medium’, ‘high’, ‘Liberica’, ‘light’);
insert into Caffeinated values (‘cappuccino’, ‘small’, ‘low’, ‘Arabica’, ‘medium’);
insert into Caffeinated values (‘drip coffee’, ‘large’, ‘high’, ‘Robusta’, ‘dark’);
insert into Caffeinated values (‘flat white’ ‘short’, ‘low’, ‘Arabica’, ‘dark’);

insert into AddEspresso1 values (‘latte’, 4, ‘extra strong’);
insert into AddEspresso1 values (‘macchiato’, 2, ‘medium’);
insert into AddEspresso1 values (‘cappuccino’, 1, ‘weak’);
insert into AddEspresso1 values (‘drip coffee’, 2, ‘medium’);
insert into AddEspresso1 values (‘flat white’, 1, ‘weak’);

insert into AddEspresso2 values (‘latte’, 4, ‘extra large’);
insert into AddEspresso2 values (‘macchiato’, 2, ‘medium’);
insert into AddEspresso2 values (‘cappuccino’, 1, ‘small’);
insert into AddEspresso2 values (‘drip coffee’, 2, ‘large’);
insert into AddEspresso2 values (‘flat white’, 1, ‘short’);

insert into Espresso values (‘weak’, ‘single shot’);
insert into Espresso values (‘medium’, ‘double shot’);
insert into Espresso values (‘strong’, ‘triple shot’);
insert into Espresso values (‘extra strong’, ‘4 shots’);
insert into Espresso values (‘super strong’, ‘5 shots’);

insert into IcedCoffee1 values (‘latte’, ‘espresso machine’);
insert into IcedCoffee1 values (‘macchiato’, ‘espresso machine’);
insert into IcedCoffee1 values (‘cappuccino’, ‘espresso machine’);
insert into IcedCoffee1 values (‘drip coffee’, ‘french press’);
insert into IcedCoffee1 values (‘flat white’ ,’espresso machine’);

insert into IcedCoffee3 values (‘extra large’, ‘1 scoop’);
insert into IcedCoffee3 values (‘medium’, ‘2 scoops’);
insert into IcedCoffee3 values (‘small’, ‘half scoop’);
insert into IcedCoffee3 values (‘large’, ‘2 scoops’);
insert into IcedCoffee3 values (‘short’, ‘half scoop’);

insert into IcedCoffee4 values (‘extra large’, ‘latte’);
insert into IcedCoffee4 values (‘medium’, ‘macchiato’);
insert into IcedCoffee4 values (‘small’, ‘cappuccino’);
insert into IcedCoffee4 values (‘large’, ‘drip coffee’);
insert into IcedCoffee4 values (‘short’, ‘flat white’);