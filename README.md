Installation steps
===================

Creating an offer
------------------

1. Logon to Instamojo, and create an offer under the Services / Membership Type
2. Add a title, description, and a minimum value (10 is the least you can enter. Don't make it zero)
3. Check "Pay what you want"
4. In the Advanced Settings section, go to the "Custom Redirection URL", and enter : http://yourdomain.com/modules/instamojo/validation.php
5. Save the offer


Custom Fields
--------------

Prestashop assigns an id to each shopping cart, which it needs to get back from the Payment Gateway (Instamojo). So, you must create a custom field on Instamojo

1. Navigate to the Instamojo Dashboard at https://www.instamojo.com/dashboard/, find your offer, and click on "Custom Fields"
2. Enter "TransactionId" (without the quotes) as the field name, make it Required, and click Save. Place your mouse pointer on the field name, you'll see something like Field_1111 (the number will be different). Note that down
3. Copy that into the file here : modules > instamojo > lib > Config.php in the variable TXN_ID_NAME. 


HTML Code
---------

a. Get the HTML code for the Instamojo button for your website (it's different for every merchant) by contacting Instamojo.
b. Put the above HTML code in the file here : modules > instamojo > views > templates > front > instamojo.tpl . Replace the code within the `<p> .. </p>` tags, that should be enough.

API parameters
---------------

a. Get your API keys from https://www.instamojo.com/developers/
b. Copy them into the file here : modules > instamojo > lib > Config.php in the corresponding fields


Installing into Prestashop
---------------------------

1. Download the zip file by clicking the Download button on the right.
2. Upload the zip file to the "modules" folder on your server running Prestashop, and unzip it.
3. Rename the unzipped folder to "instamojo".
4. Login to the Prestashop backend, and go to the "Modules" section.
5. Search for "Instamojo", the plugin should show up. Click on Install.

That's it, you are done with the installation with Prestashop !

This plugin is live at http://daflabs.com , in case you want to check out how (smoothly) it works

If you have a question, write to dev@instamojo.com (not me ;) )

If you want to pay me for this though, you can write to me at me@ankitdaf.com , and I'll send across an Instamojo link ;)


License
--------

<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Instamojo Plugin for Prestahop</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://ankitdaf.com" property="cc:attributionName" rel="cc:attributionURL">Ankit Daftery</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.