<div class="wrap">
	<h1>Coin market cap settings</h1>
	<form method="post">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="cron_run">Run cron</label>
					</th>
					<td>
						<input name="cron_run" type="checkbox" <?php echo ((isset($setting['cron_run']) && $setting['cron_run']) || !isset($setting['cron_run']) ? 'checked="checked"' : '')?> id="run" value="1" >
						<p class="description">Running cron task for update the exchange rate</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="cron_limit_time">Cron limit time</label>
					</th>
					<td>
						<input name="cron_limit_time" type="text" id="" value="<?php echo @$setting['cron_limit_time'] ?: 5; ?>" class="regular-text">
						<p class="description">How often does the cron run task(minutes)</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="limit_cryptocurrency">Limits cryptocurrency</label>
					</th>
					<td>
						<input name="limit_cryptocurrency" type="text" id="" value="<?php echo @$setting['limit_cryptocurrency'] ?: 100; ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="limit_count_history">Limit count history</label>
					</th>
					<td>
						<input name="limit_count_history" type="text" id="" value="<?php echo @$setting['limit_count_history'] ?: 10; ?>" class="regular-text">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input type="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
</div>