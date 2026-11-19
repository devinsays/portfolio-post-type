<?php
namespace PortfolioPostType\Tests\Unit;

use WP_UnitTestCase;
use Portfolio_Post_Type;

/**
 * Guards against release metadata drifting apart. A stale readme "Stable tag"
 * kept WordPress.org serving 1.0.1 for years after 1.1 shipped.
 */
class VersionConsistencyTest extends WP_UnitTestCase {

	private function plugin_headers() {
		return get_file_data(
			PROJECT_DIR . '/portfolio-post-type.php',
			array(
				'version'      => 'Version',
				'requires'     => 'Requires at least',
				'requires_php' => 'Requires PHP',
				'tested'       => 'Tested up to',
				'text_domain'  => 'Text Domain',
			)
		);
	}

	private function readme_headers() {
		return get_file_data(
			PROJECT_DIR . '/readme.txt',
			array(
				'stable_tag'   => 'Stable tag',
				'requires'     => 'Requires at least',
				'requires_php' => 'Requires PHP',
				'tested'       => 'Tested up to',
			)
		);
	}

	public function test_version_constant_matches_plugin_header() {
		$this->assertSame( $this->plugin_headers()['version'], Portfolio_Post_Type::VERSION );
	}

	public function test_readme_stable_tag_matches_plugin_version() {
		$this->assertSame( $this->plugin_headers()['version'], $this->readme_headers()['stable_tag'] );
	}

	public function test_readme_changelog_has_entry_for_current_version() {
		$readme = file_get_contents( PROJECT_DIR . '/readme.txt' );
		$this->assertStringContainsString( '= ' . Portfolio_Post_Type::VERSION . ' =', $readme );
	}

	public function test_requirements_match_between_plugin_header_and_readme() {
		$plugin = $this->plugin_headers();
		$readme = $this->readme_headers();

		$this->assertSame( $plugin['requires'], $readme['requires'], 'Requires at least' );
		$this->assertSame( $plugin['requires_php'], $readme['requires_php'], 'Requires PHP' );
		$this->assertSame( $plugin['tested'], $readme['tested'], 'Tested up to' );
	}

	public function test_text_domain_matches_plugin_slug() {
		$this->assertSame( Portfolio_Post_Type::PLUGIN_SLUG, $this->plugin_headers()['text_domain'] );
		$this->assertSame( 'portfolio-post-type', basename( PROJECT_DIR . '/portfolio-post-type.php', '.php' ) );
	}
}
