DROP DATABASE IF EXISTS MealPlanProj;
CREATE DATABASE MealPlanProj;
USE MealPlanProj;

CREATE TABLE Users (
                userID INT NOT NULL AUTO_INCREMENT,
                user_fname VARCHAR(255) NOT NULL,
                user_lname VARCHAR(255) NOT NULL,
                user_password VARCHAR(255) NOT NULL,
                user_email VARCHAR(255) NOT NULL,
                PRIMARY KEY(userID)
        );

CREATE TABLE MealPlanner(
        planner_id INT NOT NULL AUTO_INCREMENT,
        userID INT NOT NULL,
        PRIMARY KEY(planner_id),
        FOREIGN KEY(userID) REFERENCES Users(userID) ON DELETE CASCADE ON UPDATE CASCADE,
        UNIQUE KEY(userID)
        );

CREATE TABLE Recipe (
        recipe_id INT NOT NULL AUTO_INCREMENT,
        recipe_nm VARCHAR(255) NOT NULL,
        date_created DATE NOT NULL,
        estimatedtime TIME NOT NULL,
        recipe_description VARCHAR(255) NOT NULL,
        image VARCHAR(255) NOT NULL,
        PRIMARY KEY(recipe_id)
        ); 

CREATE TABLE CalorieCount (
        calorie_c_id INT NOT NULL AUTO_INCREMENT,
        number_of_calories INT NOT NULL,
        type_of_calories VARCHAR(255) NOT NULL,
        PRIMARY KEY(calorie_c_id)
        );

CREATE TABLE instruction (
        instruct_id INT NOT NULL AUTO_INCREMENT,
	instruct_description VARCHAR(255) NOT NULL,
	recipe_id INT NOT NULL,
        PRIMARY KEY(instruct_id),
	FOREIGN KEY(recipe_id) REFERENCES Recipe(recipe_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Ingredients (
        ingredient_id INT NOT NULL AUTO_INCREMENT,
        ingredient_name VARCHAR(255) NOT NULL,
        PRIMARY KEY(ingredient_id),
        UNIQUE KEY(ingredient_name)
        );

CREATE TABLE Measurements (
        measure_id INT NOT NULL AUTO_INCREMENT,
	unit VARCHAR(15) NOT NULL,
        PRIMARY KEY(measure_id)
);

CREATE TABLE IngredientMeasurement(
        recipe_id INT NOT NULL,
	ingredient_id INT NOT NULL,
	measure_id INT NOT NULL,
	quantity FLOAT(2) NOT NULL,
        PRIMARY KEY(recipe_id, ingredient_id),
	FOREIGN KEY(recipe_id) REFERENCES Recipe(recipe_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(ingredient_id) REFERENCES Ingredients(ingredient_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(measure_id) REFERENCES Measurements(measure_id) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE Meals(
        meal_id INT NOT NULL AUTO_INCREMENT,
        planner_id INT NOT NULL,
        meal_name varchar(255) NOT NULL,
        meal_type varchar(255) NOT NULL,
        servingsize INT NOT NULL,
        calorie_c_id INT NOT NULL,
        recipe_id INT NOT NULL,
        PRIMARY KEY(meal_id, planner_id),
        FOREIGN KEY(recipe_id) REFERENCES Recipe(recipe_id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(calorie_c_id) REFERENCES CalorieCount(calorie_c_id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(planner_id) REFERENCES MealPlanner(planner_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE AvailableIngredients(
        userID INT NOT NULL,
	ingredient_id INT NOT NULL,
	quantity_of_ingredients INT NOT NULL,
        PRIMARY KEY(userID, ingredient_id),
	FOREIGN KEY(userID) REFERENCES Users(userID) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(ingredient_id) REFERENCES Ingredients(ingredient_id) ON DELETE CASCADE ON UPDATE CASCADE
);

DELIMITER //
CREATE PROCEDURE userGet(IN userid INT)
BEGIN   
    SELECT * FROM Users WHERE userID=userid;   
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE recipeAdd(IN n_rname VARCHAR(255),IN n_date DATETIME, IN n_time TIME, IN n_desc VARCHAR(255),IN n_image VARCHAR(255))
BEGIN  
        INSERT INTO Recipe(recipe_nm,image, estimatedtime, date_created, recipe_description)
        VALUES (n_rname,n_image, n_estimatedtime, n_date, n_desc);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE userAdd( IN n_user_fname VARCHAR(255), IN n_user_lname VARCHAR(255), IN n_user_password VARCHAR(255), IN n_user_email VARCHAR(255))
BEGIN
        INSERT INTO Users(user_fname, user_lname, user_password,user_email) VALUES
        (n_user_fname, n_user_lname, n_user_password,n_user_email);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE MealPlanGet(IN userID INT)
BEGIN
    SELECT p.meals_that_are_planned FROM Planners_containing_meals_json p WHERE  p.userID = userID;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE SuperMarketListGET(IN userID INT)
BEGIN
    SELECT * FROM MarketLists s WHERE s.userID = userID;
    
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE RecipeSearch(IN rnm VARCHAR(255))
BEGIN
    Select recipe_id,recipe_nm,recipe_description,image FROM Recipe allr where allr.recipe_nm LIKE rnm;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE  userCount()
BEGIN
    SELECT COUNT(userID) from Users;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE MealGet(IN mid INT)
BEGIN
     Select * from p_meal_recipe_json_cal p where p.meal_id =mid;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE RecipeSpecificGet(IN rid INT)
BEGIN
    Select * FROM all_recipes_json allr where allr.recipe_id=rid;
END //
DELIMITER ;

Insert into Users VALUES (1,"Daniel","Wolf","8DXJsttx&7","DanielWolf@NotanEmail.com");
CREATE VIEW user_stock
AS

SELECT 
    u.userID, u.user_fname, u.user_lname,
    ai.ingredient_id, ai.ingredient_name, ai.quantity_of_ingredients
FROM 
    Users u JOIN(
        SELECT 
            a.quantity_of_ingredients, a.ingredient_id,
            i.ingredient_name, a.userID
        FROM
            AvailableIngredients a
            JOIN Ingredients i
            ON i.ingredient_id=a.ingredient_id
        ) ai
    ON ai.userID=u.userID
;




/* coming back to this */
CREATE VIEW Ing_measured  AS
SELECT 
    ime_i.ingredient_id,
    ime_i.ingredient_name,
    m.measure_id,
    m.unit,
    ime_i.quantity,
    ime_i.recipe_id
FROM Measurements m JOIN 
    (SELECT 
            ime.recipe_id,
            ime.ingredient_id,
            i.ingredient_name,
            ime.measure_id,
            ime.quantity
        FROM 
            IngredientMeasurement ime 
            JOIN Ingredients i
            ON i.ingredient_id=ime.ingredient_id
    )ime_i
    ON ime_i.measure_id=m.measure_id
;

-- return to this    
CREATE VIEW Ing_measured_json
AS
SELECT
    im.recipe_id,
    JSON_ARRAYAGG(
        CONCAT(im.quantity," ",im.unit," ",im.ingredient_name )
        )ingredients
FROM Ing_measured im
GROUP BY im.recipe_id
;

CREATE VIEW instruction_json AS
SELECT
    i.recipe_id,
    JSON_ARRAYAGG(i.instruct_description)instructions
FROM instruction i
GROUP BY i.recipe_id
;
    
CREATE VIEW all_recipes AS
SELECT 
    rin.recipe_id,
    rin.recipe_nm,
    rin.image,
    rin.estimatedtime,
    rin.date_created,
    rin.recipe_description,
    rin.instruct_id,
    rin.instruct_description,
    im.ingredient_id,
    im.ingredient_name,
    im.measure_id,
    im.quantity,
    im.unit
FROM
    Ing_measured im
    JOIN(
        SELECT
            r.recipe_id,
            r.recipe_nm,
            r.image,
            r.estimatedtime,
            r.date_created,
            r.recipe_description,
            ins.instruct_id,
            ins.instruct_description
        FROM Recipe r JOIN instruction ins ON ins.recipe_id=r.recipe_id
    ) rin
    ON rin.recipe_id=im.recipe_id
;
    
CREATE VIEW all_recipes_json AS
SELECT 
    rin.recipe_id,
    rin.recipe_nm,
    rin.image,
    rin.estimatedtime,
    rin.date_created,
    rin.recipe_description,
    rin.instructions,
    im.ingredients
FROM
    Ing_measured_json im 
    JOIN(
        SELECT 
            recp.recipe_id,recp.recipe_nm,recp.image,
            recp.estimatedtime,
            recp.date_created,
            recp.recipe_description,
            ins.instructions
        FROM Recipe recp JOIN instruction_json ins ON ins.recipe_id=recp.recipe_id
        GROUP BY recp.recipe_id
    ) rin
    ON rin.recipe_id=im.recipe_id
    GROUP BY rin.recipe_id
;
    
CREATE VIEW p_meal_recipe AS
SELECT 
    ar.recipe_id,
    ar.recipe_nm,
    ar.image,
    ar.estimatedtime,
    ar.date_created,
    ar.recipe_description,
    ar.instruct_id,
    ar.instruct_description,
    ar.ingredient_id,
    ar.ingredient_name,
    ar.measure_id,
    ar.quantity,
    ar.unit,
    meal.calorie_c_id,
    meal.meal_id,
    meal.servingsize,
    meal.planner_id,
    meal.meal_type
FROM
    Meals meal JOIN all_recipes ar ON meal.recipe_id=ar.recipe_id
;
    
CREATE VIEW p_meal_recipe_json AS
SELECT
    alrj.recipe_id,
    alrj.recipe_nm,
    alrj.image,
    alrj.estimatedtime,
    alrj.date_created,
    alrj.recipe_description,
    alrj.instructions,
    alrj.ingredients,
    meal.calorie_c_id,
    meal.meal_id,
    meal.planner_id,
    meal.servingsize,
    meal.meal_type
FROM
    Meals meal JOIN all_recipes_json alrj ON meal.recipe_id=alrj.recipe_id
;
CREATE VIEW p_meal_recipe_json_cal AS
SELECT
    pmrj.recipe_id,
    pmrj.recipe_nm,
    pmrj.image,
    pmrj.estimatedtime,
    pmrj.date_created,
    pmrj.recipe_description,
    pmrj.instructions,
    pmrj.ingredients,
    pmrj.meal_id,
    pmrj.planner_id,
    pmrj.servingsize,
    pmrj.meal_type,
    CONCAT(c.number_of_calories," ",c.type_of_calories) Calories
FROM
    CalorieCount c JOIN p_meal_recipe_json pmrj ON c.calorie_c_id=pmrj.calorie_c_id
;

CREATE VIEW Planners_containing_meals AS
SELECT
    pmr.planner_id,
    mp.userID,
    pmr.recipe_id,
    pmr.recipe_nm,
    pmr.image,
    pmr.estimatedtime,
    pmr.date_created,
    pmr.recipe_description,
    pmr.instruct_id,
    pmr.instruct_description,
    pmr.ingredient_id,
    pmr.ingredient_name,
    pmr.measure_id,
    pmr.quantity,
    pmr.unit,
    pmr.calorie_c_id,
    pmr.meal_id,
    pmr.servingsize,
    pmr.meal_type
FROM
    MealPlanner mp JOIN p_meal_recipe pmr ON pmr.planner_id=mp.planner_id
;

CREATE VIEW Planners_containing_meals_json AS
SELECT 
    mp.userID, 
    mp.planner_id,
    JSON_ARRAYAGG(CONCAT(pmrjc.image,", ",
    pmrjc.recipe_nm," ,",
    pmrjc.recipe_id," ,",
    pmrjc.meal_type,", ",
    pmrjc.servingsize,", ",
        pmrjc.Calories," "
        )) meals_that_are_planned
FROM
    MealPlanner mp JOIN p_meal_recipe_json_cal pmrjc ON mp.planner_id=pmrjc.planner_id
Group by mp.planner_id;
;
    
CREATE VIEW MarketLists AS
SELECT
    pa.userID,
    u.user_fname,
    u.user_lname,
    pa.ingredient_name,
    u.quantity_of_ingredients,
    pa.total_amount amount_needed,
    pa.unit
FROM
    user_stock u
    JOIN 
        ( SELECT
                p.userID,
                p.ingredient_name,
                SUM(p.quantity) total_amount,
                p.unit
            FROM
                Planners_containing_meals p
            GROUP BY p.userID, p.ingredient_name
        ) pa
    ON pa.userID=u.userID
GROUP BY pa.userID, pa.ingredient_name
;

