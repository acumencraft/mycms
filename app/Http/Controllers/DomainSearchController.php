<?php

namespace App\Http\Controllers;

use App\Services\DomainSearchService;
use Illuminate\Http\Request;

class DomainSearchController extends Controller
{
    protected $domainSearchService;

    public function __construct(DomainSearchService $domainSearchService)
    {
        $this->domainSearchService = $domainSearchService;
    }

    public function search(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|min:3|max:100',
        ]);

        $domain = strtolower(trim($request->domain));
        $domain = preg_replace('/^https?:\/\//', '', $domain);
        $domain = rtrim($domain, '/');

        $results = $this->domainSearchService->searchDomain($domain, $request->ip());

        return response()->json($results);
    }
}
