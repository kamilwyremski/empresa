
{if isset($offers)}

	<form method="get" class="pull-right">
		{foreach from=$pagination.page_url.sort item=item key=key}
			{if is_array($item)}
				{foreach from=$item item=item2 key=key2}
					{if is_array($item2)}
						{foreach from=$item2 item=item3 key=key3}
							<input type="hidden" name="{$key}[{$key2}][{$key3}]" value="{$item3}">
						{/foreach}
					{else}
						<input type="hidden" name="{$key}[{$key2}]" value="{$item2}">
					{/if}
				{/foreach}
			{else}
				<input type="hidden" name="{$key}" value="{$item}">
			{/if}
		{/foreach}
		<select name="sort" onchange="this.form.submit()" title="{'Select sort method'|lang}" class="form-control" style="width: auto">
			<option value="random" {if isset($smarty.get.sort) and $smarty.get.sort=="random"}selected{/if}>{'Random'|lang}</option>
			<option value="newest" {if isset($smarty.get.sort) and $smarty.get.sort=="newest"}selected{/if}>{'Newest'|lang}</option>
			<option value="oldest" {if isset($smarty.get.sort) and $smarty.get.sort=="oldest"}selected{/if}>{'Oldest'|lang}</option>
			<option value="a-z" {if isset($smarty.get.sort) and $smarty.get.sort=="a-z"}selected{/if}>{'A - Z'|lang}</option>
			<option value="z-a" {if isset($smarty.get.sort) and $smarty.get.sort=="z-a"}selected{/if}>{'Z - A'|lang}</option>
			{if isset($smarty.get.distance) and $smarty.get.distance>0}
				<option value="nearest" {if isset($smarty.get.sort) and $smarty.get.sort=="nearest"}selected{/if}>{'Nearest'|lang}</option>
				<option value="farthest" {if isset($smarty.get.sort) and $smarty.get.sort=="farthest"}selected{/if}>{'Farthest'|lang}</option>
			{/if}
		</select>
	</form>
	<div class="clearfix"></div>
	<br>
	<div>
		{foreach from=$offers item=item key=key}
			<div class="offers" itemscope itemtype="https://schema.org/Corporation">
				<div class="row {if $item.promoted}promoted{/if}">
					<div class="col-sm-3 text-center">
						<a href="{$item.id},{$item.slug}" title="{$item.name}" itemprop="url"><img src="{if $item.thumb}upload/photos/{$item.thumb}{else}{$settings.base_url}/views/{$settings.template}/images/no_image.png{/if}" alt="{$item.name}" onerror="this.src='{$settings.base_url}/views/{$settings.template}/images/no_image.png'" itemprop="image"></a>
					</div>
					<div class="col-sm-6 overflow_hidden">
						<h4><a href="{$item.id},{$item.slug}" title="{$item.name}"><span itemprop="name">{$item.name|truncate:70}</span></a></h4>
						<p class="text-muted" itemprop="disambiguatingDescription">{$item.description|strip_tags|truncate:150}</p>
						{if isset($item.distance)}<p>{'Distance'|lang}: {$item.distance|string_format:"%.2f"} {'km'|lang}</p>{/if}
					</div>
					<div class="col-sm-3">
						{if !empty($item.category.name)}<div class="offers_category offers_category_top text-center"><p><a href="{$links.offers}?search=&category%5B%5D={$item.category.slug}" title="{$item.category.name}"><strong>{$item.category.name}</strong></a></p></div>{/if}
						{if !empty($item.state.name)}<div class="offers_category offers_category_bottom text-center"><p><a href="{$links.offers}?search=&state%5B%5D={$item.state.slug}" title="{$item.state.name}"><strong itemprop="address">{$item.state.name}</strong></a></p></div>{/if}
					</div>
					{if $page=='my_offers'}
						<div class="col-sm-12 text-center">
							<br>
							<h5><a href="{$links.edit}/{$item.id},{$item.slug}" title="{'Edit offer'|lang}: {$item.name}" class="text-warning">{'Edit offer'|lang}</a> | <a href="#" title="{'Delete offer'|lang}: {$item.name}" class="text-danger ajax_confirm" data-title="{'Are you sure you want to delete offer'|lang} {$item.name}?" data-action="remove_offer" data-id="{$item.id}">{'Delete offer'|lang}</a></h5>
						</div>
					{/if}
				</div>
			</div>
		{/foreach}
	</div>
	<br>
	{include file="pagination.tpl"}
{else}
	<h3 class="text-danger">{'Nothing found'|lang}</h3>
{/if}