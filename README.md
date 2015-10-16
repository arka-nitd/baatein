# Baatein

It is a basic social networking website made using php for backend and html and css for frontend.

Some steps to make it functional.

1.) create a database named baatein and adjust the password.
2.) create four tables in it named friend_requests, posts, pvt_messages, users

Table 1 : users

This table has 11 columns which are of following type

name                 type  
id                  int(11)
username            varchar(255)
firstname           varchar(255)
lastname            varchar(255)
email               varchar(255)
password            varchar(32)
sign_up_date        date
activated           enum(0,1)
bio                 text
profile_pic         text    
friend_array        text

Table 2 : pvt_messages

name                 type  
id                  int(11)
user_from           varchar(255)
user_to             varchar(255)
msg_title           text
msg_body            text   
date                date
opened              varchar(255)

Table 3 : pvt_messages

name                 type  
id                  int(11)
body                text
date_added          date   
added_by            varchar(255)
user_posted_to      varchar(255)

Table 4 : friend_requests

name                 type  
id                  int(11)
user_from           varchar(255)
user_to             varchar(255)

P.S : this website was inspired from the tutorial series on making social network provided 
by the channel howtocode in youtube. I made this website for learning php, so do ping me if 
you want to help me in optimising this site
