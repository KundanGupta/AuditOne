=== Social Media and Share Icons (Ultimate Social Media) ===
Contributors: socialdude
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZWYMA8LFHGHCC
Tags: social media, facebook, instagram, youtube, twitter, share, social share, buttons, counter, pop-up, subscription, icons
Requires at least: 2.8
Tested up to: 4.7.3
Stable tag: 1.6.6
License: GPLv2 
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy to use social media plugin which adds social media icons to your website with tons of customization features!    

== Description ==

Social media plugin which let's you add icons for RSS, Email, Facebook, Twitter, LinkedIn, Google+, Pinterest, Instagram, Youtube, 'Share' (covering 200+ other social media platforms) and upload custom icons of your choice. 

The social media plugin offers a wide range of options, for example you can: 

- Pick from 16 different designs for your social media icons
- Give several actions to one social media icon (e.g. your facebook icon can lead visitors to your Facebook page, and also give visitors the opportunity to like your page)
- Decide to give your social media icons an animation (e.g. automatic shuffling, mouse-over effects) to make your visitors aware of them, increasing the chance that they follow/share your blog
- Make your social media icons 'float' or 'sticky'
- Allow visitors to subscribe to your blog by Email 
- Add 'counts' to your social media icons
- Decide to display a pop-up (on all or only on selected pages) asking people to follow/share you via your social media icons
- Decide to display sharing-buttons and social media icons at the end of every post
- Select from many other customization features for your socialmedia icons!

The social media plugin is very easy to use as it takes you through all the steps: 

- Step 1: Choose which social media icons you want to display
- Step 2: Define what actions your social media icons should perform
- Step 3: Pick design & animation options for your social media icons
- Step 4: Add counts to your social media icons (optional)
- Step 5: Select from various other options, e.g. make your social media icons 'float'
- Step 6: Add sharing/linking icons next to each blog post (optional)
- Step 7: Add a customized pop-up asking people to follow/share (optional)
- Step 8: Add a subscription form on your site (optional)

In case of issues please check the FAQ on http://ultimatelysocial.com/faq

We hope you enjoy the social media plugin! 

== Installation ==
Extract the zip file and drop the contents into the wp-content/plugins/ directory of your WordPress installation. Then activate the plugin from the plugins page.

Then go to plugin settings page and follow the instructions. After you're done, go to the Widget area (Appearance >> Widget) and place the widget on your sidebar to display your your icons on your blog.

Note: This plugin requires CURL to be activated/installed on your server (which should be the standard case), and a PHP version of 5.4 or above. If you don't have it, please contact your hosting provider or server admin.

== Frequently Asked Questions ==

== Frequently Asked Questions ==

= Please also check the more comprehensive FAQ on http://ultimatelysocial.com/faq =

.

= I face fundamental issues (the plugin doesn't load etc.) =

Please ensure that: 

- You're using the latest version of the plugin(s)
- Your site is running on PHP 5.4 or above 
- You have CURL activated (should be activated by default)

If you're not familiar with those please contact your hosting company or server admin.

Please check if you have browser extensions activated which may conflict with the plugin. Known culprits include:

- Open SEO Stats (Formerly: PageRank Status) in Chrome
- Adblock Plus in Chrome
- Vine in Chrome

Either de-activate those extensions or try it in a different browser.

If the plugin setting's area looks 'funny' after an upgrade then please clear your cache with String+F5 (PC) or Command+R (Mac).

Please also try if the other plugin works: https://wordpress.org/plugins/ultimate-social-media-plus/

= I get error messages 'Error : 7', 'Error : 56', 'Error : 6' etc. =

Those point to a CURL-issue on your site. Please contact your server admin or your hosting company to resolve it.

= Icons don't show = 

Please ensure you actually placed them. The USM+ plugin (https://wordpress.org/plugins/ultimate-social-media-plus/) makes placing icons especially easy (separate question 3).

If only some icons show, but not all, then please clear your cache, and check if you may have conflicting browser extensions (e.g. 'Disconnect'-app in Chrome). Also Ad-Blockers are known culprits, please switch them off temporarily to see if that is the reason.

If the icons still don't show then there's an issue with your template. Please contact the creator of your template for that. 

= Twitter share-counts are not displaying (anymore) =

Unfortunately, Twitter stopped providing that information.

= Changes don't get saved / Deleted plugin but icons still show = 

Most likely you have the WP Cache plugin installed. Please de-activate and then re-activate it.

= Links don't work = 

Please ensure you've entered the 'http://' at the beginning of the url. If the icons are not clickable at all there is most likely an issue with your template. 

= I cannot upload custom icons = 

Most likely that's because you've set 'allow_url_fopen' to 'off'. Please turn it to 'on' (or ask your server admin to do so, he'll know what to do).

= My Youtube icon (direct follow) doesn't work = 

Please ensure that you've selected the radio button 'Username' when you enter a youtube username, or 'Channel ID' when you entered a channel ID.

= Aligning the icons (centered, left- or right-aligned) doesn't work = 

The alignment options under question 5 align the icons with respect to each other, not where they appear on the page. Everything else is template work. 

= Clicking on the RSS icon returns funny codes = 

That's normal. RSS users will know what to do with it (i.e. copy & paste the url into their RSS readers).

= Facebook 'like'-count isn't correct = 

When you 'like' something on your blog via facebook it likes the site you're currently on (e.g. your blog) and not your Facebook page.

Therefore it also doesn't show the number of your facebook followers however that's something we're thinking about offering as well.

= Sharing doesn't take the right text or picture = 

We use the codes from Facebook, Google+ etc. and therefore don't have any influence over which text & pic gets shared.

Note that you can define an image as 'Featured Image' which tells Facebook / Google etc. to take that one. You'll find this 'Featured Image' section in your blog's admin area where you can edit your blog post.

You can crosscheck which image Facebook will take by entering your url on https://developers.facebook.com/tools/debug/og/object/.

= The pop-up shows although I only gave my icon one function = 

The pop-up only disappears if you've given your icons only a 'visit us'-function, otherwise (e.g. if you gave it 'Like' (on facebook) or 'Tweet' functions) a pop-up is still needed because the buttons for those are coming directly from the social media sites (e.g. Facebook, Twitter) and we don't have any influence over their design.

= I selected to display icons after every post but they don't show = 

They usually do show, however not on your blog page, but on your single posts pages. The USM+ plugin (https://wordpress.org/plugins/ultimate-social-media-plus/) also allows to display the icons on your homepage.

= Plugin decreases my site's loading speed = 

The USM and USM+ plugins are one of the most optimized social media plugins in terms of impact on a site's loading speed (optimized code, compressed pictures etc.).

If you still experience loading speed issues, please note that:

- The more sharing- and invite- features you place on your site, the more external codes you load (i.e. from the social media sites; we just use their code), therefore impacting loading speed. So to prevent this, give your icons only 'Visit us'-functionality rather than sharing-functionalities.

- We've programmed it so that the code for the social media icons is the one which loads lasts on your site, i.e. after all the other content has already been loaded. This means: even if there is a decrease in loading speed, it does not impact a user's experience because he sees your site as quickly as before, only the social media icons take a bit longer to load.

There might be also other issues on your site which cause a high loading speed (e.g. conflicts with our plugins or template issues). Please ask your template creator about that.

= After moving from demo-server to live-server the follow/subscribe-link doesn't work anymore = 

Please delete and install the plugin again.

If you already placed the code for a subscription form on your site, remove it again and take the new one from the new plugin installation.

= When I try to like/share via Facebook, I get error message 'App Not Setup: This app is still...' = 

If you get the error message...

'App Not Setup: This app is still in development mode, and you don't have access to it. Switch to a registered test user or ask an app admin for permissions.'

...then most likely you're currently logged in with a business account on Facebook. Please logout, or switch to your personal account.

= There are other issues when I activate the plugin or place the icons = 

Please check the following:

Please try the other plugin, i.e. if you use our USM plugin, please also try it with the USM+ plugin and vice versa.

The plugins require that CURL is installed & activated on your server (which should be the standard case). If you don't have it, please contact your hosting provider.

Please ensure that you don't have any browser extension activated which may conflict with the plugin, esp. those which block certain content. Known culprits include the 'Disconnect' extension in Chrome or the 'Privacy Badger' extension in Firefox.

If issues persist most likely your theme has issues which makes it incompatible with our plugin. Please contact your template creator for that. 

= How can I see how many people shared or liked my post? = 

You can see this by activating the 'counts' on the front end (under question 4 in the USM plugin, question 5 in the USM+ plugin).

We cannot provide you this data in other ways as it's coming directly from the social media sites. One exception: if you like to know when people start to follow you by email, then you can get email alerts. For that, please claim your feed (see question above).

= How can I change the 'Please follow & like us :)'? = 

You can change it in the Widget-area where you dropped the widget on the sidebar. Please click on it (on the sidebar), it will open the menu where you can change the text.

If you don't want to show any text, just enter a space (' ').

= How can I remove the credit-link ('Powered by Ultimatelysocial')? = 

Please note that we didn't place the credit link without your consent (you agreed to it when de-selecting the email-icon).

Open the first question in the plugin ('1. Which icons do you want to show on your site?'), on the level of the email-icon you see a link on the right hand side. Please click it to remove the credit link.

= Can I use a shortcode to place the icons? = 

Yes, it's [DISPLAY_ULTIMATE_SOCIAL_ICONS]. You can place it into any editor.

Alternatively, you can place the following into your codes: <?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?> 

= Can I get more options for the icons next to posts? = 

Please use this plugin for that: https://wordpress.org/plugins/ultimate-social-media-plus/

= Can I also give the email-icon a 'mailto:' functionality? = 

Yes, you can! For that please upload an email icon as custom icon, and then enter the mailto:-link (and email) under question 2.

To get the email-icon in the same design style you picked, activate it, then on the front-end, rightclick on the icon, and save it as picture. Upload that picture as custom icon.

= Can I also display the icons vertically? = 

Yes. For that please go to question 5 and select to display only 1 icon per row.

= How can I change the text on the 'visit us'-buttons? = 

Use this plugin: https://wordpress.org/plugins/ultimate-social-media-plus/

= Can I deactivate the icons on mobile? = 

Yes, there's an option for that under question 5.

= How can I use two instances of the plugin on my site? = 

You cannot use the same plugin twice, however you can install both the USM as well as the USM+ plugin (https://wordpress.org/plugins/ultimate-social-media-plus/). We've developed the code so that there are no conflicts and they can be used in parallel.


== Screenshots ==

1. After installing the plugin, you'll see this overview. You'll be taken through the easy-to-understand steps to configure your plugin 

2. As a first step you select which icons you want to display on your website

3. Then you'll define what the icons should do (they can perform several actions, e.g. lead users to your facebook page, or allow them to share your content on their facebook page)

4. You can pick from a wide range of icon designs

5. Here you can animate your icons (automatic shuffling, mouse-over effects etc.), to make visitors of your site aware that they can share, follow & like your site

6. You can choose to display counts next to your icons (e.g. number of Twitter-followers)

7. There are many more options to choose from 

8. You can also add share-icons at the end of every post 

9. ...or even display a pop-up (designed to your liking) which asks users to like & share your site


== Changelog ==

= 1.6.6 =
* New option for tailor-made icons

= 1.6.5 =
* Activation/deactivation links optimized

= 1.6.4 =
* Links to additional features optimized

= 1.6.3 =
* Notification issues corrected

= 1.6.1 =
* Dismissal of notification lead to plugin setting's page previously, this is corrected now

= 1.5.8 =
* Educational comments added

= 1.5.7 =
* Conflicts with other plugins resolved

= 1.5.6 =
* Instructions for trouble shooting optimized

= 1.5.5 = 
* Facebook icon leading to empty pages (in specific cases) fixed

= 1.5.4 = 
* Twitter sharing text issues with forwarded slashes fixed
* Links to review sites adjusted following Wordpress changes in review section

= 1.5.3 = 
* Missing counts for email follow option fixed (when there are no subscribers yet)
* Extra explanation text added

= 1.5.2 = 
* Corner case vulnerability fixed

= 1.5.1 = 
* Claiming process simplified
* Mouse-over for custom icons sometimes showed wrong text, corrected now

= 1.4.8 = 
* Size of custom icons corrected
* Cute G+ icon too small before, corrected now
* Better description how to get G+ API key added
* Unsupported "live" function in jquery fixed

= 1.4.7 = 
* Icons sometimes on top of each other - fixed

= 1.4.5 = 
* E-Notice errors fixed
* Facebook share button added for before/after posts

= 1.4.4 = 
* Errors fixed with color code sanitizing function

= 1.4.3 = 
* Removed the js files from plugin and using the ones provided by WP now

= 1.4.2 = 
* POST calls optimized (sanitize, escape, validate)

= 1.4.1 =
* Removed feedback option
* Tags changed

= 1.3.9 =
* Added Pinterest button for rectangle icons after/before posts
* If user has given an icon several functions, the tooltip appears as before, however if user clicks on the main icon then it will now also perform an action, i.e. the 'visit us'-function

= 1.3.8 =
* Review request changed

= 1.3.7 =
* Claiming links corrected
* Icons don't have any mouseover-effects (e.g. fade in) by default anymore 

= 1.3.6 =
* Overkill declaration in the CSS fixed 
* Custom icons can now have mailto:-functionality
* jQuery UI issues fixed
* Rectangle G+ icon now shown as last one as it takes more space (looks better)
* Comment added that partner plugin https://wordpress.org/plugins/ultimate-social-media-plus/ now allows buttons in various languages

= 1.3.5 =
* jQuery issues/conflicts fixed
* Placing icons on blog homepage had issues with counts, fixed now
* Script issues fixed
* Text added on plugin setting's page for easier understanding
* Issue that dashboard sometimes doesn't load fixed
* Instagram thin-icon issue fixed (misspelled, therefore didn't show)

= 1.3.4 =
* Facebook changed their API - please upgrade if you want Facebook sharing on mobile to work properly on your site! 

= 1.3.3 =
* Feed claiming optimized 
* New 'Visit us'-icon for Twitter added which matches the new Twitter-design
* PNG-file error for Houzz icon corrected
* Incorrect G+ icon replaced
* Error message for sites where subscription form doesn't work added
* Extra comments added how to claim a feed and several other texts optimized

= 1.3.2 =
* Feed claiming optimized 

= 1.3.1 =
* Shortpixel link fixed

= 1.3.0 =
* Feed claiming bug fixed 

= 1.2.9 =
* New G+ button updated
* Quicker claiming of feed possible
* Comments to share-button added
* Credit to shortpixel added

= 1.2.8 =
* New feature: Users can now decide where exactly the floating icons will display
* Internal links corrected
* Fixed: Targets only labels within the social icons div.
* Subscriber counts fixed
* Apostrophe issues fixed
* Conflicts with Yoast SEO plugin resolved
* PHP errors fixed

= 1.2.7 =
* Count issues fixed - please upgrade!
* Style constructor updated to PHP 5
* Text adjustments in admin area

= 1.2.6 =
* (Minor) compatibility issues with Wordpress 4.3. fixed

= 1.2.5 =
* Updating process fixed

= 1.2.4 =
* New question 8 added: you can now also add a subscription form to your site

= 1.2.3 =
* More explanations added how to fix if counts don't work
* Icon files are compressed now for faster loading - thank you ShortPixel.com!
* A typo in the code threw an error message in certain cases, this is fixed now

= 1.2.2 =
* jQuery issues fixed
* Vulnerability issues fixed
* Twitter-button didn't get displayed in full sometimes, this is fixed now
* CSS issues (occurred on some templates) fixed
* Facebook updated API (so counts didn't get displayed correctly anymore), we updated the plugin accordingly

= 1.2.1 =
* Template-specific issues fixed
* Layout in admin-area optimized
* Sometimes title didn't get rendered correctly, this is fixed now
* Youtube API changes also updated in plugin
* Outdated (and vulnerable) JS library updated
* New options for placing icons after every post (under question 6) 

= 1.2.0 =
* Links with '@' in the url (e.g. as in Flickr-links) now get recognized as well
* Alignment issues of icons in tooltip fixed
* Layout optimizations in plugin area
* Users can now select to have the number of likes of their facebook page displayed as counts of the facebook icon on their blogs
* Typos in admin area corrected

= 1.1.1.12 =
* Vulnerabilities (AJAX) fixed 
* OG-issues (caused in conjunction with other plugins) fixed

= 1.1.1.11 =
* Conflicts with Yoast SEO plugin sorted
* Performance optimized
* Facebook sharing text issues fixed
* Sometimes facebook share count didn't increase despite liking it, this should be fixed now (to be observed) 
* When sharing from a Facebook business page it returned errors, this should be fixed now (to be observed) 
* Share-box only displayed partly sometimes, fixed now
* Template CSS conflicts solved in the plugin
* Adding of unwanted spans fixed

= 1.1.1.10 =
* OG-issues fixed
* Text which gets shared sometimes didn't contain spaces, fixed now
* Plugin name in php file shortened
* More explanation texts added in admin area
* Facebook share window sometimes only got displayed partially, fixed now
* Other facebook share issues fixed
* Template CSS issues causing icons to be displayed not in one straight horizontal line fixed
* In some cases facebook counts didn't increase if liked, this should be fixed now
* Tested for up to Wordpress version 4.2.1.

= 1.1.1.9 =
* Issues with custom icon upload & custom icon removal fixed
* Box asking for review didn't disappear in some cases, fixed now
* Some design issues with some CSS for icons after every post, fixed now
* Changes in text / guide in plugin
* Conflicts with YOAST SEO plugin sorted
* Conflicts with ADD MEDIA button and ADD LINK sorted
* In some cases activating the icons after every post the content disappeared, this is fixed now
* New option to center icons after posts
* In some cases if no widget was placed it said 'Kindly go to settings page and check the option 'show them via widget'' got displayed on the blog, this is fixed now
* G+ window disappeared sometimes after moving over it, fixed now
* LinkedIn icon disappeared after moving over it a few times, fixed now
* Several other CSS issues fixed
* Sometimes tooltips didn't appear, fixed now
* When plugin is activated some toggle functionality stopped working, fixed now
* Click on icons after posts now shares the post, not the blog page
* Several little design enhancements
* When user selected that icons should show floating in the bottom right they floated in the center right, fixed now
* Issues with Youtube direct follow fixed
* Number of Instagram followers not always got pulled correctly, fixed now
* When site loaded the widget sometimes overlapped with others, fixed now

= 1.1.1.8 =
* Plugin's menu button now has less aggressive colors 
* Sometimes sharing via facebook returned error messages, this is fixed now
* Conflicts with WooTheme Whitelight resolved
* Occasional problems with https-sites previously, now compatibile 

= 1.1.1.7 =
* The 'counts' were not always correct, fixed now
* Conflicts with page editor resolved
* Last plugin update fixed Youtube points, however the 'channel' was as default, set back to 'username'
* Mouseover-text for social icons now correct
* Some layout adjustment in the admin area (menu-button will also be adjusted in next release)
* Setting order of icons sometimes didnt work properly when custom icons got uploaded, this is fixed now

= 1.1.1.6 =
* jQuery updated, now most conflicts with other plugins should be resolved

= 1.1.1.5 =
* Conflicts with several plugins sorted
* Icons can now be disabled on mobile
* Renaming of 'Youtube Channel' to 'Username' to avoid confusion
* On some templates there were alignment issues of the icons, this is fixed
* Menu button sub-menu removed (wasn't really necessary)
* Lightbox in admin area for custom icon upload shortened (was too large)
* Tags for all icons defined (for SEO purposes) 

= 1.1.1.4 =
* If given only a 'visit us'-function for the Twitter-icon, the is no tooltip anymore (like for the other icons)
* Sharing sometimes pulled an incorrect image, fixed now
* Pop-up now also has an 'x' in the top right corner for people to close
* Sometimes icons overlapped, this is fixed now
* Several issues fixed when users put shortcode into the header
* Sometimes our request to ask users for feedback got displayed too early, this is fixed now
* Some youtube accounts don't have a username, but only a channel. To allow users to directly to subscribe to your youtube channel the plugin required a User ID, now a channel is possible too
* Several conflicts with other plugins resolved
* Some CSS issues fixed
* Steps 1., 2., 3. in the guide how to upload a custom icon were sometimes missing, this is fixed now
* Title removed now when using shortcodes
* Some error messages in developer tools not showing up anymore

= 1.1.1.3 =
* Several CSS issues fixed

= 1.1.1.2 =
* Shortcode now available too, so that you can place the icons wherever you want: Insert [DISPLAY_ULTIMATE_SOCIAL_ICONS]
* 'Visit us'-option now also available for Twitter-users
* Description added for people helping to find their LinkedIn-ID
* Description added for people helping to generate their API-keys for Twitter, LInkedIn and G+ to display their counts automatically
* Design of pop-up for upload of custom icons changed, to better explain required steps
* 'Icons per row' didn't work properly in specific cases, fixed now
* If user displayed counts for the icons, and picked the option 'floating' and 'bottom', the counts were sometimes not displayed because they moved too far down. This is fixed now. 

= 1.1.1.1 =
* Previously custom icons got deleted if plugin was upgraded. This is fixed *from now on*. If you previously uploaded a custom icon, please do so (once) more. Sorry for the inconvenience.  
* Question #5 The 'Sticking & Floating' -> 'Where shall they float?' was storing the right value but showing the 'Top - Left' always
* If the floating icons on the frontend had 'counts' enabled for them, the counts for the last row of the icons were being cut-off on the screen if the 'Bottom - Left' OR 'Bottom - Right' was chosen as the display position 

= 1.1.1.0 =
* Following user suggestions we made it easier to remove the credit link (if previously activated by user - otherwise it doesn't display)

= 1.1.0.9 =
* Some servers don't display svg-images due to security issues, so we switched back to png
* Removed the comment line which may be  me causes the syntax error at the time of installation

= 1.1.0.8 =
* In specific cases some share-icons were missing, this is fixed now
* Plugin sent error messages if user had developer mode active, this won't happen anymore

= 1.1.0.7 =
* 'Visit us' icons sometimes didn't get displayed in the backend, this is fixed now
* Also the design of the 'Visit us'-icons on the front end has been improved
* If the email-delivery option is used, emails now get sent out much faster (central server gets pinged)
* Pop-up in some cases didn't get shown on inner pages, fixed now
* Some responsive adjustments for mobile
* Custom icons had some resizing issues, fixed now

= 1.1.0.6 =
* If 'Do you want to display icons at end of every post' is clicked there were some issues on mobile view, this is fixed now
* 'Visit us'-icons in the tooltips were no vector-icons, which made them look fuzzy in some browsers, this is fixed now

= 1.1.0.5 =
* On certain pages sometimes the youtube icon didnt show, this is fixed now
* Custom uploaded icons got a black background, this is fixed now
* In the admin panel the plugin conflicted (in rare cases) with other plugins, this is fixed 
* Pop-ups sometimes didn't disappear automatically, fixed now
* The tooltip for floating icons now gets displayed so that it is always visible

= 1.1.0.4 =
* Several changes done to optimize display on mobile & tablets
* Issues with widget fixed (in rare cases the separating lines between widgets didnt get displayed correctly)
* Deletion of headline for widget works now
* Slight alignment issues of share- and like buttons at the end of blog posts corrected

= 1.1.0.3 =
* Tooltip from share-option sometimes appeared some other strange places on the site, this is fixed now
* Extra checks added if user enters nonsense in the admin area
* Links to our review site added (please please give 5 stars)

= 1.1.0.2 =
* In specific cases there were Javascript loading errors, that's fixed now
* Moving from the icons to the tooltips made the tooltips disappear sometimes, now they are 'stickier'
* In specific cases the facebook-icon was displayed very small in the tooltip, fixed now

= 1.1.0.1 =
* Corrected that when only the 'visit us' function is selected, no tooltip is displayed

= 1.1 =
* Email-icon didn't get displayed for all design sets (on the website), this is fixed now
* Alignments of buttons in tooltips optimized
* Updated readme.txt

= 1.0 =
* First release


== Upgrade Notice ==

= 1.6.6 =
Please upgrade