
{if $settings.ads_side_1}<div class="ads">{$settings.ads_side_1}</div>{/if}

<form class="form-horizontal form-search" method="get" id="form_search_offers">
	<input type="hidden" name="search">
	{if isset($smarty.get.username)}
		<div class="form-group">
			<label for="username" class="control-label">{'Username'|lang}: </label>
			<select name="username" id="username" class="form-control">
				<option value="">{'All users'|lang}</option>
				<option value="{$smarty.get.username}" selected>{$smarty.get.username}</option>
			</select>
		</div>
	{/if}
	<div class="form-group">
		<label for="keywords" class="control-label">{'Keywords'|lang}: </label>
		<input class="form-control" type="text" name="keywords" id="keywords" placeholder="{'Enter your keywords...'|lang}" title="{'Enter your keywords...'|lang}" {if isset($smarty.get.keywords)}value="{$smarty.get.keywords}"{/if}>
	</div>
	{if isset($offers_categories)}
		<div class="form-group check_all_parent">
			<label for="category" class="control-label">{'Category'|lang}:</label>
			<div class="checkbox">
				<label><input type="checkbox" class="check_all" {if !isset($smarty.get.category) or empty($smarty.get.category)}checked{/if}>{'All'|lang}</label>
			</div>
			<div class="group_checkbox" {if !isset($smarty.get.category) or empty($smarty.get.category)}style="display:none"{/if}>
				{foreach from=$offers_categories item=item key=key}
					<div class="checkbox">
						<label><input type="checkbox" name="category[]" value="{$item.slug}" {if isset($smarty.get.category) && is_array($smarty.get.category) && $item.slug|in_array:$smarty.get.category}checked{/if}>{$item.name}</label>
					</div>
				{/foreach}
			</div>
		</div>
	{/if}
	{if isset($offers_state)}
		<div class="form-group check_all_parent">
			<label for="state" class="control-label">{'State'|lang}:</label>
			<div class="checkbox">
				<label><input type="checkbox" class="check_all" {if !isset($smarty.get.state) or empty($smarty.get.state)}checked{/if}>{'All'|lang}</label>
			</div>
			<div class="group_checkbox" {if !isset($smarty.get.state) or empty($smarty.get.state)}style="display:none"{/if}>
				{foreach from=$offers_state item=item key=key}
					<div class="checkbox">
						<label><input type="checkbox" name="state[]" value="{$item.slug}" {if isset($smarty.get.state) && is_array($smarty.get.state) && $item.slug|in_array:$smarty.get.state}checked{/if}>{$item.name}</label>
					</div>
				{/foreach}
			</div>
		</div>
	{/if}
	<div class="form-group">
		<input class="form-control btn-1" type="submit" value="{'SEARCH!'|lang}">
	</div>
	<div class="form-group">
		<label for="search_box_address">{'Address'|lang}:</label>
		<input type="text" name="address" class="form-control" placeholder="{'1600 Pennsylvania Avenue NW, Washington, D.C. 20500'|lang}" title="{'Enter the address'|lang}" {if isset($smarty.get.address)}value="{$smarty.get.address}"{/if} id="search_box_address">
	</div>
	{if $settings.google_maps_api}
		<div class="form-group">
			<div class="form-inline text-right">
				<div class="input-group">
					<div class="input-group-addon">{'Distance'|lang}: </div>
					<input type="number" name="distance" class="form-control text-right" placeholder="20" title="Tu wpisz odległość od poszukiwanego adresu" value="{if isset($smarty.get.distance)}{$smarty.get.distance}{else}10{/if}" min="0" step="1" style="width:80px">
					<div class="input-group-addon">{'km'|lang}</div>
				</div>
			</div>
		</div>
	{/if}
	{if isset($offers_options)}
		{foreach from=$offers_options item=item key=key}
			<div class="form-group">
				<label for="options[{$item.name}]" class="control-label">{$item.name}: </label>
				{if $item.kind=='text'}
					<input class="form-control" type="text" name="options[{$item.slug}]" {if isset($smarty.get.options[$item.slug])}value="{$smarty.get.options[$item.slug]}"{/if}>
				{elseif $item.kind=='number'}
					<div class="input-group">
						<input class="form-control text-right" type="number" name="options[{$item.slug}][from]" placeholder="{'Min...'|lang}" title="{'Enter the min value'|lang}" {if isset($smarty.get.options[{$item.slug}].from)}value="{$smarty.get.options[{$item.slug}].from}"{/if}>
						<div class="input-group-addon"> - </div>
						<input class="form-control text-right" type="number" name="options[{$item.slug}][to]" placeholder="{'Max...'|lang}" title="{'Enter the max value'|lang}" {if isset($smarty.get.options[{$item.slug}].to)}value="{$smarty.get.options[{$item.slug}].to}"{/if}>
					</div>
				{elseif $item.kind=='select' && isset($item.choices)}
					<div class="group_checkbox">
						{foreach from=$item.choices item=item2 key=key2}
							<div class="checkbox">
								<label><input type="checkbox" name="options[{$item.slug}][]" value="{$item2}" {if isset($smarty.get.options[{$item.slug}]) && is_array($smarty.get.options[{$item.slug}]) && $item2|in_array:$smarty.get.options[{$item.slug}]}checked{/if}>{$item2}</label>
							</div>
						{/foreach}
					</div>
				{/if}
			</div>
		{/foreach}
	{/if}
	<div class="form-group">
		<input class="form-control btn-1" type="submit" value="{'SEARCH!'|lang}">
	</div>
</form>

{if $settings.ads_side_2}<div class="ads">{$settings.ads_side_2}</div>{/if}