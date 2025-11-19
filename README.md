# Coffee Shop Management Site
---
## Application Description
This application is for cafes and coffee shops, focusing specifically on inventory management and recipe directions for drinks. Specifically, the database shows how the cafe’s sales are used in this process and the various details in purchasing these ingredients, such as the supplier’s location, their available coffee bean types, and delivery options.

Users are able to view the recipes for each drink, including the type, toppings, and other additions, as well as the required amounts of each. Moreover, users are able to see where they can purchase each ingredient and add ingredients to a shopping list. Depending on the shop’s funds, these items can then be ordered and delivered to the cafe.
---
## Query Functionalities

Find the average order cost for each supplier:
```
SELECT d.supName AS SUPNAME, COUNT(d.supName) AS COUNT_SUPNAME, AVG(p.price) AS AVG_PRICE
		 FROM Deliver d, Delivery dy, Purchase p, ShoppingList sl
		 WHERE d.trackingNum=dy.trackingNum AND dy.trackingNum=p.trackingNum AND p.listDate=sl.listDate
		 GROUP BY d.supName
```
