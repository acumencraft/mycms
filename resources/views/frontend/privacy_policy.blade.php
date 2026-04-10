@extends('layouts.main')
@section('title', 'Privacy Policy - ' . config('agency.seo.title_suffix') . '')

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-10">
      <h1 class="text-4xl font-bold text-gray-900 mb-2" style="letter-spacing:-0.02em">Privacy Policy</h1>
      <p class="text-gray-500 text-sm">Last updated: {{ date('F j, Y') }}</p>
    </div>

    @if($page?->content)
      <div class="prose prose-gray max-w-none">
        {!! $page->content !!}
      </div>
    @else
      <div class="prose prose-gray max-w-none space-y-6 text-gray-700">
        <p>At {{ config('agency.name') }}, we are committed to protecting your personal information and your right to privacy.</p>

        <h2 class="text-xl font-bold text-gray-900">Information We Collect</h2>
        <p>We collect information you provide directly to us, such as when you create an account, place an order, or contact us. This may include your name, email address, phone number, and other contact information.</p>

        <h2 class="text-xl font-bold text-gray-900">How We Use Your Information</h2>
        <p>We use the information we collect to provide, maintain, and improve our services, process transactions, send communications, and comply with legal obligations.</p>

        <h2 class="text-xl font-bold text-gray-900">Information Sharing</h2>
        <p>We do not sell, trade, or rent your personal information to third parties. We may share your information with trusted service providers who assist us in operating our website and conducting our business.</p>

        <h2 class="text-xl font-bold text-gray-900">Data Security</h2>
        <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

        <h2 class="text-xl font-bold text-gray-900">Cookies</h2>
        <p>We use cookies and similar tracking technologies to enhance your experience on our website. You can control cookie settings through your browser preferences.</p>

        <h2 class="text-xl font-bold text-gray-900">Your Rights</h2>
        <p>You have the right to access, correct, or delete your personal information. To exercise these rights, please contact us at <a href="mailto:{{ data_get($siteSettings, 'site_email', 'info@archvadze.com') }}" class="text-primary">{{ data_get($siteSettings, 'site_email', 'info@archvadze.com') }}</a>.</p>

        <h2 class="text-xl font-bold text-gray-900">Contact Us</h2>
        <p>If you have questions about this Privacy Policy, please contact us at <a href="{{ route('contact') }}" class="text-primary">our contact page</a>.</p>
      </div>
    @endif
  </div>
</main>
@endsection
