<div class="w-full" x-data="domainSearch()">
    <div class="flex gap-2">
        <div class="relative flex-1">
            <input
                type="text"
                x-model="query"
                @keydown.enter="search()"
                placeholder="Search domain (e.g. mybusiness)"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 text-sm"
            >
        </div>
        <button
            @click="search()"
            :disabled="loading || !query"
            class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold px-6 py-3 rounded-lg transition whitespace-nowrap text-sm"
        >
            <span x-show="!loading">Check</span>
            <span x-show="loading">Searching...</span>
        </button>
    </div>

    {{-- Results --}}
    <div x-show="results.length > 0" class="mt-4 space-y-2" x-transition>
        <template x-for="result in results" :key="result.domain">
            <div class="flex items-center justify-between p-3 rounded-lg border"
                 :class="result.available ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200'">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full"
                         :class="result.available ? 'bg-green-500' : 'bg-gray-400'"></div>
                    <span class="font-medium text-gray-900 text-sm" x-text="result.domain"></span>
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                          :class="result.available ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600'"
                          x-text="result.available ? 'Available' : 'Taken'"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-gray-700" x-text="result.available ? '$' + result.price + '/yr' : ''"></span>
                    <a x-show="result.available"
                       :href="'/order?domain=' + result.domain"
                       class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">
                        Order
                    </a>
                </div>
            </div>
        </template>
    </div>

    {{-- Error --}}
    <p x-show="error" x-text="error" class="mt-2 text-red-500 text-sm"></p>
</div>

<script>
function domainSearch() {
    return {
        query: '',
        results: [],
        loading: false,
        error: '',
        async search() {
            if (!this.query.trim()) return;
            this.loading = true;
            this.error = '';
            this.results = [];
            try {
                const response = await fetch('/domain-search', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ domain: this.query }),
                });
                this.results = await response.json();
            } catch (e) {
                this.error = 'Search failed. Please try again.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
