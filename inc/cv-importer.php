<?php
/**
 * Create CV Page importer & modal panel for Appearance → FoA Cleaner.
 *
 * Enabled when Jetpack is active and Jetpack Markdown (for CV) is enabled.
 * Safely parses canonical `cv-md/1.1` Markdown files (YAML frontmatter + body),
 * optionally uploads a companion PDF to the Media Library, and generates a
 * native WordPress Draft page using the `page-cv` template.
 *
 * @package FoA_Cleaner
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FOA_CLEANER_CV_PAGE_ID_OPTION', 'foa_cleaner_cv_page_id' );
define( 'FOA_CLEANER_CV_FORMAT_REF_URL', 'https://github.com/ivans3m/cv-formatter' );
define( 'FOA_CLEANER_CV_MAX_MD_BYTES', 524288 );     // 512 KB.
define( 'FOA_CLEANER_CV_MAX_PDF_BYTES', 10485760 );  // 10 MB.

/**
 * Return the filterable URL for the canonical CV Markdown format reference.
 *
 * @since 1.1.0
 *
 * @return string Validated reference URL.
 */
function foa_cleaner_get_cv_format_reference_url(): string {
	/**
	 * Filter the documentation URL describing the `cv-md/1.1` Markdown CV format.
	 *
	 * @since 1.1.0
	 *
	 * @param string $url Default GitHub reference URL.
	 */
	$url = (string) apply_filters( 'foa_cleaner_cv_format_reference_url', FOA_CLEANER_CV_FORMAT_REF_URL );

	return esc_url_raw( $url, array( 'http', 'https' ) );
}

/**
 * Return the managed CV page post if it still exists and is not trashed.
 *
 * Automatically clears the stored option if the page was trashed or deleted
 * so the upload workflow returns immediately.
 *
 * @since 1.1.0
 *
 * @return WP_Post|null Active managed CV page, or null if none exists.
 */
function foa_cleaner_get_managed_cv_page(): ?WP_Post {
	$page_id = absint( get_option( FOA_CLEANER_CV_PAGE_ID_OPTION, 0 ) );
	if ( $page_id <= 0 ) {
		return null;
	}

	$post = get_post( $page_id );
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type || 'trash' === $post->post_status ) {
		delete_option( FOA_CLEANER_CV_PAGE_ID_OPTION );
		return null;
	}

	return $post;
}

/**
 * Check whether the Create CV Page workflow is currently enabled.
 *
 * @since 1.1.0
 *
 * @return bool True when Jetpack is active and Jetpack Markdown is enabled.
 */
function foa_cleaner_is_cv_importer_enabled(): bool {
	return foa_cleaner_is_jetpack_active() && foa_cleaner_is_jetpack_markdown_enabled();
}

/**
 * Strip surrounding YAML quotes from a scalar string.
 *
 * @since 1.1.0
 *
 * @param string $value Raw YAML scalar.
 * @return string Unquoted string.
 */
function foa_cleaner_unquote_yaml_scalar( string $value ): string {
	$value = trim( $value );
	$len   = strlen( $value );

	if ( $len >= 2 ) {
		$first = $value[0];
		$last  = $value[ $len - 1 ];
		if ( ( '"' === $first && '"' === $last ) || ( "'" === $first && "'" === $last ) ) {
			$value = substr( $value, 1, -1 );
			if ( '"' === $first ) {
				$value = str_replace( array( '\"', '\\\\' ), array( '"', '\\' ), $value );
			}
		}
	}

	return trim( $value );
}

/**
 * Safely parse and validate a `cv-md/1.1` Markdown file into frontmatter + body.
 *
 * Pure-PHP parser with strict UTF-8, NUL-byte, and malformed-frontmatter checks.
 *
 * @since 1.1.0
 *
 * @param string $raw Raw file contents.
 * @return array{meta: array<string, mixed>, body: string}|WP_Error Parsed data or error.
 */
function foa_cleaner_parse_cv_markdown( string $raw ) {
	if ( '' === trim( $raw ) ) {
		return new WP_Error( 'foa_cv_empty', __( 'The uploaded Markdown file is empty.', 'foa-cleaner' ) );
	}

	if ( false !== strpos( $raw, "\0" ) ) {
		return new WP_Error( 'foa_cv_binary', __( 'Binary files are not allowed. Please upload a plain-text UTF-8 Markdown (.md) file.', 'foa-cleaner' ) );
	}

	// Strip UTF-8 BOM if present and normalize line endings.
	if ( 0 === strncmp( $raw, "\xEF\xBB\xBF", 3 ) ) {
		$raw = substr( $raw, 3 );
	}

	if ( '' === wp_check_invalid_utf8( $raw ) ) {
		return new WP_Error( 'foa_cv_encoding', __( 'The uploaded file is not valid UTF-8 text.', 'foa-cleaner' ) );
	}

	$normalized = str_replace( array( "\r\n", "\r" ), "\n", $raw );
	$meta       = array(
		'schema'             => '',
		'name'               => '',
		'headline'           => '',
		'location'           => '',
		'work_authorization' => '',
		'availability'       => '',
		'email'              => '',
		'phone'              => '',
		'links'              => array(),
	);
	$body       = $normalized;

	// Parse optional leading YAML frontmatter delimited by --- lines.
	if ( preg_match( '/\A---[ \t]*\n/', $normalized ) ) {
		if ( ! preg_match( '/\A---[ \t]*\n(.*?)\n---[ \t]*(?:\n|\z)(.*)\z/s', $normalized, $parts ) ) {
			return new WP_Error(
				'foa_cv_malformed_frontmatter',
				__( 'Malformed YAML frontmatter: found opening "---" without a matching closing "---" delimiter.', 'foa-cleaner' )
			);
		}

		$yaml_lines = explode( "\n", $parts[1] );
		$body       = trim( $parts[2] );
		$in_links   = false;
		$curr_link  = null;

		$allowed_scalars = array(
			'schema',
			'name',
			'headline',
			'location',
			'work_authorization',
			'availability',
			'email',
			'phone',
		);

		foreach ( $yaml_lines as $line ) {
			$trimmed = trim( $line );
			if ( '' === $trimmed || 0 === strpos( $trimmed, '#' ) ) {
				continue;
			}

			// Inside `links:` list.
			if ( $in_links && preg_match( '/^[ \t]+-\s*([a-zA-Z0-9_]+)\s*:\s*(.*)$/', $line, $m ) ) {
				if ( is_array( $curr_link ) && ! empty( $curr_link['label'] ) && ! empty( $curr_link['url'] ) ) {
					$meta['links'][] = $curr_link;
				}
				$curr_link = array(
					'label' => '',
					'url'   => '',
				);
				$k         = strtolower( $m[1] );
				if ( 'label' === $k || 'url' === $k ) {
					$curr_link[ $k ] = foa_cleaner_unquote_yaml_scalar( $m[2] );
				}
				continue;
			}

			if ( $in_links && preg_match( '/^[ \t]{2,}([a-zA-Z0-9_]+)\s*:\s*(.*)$/', $line, $m ) && is_array( $curr_link ) ) {
				$k = strtolower( $m[1] );
				if ( 'label' === $k || 'url' === $k ) {
					$curr_link[ $k ] = foa_cleaner_unquote_yaml_scalar( $m[2] );
				}
				continue;
			}

			// Top-level key: value.
			if ( preg_match( '/^([a-zA-Z0-9_]+)\s*:\s*(.*)$/', $line, $m ) ) {
				if ( $in_links && is_array( $curr_link ) && ! empty( $curr_link['label'] ) && ! empty( $curr_link['url'] ) ) {
					$meta['links'][] = $curr_link;
				}
				$curr_link = null;
				$key       = strtolower( $m[1] );
				$val       = foa_cleaner_unquote_yaml_scalar( $m[2] );

				if ( 'links' === $key ) {
					$in_links = true;
					continue;
				}

				$in_links = false;
				if ( in_array( $key, $allowed_scalars, true ) ) {
					$meta[ $key ] = $val;
				}
			}
		}

		if ( $in_links && is_array( $curr_link ) && ! empty( $curr_link['label'] ) && ! empty( $curr_link['url'] ) ) {
			$meta['links'][] = $curr_link;
		}
	}

	// Sanitize parsed metadata strictly.
	$meta['schema']             = sanitize_text_field( (string) $meta['schema'] );
	$meta['name']               = sanitize_text_field( (string) $meta['name'] );
	$meta['headline']           = sanitize_text_field( (string) $meta['headline'] );
	$meta['location']           = sanitize_text_field( (string) $meta['location'] );
	$meta['work_authorization'] = sanitize_text_field( (string) $meta['work_authorization'] );
	$meta['availability']       = sanitize_text_field( (string) $meta['availability'] );
	$meta['phone']              = sanitize_text_field( (string) $meta['phone'] );

	$raw_email     = sanitize_email( (string) $meta['email'] );
	$meta['email'] = is_email( $raw_email ) ? $raw_email : '';

	$clean_links = array();
	foreach ( array_slice( (array) $meta['links'], 0, 8 ) as $link ) {
		$label = sanitize_text_field( (string) ( $link['label'] ?? '' ) );
		$url   = esc_url_raw( (string) ( $link['url'] ?? '' ), array( 'http', 'https' ) );
		if ( '' !== $label && '' !== $url ) {
			$clean_links[] = array(
				'label' => $label,
				'url'   => $url,
			);
		}
	}
	$meta['links'] = $clean_links;

	// Strip any raw HTML tags (including <script>/<style> contents) without
	// HTML-encoding plain `&` characters inside the Markdown source.
	$body = trim( wp_strip_all_tags( $body ) );

	// Neutralize unsafe URI schemes (javascript:, vbscript:, data:) in Markdown links
	// before storing in the jetpack/markdown `source` attribute.
	$body = (string) preg_replace_callback(
		'/\[([^\]]+)\]\(\s*([^)\s]+)\s*\)/',
		static function ( array $m ): string {
			$url = esc_url_raw( $m[2], array( 'http', 'https', 'mailto' ) );
			if ( '' === $url ) {
				return $m[1];
			}
			return '[' . $m[1] . '](' . $url . ')';
		},
		$body
	);

	// If no frontmatter `name`, extract leading `# Heading` if present.
	if ( '' === $meta['name'] && preg_match( '/\A#[ \t]+(.+?)(?:\n+|\z)(.*)\z/s', $body, $h1 ) ) {
		$meta['name'] = sanitize_text_field( $h1[1] );
		$body         = trim( $h1[2] );
	}

	if ( '' === $body ) {
		return new WP_Error(
			'foa_cv_empty_body',
			__( 'No CV body content found after the frontmatter. Include at least one Markdown section (e.g. ## Experience).', 'foa-cleaner' )
		);
	}

	return array(
		'meta' => $meta,
		'body' => $body,
	);
}

/**
 * Apply markdown-it `typographer: true` smart punctuation substitutions to
 * plain text (outside inline code spans) so saved HTML matches Jetpack's
 * `jetpack/markdown` block serializer in Gutenberg.
 *
 * @since 1.1.0
 *
 * @param string $text HTML-escaped text without code spans.
 * @return string Text with smart quotes, apostrophes, dashes, and ellipses.
 */
function foa_cleaner_cv_typographer( string $text ): string {
	// Ellipses and dashes (outside HTML tags).
	$text = str_replace( '...', '…', $text );
	$text = preg_replace( '/(?<!-)---(?!-)/', '—', $text );
	$text = preg_replace( '/(?<!-)--(?!-)/', '–', $text );

	// Opening / closing double quotes (only on text nodes, never tag attributes).
	$parts = preg_split( '/(<[^>]+>)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE );
	if ( ! is_array( $parts ) ) {
		return $text;
	}

	foreach ( $parts as $idx => $segment ) {
		if ( '' === $segment || '<' === $segment[0] ) {
			continue;
		}
		// Smart double quotes.
		$segment = preg_replace( '/(^|[\s(\[{—–])"(?=\S)/u', '$1“', $segment );
		$segment = str_replace( '"', '”', $segment );
		// Smart apostrophes / single quotes.
		$segment = preg_replace( '/(^|[\s(\[{—–])\'(?=\S)/u', '$1‘', $segment );
		$segment = str_replace( "'", '’', $segment );

		$parts[ $idx ] = $segment;
	}

	return implode( '', $parts );
}

/**
 * Format inline CommonMark syntax (code, links, bold, italic) safely as HTML
 * matching Jetpack's `markdown-it({ typographer: true })` output.
 *
 * @since 1.1.0
 *
 * @param string $text Plain text line.
 * @return string Safe inline HTML.
 */
function foa_cleaner_cv_format_inline_md( string $text ): string {
	// Protect inline `code` spans first (no typographer inside code).
	$code_tokens = array();
	$text        = preg_replace_callback(
		'/`([^`]+)`/',
		static function ( array $m ) use ( &$code_tokens ): string {
			$key                 = '%%FOACODE' . count( $code_tokens ) . '%%';
			$code_tokens[ $key ] = '<code>' . htmlspecialchars( $m[1], ENT_COMPAT | ENT_HTML5, 'UTF-8' ) . '</code>';
			return $key;
		},
		$text
	);

	// Escape `<`, `>`, `&` while leaving quotes for typographer pass.
	$escaped = str_replace( array( '&', '<', '>' ), array( '&amp;', '&lt;', '&gt;' ), $text );

	// Links: [label](https://...) — strictly allow http/https/mailto only.
	$escaped = preg_replace_callback(
		'/\[([^\]]+)\]\(([^)\s]+)\)/',
		static function ( array $m ): string {
			$raw_url = html_entity_decode( $m[2], ENT_QUOTES, 'UTF-8' );
			$url     = esc_url( $raw_url, array( 'http', 'https', 'mailto' ) );
			if ( '' === $url ) {
				return $m[1];
			}
			return '<a href="' . $url . '">' . $m[1] . '</a>';
		},
		$escaped
	);

	// Bold (**text**) then italic (*text*).
	$escaped = preg_replace( '/\*\*(.+?)\*\*/', '<strong>$1</strong>', $escaped );
	$escaped = preg_replace( '/(?<!\*)\*(?!\*)([^*]+?)(?<!\*)\*(?!\*)/', '<em>$1</em>', $escaped );

	// Apply markdown-it typographer rules outside HTML tags and code spans.
	$escaped = foa_cleaner_cv_typographer( $escaped );

	if ( ! empty( $code_tokens ) ) {
		$escaped = strtr( $escaped, $code_tokens );
	}

	return $escaped;
}

/**
 * Convert sanitized `cv-md/1.1` Markdown body into clean, safe HTML
 * for the `jetpack/markdown` block's saved markup.
 *
 * @since 1.1.0
 *
 * @param string $markdown Sanitized CommonMark body.
 * @return string Safe HTML filtered through `wp_kses_post()`.
 */
function foa_cleaner_cv_markdown_to_html( string $markdown ): string {
	$lines   = explode( "\n", str_replace( array( "\r\n", "\r" ), "\n", $markdown ) );
	$out     = array();
	$in_list = false;
	$para    = array();

	$flush_para = static function () use ( &$para, &$out ): void {
		if ( ! empty( $para ) ) {
			$out[] = '<p>' . foa_cleaner_cv_format_inline_md( implode( ' ', $para ) ) . '</p>';
			$para  = array();
		}
	};

	$close_list = static function () use ( &$in_list, &$out ): void {
		if ( $in_list ) {
			$out[]   = '</ul>';
			$in_list = false;
		}
	};

	foreach ( $lines as $line ) {
		$trimmed = trim( $line );

		if ( '' === $trimmed ) {
			$flush_para();
			$close_list();
			continue;
		}

		// Horizontal rule.
		if ( preg_match( '/^(?:-{3,}|\*{3,}|_{3,})$/', $trimmed ) ) {
			$flush_para();
			$close_list();
			$out[] = '<hr />';
			continue;
		}

		// Headings (##, ###, ####, etc.).
		if ( preg_match( '/^(#{1,6})\s+(.+)$/', $trimmed, $m ) ) {
			$flush_para();
			$close_list();
			$level = min( 6, max( 1, strlen( $m[1] ) ) );
			$out[] = sprintf( '<h%1$d>%2$s</h%1$d>', $level, foa_cleaner_cv_format_inline_md( $m[2] ) );
			continue;
		}

		// Unordered list items (- or *).
		if ( preg_match( '/^[-*]\s+(.+)$/', $trimmed, $m ) ) {
			$flush_para();
			if ( ! $in_list ) {
				$out[]   = '<ul>';
				$in_list = true;
			}
			$out[] = '<li>' . foa_cleaner_cv_format_inline_md( $m[1] ) . '</li>';
			continue;
		}

		$close_list();
		$para[] = $trimmed;
	}

	$flush_para();
	$close_list();

	return wp_kses_post( implode( "\n", $out ) ) . "\n";
}

/**
 * Strip the Markdown-only trailing `## Facts` section (and localized cv-md/1.1
 * equivalents) from a CV Markdown string before publishing a downloadable `.md` file.
 *
 * @since 1.1.0
 *
 * @param string $markdown Sanitized Markdown body.
 * @return string Public Markdown body without trailing Facts notes.
 */
function foa_cleaner_strip_cv_facts_from_markdown( string $markdown ): string {
	$stripped = preg_replace(
		'/(?:\A|\n)##[ \t]+(?:facts|feiten|fakten|faits)[ \t]*(?:\n.*)?\z/is',
		'',
		$markdown
	);

	return is_string( $stripped ) ? trim( $stripped ) : trim( $markdown );
}

/**
 * Rebuild a clean, sanitized public `cv-md/1.1` Markdown document (without raw HTML,
 * unsafe link schemes, or trailing `## Facts` notes) for the Download CV.MD fallback.
 *
 * @since 1.1.0
 *
 * @param array{meta: array<string, mixed>, body: string} $parsed Validated CV data.
 * @return string Clean UTF-8 Markdown document.
 */
function foa_cleaner_build_public_cv_markdown( array $parsed ): string {
	$meta       = $parsed['meta'];
	$public_md  = foa_cleaner_strip_cv_facts_from_markdown( (string) $parsed['body'] );
	$yaml_lines = array();

	$scalar_keys = array(
		'schema',
		'name',
		'headline',
		'location',
		'work_authorization',
		'availability',
		'email',
		'phone',
	);

	foreach ( $scalar_keys as $key ) {
		if ( ! empty( $meta[ $key ] ) ) {
			$val          = str_replace( array( '\\', '"' ), array( '\\\\', '\"' ), (string) $meta[ $key ] );
			$yaml_lines[] = $key . ': "' . $val . '"';
		}
	}

	if ( ! empty( $meta['links'] ) && is_array( $meta['links'] ) ) {
		$yaml_lines[] = 'links:';
		foreach ( $meta['links'] as $link ) {
			$label        = str_replace( array( '\\', '"' ), array( '\\\\', '\"' ), (string) $link['label'] );
			$url          = str_replace( array( '\\', '"' ), array( '\\\\', '\"' ), (string) $link['url'] );
			$yaml_lines[] = '  - label: "' . $label . '"';
			$yaml_lines[] = '    url: "' . $url . '"';
		}
	}

	if ( empty( $yaml_lines ) ) {
		return $public_md . "\n";
	}

	return "---\n" . implode( "\n", $yaml_lines ) . "\n---\n\n" . $public_md . "\n";
}

/**
 * Store a validated, sanitized public `.md` CV file in the WordPress uploads directory.
 *
 * Called after `foa_cleaner_parse_cv_markdown()` succeeds so visitors and AI agents
 * can always download the sanitized Markdown CV (either via the subtle `Download CV.md`
 * link beneath `Download PDF`, or as the primary `Download CV.MD` button when no PDF
 * is uploaded).
 *
 * @since 1.1.0
 *
 * @param array{meta: array<string, mixed>, body: string} $parsed   Validated CV data.
 * @param string                                          $filename Desired base filename (without extension).
 * @return string|WP_Error Public file URL on success, or WP_Error on failure.
 */
function foa_cleaner_store_cv_markdown_file( array $parsed, string $filename ) {
	if ( ! current_user_can( 'upload_files' ) ) {
		return new WP_Error( 'foa_cv_md_cap', __( 'You do not have permission to upload files.', 'foa-cleaner' ) );
	}

	$safe_base = sanitize_file_name( $filename );
	if ( '' === $safe_base ) {
		$safe_base = 'cv';
	}

	$public_md = foa_cleaner_build_public_cv_markdown( $parsed );

	// WordPress core's default upload_mimes does not include `.md`, which causes
	// wp_upload_bits() to reject it with "Sorry, you are not allowed to upload this file type."
	// Allow `text/markdown` strictly for this sanitized write, then remove immediately.
	$allow_md_mime = static function ( array $mimes ): array {
		$mimes['md'] = 'text/markdown';
		return $mimes;
	};

	add_filter( 'upload_mimes', $allow_md_mime, 99 );
	try {
		$uploaded = wp_upload_bits( $safe_base . '.md', null, $public_md );
	} finally {
		remove_filter( 'upload_mimes', $allow_md_mime, 99 );
	}

	if ( ! empty( $uploaded['error'] ) || empty( $uploaded['file'] ) || empty( $uploaded['url'] ) ) {
		$msg = ! empty( $uploaded['error'] )
			? (string) $uploaded['error']
			: __( 'Could not save the Markdown file to the uploads directory.', 'foa-cleaner' );
		return new WP_Error( 'foa_cv_md_store', $msg );
	}

	$attachment_id = wp_insert_attachment(
		array(
			'guid'           => (string) $uploaded['url'],
			'post_mime_type' => 'text/markdown',
			'post_title'     => sanitize_file_name( pathinfo( (string) $uploaded['file'], PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		(string) $uploaded['file']
	);

	if ( is_wp_error( $attachment_id ) ) {
		wp_delete_file( (string) $uploaded['file'] );
		return $attachment_id;
	}

	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	$attach_meta = wp_generate_attachment_metadata( $attachment_id, (string) $uploaded['file'] );
	if ( is_array( $attach_meta ) ) {
		wp_update_attachment_metadata( $attachment_id, $attach_meta );
	}

	return (string) $uploaded['url'];
}

/**
 * Build Gutenberg block markup for a CV page from parsed `cv-md/1.1` data.
 *
 * Generates a native `foa-cv-header` group (Name, Headline, Contact/Links meta,
 * and Download PDF + subtle Download CV.md link, or Download CV.MD button alone)
 * followed by a `jetpack/markdown` block.
 *
 * @since 1.1.0
 *
 * @param array{meta: array<string, mixed>, body: string} $parsed           Parsed CV data.
 * @param string                                          $download_url     Optional primary PDF or `.md` download URL.
 * @param string                                          $download_label   Optional button label (defaults to "Download PDF").
 * @param string                                          $secondary_md_url Optional secondary `.md` URL rendered in tiny letters beneath "Download PDF".
 * @return string Serialized Gutenberg block content.
 */
function foa_cleaner_build_cv_page_blocks( array $parsed, string $download_url = '', string $download_label = '', string $secondary_md_url = '' ): string {
	$meta = $parsed['meta'];
	$body = $parsed['body'];

	$name     = '' !== $meta['name'] ? $meta['name'] : __( 'Curriculum Vitae', 'foa-cleaner' );
	$headline = (string) $meta['headline'];

	// Build contact & metadata strip items.
	$meta_parts = array();
	foreach ( array( 'location', 'work_authorization', 'availability', 'phone' ) as $field ) {
		if ( ! empty( $meta[ $field ] ) ) {
			$meta_parts[] = esc_html( (string) $meta[ $field ] );
		}
	}
	if ( ! empty( $meta['email'] ) ) {
		$email        = (string) $meta['email'];
		$meta_parts[] = sprintf( '<a href="mailto:%1$s">%2$s</a>', esc_attr( $email ), esc_html( $email ) );
	}
	foreach ( (array) $meta['links'] as $link ) {
		$meta_parts[] = sprintf(
			'<a href="%1$s" rel="noopener noreferrer">%2$s</a>',
			esc_url( (string) $link['url'] ),
			esc_html( (string) $link['label'] )
		);
	}

	$blocks   = array();
	$blocks[] = '<!-- wp:group {"tagName":"header","className":"foa-cv-header","layout":{"type":"default"}} -->';
	$blocks[] = '<header class="wp-block-group foa-cv-header">';
	$blocks[] = '<!-- wp:group {"className":"foa-cv-header__top","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"top"}} -->';
	$blocks[] = '<div class="wp-block-group foa-cv-header__top">';
	$blocks[] = '<!-- wp:group {"style":{"spacing":{"blockGap":"0.25rem"}},"layout":{"type":"default"}} -->';
	$blocks[] = '<div class="wp-block-group">';
	$blocks[] = '<!-- wp:heading {"level":1,"className":"foa-cv-header__name","fontSize":"2-xl"} -->';
	$blocks[] = '<h1 class="wp-block-heading foa-cv-header__name has-2-xl-font-size">' . esc_html( $name ) . '</h1>';
	$blocks[] = '<!-- /wp:heading -->';

	if ( '' !== $headline ) {
		$blocks[] = '<!-- wp:paragraph {"className":"foa-cv-header__headline is-style-lead"} -->';
		$blocks[] = '<p class="foa-cv-header__headline is-style-lead">' . esc_html( $headline ) . '</p>';
		$blocks[] = '<!-- /wp:paragraph -->';
	}

	$blocks[] = '</div>';
	$blocks[] = '<!-- /wp:group -->';

	if ( '' !== $download_url ) {
		$safe_url  = esc_url( $download_url );
		$btn_label = '' !== $download_label ? $download_label : __( 'Download PDF', 'foa-cleaner' );

		if ( '' !== $secondary_md_url ) {
			$safe_md_url = esc_url( $secondary_md_url );
			$blocks[]    = '<!-- wp:group {"className":"foa-cv-header__actions foa-cv-no-print","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->';
			$blocks[]    = '<div class="wp-block-group foa-cv-header__actions foa-cv-no-print">';
			$blocks[]    = '<!-- wp:buttons -->';
			$blocks[]    = '<div class="wp-block-buttons">';
			$blocks[]    = '<!-- wp:button {"className":"is-style-ghost"} -->';
			$blocks[]    = '<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="' . $safe_url . '">' . esc_html( $btn_label ) . '</a></div>';
			$blocks[]    = '<!-- /wp:button -->';
			$blocks[]    = '</div>';
			$blocks[]    = '<!-- /wp:buttons -->';
			$blocks[]    = '<!-- wp:paragraph {"align":"center","className":"foa-cv-header__md-link"} -->';
			$blocks[]    = '<p class="has-text-align-center foa-cv-header__md-link"><a href="' . $safe_md_url . '">' . esc_html__( 'Download CV.md', 'foa-cleaner' ) . '</a></p>';
			$blocks[]    = '<!-- /wp:paragraph -->';
			$blocks[]    = '</div>';
			$blocks[]    = '<!-- /wp:group -->';
		} else {
			$blocks[] = '<!-- wp:buttons {"className":"foa-cv-no-print"} -->';
			$blocks[] = '<div class="wp-block-buttons foa-cv-no-print">';
			$blocks[] = '<!-- wp:button {"className":"is-style-ghost"} -->';
			$blocks[] = '<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button" href="' . $safe_url . '">' . esc_html( $btn_label ) . '</a></div>';
			$blocks[] = '<!-- /wp:button -->';
			$blocks[] = '</div>';
			$blocks[] = '<!-- /wp:buttons -->';
		}
	}

	$blocks[] = '</div>';
	$blocks[] = '<!-- /wp:group -->';

	if ( ! empty( $meta_parts ) ) {
		$blocks[] = '<!-- wp:paragraph {"className":"foa-cv-header__meta"} -->';
		$blocks[] = '<p class="foa-cv-header__meta">' . implode( ' · ', $meta_parts ) . '</p>';
		$blocks[] = '<!-- /wp:paragraph -->';
	}

	$blocks[] = '</header>';
	$blocks[] = '<!-- /wp:group -->';
	$blocks[] = '';

	$md_attrs = wp_json_encode( array( 'source' => $body ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	$md_html  = foa_cleaner_cv_markdown_to_html( $body );

	$blocks[] = '<!-- wp:jetpack/markdown ' . $md_attrs . ' -->';
	$blocks[] = '<div class="wp-block-jetpack-markdown">' . $md_html . '</div>';
	$blocks[] = '<!-- /wp:jetpack/markdown -->';

	return implode( "\n", $blocks );
}

/**
 * Validate and upload an optional companion PDF file to the Media Library.
 *
 * @since 1.1.0
 *
 * @param array $file Entry from `$_FILES['cv_pdf']`.
 * @return string|WP_Error Attachment URL on success, or WP_Error on failure.
 */
function foa_cleaner_handle_cv_pdf_upload( array $file ) {
	if ( ! current_user_can( 'upload_files' ) ) {
		return new WP_Error( 'foa_cv_pdf_cap', __( 'You do not have permission to upload PDF files.', 'foa-cleaner' ) );
	}

	if ( ! empty( $file['error'] ) && UPLOAD_ERR_OK !== (int) $file['error'] ) {
		return new WP_Error( 'foa_cv_pdf_upload_err', __( 'PDF upload failed. Please try again.', 'foa-cleaner' ) );
	}

	$size = isset( $file['size'] ) ? (int) $file['size'] : 0;
	if ( $size <= 0 || $size > FOA_CLEANER_CV_MAX_PDF_BYTES ) {
		return new WP_Error( 'foa_cv_pdf_size', __( 'PDF file must be smaller than 10 MB.', 'foa-cleaner' ) );
	}

	$tmp_name = isset( $file['tmp_name'] ) ? (string) $file['tmp_name'] : '';
	if ( '' === $tmp_name || ! is_uploaded_file( $tmp_name ) ) {
		return new WP_Error( 'foa_cv_pdf_invalid', __( 'Invalid PDF upload.', 'foa-cleaner' ) );
	}

	// Verify PDF magic header (%PDF-).
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- reading 5-byte magic header from uploaded temp file.
	$header = file_get_contents( $tmp_name, false, null, 0, 5 );
	if ( '%PDF-' !== $header ) {
		return new WP_Error( 'foa_cv_pdf_magic', __( 'The uploaded PDF file is not a valid PDF document.', 'foa-cleaner' ) );
	}

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	$uploaded = wp_handle_upload(
		$file,
		array(
			'test_form' => false,
			'mimes'     => array( 'pdf' => 'application/pdf' ),
		)
	);

	if ( isset( $uploaded['error'] ) || empty( $uploaded['file'] ) || empty( $uploaded['url'] ) ) {
		$err_msg = isset( $uploaded['error'] ) ? (string) $uploaded['error'] : __( 'Could not store PDF file.', 'foa-cleaner' );
		return new WP_Error( 'foa_cv_pdf_store', $err_msg );
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => 'application/pdf',
			'post_title'     => sanitize_file_name( pathinfo( $uploaded['file'], PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$uploaded['file']
	);

	if ( is_wp_error( $attachment_id ) ) {
		return $attachment_id;
	}

	$attach_meta = wp_generate_attachment_metadata( $attachment_id, $uploaded['file'] );
	if ( is_array( $attach_meta ) ) {
		wp_update_attachment_metadata( $attachment_id, $attach_meta );
	}

	return (string) $uploaded['url'];
}

/**
 * Render the Create / Edit CV Page panel directly beneath the Jetpack Markdown
 * setting inside Appearance → FoA Cleaner.
 *
 * The `<dialog>` upload modal is rendered separately after `</form>` via
 * `foa_cleaner_render_cv_upload_modal()` to avoid nested `<form>` elements.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_cv_builder_panel(): void {
	$enabled     = foa_cleaner_is_cv_importer_enabled();
	$cv_page     = foa_cleaner_get_managed_cv_page();
	$ref_url     = foa_cleaner_get_cv_format_reference_url();
	$can_write   = current_user_can( 'publish_pages' );
	$panel_title = ( $enabled && $cv_page instanceof WP_Post )
		? __( 'Edit CV Page', 'foa-cleaner' )
		: __( 'Create CV Page', 'foa-cleaner' );
	?>
	<div
		class="foa-admin-panel foa-cv-panel foa-cv-panel--inline<?php echo $enabled ? '' : ' is-disabled'; ?>"
		role="region"
		aria-labelledby="foa-cv-builder-heading"
		data-foa-cv-panel
		data-enabled="<?php echo $enabled ? '1' : '0'; ?>"
	>
		<div class="foa-admin-panel__header">
			<div class="foa-cv-panel__title-row">
				<h3 id="foa-cv-builder-heading" class="foa-admin-panel__title"><?php echo esc_html( $panel_title ); ?></h3>
				<?php if ( ! $enabled ) : ?>
					<span class="foa-plugin-badge is-optional"><?php esc_html_e( 'Requires Jetpack Markdown', 'foa-cleaner' ); ?></span>
				<?php elseif ( $cv_page instanceof WP_Post ) : ?>
					<?php if ( 'publish' === $cv_page->post_status ) : ?>
						<span class="foa-plugin-badge is-active" data-foa-cv-status-badge><?php esc_html_e( 'Published', 'foa-cleaner' ); ?></span>
					<?php else : ?>
						<span class="foa-plugin-badge is-draft" data-foa-cv-status-badge><?php esc_html_e( 'Draft', 'foa-cleaner' ); ?></span>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<p class="foa-admin-panel__subtitle">
				<?php esc_html_e( 'Import a canonical Markdown CV (cv-md/1.1) to generate a print-ready CV page with structured header metadata and a Jetpack Markdown body.', 'foa-cleaner' ); ?>
				<a href="<?php echo esc_url( $ref_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'CV Markdown format reference →', 'foa-cleaner' ); ?></a>
			</p>
		</div>

		<?php if ( ! $enabled ) : ?>
			<div class="foa-cv-panel__body">
				<button type="button" class="button button-secondary" disabled="disabled"><?php esc_html_e( 'Upload CV Markdown', 'foa-cleaner' ); ?></button>
				<span class="foa-plugin-active-note"><?php esc_html_e( 'Activate Jetpack and enable "Jetpack Markdown (for CV)" above to unlock CV import.', 'foa-cleaner' ); ?></span>
			</div>
		<?php else : ?>
			<div class="foa-cv-panel__body" data-foa-cv-state-container>
				<?php if ( $cv_page instanceof WP_Post ) : ?>
					<?php
					$is_draft = 'publish' !== $cv_page->post_status;
					$view_url = $is_draft ? get_preview_post_link( $cv_page ) : get_permalink( $cv_page );
					$edit_url = get_edit_post_link( $cv_page->ID, 'raw' );
					?>
					<div class="foa-cv-page-summary" data-foa-cv-summary data-page-id="<?php echo esc_attr( (string) $cv_page->ID ); ?>">
						<div class="foa-cv-page-summary__info">
							<strong class="foa-cv-page-summary__title"><?php echo esc_html( get_the_title( $cv_page ) ); ?></strong>
							<code class="foa-cv-page-summary__slug">/<?php echo esc_html( $cv_page->post_name ); ?>/</code>
						</div>
						<div class="foa-cv-page-summary__actions">
							<?php if ( $is_draft && $can_write ) : ?>
								<button type="button" class="button button-primary" data-foa-cv-publish data-page-id="<?php echo esc_attr( (string) $cv_page->ID ); ?>">
									<?php esc_html_e( 'Publish', 'foa-cleaner' ); ?>
								</button>
							<?php endif; ?>
							<?php if ( $view_url ) : ?>
								<a href="<?php echo esc_url( $view_url ); ?>" class="button button-secondary" target="_blank" rel="noopener noreferrer" data-foa-cv-view-link>
									<?php echo $is_draft ? esc_html__( 'Preview', 'foa-cleaner' ) : esc_html__( 'View', 'foa-cleaner' ); ?>
								</a>
							<?php endif; ?>
							<?php if ( $edit_url ) : ?>
								<a href="<?php echo esc_url( $edit_url ); ?>" class="button button-secondary">
									<?php esc_html_e( 'Edit', 'foa-cleaner' ); ?>
								</a>
							<?php endif; ?>
							<?php if ( current_user_can( 'delete_post', $cv_page->ID ) ) : ?>
								<button type="button" class="button button-link-delete foa-cv-delete-btn" data-foa-cv-delete data-page-id="<?php echo esc_attr( (string) $cv_page->ID ); ?>">
									<?php esc_html_e( 'Delete', 'foa-cleaner' ); ?>
								</button>
							<?php endif; ?>
						</div>
					</div>
				<?php else : ?>
					<div class="foa-cv-upload-cta" data-foa-cv-upload-cta>
						<?php if ( $can_write ) : ?>
							<button type="button" class="button button-primary" data-foa-cv-open-modal>
								<?php esc_html_e( 'Upload CV Markdown', 'foa-cleaner' ); ?>
							</button>
							<span class="foa-plugin-active-note"><?php esc_html_e( 'Creates a Draft page at /cv/ using the CV / Resume template.', 'foa-cleaner' ); ?></span>
						<?php else : ?>
							<span class="foa-plugin-active-note"><?php esc_html_e( 'You need permission to publish pages to create a CV page.', 'foa-cleaner' ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<p class="foa-plugin-card__message" role="status" aria-live="polite" data-foa-cv-panel-message></p>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Render the native `<dialog>` CV upload modal outside the main settings `<form>`.
 *
 * @since 1.1.0
 */
function foa_cleaner_render_cv_upload_modal(): void {
	if ( ! foa_cleaner_is_cv_importer_enabled() || ! current_user_can( 'publish_pages' ) ) {
		return;
	}

	$ref_url = foa_cleaner_get_cv_format_reference_url();
	?>
	<dialog class="foa-modal" id="foa-cv-upload-modal" aria-labelledby="foa-cv-modal-title">
		<div class="foa-modal__header">
			<h3 id="foa-cv-modal-title" class="foa-modal__title"><?php esc_html_e( 'Create CV Page from Markdown', 'foa-cleaner' ); ?></h3>
			<button type="button" class="foa-modal__close" data-foa-cv-close-modal aria-label="<?php esc_attr_e( 'Close modal', 'foa-cleaner' ); ?>">&times;</button>
		</div>

		<form class="foa-modal__form" data-foa-cv-upload-form enctype="multipart/form-data">
			<div class="foa-modal__body">
				<p class="foa-modal__intro">
					<?php esc_html_e( 'Upload a UTF-8 Markdown file following our cv-md/1.1 schema. Frontmatter fields populate the CV Header block; the Markdown body is inserted into a Jetpack Markdown block.', 'foa-cleaner' ); ?>
					<a href="<?php echo esc_url( $ref_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View format reference →', 'foa-cleaner' ); ?></a>
				</p>

				<div class="foa-modal__field">
					<label for="foa-cv-md-file"><?php esc_html_e( 'CV Markdown File (.md)', 'foa-cleaner' ); ?> <span class="required">*</span></label>
					<input type="file" id="foa-cv-md-file" name="cv_markdown" accept=".md,.markdown,.txt,text/markdown,text/plain" required />
					<p class="description"><?php esc_html_e( 'UTF-8 plain-text Markdown, max 512 KB. Trailing ## Facts sections are hidden automatically on the frontend.', 'foa-cleaner' ); ?></p>
				</div>

				<div class="foa-modal__field">
					<label for="foa-cv-pdf-file"><?php esc_html_e( 'Companion PDF File (optional)', 'foa-cleaner' ); ?></label>
					<input type="file" id="foa-cv-pdf-file" name="cv_pdf" accept=".pdf,application/pdf" />
					<p class="description"><?php esc_html_e( 'Uploaded to the Media Library and linked to the "Download PDF" button in the CV Header, with a subtle "Download CV.md" link right beneath it. If left blank, the button becomes "Download CV.MD" linking to your uploaded Markdown file.', 'foa-cleaner' ); ?></p>
				</div>

				<div class="foa-modal__field">
					<label for="foa-cv-slug"><?php esc_html_e( 'Page Slug', 'foa-cleaner' ); ?></label>
					<input type="text" id="foa-cv-slug" name="cv_slug" value="cv" class="regular-text" placeholder="cv" />
					<p class="description"><?php esc_html_e( 'Defaults to /cv/. The page is created as a Draft so you can preview it before publishing.', 'foa-cleaner' ); ?></p>
				</div>

				<p class="foa-plugin-card__message" role="alert" aria-live="polite" data-foa-cv-modal-message></p>
			</div>

			<div class="foa-modal__footer">
				<button type="button" class="button button-secondary" data-foa-cv-close-modal><?php esc_html_e( 'Cancel', 'foa-cleaner' ); ?></button>
				<button type="submit" class="button button-primary" data-foa-cv-submit><?php esc_html_e( 'Create Draft CV Page', 'foa-cleaner' ); ?></button>
			</div>
		</form>
	</dialog>
	<?php
}

/**
 * AJAX handler: validate uploaded CV Markdown (+ optional PDF) and create Draft CV page.
 *
 * @since 1.1.0
 */
function foa_cleaner_ajax_create_cv_page(): void {
	check_ajax_referer( 'foa_cleaner_cv_action', 'nonce' );

	if ( ! current_user_can( 'edit_theme_options' ) || ! current_user_can( 'publish_pages' ) ) {
		wp_send_json_error(
			array( 'message' => __( 'You do not have permission to create CV pages.', 'foa-cleaner' ) ),
			403
		);
	}

	if ( ! foa_cleaner_is_cv_importer_enabled() ) {
		wp_send_json_error(
			array( 'message' => __( 'Enable Jetpack and Jetpack Markdown (for CV) first.', 'foa-cleaner' ) ),
			400
		);
	}

	if ( foa_cleaner_get_managed_cv_page() instanceof WP_Post ) {
		wp_send_json_error(
			array( 'message' => __( 'A CV page already exists. Delete it first before uploading a new one.', 'foa-cleaner' ) ),
			409
		);
	}

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- validated below.
	$md_file = isset( $_FILES['cv_markdown'] ) && is_array( $_FILES['cv_markdown'] ) ? $_FILES['cv_markdown'] : null;

	if ( ! $md_file || empty( $md_file['tmp_name'] ) || ! is_uploaded_file( (string) $md_file['tmp_name'] ) ) {
		wp_send_json_error(
			array( 'message' => __( 'Please select a Markdown (.md) file to upload.', 'foa-cleaner' ) ),
			400
		);
	}

	if ( ! empty( $md_file['error'] ) && UPLOAD_ERR_OK !== (int) $md_file['error'] ) {
		wp_send_json_error(
			array( 'message' => __( 'File upload failed. Please try again.', 'foa-cleaner' ) ),
			400
		);
	}

	$md_size = isset( $md_file['size'] ) ? (int) $md_file['size'] : 0;
	if ( $md_size <= 0 || $md_size > FOA_CLEANER_CV_MAX_MD_BYTES ) {
		wp_send_json_error(
			array( 'message' => __( 'Markdown file must be between 1 byte and 512 KB.', 'foa-cleaner' ) ),
			400
		);
	}

	$md_name = isset( $md_file['name'] ) ? sanitize_file_name( wp_unslash( (string) $md_file['name'] ) ) : '';
	$md_ext  = strtolower( pathinfo( $md_name, PATHINFO_EXTENSION ) );
	if ( ! in_array( $md_ext, array( 'md', 'markdown', 'txt' ), true ) ) {
		wp_send_json_error(
			array( 'message' => __( 'Only .md, .markdown, or .txt files are allowed.', 'foa-cleaner' ) ),
			400
		);
	}

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- reading validated uploaded temp file.
	$raw_md = file_get_contents( (string) $md_file['tmp_name'] );
	if ( ! is_string( $raw_md ) ) {
		wp_send_json_error(
			array( 'message' => __( 'Could not read the uploaded Markdown file.', 'foa-cleaner' ) ),
			400
		);
	}

	$parsed = foa_cleaner_parse_cv_markdown( $raw_md );
	if ( is_wp_error( $parsed ) ) {
		wp_send_json_error( array( 'message' => $parsed->get_error_message() ), 400 );
	}

	$raw_slug  = isset( $_POST['cv_slug'] ) ? sanitize_title( wp_unslash( (string) $_POST['cv_slug'] ) ) : 'cv';
	$page_slug = '' !== $raw_slug ? $raw_slug : 'cv';

	// Always store a validated, sanitized public .md copy (with ## Facts stripped).
	$md_base   = pathinfo( $md_name, PATHINFO_FILENAME );
	$md_result = foa_cleaner_store_cv_markdown_file( $parsed, '' !== $md_base ? $md_base : $page_slug );
	if ( is_wp_error( $md_result ) ) {
		wp_send_json_error( array( 'message' => $md_result->get_error_message() ), 400 );
	}

	// Optional PDF upload: primary "Download PDF" button + tiny "Download CV.md" link beneath it.
	// When omitted, the primary button itself is "Download CV.MD" with no second link.
	$download_url     = $md_result;
	$download_label   = __( 'Download CV.MD', 'foa-cleaner' );
	$secondary_md_url = '';
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- validated in helper.
	if ( isset( $_FILES['cv_pdf'] ) && is_array( $_FILES['cv_pdf'] ) && ! empty( $_FILES['cv_pdf']['name'] ) ) {
		$pdf_result = foa_cleaner_handle_cv_pdf_upload( $_FILES['cv_pdf'] );
		if ( is_wp_error( $pdf_result ) ) {
			wp_send_json_error( array( 'message' => $pdf_result->get_error_message() ), 400 );
		}
		$download_url     = $pdf_result;
		$download_label   = __( 'Download PDF', 'foa-cleaner' );
		$secondary_md_url = $md_result;
	}

	$page_title = ! empty( $parsed['meta']['name'] )
		? sprintf(
			/* translators: %s: candidate name from CV frontmatter */
			__( '%s — CV', 'foa-cleaner' ),
			$parsed['meta']['name']
		)
		: __( 'CV', 'foa-cleaner' );

	$content = foa_cleaner_build_cv_page_blocks( $parsed, $download_url, $download_label, $secondary_md_url );

	$page_id = wp_insert_post(
		array(
			'post_type'      => 'page',
			'post_status'    => 'draft',
			'post_title'     => $page_title,
			'post_name'      => $page_slug,
			'post_content'   => wp_slash( $content ),
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		wp_send_json_error( array( 'message' => $page_id->get_error_message() ), 500 );
	}

	update_post_meta( $page_id, '_wp_page_template', 'page-cv' );
	update_option( FOA_CLEANER_CV_PAGE_ID_OPTION, $page_id );

	$post = get_post( $page_id );

	wp_send_json_success(
		array(
			'pageId'     => $page_id,
			'title'      => get_the_title( $page_id ),
			'slug'       => $post instanceof WP_Post ? $post->post_name : $page_slug,
			'status'     => 'draft',
			'previewUrl' => get_preview_post_link( $page_id ),
			'editUrl'    => get_edit_post_link( $page_id, 'raw' ),
		)
	);
}
add_action( 'wp_ajax_foa_cleaner_create_cv_page', 'foa_cleaner_ajax_create_cv_page' );

/**
 * AJAX handler: publish the managed Draft CV page in one click.
 *
 * @since 1.1.0
 */
function foa_cleaner_ajax_publish_cv_page(): void {
	check_ajax_referer( 'foa_cleaner_cv_action', 'nonce' );

	$page_id = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : 0;
	$managed = foa_cleaner_get_managed_cv_page();

	if ( ! $managed instanceof WP_Post || $managed->ID !== $page_id ) {
		wp_send_json_error(
			array( 'message' => __( 'Managed CV page not found.', 'foa-cleaner' ) ),
			404
		);
	}

	if ( ! current_user_can( 'publish_pages' ) || ! current_user_can( 'edit_post', $page_id ) ) {
		wp_send_json_error(
			array( 'message' => __( 'You do not have permission to publish this page.', 'foa-cleaner' ) ),
			403
		);
	}

	$updated = wp_update_post(
		array(
			'ID'          => $page_id,
			'post_status' => 'publish',
		),
		true
	);

	if ( is_wp_error( $updated ) ) {
		wp_send_json_error( array( 'message' => $updated->get_error_message() ), 500 );
	}

	wp_send_json_success(
		array(
			'pageId'  => $page_id,
			'status'  => 'publish',
			'viewUrl' => get_permalink( $page_id ),
		)
	);
}
add_action( 'wp_ajax_foa_cleaner_publish_cv_page', 'foa_cleaner_ajax_publish_cv_page' );

/**
 * AJAX handler: move the managed CV page to WordPress Trash and restore upload UI.
 *
 * @since 1.1.0
 */
function foa_cleaner_ajax_delete_cv_page(): void {
	check_ajax_referer( 'foa_cleaner_cv_action', 'nonce' );

	$page_id = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : 0;
	$managed = foa_cleaner_get_managed_cv_page();

	if ( ! $managed instanceof WP_Post || $managed->ID !== $page_id ) {
		delete_option( FOA_CLEANER_CV_PAGE_ID_OPTION );
		wp_send_json_success( array( 'trashed' => true ) );
	}

	if ( ! current_user_can( 'delete_post', $page_id ) ) {
		wp_send_json_error(
			array( 'message' => __( 'You do not have permission to delete this page.', 'foa-cleaner' ) ),
			403
		);
	}

	$trashed = wp_trash_post( $page_id );
	if ( ! $trashed ) {
		wp_send_json_error(
			array( 'message' => __( 'Could not move the CV page to Trash.', 'foa-cleaner' ) ),
			500
		);
	}

	delete_option( FOA_CLEANER_CV_PAGE_ID_OPTION );

	wp_send_json_success( array( 'trashed' => true ) );
}
add_action( 'wp_ajax_foa_cleaner_delete_cv_page', 'foa_cleaner_ajax_delete_cv_page' );
