
<!--Student_Name: LauNgocQuyen--> <!--Student_ID: 104198996-->
-- TASK 1:
-- Create the cars table
CREATE TABLE cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50),
    model VARCHAR(50),
    price DECIMAL(10,2),
    yom INT
);

-- Insert 10+ records into the cars table
INSERT INTO cars (make, model, price, yom) VALUES
('Holden', 'Astra', 14000.00, 2005),
('BMW', 'X3', 35000.00, 2004),
('Ford', 'Falcon', 39000.00, 2011),
('Toyota', 'Corolla', 20000.00, 2012),
('Holden', 'Commodore', 13500.00, 2005),
('Holden', 'Astra', 8000.00, 2001),
('Holden', 'Commodore', 28000.00, 2009),
('Ford', 'Falcon', 14000.00, 2007),
('Ford', 'Falcon', 7000.00, 2003),
('Ford', 'Laser', 10000.00, 2010),
('Mazda', 'RX-7', 26000.00, 2000),
('Toyota', 'Corolla', 12000.00, 2001),
('Mazda', '3', 14500.00, 2009);


--TASK 2:
-- 1. All records
SELECT * FROM cars;

-- 2. Make, model, and price, sorted by make and model (default is asc)
SELECT make, model, price
FROM cars
ORDER BY make, model;

-- 3. Make and model of cars costing 20,000.00 or more
SELECT make, model
FROM cars
WHERE price >= 20000.00;

-- 4. Make and model of cars costing below 15,000.00
SELECT make, model
FROM cars
WHERE price < 15000.00;

-- 5. Average price of cars for similar make
SELECT make, AVG(price) AS average_price
FROM cars
GROUP BY make;




