<?php
/*
 * Plugin Name:       Embed GitHub Markdown
 * Plugin URI:        https://github.com/yrCSS/embed-gh-md
 * Description:       Allows us to embed the contents of a markdown file hosted on GitHub onto a page in our Wordpress website.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      8.4
 * Author:            yrCSS
 * Author URI:        https://yrcss.cssociety.org
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/yrCSS/embed-gh-md
 */

# From https://piszek.com/2022/08/15/wordpress-github-markdown/#
wp_embed_register_handler(
	'github_readme_md',
	'&https?:\/\/github\.com\/([a-zA-Z-_0-9/]+)\/([a-zA-Z]+)\.md&i',
	__NAMESPACE__ . '\artpi_github_markdown_handler'
);

function artpi_github_markdown_handler( $matches, $attr, $url, $rawattr ) {
	$url = str_replace(
		[ 'github.com', '/blob' ],
		[ 'raw.githubusercontent.com', '' ],
		$matches[0]
	);
	$transient_key = 'gh_' . md5( $url );
	$content = get_transient( $transient_key );
	if ( ! $content ) {
		$request = wp_remote_get( $url );
		if ( is_wp_error( $request ) ) {
			return false;
		}
		$content = wp_remote_retrieve_body( $request );
		if( ! $content ) {
			return false;
		}
		require_once __DIR__ . '/parsedown/Parsedown.php';
		$md_parser = new \Parsedown();
		$content = $md_parser->text( $content );
		if( ! $content ) {
			return false;
		}
		$content = "<div class='github_readme_md'>$content</div>";
		set_transient( $transient_key, $content, 3600 );
	}
	return apply_filters( 'embed_github_readme_md', $content, $matches, $attr, $url, $rawattr );
}
