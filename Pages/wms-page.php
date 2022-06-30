<?php

$Get_Sitemap = new Wms_Get_Sitemap();
$site_all_pages = $Get_Sitemap->get_results();
?>
<div class="wms">
	<div class="inner">
		<h1 class="wms__title">サイトマップ</h1>

		<table>
			<tr>
				<th>ID</th>
				<th>タイトル</th>
				<th>スラッグ</th>
				<th>URL</th>
			</tr>

			<?php
			$auto_crement_id = 0;
			foreach ($site_all_pages as $site_all_page) {
				++$auto_crement_id;
				 ?>
				<tr>
					<td>
						<?php echo esc_html($auto_crement_id) ?>
					</td>
					<td>
						<?php echo esc_html($site_all_page['title']) ?>
					</td>
					<td>
						<?php echo esc_html($site_all_page['slug']) ?>
					</td>
					<td>
						<?php echo esc_url($site_all_page['url']) ?>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
