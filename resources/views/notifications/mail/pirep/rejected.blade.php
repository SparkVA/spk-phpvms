@component('mail::message')
  # PIREP Rejected!

  Your PIREP for {{$pirep->ident}}, filed on {{\Carbon\Carbon::parse($pirep->submitted_at)->toDateString()}}, was rejected

  @component('mail::button', ['url' => route('frontend.pireps.show', [$pirep->id])])
    View PIREP
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
