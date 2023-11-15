<div class="card card-developer-meetup">
    <div class="meetup-img-wrapper rounded-top text-center">
        <img src="{{ asset('app-assets/images/illustration/email.svg') }}" alt="Meeting Pic" height="170" />
    </div>
    <div class="card-body">
        <div class="meetup-header d-flex align-items-center">
            <div class="meetup-day">
                <h6 class="mb-0 text-uppercase">
                    {{ now()->format('D') }}
                </h6>
                <h3 class="mb-0">
                    {{ now()->format('d') }}
                </h3>
            </div>
            <div class="my-auto">
                <h4 class="card-title mb-25">
                    {{ now()->format('F') }}, {{ now()->format('Y') }}
                </h4>
                <p class="card-text mb-0">
                    Today's Date
                </p>
            </div>
        </div>
    </div>
</div>