<?php


class Wms_Get_Sitemap {
	function __construct() {
		$this->post_types = get_post_types([
			'public'   => true,
			'_builtin' => false,
		], 'objects', 'and');
		$this->site_map = [];
		$this->type_post = get_post_type_object('post');
	}

	/**
	 * 固定ページ一覧取得
	 */
	function get_pages() {
		$pages_array = [];
		$page_list = get_pages();
		foreach ($page_list as $page) {
			$page_array = [];
			$parent_id = wp_get_post_parent_id($page->ID);
			$page_heirarchy = get_post_ancestors($page->ID);
			// $page_heirarchy_cout = count($page_heirarchy);
			$page_array['url'] = get_permalink($page->ID);
			$page_array['slug'] =  $page->post_name;
			$page_array['title'] = $page->post_title;

			$this->site_map[] = $page_array;
		}
	}

	/**
	 * アーカイブ一覧取得
	 */
	function get_archives() {

		$args = array(
			'public'   => true,
			'_builtin' => false,
		);

		$post_acrhive_array =	[
			'url' => '',
			'slug' => $this->type_post->name,
			'title' => $this->type_post->label . ' アーカイブページ',
		];
		$this->site_map[] = $post_acrhive_array;

		foreach ($this->post_types as $post_type) {
			$archive_array = [];
			$archive_array['url'] = home_url('/' . $post_type->name);
			$archive_array['slug'] = $post_type->name;
			$archive_array['title'] = 'カスタム投稿「' . $post_type->label . '」 アーカイブページ';
			$this->site_map[] = $archive_array;
		}


		// return $archives_array;
	}

	/**
	 * シングル一覧取得
	 */
	function get_singles() {
		$post_acrhive_array =	[
			'url' => '',
			'slug' => '投稿名',
			'title' => $this->type_post->label . ' シングルページ',
		];
		$this->site_map[] = $post_acrhive_array;

		foreach ($this->post_types as $post_type) {
			$single_array = [];
			$single_array['url'] = home_url('/' . $post_type->name . '/投稿名');
			$single_array['slug'] = '投稿名';
			$single_array['title'] = 'カスタム投稿「' . $post_type->label . '」 シングルページ';
			$this->site_map[] = $single_array;
		}

		// return $singles_array;
	}

	/**
	 * 全ての配列を取得する
	 *
	 */
	function get_results() {
		$this->get_pages();
		$this->get_archives();
		$this->get_singles();

		return $this->site_map;
	}
}
