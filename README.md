# HouseSimple

Below will detail on how to use this application to shorten URLs:

- Please execute the house_simple_dump.sql file to create the database schema in which will store the destination of the given url and it's counterpart short code.
- Go to http://localhost/HouseSimple/ and you will be presented with a field in which to enter a url and a choice of either submitting a short code via an API or to generate it and save it in the database locally.
- Validation has been put into place if there is nothing inputted in the field after submitting, or entering an invalid url.

** The API used to generate the short url was the rebrandly API: https://developers.rebrandly.com/docs. I used both the API key and Workspace ID given in order to connect to their API and retrive the short url.
I also implemented an interface to develop the logic for the API along with following the MVC design pattern. I used PDO to connect to my local database and save both the destination and short urls.
