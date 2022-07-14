## Introduction 

This project was developed and structured based on the following expectation but also there are additional classes and APIs to be more familiar with my programming knowledge



    1- authentication method 
    
    2- migrations and database seeders 

    3- models 

    4- base repository and model repository 

    5- query builder 

    6- services and chain checkers classes 



###installation

## 1- authentication method
The project use sanctum to authenticate API user

#

## 2- migrations and database seeders
All tables migration columns are too clear but 2 complexes have static data, this means after migrating these tables data will automatically insert into these tables, the reason is that these tables' data always are static and never won't change

<img src="https://raw.githubusercontent.com/AmirBesharati/bank-simulator-api/master/database/diagram/Diagram.jpg"/>

#

## 3 - Models 
All data models stored in App\Models 

###

- #####UserModel : user or customer of api 


- ####AccountModel : represent the bank account of the user and users can have multiple accounts

######NOTE:
    Balance of account also store in Account model
    
    each account is related to a specific account type (account types are static)

- ####AccountTypeModel : represent available types of account  

######NOTE:
    Account types data read from enums and insert into the database during migration

- #####TransactionModel : represent account transactions 

######NOTE:
    - Every tranaction has an receiver and a sender but sender could be null in some type of transaction 
    - After creating a transaction, the TransactionCreatedEvent will call


- #####TransactionTypeModel : represent all transaction types such as internal, external, create account reward and etc...
######NOTE:
    Transaction types data read from enums and insert into the database during migration

#

## 4 - Base repository and model repository
All database transactions should handle in the corresponding repository of model, all repos are extend from a parent one that has general functions such as (find , findBy , Create , CreateWithingModel , Update and etc.... )

#


## 5 - Query builder (my favorite part)
The main reason of using query builders is that it can filter list data and sorting them is right order with few line of codes 


#

## 6 - services and chain checkers classes
 - **`ApiResponseService`**: The ApiResponseService class handles all the API responses it can help us to have one structure for all responses
 - **`TransactionService`**: The TransactionService class manages all transaction that the user wants to create it checks the availaibility of the account and check requirements to reassure that everything work well



