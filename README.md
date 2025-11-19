# Coffee Shop Management Site
---
## Application Description

This site is for cafes and coffee shops, focusing on inventory management and recipe directions for drinks. Specifically, the database shows how the cafe’s sales are used in this process and the various details in purchasing these ingredients, such as the supplier’s location, their available coffee bean types, and delivery options.

Users are able to view the recipes for each drink, including the type, toppings, and other additions, as well as the required amounts of each. Moreover, users are able to see where they can purchase each ingredient and add ingredients to a shopping list. Depending on the shop’s funds, these items can then be ordered and "delivered" to the cafe.

---

## Query Functionalities

The site includes basic insert, delete, and update functionalities based on user input. Some examples of more complex queries can be seen below.

**Find the average order cost for each supplier:**
```
SELECT d.supName AS SUPNAME, COUNT(d.supName) AS COUNT_SUPNAME, AVG(p.price) AS AVG_PRICE
FROM Deliver d, Delivery dy, Purchase p, ShoppingList sl
WHERE d.trackingNum=dy.trackingNum AND dy.trackingNum=p.trackingNum AND p.listDate=sl.listDate
GROUP BY d.supName;
```
Output:

<img width="328" height="130" alt="Screenshot 2025-11-19 at 9 33 57 AM" src="https://github.com/user-attachments/assets/7f98cf33-7520-4adf-a71b-c92f02784cf2" />

**Find the number of creamer products that were purchased at a below-average price:**
```
SELECT COUNT(*) AS BELOW_AVG_PURCHASE
FROM listCream
WHERE price < (SELECT AVG(price) FROM listCream);
```
Output:

<img width="164" height="71" alt="Screenshot 2025-11-19 at 9 54 31 AM" src="https://github.com/user-attachments/assets/899ad983-ad1e-4b83-a0d8-ac0e710bd0a8" />

---

## Database Design

This data is synthetic and was created specifically to be used for this site. 
The database was designed using the following Entity Relationship Diagram:

<img width="519" height="633" alt="Screenshot 2025-11-19 at 2 06 45 PM" src="https://github.com/user-attachments/assets/a2854c04-3e63-4b13-8229-2c74319d725b" />

The database was initially hosted on Oracle, but has since been refactored to use MySQL instead.
