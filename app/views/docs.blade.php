<div class="row">
	<div class="small-3 columns">

		<ul>
			<li> <h3>Index</h3> </li>
			<ul>
				@foreach($index as $i => $v )
					<li><a href="{{ URL::to($v['uri']) }}" data-title="{{ $v['title'] }}" data-toggle="loadContent">{{ $v['title'] }}</a></li>				
				@endforeach
			</ul>
		</ul>
	</div>
	<div class="small-9 columns">
		{{ $chapter }}
	</div>
</div>