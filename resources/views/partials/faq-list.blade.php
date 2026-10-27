{{-- $faqs: koleksi Faq --}}
<div class="divide-y divide-gray-100 border border-gray-100 rounded-2xl bg-white" x-data="{ buka: null }">
    @foreach($faqs as $faq)
    <div>
        <h3>
            <button type="button" @click="buka = buka === {{ $faq->id }} ? null : {{ $faq->id }}"
                    :aria-expanded="buka === {{ $faq->id }}"
                    class="w-full flex justify-between items-center gap-4 text-left px-5 py-4 text-sm font-medium text-gray-800 hover:text-teal-700">
                {{ $faq->pertanyaan }}
                <span class="text-teal-600 text-lg transition-transform" :class="buka === {{ $faq->id }} && 'rotate-45'">+</span>
            </button>
        </h3>
        <div x-cloak x-show="buka === {{ $faq->id }}" x-transition.opacity class="px-5 pb-4 text-sm text-gray-500 leading-relaxed">
            {!! nl2br(e($faq->jawaban)) !!}
        </div>
    </div>
    @endforeach
</div>
