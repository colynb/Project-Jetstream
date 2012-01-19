
<h2>Search</h2>

<div class="span-25 last">
	<?=$this->widget('Search::resultsheader',compact('named'))?>
</div>

<div class="span-6">

			<form id="search-filters" action="<?=$this->request->canonical?>" method="get">

	<?=$this->widget('Search::filters',compact('refinements'))?>




			</form>

</div>

<div class="span-19 last">
<?=$this->widget('Search::results',compact('results'))?>
</div>