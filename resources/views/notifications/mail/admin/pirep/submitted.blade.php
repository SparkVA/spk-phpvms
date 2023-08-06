@component('mail::message')
  # New PIREP Submitted

  A new PIREP has been submitted by {{ $pirep->user->ident }} {{ $pirep->user->name }}

  Ident: {{$pirep->ident}}
  Departing: {{$pirep->dpt_airport_id}}
  Arriving: {{$pirep->arr_airport_id}}

  @component('mail::button', ['url' => route('admin.pireps.edit', [$pirep->id])])
    View PIREP
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
