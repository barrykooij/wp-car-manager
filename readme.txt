=== WP Car Manager ===
Contributors: never5, barrykooij
Donate link: http://www.barrykooij.com/donate/
Tags: car, vehicle, motor, sell, car listings, cars, auto, car market, marketplace, car dealer, car classifieds, auto dealer, auto classifieds, autostock, selling cars, dealer, car-dealer, cardealer, automotive, sales, lots, auto, motorcycle, bike, boat, airplane, rvs, tractors, motorhomes, trailers, car sales
Requires at least: 3.8
Tested up to: 4.4.2
Stable tag: 1.2.1
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
