"# magento-api" 
"# magento-api" 
 API for magento by using magento v2_soap and magento session (Tested with magento 1.9.2)

An  api for  magento  that can be used with Javascrpt base applications or by frontend developers or for a mobile application who need to connect to the store, with there app

you will need to add your soap api user name and APIKEY that you get from you magento admin panel and 
there is one more config file that is config.php open it and edit according your path now it's done call API.
Just copy and paste your APIUSER and APIKEY in soapconfig.php file and place this folder in your magento website root that's it now you can show the magic of API

example $proxy->login('admin', 'admin@123');



You can simply call API for example  calling country_list API that will give you list of country
http://magentohost.com/API/country_list.php

for post data always pass data fields and it's value in boday not in header.


