<x-layout>
    <div class="bg-[#10101C] text-white">
        <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="flex flex-col justify-center gap-16 py-10 lg:py-16">
                <div class="flex flex-col gap-4 items-center">
                    <h1 class="text-3xl lg:text-4xl font-bold text-[#FE6716]">
                        Category
                    </h1>
                    <p class="text-base font-medium w-auto text-center">
                        Silahkan mencari berita sesuai kategori yang anda inginkan.
                    </p>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-6 lg:gap-11">
                    @foreach ($categories as $item)
                    <a href="/category/{{ $item->slug }}" class="flex flex-col justify-center items-center gap-3 group">
                        <img src="https://via.placeholder.com/400x225" alt="" class="w-24 h-24 lg:w-40 lg:h-40 rounded-lg">
                        <span class="text-2xl lg:text-3xl font-bold group-hover:text-[#FE6716]">{{ $item->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="flex flex-col justify-center gap-16 py-10 lg:py-16">
            <div class="flex flex-col justify-start gap-4 items-start">
                @if($category)
                <h1 class="text-2xl lg:text-4xl font-bold text-[#FE6716]">
                    {{ $category->name }} News
                </h1>
                @else
                <h1 class="text-2xl lg:text-4xl font-bold text-[#FE6716]">
                    All News
                </h1>
                @endif
                <p class="text-base font-medium w-auto lg:w-[524px]">
                    Temukan berita terbaru dari berbagai category, mulai dari politik, 
                    teknologi, hingga peristiwa dunia, semuanya disajikan up-to-date dan 
                    terpercaya.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-14">
                @foreach($allNews as $news)
                <a href="/news/{{ $news->slug }}" class="bg-transparent rounded-lg shadow-xl overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        <img class="w-auto h-auto lg:w-[400px] lg:h-[225px] object-cover" src="{{ asset('storage/' . $news->image_url) }}"
                            alt="News Image">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-black">
                            {{ \Illuminate\Support\Str::limit($news->title, 50, '...') }}
                        </h3>
                        <p class="text-sm text-neutral-800 mb-4">
                            {{ \Illuminate\Support\Str::words(strip_tags($news->content, '<b>'), 18, '...') }}
                        </p>
                        <div class="flex items-center text-sm text-neutral-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                                {{ $news->user->name }} - {{ $news->created_at->format('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>