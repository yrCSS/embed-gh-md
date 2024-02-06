# embed-gh-md

This is a simple Wordpress plugin that allows us to embed markdown files from GitHub on
a page, simply by pasting the file's URL onto any page.

## Installation

You cannot use the `Download ZIP` button on the GitHub web interface unfortunately,
because [the `parsedown` submodule won't get
downloaded](https://github.com/dear-github/dear-github/issues/214). Instead, you should:


1. Clone the repository
2. Zip using the command line as follows (if you use the graphical interface of GNOME's
   / macOS' file explorer, you'll get an error on upload):
    ```
    zip -r embed-gh-md.zip embed-gh-md
    ```
3. Upload from the admin panel at `/wp-admin/plugin-install.php`.
