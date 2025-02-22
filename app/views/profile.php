<h1>{{ __('app.profile') }}</h1>

<div class="margin-vertical is-default-text-color">{{ __('app.profile_hint', ['name' => $user->get('name'), 'email' => $user->get('email')]) }}</div>

@include('flashmsg.php')

<div class="margin-vertical">
	<a class="button is-link" href="javascript:void(0);" onclick="window.vue.bShowEditPreferences = true;">{{ __('app.preferences') }}</a>
</div>

<div class="margin-vertical">
	<h2 class="smaller-headline">{{ __('app.personal_notes') }}</h2>

	<form method="POST" action="{{ url('/profile/notes/save') }}">
		@csrf

		<div class="field">
			<div class="control">
				<textarea class="textarea is-input-dark" name="notes">{{ $user->get('notes') ?? 'N/A' }}</textarea>
			</div>
		</div>

		<div class="field">
			<div class="control">
				<input type="submit" class="button is-info" value="{{ __('app.save') }}">
			</div>
		</div>
	</form>
</div>

<div class="plants">
	<h2 class="smaller-headline">{{ __('app.last_authored_plants') }}</h2>

	@foreach ($plants as $plant)
		<a href="{{ url('/plants/details/' . $plant->get('id')) }}">
			<div class="plant-card" style="background-image: url('{{ asset('img/' . $plant->get('photo')) }}');">
				<div class="plant-card-overlay">
					<div class="plant-card-health-state">
						@if ($plant->get('health_state') === 'overwatered')
							<i class="fas fa-water plant-state-overwatered"></i>
						@elseif ($plant->get('health_state') === 'withering')
							<i class="fab fa-pagelines plant-state-withering"></i>
						@elseif ($plant->get('health_state') === 'infected')
							<i class="fas fa-biohazard plant-state-infected"></i>
						@endif
					</div>

					<div class="plant-card-title">{{ $plant->get('name') }}</div>
				</div>
			</div>
		</a>
	@endforeach
</div>

@if ($user->get('show_log'))
	@if (count($log) > 0)
		<div class="log">
			<div class="log-title">{{ __('app.log_title') }}</div>

			<div class="log-content">
				@foreach ($log as $entry)
					<div class="log-item">
						@if ($entry['link'])
							<a href="{{ $entry['link'] }}">[{{ $entry['date'] }}] ({{ $entry['user'] }}) {{ $entry['property'] }} =&gt; {{ $entry['value'] }} @ {{ $entry['target'] }}</a>
						@else
							[{{ $entry['date'] }}] ({{ $entry['user'] }}) {{ $entry['property'] }} =&gt; {{ $entry['value'] }} @ {{ $entry['target'] }}
						@endif
					</div>
				@endforeach
			</div>
		</div>
	@endif
@endif
