load data local infile '/Users/library/Desktop/studentdata.csv' 
into table test.studentData 
fields terminated by ',' 
enclosed by '' 
lines terminated by '\n' 
ignore 1 rows 
(user_group,usergroup_description,univ_id,first_name,last_name,expiration_date,address_line1,address_line2,city,state,postal_code,phone_number, email_address,additional_identifier,stat_category_code1,stat_category_description1,stat_category_code2,stat_category_description2,stat_category_code3,stat_category_code3_1)