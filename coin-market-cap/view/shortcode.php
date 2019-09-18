<div id="coin-market-cap">
	<div class="convert">
		<div class="convert-group">
			<div class="convert-input left">
				<div class="inline">
					<input type="text" placeholder="Enter Amount to Convert" id="convert-amount" value="1">
				</div>
				<div class="inline">
					<select id="convert-left">
						<?php foreach($crytocurrency['data'] as $cryto):?>
							<option value="<?php echo $cryto['symbol']?>" data-price="<?php echo $cryto['price_usd']?>"><?php echo $cryto['name'] . "({$cryto['symbol']})" ?></value>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="switch">
				<a href="#">
					<span class="dashicons dashicons-controls-repeat"></span>
				</a>
			</div>
			<div class="convert-input right">
				<div class="inline">
					<input type="text" id="convert-result" disabled>
				</div>
				<div class="inline">
					<select id="convert-right">
						<?php foreach($crytocurrency['data'] as $cryto):?>
							<option value="<?php echo $cryto['symbol']?>" data-price="<?php echo $cryto['price_usd']?>"><?php echo $cryto['name'] . "({$cryto['symbol']})" ?></value>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="convert-history"></div>
</div>