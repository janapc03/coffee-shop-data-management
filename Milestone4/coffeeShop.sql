drop table delivery;

create table Delivery (
    trackingNum	int	primary key,
    expectedDate date);
grant select on Delivery to public;

insert into Delivery values (1234, 2024-09-01);
insert into Delivery values (1235, 2024-09-10);
insert into Delivery values (1236, 2024-09-20);
insert into Delivery values (1237, 2024-09-30);
insert into Delivery values (1238, 2024-10-15);