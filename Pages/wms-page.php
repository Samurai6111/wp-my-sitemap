<?php

$Get_Sitemap = new Wms_Get_Sitemap();
$site_all_pages = $Get_Sitemap->get_results();
?>
<div class="wms">
	<div class="inner">
		<h1 class="wms__title">サイトマップ</h1>

		<table class="wms__table">
			<tr class="wms__tr">
				<th class="wms__th">ID</th>
				<th class="wms__th">タイトル</th>
				<th class="wms__th">スラッグ</th>
				<th class="wms__th">URL</th>
			</tr>

			<?php
			$auto_crement_id = 0;
			foreach ($site_all_pages as $site_all_page) {
				++$auto_crement_id;
				 ?>
				<tr class="wms__tr">
					<td class="wms__td">
						<?php echo esc_html($auto_crement_id) ?>
					</td>
					<td class="wms__td">
						<?php echo esc_html($site_all_page['title']) ?>
					</td>
					<td class="wms__td">
						<?php echo esc_html($site_all_page['slug']) ?>
					</td>
					<td class="wms__td">
						<?php echo esc_url($site_all_page['url']) ?>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
