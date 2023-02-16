# comp3161-project
#Jordan Lewis       
#Khalid Williams
#Shane-Michael Thompson
#Tadave Brown
#Noel Powel

This final project consists of two (2) parts:
The first part will be a document that will consist of the ER Diagram that was chosen as the best for
the implementation of the application, the tables before normalization, the list of functional
dependencies and the set of normalized tables. You should clearly indicate which keys are to be used as
the primary keys. Your normalized tables should be in at least 3NF, and where possible BCNF. Explain
which form each table is in and your reasons for choosing this form. You should also include a data
dictionary, describing the intended meanings of the various table and attribute names used in the tables.
The second part will be the application. The choice of front end is up to you. The requirements for the
application are:
1. You should ensure that all the requirements from Assignment 1 are done.
2. You need to authenticate to use the system. You do not need to register using email
 confirmations, you can just allow a user to sign up and then be able to log in.
3. You must use at least 2 stored procedures in your queries.
4. The database should contain at least 200,000 fake users and 600,000 fake recipes. You will need to 
use a programming language and an appropriate helper library of your choosing to populate your tables
(eg. Python and Faker). The script should output an sql file that you will execute for the population 
of your databases. Make all the necessary decisions to optimize your application's communication with
the database.
5. You should provide the script (Not the SQL File) used to create and populate your database. Attach
 this file to the document created in the first part of this assignment.
6. You should also be able to provide the following additional feature:
(a). Search for recipes and follow a link that will give the details of the recipe(s) that you find