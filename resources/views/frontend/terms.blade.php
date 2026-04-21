@extends('layouts.main')
@section('title', 'Terms of Service - ' . config('agency.seo.title_suffix'))

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-10">
      <h1 class="text-4xl font-bold text-gray-900 mb-2" style="letter-spacing:-0.02em">Terms of Service</h1>
      <p class="text-gray-500 text-sm">Last updated: {{ date('F j, Y') }}</p>
    </div>

    @if($page?->content)
      <div class="prose prose-gray max-w-none">
        {!! $page->content !!}
      </div>
    @else
      <div class="prose prose-gray max-w-none space-y-6 text-gray-700">
        <p>By accessing and using ' . config('agency.seo.title_suffix')s services, you accept and agree to be bound by the terms and provisions of this agreement.</p>

        <h2 class="text-xl font-bold text-gray-900">Services</h2>
        <p>{{ config('agency.name') }} provides web development, design, and digital marketing services. The scope of each project is defined in the individual project agreement or order confirmation.</p>

        <h2 class="text-xl font-bold text-gray-900">Payment Terms</h2>
        <p>Payment terms are specified in individual project agreements. Generally, we require a 50% deposit before project commencement and the remaining balance upon project completion.</p>

        <h2 class="text-xl font-bold text-gray-900">Intellectual Property</h2>
        <p>Upon full payment, clients receive ownership of the final deliverables. {{ config('agency.name') }} retains the right to showcase completed work in our portfolio unless otherwise agreed.</p>

        <h2 class="text-xl font-bold text-gray-900">Revisions</h2>
        <p>Each project includes a defined number of revision rounds as specified in the project agreement. Additional revisions may incur extra charges.</p>

        <h2 class="text-xl font-bold text-gray-900">Limitation of Liability</h2>
        <p>{{ config('agency.name') }}'s liability is limited to the amount paid for the specific service. We are not liable for indirect, consequential, or incidental damages.</p>

        <h2 class="text-xl font-bold text-gray-900">Termination</h2>
        <p>Either party may terminate a project with written notice. In case of termination, payment is due for work completed up to that point.</p>

        <h2 class="text-xl font-bold text-gray-900">Contact</h2>
        <p>For questions about these terms, contact us at <a href="{{ route('contact') }}" class="text-primary">our contact page</a>.</p>
      </div>
    @endif
  </div>
</main>
@endsection
