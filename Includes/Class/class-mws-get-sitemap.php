<?php


class mws_Get_Sitemap {
	function __construct() {
		$this->post_types = get_post_types([
			'public'   => true,
			'_builtin' => false,
		], 'objects', 'and');
		$this->type_post = get_post_type_object('post');
		$this->post_hierarchy_counts = [];
		$this->site_map_values = [];
		$this->site_hierarchy_count = [];
		$this->post_status_array = [
			'post_status' => 'publish',
			'post_status' => 'pending',
			'post_status' => 'draft',
			'post_status' => 'auto-draft',
			'post_status' => 'future',
			'post_status' => 'private',
		];
	}

	/**
	 * 全ての投稿タイプを連想配列で取得
	 *
	 * @param $
	 */
	function get_post_types() {
		$post_types = [
			'post' =>	'post',
			'page' =>	'page',
		];

		$registered_post_types = get_post_types([
			'public'   => true,
			'_builtin' => false
		]);

		$post_types = array_merge($post_types, $registered_post_types);

		$return = [
			'object' => $post_types,
			'values' => array_values($post_types),
		];

		return $return;
	}


	/**
	 * 全ての投稿タイプの一番大きい階層を取得
	 */
	function get_hierarchy_level() {

		$get_post_types = $this->get_post_types()['values'];
		$post_hierarchy_counts = $this->post_hierarchy_counts;

		$WP_post = new WP_Query([
			'post_type' => $get_post_types,
			'posts_per_page' => -1,
		]);

		if ($WP_post->have_posts()) {
			while ($WP_post->have_posts()) {
				$WP_post->the_post();

				$post_id = get_the_ID();
				$post_hierarchy = get_post_ancestors($post_id);
				$post_hierarchy_count = count($post_hierarchy);

				$post_hierarchy_counts[] = $post_hierarchy_count;
			}
		}
		wp_reset_postdata();

		$page_hierarchy_count_max = max($post_hierarchy_counts);

		return $page_hierarchy_count_max;
	}
	function get_hierarchy_level_1() {
		return $this->get_hierarchy_level() + 1;
	}

	/**
	 * 固定ページ一覧取得
	 */
	function get_pages() {
		$page_list = get_pages();

		foreach ($page_list as $page) {
			/*--------------------------------------------------
			/* 投稿の詳細を取得
			/*------------------------------------------------*/
			$page_array = [];
			$post_hierarchy = get_post_ancestors($page->ID);
			$post_hierarchy_count = count($post_hierarchy);

			$page_array['title']['title' . $post_hierarchy_count] = $page->post_title;
			$page_array['slug']['slug0'] =  $page->post_name;
			$page_array['url']['url0'] = get_permalink($page->ID);

			$this->site_map_values[] = $page_array;
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
			'title' => ['title0' => $this->type_post->label . ' アーカイブページ'],
			'slug' => ['slug0' => $this->type_post->name],
			'url' => ['url0' => ''],
		];
		$this->site_map_values[] = $post_acrhive_array;

		foreach ($this->post_types as $post_type) {
			$archive_array = [];
			$archive_array['title']['title0'] = 'カスタム投稿「' . $post_type->label . '」 アーカイブページ';
			$archive_array['slug']['slug0'] = $post_type->name;
			$archive_array['url']['url0'] = home_url('/' . $post_type->name);
			$this->site_map_values[] = $archive_array;
		}


		// return $archives_array;
	}

	/**
	 * シングル一覧取得
	 */
	function get_singles() {
		$post_acrhive_array =	[
			'title' => ['title0' => $this->type_post->label . ' シングルページ'],
			'slug' => ['slug0' => '投稿名'],
			'url' => ['url0' => ''],
		];
		$this->site_map_values[] = $post_acrhive_array;

		foreach ($this->post_types as $post_type) {
			$single_array = [];

			$single_array['title']['title0'] = 'カスタム投稿「' . $post_type->label . '」 シングルページ';
			$single_array['slug']['slug0'] = '投稿名';
			$single_array['url']['url0'] = home_url('/' . $post_type->name . '/投稿名');
			$this->site_map_values[] = $single_array;
		}
	}

	/**
	* テーブルのヘッドを取得
	*/
	function get_sitemap_head() {
		$site_map_head_array = [
			'ID' => ['id' => 'ID'],
		];

		$i = 0;
		$post_hierarchy_counts_1 = $this->get_hierarchy_level_1();
		while ($i < $post_hierarchy_counts_1) {
			if ($i === 1) {
				$site_map_head_array['title']['title' . $i] = 'タイトル';
			} else {
				$site_map_head_array['title']['title' . $i] = '';
			}
			++$i;
		}

		$site_map_head_array['slug'] = ['slug' => 'スラッグ'];
		$site_map_head_array['url'] = ['url' => 'URL'];

		return $site_map_head_array;
	}

	/**
	 * 全ての配列を取得する
	 *
	 */
	function get_results() {
		$this->get_pages();
		$this->get_archives();
		$this->get_singles();



		return $this->site_map_values;
	}
}
