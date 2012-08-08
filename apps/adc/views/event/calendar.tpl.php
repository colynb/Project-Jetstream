


<h2>Browse <?=ucwords($named['event_type'])?> Auction Events</h2>

<div class="span-25 last">
	<?=$this->widget('Event::resultsheader',compact('query','named'))?>
</div>

<div class="span-7">

			<form id="event-filters" action="<?=$this->route->url('event-calendar',array('event_type'=>$named['event_type']))?>">

	<?=$this->widget('Event::filters',compact('query','named'))?>




			</form>

</div>

<div class="span-18 last">
<?=$this->widget('Event::results',compact('query','named'))?>
</div>