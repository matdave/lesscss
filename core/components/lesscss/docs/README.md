=== USAGE ===

STEP 1:

Create a new resource/document in MODX to serve as your main stylesheet.
Be sure to assign an blank/empty template to your new resource
Be sure to change the page type to CSS
STEP 2:

Add the lessCSS snippet to the content of your new page
Set &path to the path to your LESS file *relative to base_url*
Set &file to the name of your LESS file including the file extension
IMPORTANT NOTES:
* It is strongly recommended that you call the snippet cached! (more on that later)
* The path variable will be prepended with MODX's base_url setting
* End your path reference with a trailing slash /
  example: [[lessCSS? &path=`assets/templates/myTemplate/` &file=`style.less`]]

STEP 3:

Reference your file in your HTML header.

=== CACHING ===

It is best to use the snippet cached, i.e., without the no-cache flag (!). During development, uncheck the cacheable setting in the referencing document. Then, when done with development, turn the page caching back on to prevent lessphp from recompiling on every page load.

=== SAMPLE LESS FILES ===

For some help for those getting started with LESS, a sample LESS setup for a site is included in the assets/components/lesscss/ folder.

=== ADDITIONAL OPTIONS ===

&compress : yes/no : default = 1 : the add-on will strip unecessary white space from CSS output (renders CSS largely unreadable)

&fixRelativePaths : yes/no : default = 1 : the add-on will fix relative URLs in the output to point to the path set in the &path option. This allows you to use paths in your LESS file relative to the LESS file's path (CSS-like behavior) without regard to the path of the MODX output. Will not affect any paths that start with 'http://', 'https://', or '/'.