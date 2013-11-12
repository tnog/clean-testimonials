=== Clean Testimonials ===
Contributors: hello@lukerollans.me
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=hello%40lukerollans%2eme&lc=GB&item_name=Plugin%20Development%20Donation&currency_code=USD
Tags: testimonials,testimonial,recommendation,recommend,testimony,reference,referral,widget,reviews,review
Requires at least: 2.5
Tested up to: 3.6
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add Testimonials to your WordPress website. Simple, easy, quick and clean.

== Description ==

Clean Testimonials enables you to easily and quickly add Testimonials to your WordPress website. The plugin integrates seamlessly with your existing WordPress admin area, so you will feel right at home.

There are a few simple ways to manage your testimonials:

1. Easy to use shortcodes when editing content in the WordPress admin area.
2. The built-in Testimonial Widget to display a specific or random testimonial
3. PHP code if you are a developer (see FAQ).

This plugin is in constant development. If you have any feature requests or questions, please feel free to submit them via the support forum.

= Features =

* Creates a "Testimonials" link in your WordPress admin area which allows you or your visitors to submit Testimonials.
* Leverages the simplicity of WordPress shortcodes, allowing you to easily display your Testimonials wherever you like (see FAQ for individual shortcodes).
* Categorize Testimonials any way you see fit and display those categories wherever you like.
* Creates a Testimonial Widget which allows you to display your testimonials in sidebar or widgetized areas.
* Display random testimonials using either a shortcode or the built-in widget.
* Allows your visitors to upload a thumbnail with their testimonial.
* Allows your visitors to choose whether their contact details are displayed with their testimonials.
* Allows powerful customizations for developers.
* Supports **WP-Paginate** if installed.

**Please Note:** Although any output Clean Testimonials generates is well structured, no styling is shipped out of the box. This means it is up to your theme to decide how the output will be styled.

If you have found this plugin useful, consider taking a moment to rate it, or perhaps even a small donation.

**Want to contribute to Clean Testimonials?** Fork Clean Testimonials on Github at http://github.com/lukerollans/clean-testimonials

== Installation ==

1. Upload the `clean-testimonials` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently asked questions ==

= Can testimonials be submitted by my visitors automatically? =

Yes. On top of your ability to add and edit testimonials in the WordPress admin area, you can also use a shortcode to display a form on any page you like. This form will create a new testimonial when a user fills it out. The shortcode to do this is [testimonial-submission-form]

When a user submits a testimonial, it will default to "Draft" status. You will need to publish any testimonials this way before they will display on your site. Just in case someone writes anything naughty!

= How do I display all of my testimonials? =

To display all testimonials with pagination, use the [testimonials] shortcode.

= How do I display a testimonial? =

To display a single testimonial you can use the [testimonial id="xyz"] shortcode, where "xyz" is the ID of the testimonial you wish to display.
You can copy and paste the testimonial shortcode complete with ID from your Testimonials admin page in WordPress.

= How can I display a category of testimonials? =

To display a category of testimonials (with pagination!), you can use the [testimonials category="xyz"] shortcode. where "xyz" is the ID of the testimonial category you wish to display.
You can copy and paste this shortcode complete with ID from the Testimonials -> Categories admin page in WordPress.

= Can I display a random testimonial? =

Yes, you can use the Testimonial Widget and specify the "random" option, or you can use the [testimonial id="random"] shortcode.

= Can I change the number of testimonials shown per page? =

Yes. Specify the "per_page" attribute when using the [testimonials] shortcode. EG, [testimonials category="10" per_page="5"].

= I am a developer, what can you tell me? =

The following information might be handy for you to know.

1. Testimonials operate via a custom post type which is simply named "testimonial".
2. Testimonials are grouped in a custom taxonomy named "testimonial_category".
3. The Testimonial widget class name is "Testimonial_Widget" and of course extends WP_Widget.

== Screenshots ==

1. An overview of the Testimonials menu
2. Editing or creating a Testimonial in the backend
3. Managing Testimonial categories
4. Example use of the [testimonials] shortcode. This will display all testimonials with pagination
5. Example use of the [testimonial-submission-form] shortcode. This shortcode will turn this page into a Testimonial submission page for your users

== Changelog ==

= 1.3.2 =
* Fixed bug causing Testimonials submitted via the template submission form to be saved as incomplete

= 1.3.1 =
* Added CAPTCHA to testimonial submission form

= 1.3 =
* Added "per_page" attribute to [testimonials] shortcode which allows you to specify how many testimonials to display per page. EG, [testimonials category="25" per_page="5"]. Default is 2
* Fixed small PHP warning which could be generated when testimonial pagination is rendered

= 1.2.5 =
* When displaying a testimonial, the comma separating the client name and company name will no longer be displayed if the company name is not set

= 1.2.4 =
* Fixed output positioning of shortcode data

= 1.2.3 =
* Small security updates

= 1.2.2 =
* Fixed bug causing Featured Images (thumbnails) to not appear on the Testimonial edit page
* Added Testimonial Widget
* Changed [testimonial] shortcode to accept "random" as an ID which, in turn, outputs a random testimonial

= 1.2 =
* Enhancements and bug fixes

= 1.0 =
* Initial release of plugin

== Upgrade notice ==

No upgrade notice necessary