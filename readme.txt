=== Plugin Name ===
Contributors: danasf
Tags: congress, political, forms, sunlight, senate, house
Requires at least: 2.8.0
Tested up to: 3.0.4
Stable tag: 0.6.8

WPCongress allows your visitors to look up contact information of their Members of Congress, plus some info on bills, votes, etc.
== Description ==

= Stable features =

This plugin allows your visitors to look up contact information of their Members of Congress (Senators and Representatives)

It is very rudimentary at the moment but will be expanded much, much further soon. 

It's powered by free data APIs from the Sunlight Foundation and Govtrack.us. When necessary geocoding is done by Geocoder.us

* Add [wpcongress_form] to the page if you want a lookup form to appear
* Add [wpcongress_browse] to the page if you want a browse by state form to appear
* A sidebar widget is also available!

You can see a demo here:
http://thecoocoup.com/wptest/

= Work in Progress Features =
Some basic capabilities to view information about a particular legislator, a specific bill or a roll call vote have been added. 

These features are in a VERY preliminary state and will be significantly refined, streamlined, added to in future releases.
They are powered by the Sunlight Labs Drumbone API (http://services.sunlightlabs.com/docs/Drumbone_API/). 

Returns recent sponsorship/cosponsorship information for a given legislator:

* [wpcongress_legislator id="L000551"]
* id is based upon http://bioguide.congress.gov/biosearch/biosearch.asp (search, look in the url of the legislators bio page for this value)

Returns information about specified bill:

* [wpcongress_bill id="hr3590-111"]
* id is of the format: [type][number]-[session] 

For example, HR 3590 from the 111th Congress would be "hr3590-111".

Returns information about specified roll call vote:
* [wpcongress_roll id="h165-2010"]
* id is of the format: [chamber][rollnumber]-[year]

For example, Roll Call 165, from 2010 in the House would be "h165-2010".

As stated earlier these features will improve significantly over time! A search interface and TinyMCE integration is also in the works to make finding legislators, bills and roll calls much easier.

== Installation ==

1. Register for a Sunlight API key (it's free, you can get one here: http://services.sunlightlabs.com/accounts/register/)
1. Add your key to the settings page. Plugins -> WPCongress Settings. Hit Save.
1. Add [wpcongress_form] to the page where you want a lookup form to appear
1. Add [wpcongress_browse] to the page where you want a browse by state form to appear
1. You can add [wpcongress_bill], [wpcongress_roll], [wpcongress_legislator] to your site per instructions in the Description
1. You should be up and running!

== Frequently Asked Questions ==

= Where can I get a Sunlight API key? =

Right here: http://services.sunlightlabs.com/accounts/register/

= What are the terms of use of the Sunlight API? =

Again see this page: http://services.sunlightlabs.com/accounts/register/

= What are the terms of use of Geocoder.us? =

"Free data services are provided from sources in the public domain, or under licenses that do not prohibit their open redistribution by us, e.g. Creative Commons licenses. These services are licensed for use by the general public for non-commercial uses only. Individuals and businesses that wish to use our services for any commercial, for-profit activity must obtain our premium services." - http://geocoder.us/terms.shtml

= Where do you get your data? =

Most of this data is from the Sunlight Foundation. They seem to get their data from a variety of public domain and open-ended sources. You can download most if not all of it from their web site and create your own repository/API if you so choose.

Geocoding is provided by geocoder.us. They seem to get much of their data from the US Census TIGER/Line dataset (http://www.census.gov/geo/www/tiger/). They also offer their code & data for download.

= Why does this plugin need to use geocoding? =
 Congressional districts are extremely irregular, not deliniated by city or at times even zip code. Finding latitude and longitude from an address is the easiest way to locate a Congressional District.

= I want to help develop or have a suggestion, technical question or another issue =

Please contact the author dsniezko )at{ sonic {dot] net. 

= Do you have a political agenda with this plugin? Who funded it? =

I strongly believe in transparency and created this plugin as a public service because I found free tools to connect people with their elected officials to be sorely lacking.

I am happy to work with anyone who would like to improve this plugin. And if you don't trust me this code is open source --- you are free to inspect, modify, fork it, etc.

As of right now, this plugin hasn't received any financial backing, it was created by one individual on my own time.

== Screenshots ==

1. submission form
2. results

== Changelog ==
= 0.6.7 =
*  minor bug fixes

= 0.6.7 =
*  bug fix per reports

= 0.6.6 =
* minor bug fix per reports

= 0.6.5 =
* editable stylesheet and javascript added
* ajax form option
* some basic cacheing
* sidebar widget
* improved stability
* better FAQ
= 0.6.1 =
typo corrections
= 0.6.0 =
launch of several work in progress features
= 0.5.3 =
one further fix 

= 0.5.2 =
one more fix 

= 0.5.1 =
several bug fixes

= 0.5.0 =
Initial launch