=====================================
EZProxy Log Processing by David Raygoza
=====================================
* Last Updated 01/10/2022 *

* DO NOT make change any code, database tables, or properties unless ABSOLUTELY NECESSARY. Everything is set to work in exact unison with a python script to automatically upload new data to the database every morning. If any changes are made to the code, database, etc. they will most likely have to be made across the entire project (web interface, database, and pythons scripts). Please create backups prior to making any code changes in case you need to revert back *

Instructions on duplicating project in Mac local host server
* For setting up apache and php on Mac: https://youtu.be/4QtbV5D_X3k *
* Project folder will be housed in Macintosh HD > Library > WebServer > Documents *


Instructions on how to change database connection:
1) Open includes/DatabaseConnection.php in the web interface files
2) Update the IP address, database name, username, and password in the PDO statement. 
* If migrating to new database you will need to create a new username and password to access your database (this user must be granted all privileges to the database). *


How to make edits to web interface code:
* This is a bit of a long process that may require some basic linux knowledge. But I will walk you through step-by-step. A VERY important thing to keep in mind is to always make sure you DO NOT move, or delete any files without first backing them up. *
1) Connect to the school VPN
2) The easiest way to grab these files is to install FileZilla client for drag & dropping. Download here: https://filezilla-project.org
3) Open FileZilla and click site manager. Now, enter the following info
	Protocol: SSH
	Host: library-php.laverne.edu
	Port: 322
	User: ulvlibrary
	Password: sran#8Ejb
4) The web interface files are housed in a private apache folder so you must go into the folder, and move them to a public folder like /home/ulvlibrary to drag them out of FileZilla
5) Open up your terminal or command prompt.
6) Now, we need to connect to the Linux server using SSH. Enter the command 'ssh -p 322 ulvlibrary@10.100.201.26'
7) Enter the following password: 'sran#8Ejb'
8) Next, we need root access to the server so type 'sudo su'
9) Re-enter the same password 'sran#8Ejb'  
10) Now, we need to move to the apache folder. Enter the command 'cd /var/www/html'
11) You are now in the apache folder, you can type 'ls' to view all files in the directory.
12) Next, we need to make a copy of the project folder and move it to the public ulvlibrary folder. Enter the command 'cp filename /home/ulvlibrary'
13) Finally, you can go to FileZilla and refresh the home/ulvlibrary folder and you should see a copy of the project folder that you can downlaod
14) Once you make your edits you can upload your updated project folder using the same process.
	1) Drop your project into the /home/ulvlibrary folder in FileZilla
	2) Move project to apache folder using ' mv filename /var/www/html'
	3) Keep a copy of the old project folder by changing its name using 'mv filename newfilename'


* If you ever need to delete an OLD project folder use the command 'rm -r filename' *




How to make changes to the database if necessary:
* The database is housed on a separate server so to easily access the server *
1) Make sure you are connected to the VPN
2) The easiest way to do this is to download mySQL Workbench: https://dev.mysql.com/downloads/workbench/
3) Now you can create a new SQL connection by clicking at the top database/manage connections
4) Click 'New' and enter the following info:
	1) Name your connection whatever you like
	2) Protocol: Standard (TCP/IP)
	3) Hostname: '10.100.200.148'
	4) Port: '3306'
	5) Username: 'ezproxyuser'
	6) Password (when prompted): 'Fall2010!' 
* For importing large sums of data MANUALLY refer to the 'OptimizedDataLoad.sql' file for a very efficient importing query, and replace the necessary parameters such as tables, columns, file names, etc. * 




What happens if something is broken & the web app is not working?

1) Check history log in python scripts to check if you believe data has been uploaded properly. If data has not been uploading properly check README.txt located in the Python Scripts Beau Daoust has created for more information on how to solve this issue. 
2) If site is not loading make sure you are connected to the VPN
3) If site/url cannot be found by server then check linux server and make sure project is in correct folder and you are using the correct url
4) If results are not loading after submitting a query request on the website then check the database or windows server for any issues. 

* If all else fails, try to contact the creator, David Raygoza (draygoza2799@gmail.com) *



Database Tables Descriptions:

Domain: Contains full-site urls as well as the domain accessed through each corresponding sessionID

Log: Contains all login data such as sessionID and user email

StudentData: Contains all student data such as ID number, email, major, year, campus, etc. (Last Updated 2021)


Database Views Relationships/Descriptions:

SessionJoiner3: Joins domain and log tables based on matching sessionIDs

Groupingdata3: Joins sessionJoiner3 and studentdata tables based on matching user emails

Distinctfullsites: Grabs all distinct full site urls from domain table to generate a dynamic list of database profiles for proquest, ebscohost, and gale to be added to database dropdown list on live site 

Distinctsessions: generates all distinct sessions from sessionJoiner3

Distinctuserids: generates all distinct university ID's from groupingdata3

Distinctusers: generates all distinct user emails from the log table and removes the '@laverne.edu' from each email address

Newcampuses: generates a list of all distinct campuses from the studentdata table that is used in the dynamic dropdown selector as a query parameter 

Newdbnames: generates a list of all distinct database names from the studentdata table that is used in the dynamic dropdown selector as a query parameter 

Newmajors: generates a list of all distinct majors from the studentdata table that is used in the dynamic dropdown selector as a query parameter 










