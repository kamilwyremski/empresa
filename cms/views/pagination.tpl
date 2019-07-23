{if $pagination.page_count}
	<div class="text-center">
		<ul class="pagination">
			<li {if $pagination.page_number==1}class="disabled"{/if}><a href="{if $pagination.page_url.page_cms}?{/if}{$pagination.page_url.page_cms}" title="{'First page'|lang}" {if $pagination.page_number==1}class="inactive"{/if}>&laquo;</a></li>
			{for $this_page=$pagination.page_start to $pagination.page_count max=9}
				<li {if $pagination.page_number==$this_page}class="disabled"{/if}><a href="?{$pagination.page_url.page_cms}{if $pagination.page_url.page_cms}&{/if}page={$this_page}" title="{'Page'|lang}: {$this_page}" {if $pagination.page_number==$this_page}class="inactive"{/if}>{$this_page}</a></li>
			{/for}
		   <li {if $pagination.page_number==$pagination.page_count}class="disabled"{/if}><a href="?{$pagination.page_url.page_cms}{if $pagination.page_url.page_cms}&{/if}page={$pagination.page_count}" title="{'Last page'|lang}" {if $pagination.page_number==$pagination.page_count}class="inactive"{/if}>&raquo;</a></li>
		</ul>
	</div>
{/if}