=== WP Car Manager ===
Contributors: never5, barrykooij, hchouhan
Donate link: http://www.barrykooij.com/donate/
Tags: car, vehicle, motor, sell, car listings, cars, auto, car market, marketplace, car dealer, car classifieds, auto dealer, auto classifieds, autostock, selling cars, dealer, car-dealer, cardealer, automotive, sales, lots, auto, motorcycle, bike, boat, airplane, rvs, tractors, motorhomes, trailers, car sales
Requires at least: 3.8
Tested up to: 4.8.1
Stable tag: 1.3.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The easiest way to manage, list and sell your cars online using WordPress!

== Description ==

= WP Car Manager =

WP Car Manager allows you to manage and list your cars from within your WordPress website!

WP Car Manager's goal is to enable anyone to manage and list their cars by using WordPress. With our plugin anyone can add, manage and list cars without any technical knowledge!

= Intuitive Admin =
The admin UI lists your cars in an organized fashion. You can easily control important car data like Make and Model, add features like ABS or Navigation and add complete photo galleries with a single upload!

There is also a Make & Models page and a Features page so you can control this data separately as well.

= Filterable Car Listings =
List all your cars on your WordPress website by simply adding our shortcode to your page. The shortcode will output a simple yet powerful car listings that is filterable without refreshing the page (AJAX). Your visitors will find the car they're looking for in no time!

= Detailed Car Pages =
Our detailed car pages will display the car details beautifully. The car detail pages include a summary for the most important data, an overlay image gallery, automatically generated tables for all your car data, automatically created lists for the car's features and configurable call to action buttons.

= User Submitted Listings =
Allow your visitors to add their own cars to your website! Simply add our `[wpcm_submit_car_form]` shortcode to your page and allow your visitor to create car listings on your website!

[Find out more information about our plugin, documentation and extensions at our website](https://www.wpcarmanager.com/?utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=more-information)

> #### WP Car Manager Extensions
> Extend the core WP Car Manager plugin with its powerful extensions. All extensions come with one year of updates and support!<br />
>
> Some of our popular extensions include: [Makes and Models Sync](https://www.wpcarmanager.com/extensions/makes-models-sync/?utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=description-block-page-addon), [Paid Listings](https://www.wpcarmanager.com/extensions/paid-listings/?utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=description-block-email-lock) and [Share This](https://www.wpcarmanager.com/extensions/share-this/?utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=description-block-csv-importer).
>
> Want to see more? [Browse All Extensions](https://www.wpcarmanager.com/extensions/?utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=description-block-browse-all)

This is the best car listing plugin for WordPress for car dealers, for people who want to setup their own car marketplace / listing website in WordPress or for those who simply want to list their car collection on their WordPress website.

WP Car Manager integrates well with all WordPress theme (including car WordPress themes) that respect the WordPress standards. We will also offer WordPress car themes specifically created for WP Car Manager soon!

> #### PHP Requirement
> This plugin requires PHP version 5.3 or higher.<br />
> If you're still at PHP 5.2, it's time to update. [Read here why and how](http://www.wpupdatephp.com/update/)<br />
> Updating to a newer PHP version is almost always done in minutes and free of charge!

== Installation ==

= Installing the plugin =
1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for *WP Car Manager* and click "Install now"
1. Alternatively, download the plugin and upload the contents of `wp-car-manager.zip` to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin

== Frequently Asked Questions ==

= What PHP version is required for this plugin? =
This plugin requires a minimum of PHP 5.3.

[Please visit our Knowledge Base for more documentation](https://www.wpcarmanager.com/kb/?utm_source=wp-plugin-repo&utm_medium=link&utm_campaign=faq)

= How do I list the vehicles on my website? =
Upon installation the plugin should have created a page called 'Cars' (could be translated to your websites language) that contains our listing shortcode. You can read more on how to list your vehicles here: (https://www.wpcarmanager.com/kb/listings-page/)[https://www.wpcarmanager.com/kb/listings-page/].

== Screenshots ==
1. Manage your cars via your WordPress dashboard.
2. We generate clear filterable and sortable overview pages for you.
3. Your cars will be displayed beautifully in our vehicle detail pages.

== Changelog ==

= 1.3.5: August 3, 2017 =
* Tweak: Fixed incorrect 'Min Year' filter in overview. It was incorrectly filtering date_to, where it should filter date_from.

= 1.3.4: May 4, 2017 =
* Tweak: Fixed incorrect filter in sort template. New filter: wpcm_filter_sort
* Tweak: Fixed a display issue for listing overview pages.
* Tweak: Some CSS tweaks to better hide incorrect theme single (header) images.

= 1.3.3: March 28, 2017 =
* Tweak: Introduced get_make_by_name() method in MakeModelManager.
* Tweak: Introduced get_model_by_name() method in MakeModelManager.
* Tweak: Introduced insert_make() & update_make() methods in MakeModelManager.
* Tweak: Introduced insert_model() & update_model() methods in MakeModelManager.
* Tweak: Remove power_type since it's no longer used.
* Tweak: Added Tunisian Dinar, props BesrourMS.

= 1.3.2: December 16, 2016 =
* Tweak: AJAX url now uses home_url() instead of site_url().
* Tweak: Fixed a bug where 2015 was the 'latest' year in date filter (latest is now current year).
* Tweak: Added Pakistani Rupee.

= 1.3.1: August 12, 2016 =
* Tweak: Added 'wpcm_currency_symbol' filter.
* Tweak: Use listing author's email address for email button.
* Tweak: Fixed a visual bug on the extensions tab.
* Tweak: Currency: Added CFA Franc.
* Tweak: Updated German translation, props Robert from Switzerland.
* Tweak: Updated Italian translation, props Dario Gattuso.
* Tweak: Updated Dutch translation, props Ad.

= 1.3.0: June 28, 2016 =
* Feature: Car listings now fully support pagination, amount of vehicles per page can be set in settings.
* Feature: Added 'sold' banner that is displayed when listing is sold.
* Feature: Listings marked as sold can now be hidden van listing pages, see settings > Listings.
* Feature: Added sorting by date listing is created to listings page.
* Feature: Added Power kW data field.
* Feature: Added Power hp data field.
* Feature: Added 'Under Review' label to car dashboard.
* Feature: Added Swedish translation, props Nicklas.
* Feature: Added Croatian translation, props Damir.
* Feature: Added Danish translation, props Flemming.
* Tweak: Structural changes to **ALL** single content template parts. **Important: If you've overridden any of the single-vehicle/ templates, you will need to remove the 'global $vehicle;' from the top of the file!**
* Tweak: Structural changes have been made to listings/item.php. Listing image is now wrapper in div and various actions have been added. **Important: If you've overridden this template, you'll need to update your own template after updating!**
* Tweak: Structural changes have been made to dashboard/item.php. Dashboard image is now wrapper in div and various actions have been added. **Important: If you've overridden this template, you'll need to update your own template after updating!**
* Tweak: Made date fields that are displayed in single car template filterable via wpcm_single_vehicle_data_fields.
* Tweak: Non-default filters passed to get_vehicles() AJAX request can now be used via wpcm_get_vehicles_filter_$filter_key.
* Tweak: Added 'Add New' button on car dashboard.
* Tweak: Added handler class for car submit specific steps and screens.
* Tweak: Fixed schema.org declaration issue.
* Tweak: Made distance unit abbreviation translatable.
* Tweak: Fixed DateTime exceptions when data was corrupt.
* Tweak: Optimized the onboarding screen.
* Tweak: Removed per_page attribute from car dashboard (was not used in results before).
* Tweak: We're now passing current vehicle object to listings/item.php template part.
* Tweak: We're now passing current vehicle object to single-vehicle/preview.php template part.
* Tweak: We're now passing current vehicle object to single-vehicle/pending.php template part.
* Tweak: We're now passing current vehicle object to single-vehicle/expired.php template part.
* Tweak: We're now only showing template notices to administrators.
* Tweak: Vehicle\Manager::get_vehicles() now forces price-asc sorting if given sort isn't recognized.
* Tweak: We've moved the .wpcm-error class on the submission page from the input to the input-wrapper.
* Tweak: Added explanation text to features screen.
* Tweak: Added explanation text to makes screen.
* Tweak: Added explanation text to models screen.
* Tweak: Allow for custom path in ViewManager::display() so others can use it to load own views.
* Tweak: Replaced the_content() with $vehicle->get_description() in single-vehicle/content.php.
* Tweak: Made dashboard post statuses filterable via wpcm_dashboard_post_status.
* Tweak: Added more featured image classes to be hidden on vehicle detail page.
* Tweak: Included default styling for buttons because many themes lack default button styling.
* Tweak: Added 'wpcm_contact_email_link' filter to contact email template, props [kjohnson](https://github.com/kjohnson).
* Tweak: Removed focus state on settings tabs, props [JeroenSormani](https://github.com/JeroenSormani).
* Tweak: Persist on current tab in settings after saving, props [JeroenSormani](https://github.com/JeroenSormani).
* Tweak: Show message when there are no makes or models, props [JeroenSormani](https://github.com/JeroenSormani).
* Tweak: Autofocus on the 'name' field in makes and models, props [JeroenSormani](https://github.com/JeroenSormani).
* Tweak: Admin responsive styling fixes to overview and car data, props [JeroenSormani](https://github.com/JeroenSormani).
* Tweak: Currency: Added Djiboutian Franc.
* Tweak: Currency: Added Ghanaian Cedi.
* Tweak: Currency: Added Rwandan Franc.
* Tweak: Currency: Added Ethiopian Birr.
* Tweak: Currency: Added Ugandan Shilling.
* Tweak: Currency: Added Kenyan Shilling.
* Tweak: Currency: Added Tanzanian Shilling.
* Tweak: Currency: Added Burundian Franc.
* Tweak: Updated Italian translation, props VGS Service.

= 1.2.1: March 17, 2016 =
* Tweak: Fixed a bug where you couldn't use the make attribute combined with show_filters="false" in [wpcm_cars]
* Tweak: Added semi-automatic as transmission type, props [Zaanmedia](https://github.com/Zaanmedia).
* Tweak: Transmission are now filterable via wpcm_transmissions.
* Tweak: Conditions are now filterable via wpcm_conditions.
* Tweak: Updated Dutch translation.

= 1.2.0: February 29, 2016 =
* Feature: Added Frontend Car Submission functionality.
* Feature: Added Car Dashboard functionality.
* Feature: Added Onboarding process.
* Feature: Added Car Seller user role.
* Feature: Added make attribute to wpcm_cars shortcode to only display vehicles of given make.
* Feature: Added sort attribute to wpcm_cars shortcode to define default sorting. Options: price-asc, price-desc, year-asc, year-desc, mileage-asc, mileage-desc.
* Feature: Added condition attribute to wpcm_cars shortcode to only show cars with one condition. Options: new, used.
* Tweak: We're now properly flushing rewrites on website language change.
* Tweak: Always limiting short_description length to 30 words, can be filtered with wpcm_vehicle_short_description_length
* Tweak: Added new vehicle states.
* Tweak: Set manage_car_listings capability to features
* Tweak: Set manage_car_listings capability to makes & models
* Tweak: Vehicle object now has a get_url() method
* Tweak: We now bundle jQuery UI assets instead of loading from Google severs.
* Tweak: We optimized multiple responsive styling elements.
* Tweak: Dutch translation updated.
* Tweak: German translation updated.
* Tweak: French translation updated, props dirk.

= 1.1.3: December 4, 2015 =
* Tweak: Fixed the per_page attribute for the [wpcm_cars] shortcode
* Tweak: Updated Dutch translation

= 1.1.2: November 2, 2015 =
* Tweak: Fixed a path bug that caused translation not the load properly
* Tweak: Included sort labels into correct text domain

= 1.1.1: September 20, 2015 =
* Tweak: Fixed CSS issue with main vehicle thumbnail
* Tweak: Fixed fatal error on PHP 5.2, props [Danny van Kooten](https://github.com/dannyvankooten)
* Tweak: Makes & Models page now require 'edit_posts' capabilities
* Tweak: Small admin Makes & Models page styling tweaks
* Tweak: Hide default theme image on vehicle detail page

= 1.1.0: September 8, 2015 =
* Feature: Added sort possibility to car listing shortcode
* Feature: Added various custom columns to car admin manage overview screen
* Feature: Added placeholder images
* Feature: Added show_filters attribute to [wpcm_cars] shortcode
* Feature: Added placeholder to gallery meta box in edit vehicle
* Feature: Added date format option in settings
* Feature: Added tooltips to edit make & model pages
* Feature: Cars listings page is now created upon installation
* Feature: Change overriding complete singular template to only replacing content via the_content
* Feature: Added Dutch Translation
* Tweak: We won't display data and summary rows anymore when no data is entered for that row
* Tweak: Removed listings page setting because we now detect pages that contain listings shortcode
* Tweak: Moved contact template hook into wpcm_vehicle_summary
* Tweak: Added wpcm-vehicle-head wrapper around wpcm_vehicle_summary actions
* Tweak: Fixed conflict with Contact Form 7
* Tweak: Updated extension related code
* Tweak: Single article wrapper element is now article instead of div
* Tweak: Single article element wrapper are now separate overridable template files
* Tweak: Hide email contact button when no email address is entered
* Tweak: Initialize each listing separately. allowing multiple listings on one page

= 1.0.0 : August 6, 2015 =
* Initial version
