<?php

$Get_Sitemap = new mws_Get_Sitemap();
$site_all_pages = $Get_Sitemap->get_results();
?>
<div class="mws">
	<div class="inner">
		<h1 class="mws__title">サイトマップ</h1>

		<table class="mws__table">
			<tr class="mws__tr">
				<th class="mws__th">ID</th>
				<th class="mws__th">タイトル</th>
				<th class="mws__th">スラッグ</th>
				<th class="mws__th">URL</th>
			</tr>

			<?php
			$auto_crement_id = 0;
			foreach ($site_all_pages as $site_all_page) {
				++$auto_crement_id;
				 ?>
				<tr class="mws__tr">
					<td class="mws__td">
						<?php echo esc_html($auto_crement_id) ?>
					</td>
					<td class="mws__td">
						<?php echo esc_html($site_all_page['title']) ?>
					</td>
					<td class="mws__td">
						<?php echo esc_html($site_all_page['slug']) ?>
					</td>
					<td class="mws__td">
						<?php echo esc_url($site_all_page['url']) ?>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
