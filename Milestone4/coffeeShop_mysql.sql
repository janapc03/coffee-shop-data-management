DROP TABLE IF EXISTS Deliver;
DROP TABLE IF EXISTS Delivery;
DROP TABLE IF EXISTS Fund;
DROP TABLE IF EXISTS Purchase;
DROP TABLE IF EXISTS Supplier;
DROP TABLE IF EXISTS ListToppings;
DROP TABLE IF EXISTS ListCream;
DROP TABLE IF EXISTS ListSweetener;
DROP TABLE IF EXISTS ShoppingList;
DROP TABLE IF EXISTS Sales;
DROP TABLE IF EXISTS AddToppings;
DROP TABLE IF EXISTS Toppings;
DROP TABLE IF EXISTS AddCream;
DROP TABLE IF EXISTS Cream;
DROP TABLE IF EXISTS AddSweetener;
DROP TABLE IF EXISTS Sweetener;
DROP TABLE IF EXISTS ListCoffee1;
DROP TABLE IF EXISTS ListCoffee2;
DROP TABLE IF EXISTS Decaf;
DROP TABLE IF EXISTS Caffeinated;
DROP TABLE IF EXISTS IcedCoffee;
DROP TABLE IF EXISTS Coffee;

CREATE TABLE Delivery (
    trackingNum	INT PRIMARY KEY,
    expectedDate date not null
);

CREATE TABLE Supplier (
    supName VARCHAR(50) PRIMARY KEY,
    address VARCHAR(30)	not null
);

CREATE TABLE Deliver (
    supName VARCHAR(50),
    trackingNum int,
    PRIMARY KEY (supName, trackingNum),
    FOREIGN KEY (supName) REFERENCES Supplier (supName) ON DELETE CASCADE,
    FOREIGN KEY (trackingNum) REFERENCES Delivery (trackingNum) ON DELETE CASCADE
    );

CREATE TABLE ShoppingList (
    listDate DATE PRIMARY KEY,
    funds INT NOT NULL
);

CREATE TABLE Purchase (
    trackingNum INT,
    listDate DATE,
    price INT NOT NULL,
    PRIMARY KEY (trackingNum, listDate),
    FOREIGN KEY (trackingNum) REFERENCES Delivery (trackingNum) ON DELETE CASCADE,
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listDate) ON DELETE CASCADE
);

CREATE TABLE Sales (
    salesDate DATE PRIMARY KEY,
    employeePay INT NOT NULL,
    cafeFunds INT NOT NULL,
);

CREATE TABLE Fund (
    listDate DATE,
    salesDate DATE,
    PRIMARY KEY (listDate, salesDate),
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listDate) ON DELETE CASCADE,
    FOREIGN KEY (salesDate) REFERENCES Sales (salesDate) ON DELETE CASCADE
);

CREATE TABLE Coffee (
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    PRIMARY KEY (coffeeName, coffeeSize)
);

CREATE TABLE Toppings (
    toppingName VARCHAR(30) PRIMARY KEY,
    toppingInv INT NOT NULL
);

CREATE TABLE ListToppings (
    listDate DATE,
    toppingName VARCHAR(30),
    toppingQuant VARCHAR(20) NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY (listDate, toppingName),
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listDate) ON DELETE CASCADE,
    FOREIGN KEY (toppingName) REFERENCES Toppings (toppingName) ON DELETE CASCADE
);

CREATE TABLE AddToppings (
    toppingName VARCHAR(30),
    toppingAmount VARCHAR(20) NOT NULL,
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    PRIMARY KEY (toppingName, coffeeName, coffeeSize),
    FOREIGN KEY (toppingName) REFERENCES Toppings (toppingName) ON DELETE CASCADE,
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

CREATE TABLE Cream (
    creamName VARCHAR(30) PRIMARY KEY,
    creamInv INT NOT NULL
);

CREATE TABLE ListCream (
    listDate DATE,
    creamName VARCHAR(30),
    creamQuant VARCHAR(20) NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY (listDate, creamName),
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listdate) ON DELETE CASCADE,
    FOREIGN KEY (creamName) REFERENCES Cream (creamName) ON DELETE CASCADE
);

CREATE TABLE AddCream (
    creamName VARCHAR(30),
    cupAmount VARCHAR(20) NOT NULL,
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    PRIMARY KEY (creamName, coffeeName, coffeeSize),
    FOREIGN KEY (creamName) REFERENCES Cream (creamName) ON DELETE CASCADE,
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

CREATE TABLE Sweetener (
    sweetName VARCHAR(30) PRIMARY KEY,
    sweetenerInv INT NOT NULL
);

CREATE TABLE ListSweetener (
    listDate DATE,
    sweetName VARCHAR(30),
    sweetenerQuant VARCHAR(20) NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY (listDate, sweetName),
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listDate) ON DELETE CASCADE,
    FOREIGN KEY (sweetName) REFERENCES Sweetener (sweetName) ON DELETE CASCADE
);

CREATE TABLE AddSweetener (
    sweetName VARCHAR(30),
    sweetenerAmount VARCHAR(20) NOT NULL,
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    PRIMARY KEY (sweetName, coffeeName, coffeeSize),
    FOREIGN KEY (sweetName) REFERENCES Sweetener (sweetName) ON DELETE CASCADE,
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

CREATE TABLE ListCoffee1 (
    listDate DATE,
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    PRIMARY KEY (listDate, coffeeName, coffeeSize),
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listDate) ON DELETE CASCADE,
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

CREATE TABLE ListCoffee2 (
    listDate DATE PRIMARY KEY,
    coffeeQuant VARCHAR(20) NOT NULL,
    price INT NOT NULL,
    FOREIGN KEY (listDate) REFERENCES ShoppingList (listDate) ON DELETE CASCADE
);

CREATE TABLE Decaf (
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    coffeeInv INT NOT NULL,
    roastLevel VARCHAR(20) NOT NULL,
    PRIMARY KEY (coffeeName, coffeeSize),
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

CREATE TABLE Caffeinated (
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    coffeeInv INT NOT NULL,
    roastLevel VARCHAR(20) NOT NULL,
    numShots INT NOT NULL,
    PRIMARY KEY (coffeeName, coffeeSize),
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

CREATE TABLE IcedCoffee (
    coffeeName VARCHAR(30),
    coffeeSize VARCHAR(20),
    method VARCHAR(30) NOT NULL,
    iceAmount VARCHAR(20) NOT NULL,
    PRIMARY KEY (coffeeSize, coffeeName),
    FOREIGN KEY (coffeeName, coffeeSize) REFERENCES Coffee (coffeeName, coffeeSize) ON DELETE CASCADE
);

insert into Delivery values (1234, '2024-09-01');
insert into Delivery values (2345, '2024-07-10');
insert into Delivery values (3456, '2024-06-01');
insert into Delivery values (1235, '2024-09-10');
insert into Delivery values (1236, '2024-09-20');
insert into Delivery values (1237, '2024-09-30');
insert into Delivery values (1238, '2024-10-15');
insert into Delivery values (4567, '2024-07-29');

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

insert into ShoppingList values ('2024-08-01', 500);
insert into ShoppingList values ('2024-06-18', 900);
insert into ShoppingList values ('2024-05-22', 300);
insert into ShoppingList values ('2024-08-11', 650);
insert into ShoppingList values ('2024-08-15', 420);
insert into ShoppingList values ('2024-08-20', 399);
insert into ShoppingList values ('2024-08-10', 800);
insert into ShoppingList values ('2024-07-19', 110);

insert into Purchase values (1234, '2024-08-01', 150);
insert into Purchase values (2345, '2024-06-18', 452);
insert into Purchase values (3456, '2024-05-22', 220);
insert into Purchase values (1235, '2024-08-11', 300);
insert into Purchase values (1236, '2024-08-15', 275);
insert into Purchase values (1237, '2024-08-20', 399);
insert into Purchase values (1238, '2024-08-10', 200);
insert into Purchase values (4567, '2024-07-19', 60);

insert into Sales values ('2024-07-30', 500, 1200);
insert into Sales values ('2024-08-10', 590, 1300);
insert into Sales values ('2024-08-14', 700, 1250);
insert into Sales values ('2024-08-19', 600, 1350);
insert into Sales values ('2024-08-09', 800, 1100);

insert into Fund values ('2024-08-01', '2024-07-30');
insert into Fund values ('2024-08-11', '2024-08-10');
insert into Fund values ('2024-08-15', '2024-08-14');
insert into Fund values ('2024-08-20', '2024-08-19');
insert into Fund values ('2024-08-10', '2024-08-09');

insert into Coffee values ('latte', 'extra large');
insert into Coffee values ('macchiato', 'medium');
insert into Coffee values ('macchiato', 'large');
insert into Coffee values ('cappuccino', 'small');
insert into Coffee values ('drip coffee', 'large');
insert into Coffee values ('flat white', 'short');
insert into Coffee values ('decaf latte', 'extra large');
insert into Coffee values ('decaf macchiato', 'medium');
insert into Coffee values ('decaf cappuccino', 'small');
insert into Coffee values ('decaf drip coffee', 'large');
insert into Coffee values ('decaf flat white', 'short');

insert into Toppings values ('whipped cream', 50);
insert into Toppings values ('caramel drizzle', 30);
insert into Toppings values ('cinnamon', 20);
insert into Toppings values ('icing sugar', 100);
insert into Toppings values ('cocoa powder', 120);

insert into ListToppings values ('2024-08-01', 'whipped cream', '4 bottles', 10);
insert into ListToppings values ('2024-06-18', 'cinnamon', '2 bottles', 50);
insert into ListToppings values ('2024-05-22', 'icing sugar', '1 bottle', 5);
insert into ListToppings values ('2024-08-11', 'caramel drizzle', '2 bottles', 40);
insert into ListToppings values ('2024-08-15', 'cinnamon', '1 bottle', 10);
insert into ListToppings values ('2024-08-20', 'icing sugar', '3 bottles', 29);
insert into ListToppings values ('2024-08-10', 'cocoa powder', '4 bottles', 60);
insert into ListToppings values ('2024-08-01', 'cocoa powder', '1 bottle', 15);

insert into AddToppings values ('whipped cream', '5 tsp', 'latte', 'extra large');
insert into AddToppings values ('caramel drizzle', '3 tsp', 'macchiato', 'medium');
insert into AddToppings values ('cinnamon', '2 tsp', 'cappuccino', 'small');
insert into AddToppings values ('icing sugar', '4 tsp', 'drip coffee', 'large');
insert into AddToppings values ('cocoa powder', '1 tsp', 'flat white', 'short');
insert into AddToppings values ('cocoa powder', '5 tsp', 'macchiato', 'medium');
insert into AddToppings values ('cinnamon', '5 tsp', 'macchiato', 'medium');
insert into AddToppings values ('icing sugar', '5 tsp', 'macchiato', 'medium');
insert into AddToppings values ('whipped cream', '5 tsp', 'macchiato', 'medium');
insert into AddToppings values ('whipped cream', '7 tsp', 'macchiato', 'large');

insert into Cream values ('half and half', 100);
insert into Cream values ('coconut', 50);
insert into Cream values ('oat', 89);
insert into Cream values ('almond', 165);
insert into Cream values ('soy', 83);

insert into ListCream values ('2024-08-01', 'half and half', '10 cartons', 100);
insert into ListCream values ('2024-06-18', 'coconut', '5 cartons', 200);
insert into ListCream values ('2024-05-22', 'almond', '4 cartons', 100);
insert into ListCream values ('2024-08-11', 'coconut', '5 cartons', 120);
insert into ListCream values ('2024-08-15', 'oat', '4 cartons', 140);
insert into ListCream values ('2024-08-20', 'almond', '3 cartons', 150);
insert into ListCream values ('2024-08-10', 'soy', '2 cartons', 40);
insert into ListCream values ('2024-08-10', 'oat', '1 carton', 40);

insert into AddCream values ('half and half', '2 cups', 'latte', 'extra large');
insert into AddCream values ('coconut', '1 cup', 'macchiato', 'medium');
insert into AddCream values ('oat', '1/2  cup', 'cappuccino', 'small');
insert into AddCream values ('almond', '1.5 cups', 'drip coffee', 'large');
insert into AddCream values ('soy', '1/3 cup', 'flat white', 'short');
insert into AddCream values ('soy', '1/3 cup', 'latte', 'extra large');
insert into AddCream values ('coconut', '1/3 cup', 'latte', 'extra large');
insert into AddCream values ('oat', '1/3 cup', 'latte', 'extra large');
insert into AddCream values ('almond', '1/3 cup', 'latte', 'extra large');

insert into Sweetener values ('honey', 148);
insert into Sweetener values ('cane sugar', 167);
insert into Sweetener values ('stevia', 60);
insert into Sweetener values ('vanilla syrup', 76);
insert into Sweetener values ('chocolate syrup', 51);

insert into ListSweetener values ('2024-08-01', 'honey', '5 bottles', 15);
insert into ListSweetener values ('2024-06-18', 'stevia', '5 bottles', 52);
insert into ListSweetener values ('2024-05-22', 'honey', '2 bottles', 14);
insert into ListSweetener values ('2024-08-11', 'cane sugar', '5 bottles', 40);
insert into ListSweetener values ('2024-08-15', 'stevia', '2 bottles', 30);
insert into ListSweetener values ('2024-08-20', 'vanilla syrup', '4 bottles', 40);
insert into ListSweetener values ('2024-08-10', 'chocolate syrup', '1 bottle', 15);
insert into ListSweetener values ('2024-07-19', 'chocolate syrup', '3 bottles', 15);

insert into AddSweetener values ('honey', '2 pump', 'latte', 'extra large');
insert into AddSweetener values ('cane sugar', '3 spoons', 'macchiato', 'medium');
insert into AddSweetener values ('stevia', '2 pumps', 'cappuccino', 'small');
insert into AddSweetener values ('vanilla syrup', '1 pump', 'drip coffee', 'large');
insert into AddSweetener values ('chocolate syrup', '3 pumps', 'flat white', 'short');
insert into AddSweetener values ('chocolate syrup', '3 pumps', 'drip coffee', 'large');
insert into AddSweetener values ('honey', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('cane sugar', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('stevia', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('vanilla syrup', '2 pumps', 'decaf cappuccino', 'small');
insert into AddSweetener values ('chocolate syrup', '2 pumps', 'decaf cappuccino', 'small');

insert into ListCoffee1 values ('2024-08-01', 'latte', 'extra large');
insert into ListCoffee1 values ('2024-06-18', 'cappuccino', 'small');
insert into ListCoffee1 values ('2024-05-22', 'decaf latte', 'extra large');
insert into ListCoffee1 values ('2024-08-11', 'macchiato', 'medium');
insert into ListCoffee1 values ('2024-08-15', 'cappuccino', 'small');
insert into ListCoffee1 values ('2024-08-20', 'drip coffee', 'large');
insert into ListCoffee1 values ('2024-08-10', 'flat white', 'short');
insert into ListCoffee1 values ('2024-07-19', 'macchiato', 'medium');

insert into ListCoffee2 values ('2024-08-01', '5 bottles', 10);
insert into ListCoffee2 values ('2024-08-11', '6 bottles', 150);
insert into ListCoffee2 values ('2024-08-15', '3 bottles', 100);
insert into ListCoffee2 values ('2024-06-18', '5 bottles', 100);
insert into ListCoffee2 values ('2024-05-22', '2 bottles', 95);
insert into ListCoffee2 values ('2024-08-20', '4 bottles', 180);
insert into ListCoffee2 values ('2024-08-10', '1 bottle', 45);
insert into ListCoffee2 values ('2024-07-19', '2 bottle', 45);

insert into Decaf values ('decaf latte', 'extra large', 95, 'light');
insert into Decaf values ('decaf macchiato', 'medium', 95, 'light');
insert into Decaf values ('decaf cappuccino', 'small', 95,'medium');
insert into Decaf values ('decaf drip coffee', 'large', 95, 'dark');
insert into Decaf values ('decaf flat white', 'short', 95, 'dark');

insert into Caffeinated values ('latte', 'extra large', 145, 'light', 3);
insert into Caffeinated values ('macchiato', 'medium', 145, 'light', 2);
insert into Caffeinated values ('macchiato', 'large', 145, 'light', 3);
insert into Caffeinated values ('cappuccino', 'small', 145, 'medium', 1);
insert into Caffeinated values ('drip coffee', 'large', 145, 'dark', 3);
insert into Caffeinated values ('flat white', 'short', 145, 'dark', 0);

insert into IcedCoffee values ('latte', 'extra large', 'iced', '1 scoop');
insert into IcedCoffee values ('macchiato', 'medium', 'ice cap', '2 scoops');
insert into IcedCoffee values ('cappuccino', 'small', 'iced', 'half scoop');
insert into IcedCoffee values ('drip coffee', 'large', 'cold brew', '2 scoops');
insert into IcedCoffee values ('flat white', 'short','ice cap', 'half scoop');

commit;